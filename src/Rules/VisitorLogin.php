<?php

namespace Partymeister\Core\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class VisitorLogin implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $name = Arr::get(request()->all(), 'visitor-login.name');

        $guard = Auth::guard('visitor');

        return $guard->attempt(['name'     => $name,
                                'password' => $value,
        ], true); // second parameter is the "remember flag"
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
