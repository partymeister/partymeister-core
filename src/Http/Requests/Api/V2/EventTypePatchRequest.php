<?php

namespace Partymeister\Core\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class EventTypePatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'web_color' => 'nullable|string|max:255',
            'slide_color' => 'nullable|string|max:255',
        ];
    }
}
