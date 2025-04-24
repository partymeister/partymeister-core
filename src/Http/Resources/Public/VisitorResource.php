<?php

namespace Partymeister\Core\Http\Resources\Public;

use Motor\Backend\Http\Resources\BaseResource;

/**
 * @OA\Schema(
 *   schema="PublicVisitorResource",
 *
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
 *   )
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
            'name' => $this->name,
            'group' => $this->group,
            'country_iso_3166_1' => $this->country_iso_3166_1,
        ];
    }
}
