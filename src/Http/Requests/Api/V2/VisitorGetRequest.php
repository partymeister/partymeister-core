<?php

namespace Partymeister\Core\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class VisitorGetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
