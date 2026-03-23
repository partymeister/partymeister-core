<?php

namespace Partymeister\Core\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class VisitorPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'group' => 'nullable|string|max:255',
            'country_iso_3166_1' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:visitors,email',
            'additional_data' => 'nullable|array',
        ];
    }
}
