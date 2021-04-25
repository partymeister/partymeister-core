<?php

namespace Partymeister\Core\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   schema="ScheduleResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="Main schedule"
 *   ),
 * )
 */
class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $comesFromEventEndpoint = ($request->route()
                                           ->uri() === 'api/events') ? true : false;

        $events = $this->events()
                       ->orderBy('starts_at', 'ASC')
                       ->orderBy('sort_position', 'ASC')
                       ->orderBy('event_type_id', 'ASC')
                       ->orderBy('name', 'ASC');

        return [
            'id'     => (int) $this->id,
            'name'   => $this->name,
            'events' => $this->when(! $comesFromEventEndpoint, EventResource::collection($events->get())),
        ];
    }
}
