<?php

namespace Partymeister\Core\Services\Component;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Partymeister\Competitions\Models\AccessKey;
use Partymeister\Core\Models\Visitor;
use Request;

/**
 * Class VisitorRegistrationService
 *
 * @package Partymeister\Core\Services\Component
 */
class VisitorRegistrationService
{
    /**
     * @param $data
     */
    public static function register($data)
    {
        $visitor = Visitor::create([
            'name'               => $data['name'],
            'group'              => $data['group'],
            'country_iso_3166_1' => $data['country_iso_3166_1'],
            //'email'              => $data['email'],
            'password'           => bcrypt($data['password']),
            'api_token'          => Str::random(60),
        ]);
        if (config('partymeister-core-visitor-registration.require_access_key')) {
            $accessKey = AccessKey::where('access_key', $data['access_key'])
                                  ->first();
            $accessKey->visitor_id = $visitor->id;
            $accessKey->ip_address = Request::ip();
            $accessKey->registered_at = date('Y-m-d H:i:s');
            $accessKey->save();
        }

        event(new Registered($visitor));

        Auth::guard('visitor')
            ->login($visitor);
    }
}
