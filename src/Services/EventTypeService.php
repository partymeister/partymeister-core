<?php

namespace Partymeister\Core\Services;

use Motor\Admin\Services\BaseService;
use Partymeister\Core\Models\EventType;

/**
 * Class EventTypeService
 */
class EventTypeService extends BaseService
{
    /**
     * @var string
     */
    protected $model = EventType::class;
}
