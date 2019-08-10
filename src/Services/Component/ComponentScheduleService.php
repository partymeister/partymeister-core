<?php

namespace Partymeister\Core\Services\Component;

use Motor\CMS\Services\ComponentBaseService;
use Partymeister\Core\Models\Component\ComponentSchedule;

/**
 * Class ComponentScheduleService
 * @package Partymeister\Core\Services\Component
 */
class ComponentScheduleService extends ComponentBaseService
{

    protected $model = ComponentSchedule::class;

    protected $name = 'schedule';
}
