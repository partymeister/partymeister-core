<?php

namespace Partymeister\Core\Services\Component;

use Partymeister\Core\Models\Component\ComponentSchedule;
use Motor\CMS\Services\ComponentBaseService;

class ComponentScheduleService extends ComponentBaseService
{

    protected $model = ComponentSchedule::class;

    protected $name = 'schedule';
}
