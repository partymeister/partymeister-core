<?php

namespace Partymeister\Core\Services\Component;

use Illuminate\Support\Facades\Auth;

/**
 * Class VisitorLoginService
 *
 * @package Partymeister\Core\Services\Component
 */
class VisitorLoginService
{
    /**
     * @param $data
     * @return bool
     */
    public static function validateLogin($data)
    {
        $guard = Auth::guard('visitor');

        return $guard->attempt($data, true); // second parameter is the "remember flag"
    }

    /**
     * @return bool
     */
    public static function logout()
    {
        Auth::guard('visitor')
            ->logout();

        return true;
    }
}
