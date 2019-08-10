<?php

namespace Partymeister\Core\Services;

use Motor\Backend\Services\BaseService;
use Partymeister\Core\Models\EventType;

/**
 * Class EventTypeService
 * @package Partymeister\Core\Services
 */
class EventTypeService extends BaseService
{

    protected $model = EventType::class;
}
