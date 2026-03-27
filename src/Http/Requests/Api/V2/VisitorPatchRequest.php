<?php

namespace Partymeister\Core\Http\Requests\Api\V2;

class VisitorPatchRequest extends VisitorPostRequest
{
    public function rules(): array
    {
        $rules = collect(parent::rules())
            ->mapWithKeys(fn ($rule, $key) => [$key => 'sometimes|'.$rule])
            ->all();

        $rules['email'] = 'sometimes|nullable|email|unique:visitors,email,'.$this->visitor?->id;

        return $rules;
    }
}
