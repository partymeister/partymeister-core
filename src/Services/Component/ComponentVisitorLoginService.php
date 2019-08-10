<?php

namespace Partymeister\Core\Services\Component;

use Motor\CMS\Services\ComponentBaseService;
use Partymeister\Core\Models\Component\ComponentVisitorLogin;

/**
 * Class ComponentVisitorLoginService
 * @package Partymeister\Core\Services\Component
 */
class ComponentVisitorLoginService extends ComponentBaseService
{

    protected $model = ComponentVisitorLogin::class;

    protected $name = 'visitor-login';
}
