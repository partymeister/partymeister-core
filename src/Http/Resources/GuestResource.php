<?php

namespace Partymeister\Core\Http\Resources;

use Motor\Backend\Http\Resources\BaseResource;

/**
 * @OA\Schema(
 *   schema="GuestResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="Guesty McGuestface"
 *   ),
 *   @OA\Property(
 *     property="handle",
 *     type="string",
 *     example="Guest^Group"
 *   ),
 *   @OA\Property(
 *     property="email",
 *     type="string",
 *     example="guesty@mcguestface.com"
 *   ),
 *   @OA\Property(
 *     property="company",
 *     type="string",
 *     example="MyCompany Ltd."
 *   ),
 *   @OA\Property(
 *     property="country",
 *     type="string",
 *     example="United Kingdom"
 *   ),
 *   @OA\Property(
 *     property="ticket_code",
 *     type="string",
 *     example="GOOD-TICKET"
 *   ),
 *   @OA\Property(
 *     property="ticket_type",
 *     type="string",
 *     example="Supporter"
 *   ),
 *   @OA\Property(
 *     property="ticket_order_number",
 *     type="string",
 *     example="R22102030"
 *   ),
 *   @OA\Property(
 *     property="has_badge",
 *     type="boolean",
 *     example="false"
 *   ),
 *   @OA\Property(
 *     property="has_arrived",
 *     type="boolean",
 *     example="true"
 *   ),
 *   @OA\Property(
 *     property="ticket_code_scanned",
 *     type="boolean",
 *     example="true"
 *   ),
 *   @OA\Property(
 *     property="comment",
 *     type="string",
 *     example="Gets a visitor shirt in XL"
 *   ),
 *   @OA\Property(
 *     property="arrived_at",
 *     type="datetime",
 *     example="2021-05-28 12:00:00"
 *   ),
 *   @OA\Property (
 *     property="category_id",
 *     type="integer",
 *     example="1"
 *   ),
 * )
 */
class GuestResource extends BaseResource
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
            'id'                  => (int) $this->id,
            'category_id'         => (int) $this->category_id,
            'name'                => $this->name,
            'handle'              => $this->handle,
            'email'               => $this->email,
            'company'             => $this->company,
            'country'             => $this->country,
            'ticket_code'         => $this->ticket_code,
            'ticket_type'         => $this->ticket_type,
            'ticket_order_number' => $this->ticket_order_number,
            'has_badge'           => (boolean) $this->has_badge,
            'has_arrived'         => (boolean) $this->has_arrived,
            'ticket_code_scanned' => (boolean) $this->ticket_code_scanned,
            'comment'             => $this->comment,
            'arrived_at'          => $this->arrived_at,
        ];
    }
}
