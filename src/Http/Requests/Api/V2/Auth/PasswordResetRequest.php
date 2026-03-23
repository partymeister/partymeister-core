<?php

namespace Partymeister\Core\Http\Requests\Api\V2\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => 'required|string',
            'password' => 'required|string|min:6',
        ];
    }
}
