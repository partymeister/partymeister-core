<?php

namespace Partymeister\Core\Grids;

use Motor\Backend\Grid\Grid;
use Motor\Backend\Grid\Renderers\BladeRenderer;
use Motor\Backend\Grid\Renderers\BooleanRenderer;
use Motor\Backend\Grid\Renderers\DateRenderer;

/**
 * Class EventGrid
 *
 * @package Partymeister\Core\Grids
 */
class EventGrid extends Grid
{
    protected function setup()
    {
        $this->addColumn('name', trans('motor-backend::backend/global.name'), true);

        $this->addColumn('event_type.name', trans('partymeister-core::backend/event_types.event_type'))
             ->renderer(BladeRenderer::class, ['template' => 'partymeister-core::grid.event_type']);

        $this->addColumn('starts_at', trans('partymeister-core::backend/events.starts_at'), true)
             ->renderer(DateRenderer::class, ['format' => 'Y-m-d H:i']);

        $this->addColumn('starts_at', trans('partymeister-core::backend/events.starts_at'), true)
             ->renderer(DateRenderer::class, ['format' => 'Y-m-d H:i']);

        $this->addColumn('sort_position', trans('partymeister-core::backend/events.sort_position'), true)
             ->renderer(BladeRenderer::class, [
                     'template' => 'partymeister-core::grid.input_callback',
                     'field'    => 'sort_position',
                 ]);

        $this->addColumn('is_visible', trans('partymeister-core::backend/events.is_visible'), true)
             ->renderer(BooleanRenderer::class);
        $this->addColumn('is_organizer_only', trans('partymeister-core::backend/events.is_organizer_only'), true)
             ->renderer(BooleanRenderer::class);
        $this->setDefaultSorting('starts_at', 'ASC');

        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.events.edit');
        $this->addDuplicateAction(trans('motor-backend::backend/global.duplicate'), 'backend.events.duplicate')
             ->needsPermissionTo('events.write');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.events.destroy');
    }
}
