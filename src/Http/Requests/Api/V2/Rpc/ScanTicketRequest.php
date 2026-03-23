<?php

namespace Partymeister\Core\Http\Requests\Api\V2\Rpc;

use Illuminate\Foundation\Http\FormRequest;

class ScanTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ticket_code' => 'required|string',
        ];
    }
}
