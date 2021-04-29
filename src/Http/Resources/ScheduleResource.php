<?php

namespace Partymeister\Core\Http\Resources;

use Motor\Backend\Http\Resources\BaseResource;

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
class ScheduleResource extends BaseResource
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
            'id'     => (int) $this->id,
            'name'   => $this->name,
            'events' => EventResource::collection($this->whenLoaded('events')),
        ];
    }
}
