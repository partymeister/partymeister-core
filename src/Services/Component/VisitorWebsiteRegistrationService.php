<?php

namespace Partymeister\Core\Services\Component;

use Partymeister\Core\Events\VisitorRegistered;
use Partymeister\Core\Models\Visitor;

class VisitorWebsiteRegistrationService
{

    public static function register($data)
    {
        $visitor = Visitor::create([
            'name'               => $data['name'],
            'group'              => $data['group'],
            'country_iso_3166_1' => $data['country_iso_3166_1'],
            'api_token'          => str_random(60),
        ]);

        event(new VisitorRegistered($visitor));
    }
}
