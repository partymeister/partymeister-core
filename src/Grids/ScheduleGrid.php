<?php

namespace Partymeister\Core\Grids;

use Motor\Backend\Grid\Grid;

class ScheduleGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('name', trans('motor-backend::backend/global.name'), true);
        $this->addColumn('event_count', trans('partymeister-core::backend/events.events'), true);
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.schedules.edit');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.schedules.destroy');
    }
}
