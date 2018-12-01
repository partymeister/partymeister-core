<?php

namespace Partymeister\Core\Services\Component;

use Partymeister\Core\Models\Component\ComponentVisitorLogin;
use Motor\CMS\Services\ComponentBaseService;

class ComponentVisitorLoginService extends ComponentBaseService
{

    protected $model = ComponentVisitorLogin::class;

    protected $name = 'visitor-login';
}
