<?php

namespace Partymeister\Core\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class CallbackRequest
 *
 * @package Partymeister\Core\Http\Requests\Backend
 */
class CallbackRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="CallbackRequest",
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
     *     type="string",
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
     *   required={"name", "action", "title", "destination", "is_timed"},
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
            'name'          => 'required',
            'action'        => 'required|in:'.implode(',', array_flip(trans('partymeister-core::backend/callbacks.actions'))),
            'payload'       => 'nullable',
            'title'         => 'required',
            'body'          => 'nullable',
            'link'          => 'nullable|url',
            'destination'   => 'required|in:'.implode(',', array_flip(trans('partymeister-core::backend/callbacks.destinations'))),
            'is_timed'      => 'nullable|boolean',
            'has_fired'     => 'nullable|boolean',
            'fired_at'      => 'nullable|date_format:Y-m-d H:i:s',
            'embargo_until' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }
}
