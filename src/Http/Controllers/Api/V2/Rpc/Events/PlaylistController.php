<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\Rpc\Events;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Partymeister\Core\Models\Event;
use Partymeister\Slides\Models\SlideTemplate;
use Partymeister\Slides\Services\PlaylistService;

/**
 * @tags Core: Events
 */
class PlaylistController extends Controller
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
            'data' => [
                'event' => ['id' => $event->id, 'name' => $event->name],
                'templates' => $templates,
            ],
            'meta' => ['api_version' => 'v2', 'message' => 'Event playlist data retrieved'],
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

        app(PlaylistService::class)->generateEventPlaylist($event, $data);

        return response()->json([
            'data' => ['status' => 'ok'],
            'meta' => ['api_version' => 'v2', 'message' => 'Event playlist generated'],
        ]);
    }
}
