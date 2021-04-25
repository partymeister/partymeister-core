<?php

namespace Partymeister\Core\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class EventTypeRequest
 *
 * @package Partymeister\Core\Http\Requests\Backend
 */
class EventTypeRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="EventTypeRequest",
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="My event type"
     *   ),
     *   @OA\Property(
     *     property="web_color",
     *     type="string",
     *     example="#ff0000"
     *   ),
     *   @OA\Property(
     *     property="slide_color",
     *     type="string",
     *     example="#00ff00"
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
            'name'        => 'required',
            'web_color'   => 'nullable',
            'slide_color' => 'nullable',
        ];
    }
}
