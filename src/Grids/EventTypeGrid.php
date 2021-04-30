<?php

namespace Partymeister\Core\Grids;

use Motor\Backend\Grid\Grid;
use Motor\Backend\Grid\Renderers\BladeRenderer;

/**
 * Class EventTypeGrid
 *
 * @package Partymeister\Core\Grids
 */
class EventTypeGrid extends Grid
{
    protected function setup()
    {
        $this->addColumn('name', trans('motor-backend::backend/global.name'), true);
        $this->addColumn('web_color', trans('partymeister-core::backend/event_types.web_color'))
             ->renderer(BladeRenderer::class, ['template' => 'partymeister-core::grid.color']);
        $this->addColumn('slide_color', trans('partymeister-core::backend/event_types.slide_color'))
             ->renderer(BladeRenderer::class, ['template' => 'partymeister-core::grid.color']);
        $this->setDefaultSorting('name', 'ASC');
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.event_types.edit');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.event_types.destroy');
    }
}
