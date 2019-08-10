<?php

namespace Partymeister\Core\Services;

use Motor\Backend\Services\BaseService;
use Partymeister\Core\Models\EventItem;

/**
 * Class EventItemService
 * @package Partymeister\Core\Services
 */
class EventItemService extends BaseService
{

    /**
     * @var string
     */
    protected $model = EventItem::class;
}
