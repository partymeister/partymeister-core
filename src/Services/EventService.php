<?php

namespace Partymeister\Core\Services;

use Motor\Admin\Services\BaseService;
use Motor\Core\Filter\Renderers\SelectRenderer;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Models\EventType;

/**
 * Class EventService
 */
class EventService extends BaseService
{
    protected string $model = Event::class;

    protected array $loadColumns = ['event_type', 'schedule'];

    public function filters(): void
    {
        $this->filter->add(new SelectRenderer('event_type_id'))
            ->setOptionPrefix(trans('partymeister-core::backend/event_types.event_type'))
            ->setEmptyOption('-- '.trans('partymeister-core::backend/event_types.event_type').' --')
            ->setOptions(EventType::pluck('name', 'id'));
    }
}
