<?php

namespace Partymeister\Core\Http\Resources\Profile;

use Motor\Backend\Http\Resources\BaseResource;

/**
 * @OA\Schema(
 *   schema="ProfileVisitorResource",
 *
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="MyCoolHandle"
 *   ),
 *   @OA\Property(
 *     property="group",
 *     type="string",
 *     example="MyAwesomeGroup"
 *   ),
 *   @OA\Property(
 *     property="country_iso_3166_1",
 *     type="string",
 *     example="DE"
 *   ),
 *   @OA\Property(
 *     property="email",
 *     type="string",
 *     example="mycoolemail@myawesomegroup.com"
 *   ),
 *   @OA\Property(
 *     property="additional_data",
 *     type="json",
 *     example="{}"
 *   ),
 *   @OA\Property(
 *     property="api_token",
 *     type="string",
 *     example="abcdef"
 *   ),
 * )
 */
class VisitorResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'group' => $this->group,
            'country_iso_3166_1' => $this->country_iso_3166_1,
            'email' => $this->email,
            'additional_data' => $this->additional_data,
            'api_token' => $this->api_token,
        ];
    }
}
