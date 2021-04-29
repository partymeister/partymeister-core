<?php

namespace Partymeister\Core\Http\Resources\Components;

use Motor\Backend\Http\Resources\BaseResource;

/**
 * @OA\Schema(
 *   schema="ComponentVisitorLoginResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="visitor_registration_page_id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="entries_page_id",
 *     type="integer",
 *     example="2"
 *   ),
 *   @OA\Property(
 *     property="voting_page_id",
 *     type="integer",
 *     example="3"
 *   ),
 *   @OA\Property(
 *     property="comments_page_1",
 *     type="integer",
 *     example="4"
 *   ),
 * )
 */
class ComponentVisitorLoginResource extends BaseResource
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
            'id'                           => (int) $this->id,
            'visitor_registration_page_id' => $this->visitor_registration_page_id,
            'entries_page_id'              => $this->entries_page_id,
            'voting_page_id'               => $this->voting_page_id,
            'comments_page_id'             => $this->comments_page_id,
        ];
    }
}
