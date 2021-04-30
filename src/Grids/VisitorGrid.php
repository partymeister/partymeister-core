<?php

namespace Partymeister\Core\Grids;

use Motor\Backend\Grid\Grid;

/**
 * Class VisitorGrid
 *
 * @package Partymeister\Core\Grids
 */
class VisitorGrid extends Grid
{
    protected function setup()
    {
        $this->addColumn('name', trans('partymeister-core::backend/visitors.name'), true);
        $this->addColumn('group', trans('partymeister-core::backend/visitors.group'), true);
        $this->addColumn('country_iso_3166_1', trans('motor-backend::backend/global.address.country'), true);
        $this->setDefaultSorting('created_at', 'DESC');
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.visitors.edit');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.visitors.destroy');
    }
}
