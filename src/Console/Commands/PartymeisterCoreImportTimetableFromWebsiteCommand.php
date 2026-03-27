<?php

namespace Partymeister\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Motor\Admin\Models\User;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Models\Schedule;
use Partymeister\Slides\Helpers\ScreenshotHelper;

/**
 * Class PartymeisterCoreImportTimetableFromWebsiteCommand
 */
class PartymeisterCoreImportTimetableFromWebsiteCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'partymeister:core:import:timetable {--force : Force import even if timetable content is unchanged}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import timetable from Revision website';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Auth::login(User::find(1));

        // Prefer local file (mounted via K8s volume at /data/timetable), fall back to URL
        $localPath = '/data/timetable/timetable.json';

        if (file_exists($localPath)) {
            $data = file_get_contents($localPath);
            $this->info('Source: local file ('.$localPath.')');
            Log::debug('Importing timetable from local file: '.$localPath);
        } else {
            $url = config('partymeister-core.timetable_url');
            if (empty($url)) {
                Log::error('Timetable import: no source available — local file not found and PM_CORE_TIMETABLE_URL not set');
                $this->error('No timetable source: /data/timetable/timetable.json not found and PM_CORE_TIMETABLE_URL not set');

                return;
            }
            $data = @file_get_contents($url);
            if ($data === false) {
                Log::error('Timetable import: failed to fetch from URL: '.$url);
                $this->error('Failed to fetch timetable from: '.$url);

                return;
            }
            $this->info('Source: remote URL ('.$url.')');
            Log::debug('Importing timetable from URL: '.$url);
        }

        if (! $data) {
            return false;
        }

        $dataJson = json_decode($data);

        // Build a content fingerprint from the fields that affect slides
        $fingerprint = '';
        foreach ($dataJson->timetable as $day) {
            foreach ($day->events as $event) {
                $fingerprint .= strtolower($event->category).'|'.$event->title.'|'.$event->start."\n";
            }
        }
        $hash = md5($fingerprint);
        $cacheKey = 'timetable:import:hash';
        $previousHash = Cache::get($cacheKey);

        if ($previousHash === $hash && ! $this->option('force')) {
            $this->info('Timetable unchanged (hash: '.$hash.'), skipping import (use --force to override)');
            Log::debug('Timetable import skipped — content hash unchanged: '.$hash);

            return;
        }

        $this->info('Timetable changed (hash: '.$hash.', previous: '.($previousHash ?? 'none').')');
        Log::info('Timetable content changed — importing (hash: '.$hash.', previous: '.($previousHash ?? 'none').')');

        DB::transaction(function () use ($dataJson) {
            // Delete current timetable entries
            foreach (Event::where('schedule_id', 1)->get() as $event) {
                $event->delete();
                Log::debug('Deleted event: '.$event->name);
            }

            $sortPosition = 0;

            foreach ($dataJson->timetable as $day) {
                foreach ($day->events as $event) {
                    $sortPosition += 10;

                    if (strtolower($event->category) === 'deadline') {
                        $deadlines = explode("\n", $event->title);

                        foreach ($deadlines as $deadline) {
                            $sortPosition += 10;

                            $e = new Event;
                            $e->schedule_id = 1;
                            $e->event_type_id = $this->categoryToEventIdMapping($event->category);
                            $e->name = $deadline;
                            $e->starts_at = Carbon::parse($event->start);
                            $e->is_visible = true;
                            $e->sort_position = $sortPosition;
                            $e->save();
                        }
                    } else {
                        $e = new Event;
                        $e->schedule_id = 1;
                        $e->event_type_id = $this->categoryToEventIdMapping($event->category);
                        $e->name = $event->title;
                        $e->starts_at = Carbon::parse($event->start);
                        $e->is_visible = true;
                        $e->sort_position = $sortPosition;
                        $e->save();
                    }
                }
            }
        });

        Cache::forever($cacheKey, $hash);

        // Trigger timetable slide regeneration via headless browser
        if (config('partymeister-slides.generate_screenshots')) {
            $schedule = Schedule::find(1);
            if ($schedule) {
                $browser = new ScreenshotHelper;
                $url = config('app.url_internal').'/internal/generate/schedule/'.$schedule->id.'?secret='.urlencode(config('partymeister-slides.screenshot_secret', ''));
                $browser->generate($url);
                Log::info('Queued timetable slide regeneration for schedule: '.$schedule->name);
                $this->info('Queued timetable slide regeneration');
            }
        }
    }

    private function categoryToEventIdMapping($category)
    {
        switch (strtolower($category)) {
            case 'competition':
            case 'compo':
                return 1;
            case 'deadline':
                return 2;
            case 'seminar':
                return 6;
            case 'concert':
                return 7;
            case '2nd stream':
                return 10;
            case 'event':
            default:
                return 3;
        }
    }
}
