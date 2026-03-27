<?php

namespace Partymeister\Core\Grids;

use Motor\Admin\Grid\Grid;

/**
 * Class ScheduleGrid
 */
class ScheduleGrid extends Grid
{
    protected function setup()
    {
        $this->addColumn('name', trans('motor-admin::backend/global.name'), true);
        $this->addColumn('event_count', trans('partymeister-core::backend/events.events'), true);

        $this->addAction(trans('partymeister-core::backend/schedules.generate_slides'), 'backend.slidemeister-generator.schedule', ['class' => 'btn-success', 'target' => '_blank'])
            ->needsPermissionTo('schedules.read')
            ->onCondition('event_count', 0, '>');
        $this->addAction(trans('motor-admin::backend/global.show'), 'backend.schedules.show', ['class' => 'btn-primary'])
            ->needsPermissionTo('schedules.read')
            ->onCondition('event_count', 0, '>');

        $this->addEditAction(trans('motor-admin::backend/global.edit'), 'backend.schedules.edit');
        $this->addDeleteAction(trans('motor-admin::backend/global.delete'), 'backend.schedules.destroy');
    }
}
