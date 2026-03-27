<?php

namespace Partymeister\Core\Services\Component;

use Motor\CMS\Services\ComponentBaseService;
use Partymeister\Core\Models\Component\ComponentVisitorLogin;

/**
 * Class ComponentVisitorLoginService
 */
class ComponentVisitorLoginService extends ComponentBaseService
{
    protected string $model = ComponentVisitorLogin::class;

    /**
     * @var string
     */
    protected $name = 'visitor-login';
}
