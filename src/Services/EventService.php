<?php

namespace Partymeister\Core\Services;

use Motor\Backend\Services\BaseService;
use Motor\Core\Filter\Renderers\SelectRenderer;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Models\EventType;

/**
 * Class EventService
 *
 * @package Partymeister\Core\Services
 */
class EventService extends BaseService
{
    /**
     * @var string
     */
    protected $model = Event::class;

    public function filters()
    {
        $this->filter->add(new SelectRenderer('event_type_id'))
                     ->setOptionPrefix(trans('partymeister-core::backend/event_types.event_type'))
                     ->setEmptyOption('-- '.trans('partymeister-core::backend/event_types.event_type').' --')
                     ->setOptions(EventType::pluck('name', 'id'));
    }
}
