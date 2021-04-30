<?php

namespace Partymeister\Core\Grids;

use Motor\Backend\Grid\Grid;
use Motor\Backend\Grid\Renderers\BooleanRenderer;
use Motor\Backend\Grid\Renderers\DateRenderer;
use Motor\Backend\Grid\Renderers\TranslateRenderer;

/**
 * Class CallbackGrid
 *
 * @package Partymeister\Core\Grids
 */
class CallbackGrid extends Grid
{
    protected function setup()
    {
        $this->addColumn('name', trans('motor-backend::backend/global.name'), true);
        $this->setDefaultSorting('name', 'ASC');
        $this->addColumn('destination', trans('partymeister-core::backend/callbacks.destination'), true)
             ->renderer(TranslateRenderer::class, ['file' => 'partymeister-core::backend/callbacks.destinations']);
        $this->addColumn('embargo_until', trans('partymeister-core::backend/callbacks.embargo_until'), true)
             ->renderer(DateRenderer::class, ['format' => 'Y-m-d H:i']);
        $this->addColumn('has_fired', trans('partymeister-core::backend/callbacks.has_fired'), true)
             ->renderer(BooleanRenderer::class);
        $this->addColumn('is_timed', trans('partymeister-core::backend/callbacks.is_timed'), true)
             ->renderer(BooleanRenderer::class);
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.callbacks.edit');
        $this->addDuplicateAction(trans('motor-backend::backend/global.duplicate'), 'backend.callbacks.duplicate')
             ->needsPermissionTo('callbacks.write');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.callbacks.destroy');
    }
}
