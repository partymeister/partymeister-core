<?php

namespace Partymeister\Core\Services\Component;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Partymeister\Competitions\Models\AccessKey;
use Partymeister\Core\Models\Visitor;
use Request;

/**
 * Class VisitorRegistrationService
 */
class VisitorRegistrationService
{
    public static function register($data)
    {
        if (Visitor::where('email', $data['email'])->exists()) {
            throw ValidationException::withMessages([
                'visitor-registration.email' => [trans('partymeister-core::component/visitor-registrations.email_already_registered')],
            ]);
        }

        $visitor = Visitor::create([
            'name' => $data['name'],
            'group' => $data['group'],
            'country_iso_3166_1' => $data['country_iso_3166_1'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'api_token' => Str::random(60),
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
