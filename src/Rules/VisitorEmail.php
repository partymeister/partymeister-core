<?php

namespace Partymeister\Core\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Partymeister\Core\Models\Visitor;

class VisitorEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $visitor = Visitor::where('email', Arr::get(request()->all(), 'password-forgotten.email'))->first();

        return !is_null($visitor);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Nobody with this email found #sadness';
    }
}
