<?php

namespace Partymeister\Core\Grids;

use Motor\Admin\Grid\Grid;
use Motor\Admin\Grid\Renderers\CollectionRenderer;

/**
 * Class MessageGroupGrid
 */
class MessageGroupGrid extends Grid
{
    protected function setup()
    {
        $this->setDefaultSorting('name', 'ASC');
        $this->addColumn('name', trans('motor-backend::backend/global.name'), true);
        $this->addColumn('users', trans('motor-backend::backend/users.users'))
             ->renderer(CollectionRenderer::class, ['column' => 'name']);
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.message-groups.edit');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.message-groups.destroy');
    }
}
