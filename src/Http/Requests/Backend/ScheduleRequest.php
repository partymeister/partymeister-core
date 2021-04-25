<?php

namespace Partymeister\Core\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class ScheduleRequest
 *
 * @package Partymeister\Core\Http\Requests\Backend
 */
class ScheduleRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="ScheduleRequest",
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="Main schedule"
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
        return [
            'name' => 'required',
        ];
    }
}
