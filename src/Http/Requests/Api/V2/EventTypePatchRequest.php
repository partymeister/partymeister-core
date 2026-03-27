<?php

namespace Partymeister\Core\Http\Requests\Api\V2;

class EventTypePatchRequest extends EventTypePostRequest
{
    public function rules(): array
    {
        return collect(parent::rules())
            ->mapWithKeys(fn ($rule, $key) => [$key => 'sometimes|'.$rule])
            ->all();
    }
}
