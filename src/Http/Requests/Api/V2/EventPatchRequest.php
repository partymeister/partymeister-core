<?php

namespace Partymeister\Core\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class EventPatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'schedule_id' => 'sometimes|required|exists:schedules,id',
            'event_type_id' => 'sometimes|required|exists:event_types,id',
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
