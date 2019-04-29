<?php

namespace Partymeister\Core\Services;

use Motor\Backend\Models\Category;
use Partymeister\Core\Models\Schedule;
use Motor\Backend\Services\BaseService;
use Partymeister\Slides\Events\SlideSaved;
use Partymeister\Slides\Models\Slide;

class ScheduleService extends BaseService
{

    protected $model = Schedule::class;


    public static function generateSlides(Schedule $schedule, $data)
    {
        // 1. create a slide category for the timetable slides in case it does not exist yet
        $timetableCategory = Category::where('scope', 'slides')->where('name', 'Timetable')->first();
        if (is_null($timetableCategory)) {
            $rootNode = Category::where('scope', 'slides')->where('_lft', 1)->first();
            if (is_null($rootNode)) {
                die("Root node for slide category tree does not exist");
            }
            $timetableCategory        = new Category();
            $timetableCategory->scope = 'slides';
            $timetableCategory->name  = 'Timetable';
            $rootNode->appendNode($timetableCategory);
        }

        // 3. save slides
        $slideType            = config('partymeister-core-slides.timetable.slide_type', 'default');

        foreach (array_get($data, 'slide', []) as $slideName => $definitions) {
            $name = array_get($data, 'name.' . $slideName);

            // 2. look for existing slides with the same name
            $slide = Slide::where('name', $name)->where('category_id', $timetableCategory->id)->first();
            if (is_null($slide)) {
                $slide              = new Slide();
            }

            $slide->category_id = $timetableCategory->id;
            $slide->name        = $name;
            $slide->slide_type  = $slideType;
            $slide->definitions = $definitions;
            $slide->cached_html_preview = array_get($data, 'cached_html_preview.' . $slideName, '');
            $slide->cached_html_final   = array_get($data, 'cached_html_final.' . $slideName, '');

            $slide->save();

            // 7. generate slides
			// 7. generate slides
			// Convert PNG to actual file
			//$pngData = array_get($data, 'final.' . $slideName);
			//$pngData = substr($pngData, 22);
			//file_put_contents(storage_path().'/final_'.$slideName.'.png', base64_decode($pngData));

			$pngData = array_get($data, 'preview.' . $slideName);
			$pngData = substr($pngData, 22);
			file_put_contents(storage_path().'/preview_'.$slideName.'.png', base64_decode($pngData));

			$slide->clearMediaCollection('preview');
			$slide->clearMediaCollection('final');
			$slide->addMedia(storage_path().'/preview_'.$slideName.'.png')->toMediaCollection('preview', 'media');
			//$slide->addMedia(storage_path().'/final_'.$slideName.'.png')->toMediaCollection('final', 'media');

//            event(new SlideSaved($slide, 'slides'));
        }
    }
}
