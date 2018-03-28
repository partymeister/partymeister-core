<?php

namespace Partymeister\Core\Services;

use Motor\Core\Filter\Renderers\SelectRenderer;
use Partymeister\Core\Models\Event;
use Motor\Backend\Services\BaseService;
use Partymeister\Core\Models\EventType;

class EventService extends BaseService
{

    protected $model = Event::class;


    public function filters()
    {
        $this->filter->add(new SelectRenderer('event_type_id'))
                     ->setOptionPrefix(trans('partymeister-core::backend/event_types.event_type'))
                     ->setEmptyOption('-- ' . trans('partymeister-core::backend/event_types.event_type') . ' --')
                     ->setOptions(EventType::pluck('name', 'id'));
    }
}
