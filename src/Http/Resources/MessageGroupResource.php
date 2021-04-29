<?php

namespace Partymeister\Core\Http\Resources;

use Motor\Backend\Http\Resources\BaseResource;

/**
 * @OA\Schema(
 *   schema="MessageGroupResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="My message group"
 *   ),
 *   @OA\Property(
 *     property="uuid",
 *     type="string",
 *     example="75b0bcbc-a5af-11eb-bcbc-0242ac130002"
 *   ),
 * )
 */
class MessageGroupResource extends BaseResource
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
            'id'   => (int) $this->id,
            'name' => $this->name,
            'uuid' => $this->uuid,
        ];
    }
}
