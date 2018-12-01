<?php

namespace Partymeister\Core\Services\Component;

use Illuminate\Support\Facades\Auth;

class VisitorLoginService
{
    public static function validateLogin($data)
    {
        $guard = Auth::guard('visitor');

        return $guard->attempt($data, true); // second parameter is the "remember flag"
    }

    public static function logout()
    {
        Auth::guard('visitor')->logout();

        return true;
    }
}
