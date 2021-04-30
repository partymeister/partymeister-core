<?php

namespace Partymeister\Core\Grids;

use Motor\Backend\Grid\Grid;

/**
 * Class ScheduleGrid
 *
 * @package Partymeister\Core\Grids
 */
class ScheduleGrid extends Grid
{
    protected function setup()
    {
        $this->addColumn('name', trans('motor-backend::backend/global.name'), true);
        $this->addColumn('event_count', trans('partymeister-core::backend/events.events'), true);

        $this->addAction(trans('partymeister-core::backend/schedules.generate_slides'), 'backend.schedules.slides.index', ['class' => 'btn-primary'])
             ->needsPermissionTo('schedules.read')
             ->onCondition('event_count', 0, '>');
        $this->addAction(trans('motor-backend::backend/global.show'), 'backend.schedules.show', ['class' => 'btn-primary'])
             ->needsPermissionTo('schedules.read')
             ->onCondition('event_count', 0, '>');

        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.schedules.edit');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.schedules.destroy');
    }
}
