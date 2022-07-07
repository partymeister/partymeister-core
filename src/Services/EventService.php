<?php

namespace Partymeister\Core\Services;

use Motor\Admin\Services\BaseService;
use Motor\Core\Filter\Renderers\SelectRenderer;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Models\EventType;
use Partymeister\Core\Models\Schedule;

/**
 * Class EventService
 */
class EventService extends BaseService
{
    /**
     * @var string
     */
    protected $model = Event::class;

    public function filters()
    {
        $this->filter->add(new SelectRenderer('schedule_id'))
                     ->setOptionPrefix(trans('partymeister-core::backend/schedules.schedule'))
                     ->setEmptyOption('-- '.trans('partymeister-core::backend/schedules.schedule').' --')
                     ->setOptions(Schedule::pluck('name', 'id'));

        $this->filter->add(new SelectRenderer('event_type_id'))
                     ->setOptionPrefix(trans('partymeister-core::backend/event_types.event_type'))
                     ->setEmptyOption('-- '.trans('partymeister-core::backend/event_types.event_type').' --')
                     ->setOptions(EventType::pluck('name', 'id'));
    }
}
