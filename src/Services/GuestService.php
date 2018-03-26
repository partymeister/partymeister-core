<?php

namespace Partymeister\Core\Services;

use Motor\Core\Filter\Renderers\SelectRenderer;
use Partymeister\Core\Models\Guest;
use Motor\Backend\Services\BaseService;

class GuestService extends BaseService
{

    protected $model = Guest::class;

    public function filters()
    {
        $this->filter->add(new SelectRenderer('has_arrived'))->setOptionPrefix(trans('partymeister-core::backend/guests.has_arrived'))->setEmptyOption('-- ' . trans('partymeister-core::backend/guests.has_arrived') . ' --')->setOptions([
            1 => trans('motor-backend::backend/global.yes'),
            0 => trans('motor-backend::backend/global.no')
        ]);
    }
}
