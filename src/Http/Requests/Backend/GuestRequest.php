<?php

namespace Partymeister\Core\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class GuestRequest
 *
 * @package Partymeister\Core\Http\Requests\Backend
 */
class GuestRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="GuestRequest",
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
     *   required={"name"},
     * )
     */

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // FIXME: separate request class for ApiRequest
        switch ($this->method()) {
            case 'POST':
                return [
                    'category_id'         => 'required|integer|exists:categories,id',
                    'name'                => 'required',
                    'handle'              => 'nullable',
                    'email'               => 'nullable|email',
                    'company'             => 'nullable',
                    'country'             => 'nullable',
                    'ticket_code'         => 'nullable',
                    'ticket_type'         => 'nullable',
                    'ticket_order_number' => 'nullable',
                    'has_badge'           => 'nullable|boolean',
                    'has_arrived'         => 'nullable|boolean',
                    'ticket_code_scanned' => 'nullable|boolean',
                    'comment'             => 'nullable',
                    'arrived_at'          => 'nullable|date_format:Y-m-d H:i:s',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'category_id' => 'nullable|integer|exists:categories,id',
                    'arrived_at'  => 'nullable|date_format:Y-m-d H:i:s',
                ];
        }
    }
}
