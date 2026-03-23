<?php

namespace Partymeister\Core\Http\Requests\Api\V2\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'access_key' => 'required|string',
            'group' => 'nullable|string',
            'country_iso_3166_1' => 'nullable|string',
        ];
    }
}
