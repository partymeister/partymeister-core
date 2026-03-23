<?php

namespace Partymeister\Core\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class GuestPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|integer',
            'handle' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'company' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'ticket_code' => 'nullable|string|max:255',
            'ticket_type' => 'nullable|string|max:255',
            'ticket_order_number' => 'nullable|string|max:255',
            'has_badge' => 'boolean',
            'has_arrived' => 'boolean',
            'ticket_code_scanned' => 'boolean',
            'comment' => 'nullable|string',
            'arrived_at' => 'nullable|date',
        ];
    }
}
