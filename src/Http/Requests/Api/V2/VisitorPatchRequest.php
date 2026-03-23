<?php

namespace Partymeister\Core\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class VisitorPatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'password' => 'sometimes|nullable|string|min:6',
            'group' => 'nullable|string|max:255',
            'country_iso_3166_1' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'additional_data' => 'nullable|array',
        ];
    }
}
