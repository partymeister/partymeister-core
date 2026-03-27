<?php

namespace Partymeister\Core\Http\Requests\Api\V2;

class GuestPatchRequest extends GuestPostRequest
{
    public function rules(): array
    {
        return collect(parent::rules())
            ->mapWithKeys(fn ($rule, $key) => [$key => 'sometimes|'.$rule])
            ->all();
    }
}
