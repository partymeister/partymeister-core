<?php

namespace Partymeister\Core\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class VisitorRequest
 *
 * @package Partymeister\Core\Http\Requests\Backend
 */
class VisitorRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="VisitorRequest",
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
     *     property="password",
     *     type="string",
     *     example="secret-password"
     *   ),
     *   @OA\Property(
     *     property="additional_data",
     *     type="json",
     *     example="{}"
     *   ),
     *   required={"name", "country_iso_3166_1"},
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
        return [
            'name'               => 'required',
            'group'              => 'nullable',
            'country_iso_3166_1' => 'required',
            'email'              => 'nullable|unique:visitors,email',
            'password'           => 'nullable',
            'additional_data'    => 'nullable|json',
        ];
    }
}
