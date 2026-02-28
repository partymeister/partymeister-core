<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Core\Models\Event;
use Partymeister\Slides\Models\SlideTemplate;
use Partymeister\Slides\Services\PlaylistService;

class EventPlaylistController extends Controller
{
    public function show(Event $event): JsonResponse
    {
        $templates = [];
        $templateTypes = [
            'coming_up' => 'coming_up',
            'now' => 'now',
            'end' => 'end',
            'default' => 'basic',
        ];

        foreach ($templateTypes as $key => $templateFor) {
            $query = SlideTemplate::where('template_for', $templateFor);
            if ($templateFor === 'basic') {
                $query->where('name', 'Empty');
            }
            $template = $query->first();
            if ($template) {
                $templates[$key] = [
                    'id' => $template->id,
                    'definitions' => $template->definitions,
                ];
            }
        }

        return response()->json([
            'event' => [
                'id' => $event->id,
                'name' => $event->name,
            ],
            'templates' => $templates,
        ]);
    }

    public function store(Event $event, Request $request): JsonResponse
    {
        $data = [
            'slide' => [],
            'type' => [],
            'name' => [],
            'cached_html_preview' => [],
            'cached_html_final' => [],
            'id' => [],
        ];

        foreach ($request->input('slides', []) as $slide) {
            $key = $slide['key'];
            $data['slide'][$key] = $slide['definitions'];
            $data['type'][$key] = $slide['type'];
            $data['name'][$key] = $slide['name'];
            $data['cached_html_preview'][$key] = $slide['cached_html_preview'] ?? '';
            $data['cached_html_final'][$key] = $slide['cached_html_final'] ?? '';
            if (isset($slide['id'])) {
                $data['id'][$key] = $slide['id'];
            }
        }

        PlaylistService::generateEventPlaylist($event, $data);

        return response()->json(['status' => 'ok']);
    }
}
