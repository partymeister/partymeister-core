<?php

namespace Partymeister\Core\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class GuestPatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|nullable|integer',
            'handle' => 'sometimes|nullable|string|max:255',
            'email' => 'sometimes|nullable|email',
            'company' => 'sometimes|nullable|string|max:255',
            'country' => 'sometimes|nullable|string|max:255',
            'ticket_code' => 'sometimes|nullable|string|max:255',
            'ticket_type' => 'sometimes|nullable|string|max:255',
            'ticket_order_number' => 'sometimes|nullable|string|max:255',
            'has_badge' => 'sometimes|boolean',
            'has_arrived' => 'sometimes|boolean',
            'ticket_code_scanned' => 'sometimes|boolean',
            'comment' => 'sometimes|nullable|string',
            'arrived_at' => 'sometimes|nullable|date',
        ];
    }
}
