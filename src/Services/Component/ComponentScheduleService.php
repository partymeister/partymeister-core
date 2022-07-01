<?php

namespace Partymeister\Core\Services\Component;

use Motor\CMS\Services\ComponentBaseService;
use Partymeister\Core\Models\Component\ComponentSchedule;

/**
 * Class ComponentScheduleService
 */
class ComponentScheduleService extends ComponentBaseService
{
    /**
     * @var string
     */
    protected $model = ComponentSchedule::class;

    /**
     * @var string
     */
    protected $name = 'schedule';
}
