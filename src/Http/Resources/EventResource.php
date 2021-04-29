<?php

namespace Partymeister\Core\Http\Resources;

use Motor\Backend\Http\Resources\BaseResource;

/**
 * @OA\Schema(
 *   schema="EventResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="schedule_id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="event_type_id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="My event"
 *   ),
 *   @OA\Property(
 *     property="starts_at",
 *     type="datetime",
 *     example="2021-05-28 12:00:00"
 *   ),
 *   @OA\Property(
 *     property="ends_at",
 *     type="datetime",
 *     example="2021-05-28 14:00:00"
 *   ),
 *   @OA\Property(
 *     property="is_visible",
 *     type="boolean",
 *     example="true"
 *   ),
 *   @OA\Property(
 *     property="is_organizer_only",
 *     type="boolean",
 *     example="false"
 *   ),
 *   @OA\Property(
 *     property="notify_minues",
 *     type="integer",
 *     example="30"
 *   ),
 *   @OA\Property(
 *     property="link",
 *     type="string",
 *     example="https://my-event.com"
 *   ),
 *   @OA\Property(
 *     property="sort_position",
 *     type="integer",
 *     example="2"
 *   ),
 * )
 */
class EventResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => (int) $this->id,
            'name'              => $this->name,
            'schedule'          => new ScheduleResource($this->schedule),
            'event_type'        => new EventTypeResource($this->event_type),
            'starts_at'         => $this->starts_at,
            'ends_at'           => $this->ends_at,
            'is_visible'        => (boolean) $this->is_visible,
            'is_organizer_only' => (boolean) $this->is_organizer_only,
            'sort_position'     => (int) $this->sort_position,
            'notify_minutes'    => (int) $this->notify_minutes,
            'link'              => $this->link,
        ];
    }
}
