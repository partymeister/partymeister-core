<?php

namespace Partymeister\Core\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

// TODO: is this class still needed?

/**
 * Class MessageGroupRequest
 *
 * @package Partymeister\Core\Http\Requests\Backend
 */
class MessageGroupRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="MessageGroupRequest",
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="My message group"
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
