<?php

namespace Partymeister\Core\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class EventPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'schedule_id' => 'required|exists:schedules,id',
            'event_type_id' => 'required|exists:event_types,id',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date',
            'is_visible' => 'boolean',
            'is_organizer_only' => 'boolean',
            'sort_position' => 'integer',
            'notify_minutes' => 'integer|nullable',
            'link' => 'nullable|string',
        ];
    }
}
