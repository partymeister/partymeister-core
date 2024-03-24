<?php

namespace Partymeister\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Motor\Backend\Models\User;
use Partymeister\Core\Models\Event;

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
    protected $signature = 'partymeister:core:import:timetable';

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

        // Get timetable

        $data = file_get_contents(config('partymeister-core.timetable_url'));

        if (! $data) {
            return false;
        }

        // Delete current timetable entries
        foreach (Event::where('schedule_id', 1)->get() as $event) {
            $event->delete();
        }

        $dataJson = json_decode($data);

        $sortPosition = 0;

        foreach ($dataJson->timetable as $day) {
            foreach ($day->events as $event) {
                $sortPosition += 10;

                if (strtolower($event->category) === 'deadline') {
                    $deadlines = explode("\n", $event->title);

                    foreach ($deadlines as $deadline) {
                        $sortPosition += 10;

                        $e = new Event();
                        $e->schedule_id = 1;
                        $e->event_type_id = $this->categoryToEventIdMapping($event->category);
                        $e->name = $deadline;
                        $e->starts_at = Carbon::parse($event->start)->utcOffset(60);
                        $e->is_visible = true;
                        $e->sort_position = $sortPosition;
                        $e->save();
                    }
                } else {
                    $e = new Event();
                    $e->schedule_id = 1;
                    $e->event_type_id = $this->categoryToEventIdMapping($event->category);
                    $e->name = $event->title;
                    $e->starts_at = Carbon::parse($event->start)->utcOffset(60);
                    $e->is_visible = true;
                    $e->sort_position = $sortPosition;
                    $e->save();
                }
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
