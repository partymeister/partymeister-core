<?php

namespace Partymeister\Core\Grids;

use Motor\Backend\Grid\Grid;
use Motor\Backend\Grid\Renderers\BladeRenderer;
use Motor\Backend\Grid\Renderers\BooleanRenderer;

/**
 * Class GuestGrid
 *
 * @package Partymeister\Core\Grids
 */
class GuestGrid extends Grid
{
    protected function setup()
    {
        $this->addColumn('category.name', trans('motor-backend::backend/categories.category'));
        $this->addColumn('name', trans('partymeister-core::backend/guests.name'), true);
        $this->addColumn('handle', trans('partymeister-core::backend/guests.handle'), true);
        $this->addColumn('company', trans('partymeister-core::backend/guests.company'), true);
        $this->addColumn('ticket_code', trans('partymeister-core::backend/guests.ticket_code'), true);

        $this->addColumn('has_badge', trans('partymeister-core::backend/guests.has_badge'))
             ->renderer(BooleanRenderer::class);
        $this->addColumn('has_arrived', trans('partymeister-core::backend/guests.has_arrived'))
             ->renderer(BladeRenderer::class, ['template' => 'partymeister-core::grid.guest_has_arrived']);

        $this->setDefaultSorting('category_id', 'ASC');
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.guests.edit');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.guests.destroy');
    }
}
