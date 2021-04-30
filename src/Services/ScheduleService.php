<?php

namespace Partymeister\Core\Services;

use Illuminate\Support\Arr;
use Motor\Backend\Models\Category;
use Motor\Backend\Services\BaseService;
use Partymeister\Core\Models\Schedule;
use Partymeister\Slides\Helpers\ScreenshotHelper;
use Partymeister\Slides\Models\Slide;

/**
 * Class ScheduleService
 *
 * @package Partymeister\Core\Services
 */
class ScheduleService extends BaseService
{
    /**
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * @param Schedule $schedule
     * @param          $data
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     */
    public static function generateSlides(Schedule $schedule, $data)
    {
        // 1. create a slide category for the timetable slides in case it does not exist yet
        $timetableCategory = Category::where('scope', 'slides')
                                     ->where('name', 'Timetable')
                                     ->first();
        if (is_null($timetableCategory)) {
            $rootNode = Category::where('scope', 'slides')
                                ->where('_lft', 1)
                                ->first();
            if (is_null($rootNode)) {
                die("Root node for slide category tree does not exist");
            }
            $timetableCategory = new Category();
            $timetableCategory->scope = 'slides';
            $timetableCategory->name = 'Timetable';
            $rootNode->appendNode($timetableCategory);
        }

        // 3. save slides
        $slideType = config('partymeister-core-slides.timetable.slide_type', 'default');

        if (config('partymeister-slides.screenshots')) {
            $browser = new ScreenshotHelper();
        }

        foreach (Arr::get($data, 'slide', []) as $slideName => $definitions) {
            $name = Arr::get($data, 'name.'.$slideName);

            // 2. look for existing slides with the same name
            $slide = Slide::where('name', $name)
                          ->where('category_id', $timetableCategory->id)
                          ->first();
            if (is_null($slide)) {
                $slide = new Slide();
            }

            $slide->category_id = $timetableCategory->id;
            $slide->name = $name;
            $slide->slide_type = $slideType;
            $slide->definitions = stripslashes($definitions);
            $slide->cached_html_preview = Arr::get($data, 'cached_html_preview.'.$slideName, '');
            $slide->cached_html_final = Arr::get($data, 'cached_html_final.'.$slideName, '');

            $slide->save();

            // 7. generate slides
            if (isset($browser)) {
                $browser->screenshot(config('app.url').route('backend.slides.show', [$slide->id], false).'?preview=true', storage_path().'/preview_'.$slideName.'.png');
                $browser->screenshot(config('app.url').route('backend.slides.show', [$slide->id], false), storage_path().'/final_'.$slideName.'.png');

                $slide->clearMediaCollection('preview');
                $slide->clearMediaCollection('final');
                $slide->addMedia(storage_path().'/preview_'.$slideName.'.png')
                      ->toMediaCollection('preview', 'media');
                $slide->addMedia(storage_path().'/final_'.$slideName.'.png')
                      ->toMediaCollection('final', 'media');
            }
//            event(new SlideSaved($slide, 'slides'));
        }
    }
}
