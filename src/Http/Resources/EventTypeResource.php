<?php

namespace Partymeister\Core\Http\Resources;

use Motor\Backend\Http\Resources\BaseResource;

/**
 * @OA\Schema(
 *   schema="EventTypeResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="My event type"
 *   ),
 *   @OA\Property(
 *     property="web_color",
 *     type="string",
 *     example="#ff0000"
 *   ),
 *   @OA\Property(
 *     property="slide_color",
 *     type="string",
 *     example="#00ff00"
 *   ),
 * )
 */
class EventTypeResource extends BaseResource
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
            'id'          => (int) $this->id,
            'name'        => $this->name,
            'web_color'   => $this->web_color,
            'slide_color' => $this->slide_color,
        ];
    }
}
