<?php

namespace Partymeister\Core\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class EventRequest
 *
 * @package Partymeister\Core\Http\Requests\Backend
 */
class EventRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="EventRequest",
     *   @OA\Property(
     *     property="schedule_id",
     *     type="integer",
     *     example="1"
     *   ),
     *   @OA\Property(
     *     property="event_type_id",
     *     type="integer",
     *     example="1"
     *   ),
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="My event"
     *   ),
     *   @OA\Property(
     *     property="starts_at",
     *     type="datetime",
     *     example="2021-05-28 12:00:00"
     *   ),
     *   @OA\Property(
     *     property="ends_at",
     *     type="datetime",
     *     example="2021-05-28 14:00:00"
     *   ),
     *   @OA\Property(
     *     property="is_visible",
     *     type="boolean",
     *     example="true"
     *   ),
     *   @OA\Property(
     *     property="is_organizer_only",
     *     type="boolean",
     *     example="false"
     *   ),
     *   @OA\Property(
     *     property="notify_minues",
     *     type="integer",
     *     example="30"
     *   ),
     *   @OA\Property(
     *     property="link",
     *     type="string",
     *     example="https://my-event.com"
     *   ),
     *   @OA\Property(
     *     property="sort_position",
     *     type="integer",
     *     example="2"
     *   ),
     *   required={"name", "schedule_id", "event_type_id", "starts_at"},
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
                    'name'              => 'required',
                    'schedule_id'       => 'required|integer|exists:schedules,id',
                    'event_type_id'     => 'required|integer|exists:event_types,id',
                    'starts_at'         => 'required|date_format:Y-m-d H:i:s',
                    'ends_at'           => 'nullable|date_format:Y-m-d H:i:s',
                    'is_visible'        => 'nullable|boolean',
                    'is_organizer_only' => 'nullable|boolean',
                    'sort_position'     => 'nullable|integer',
                    'notify_minutes'    => 'nullable|integer',
                    'link'              => 'nullable',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'schedule_id'   => 'nullable|integer|exists:schedules,id',
                    'event_type_id' => 'nullable|integer|exists:event_types,id',
                ];
        }
    }
}
