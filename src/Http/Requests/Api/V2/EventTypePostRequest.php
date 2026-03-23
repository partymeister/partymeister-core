<?php

namespace Partymeister\Core\Http\Requests\Api\V2;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EventTypePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'web_color' => 'nullable|string|max:255',
            'slide_color' => 'nullable|string|max:255',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'error' => [
                'code' => 'VALIDATION_ERROR',
                'message' => 'The given data was invalid.',
                'details' => $validator->errors(),
            ],
            'meta' => [
                'api_version' => 'v2',
            ],
        ], 422));
    }
}
