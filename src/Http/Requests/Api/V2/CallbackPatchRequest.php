<?php

namespace Partymeister\Core\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class CallbackPatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'action' => 'nullable|string|max:255',
            'payload' => 'nullable',
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'destination' => 'nullable|string|max:255',
            'embargo_until' => 'nullable|date',
            'is_timed' => 'boolean',
        ];
    }
}
