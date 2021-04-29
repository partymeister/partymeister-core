<?php

namespace Partymeister\Core\Http\Resources;

use Motor\Backend\Http\Resources\BaseResource;

/**
 * @OA\Schema(
 *   schema="CallbackResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="My callback"
 *   ),
 *   @OA\Property(
 *     property="action",
 *     type="string",
 *     example="live_voting"
 *   ),
 *   @OA\Property(
 *     property="payload",
 *     type="json",
 *     example="{}"
 *   ),
 *   @OA\Property(
 *     property="title",
 *     type="string",
 *     example="Test Callback!"
 *   ),
 *   @OA\Property(
 *     property="body",
 *     type="string",
 *     example="Elaborate prosaic description of the content"
 *   ),
 *   @OA\Property(
 *     property="link",
 *     type="string",
 *     example="https://www.mycallback.com"
 *   ),
 *   @OA\Property(
 *     property="destination",
 *     type="json",
 *     example="public"
 *   ),
 *   @OA\Property(
 *     property="is_timed",
 *     type="boolean",
 *     example="true"
 *   ),
 *   @OA\Property(
 *     property="has_fired",
 *     type="boolean",
 *     example="false"
 *   ),
 *   @OA\Property(
 *     property="fired_at",
 *     type="datetime",
 *     example="2021-05-28 12:12:12"
 *   ),
 *   @OA\Property(
 *     property="embargo_until",
 *     type="datetime",
 *     example="2021-05-28 12:00:00"
 *   ),
 *   @OA\Property(
 *     property="hash",
 *     type="string",
 *     example="1a9aa8a4-a5b1-11eb-bcbc-0242ac130002"
 *   ),
 * )
 */
class CallbackResource extends BaseResource
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
            'id'            => (int) $this->id,
            'name'          => $this->name,
            'action'        => $this->action,
            'payload'       => $this->payload,
            'title'         => $this->title,
            'body'          => $this->body,
            'link'          => $this->link,
            'destination'   => $this->destination,
            'hash'          => $this->hash,
            'embargo_until' => $this->embargo_until,
            'fired_at'      => (boolean) $this->fired_at,
            'has_fired'     => (boolean) $this->has_fired,
            'is_timed'      => (boolean) $this->is_timed,
        ];
    }
}
