<?php

namespace Partymeister\Core\Services;

use Motor\Backend\Models\Category;
use Motor\Core\Filter\Renderers\SelectRenderer;
use Partymeister\Core\Models\Guest;
use Motor\Backend\Services\BaseService;

class GuestService extends BaseService
{

    protected $model = Guest::class;

    public function filters()
    {
        $categories = Category::where('scope', 'guest')->where('_lft', '>', 1)->orderBy('_lft', 'ASC')->pluck('name', 'id');
        $this->filter->add(new SelectRenderer('category_id'))->setEmptyOption('-- '.trans('motor-backend::backend/categories.categories').' --')->setOptions($categories);

        $this->filter->add(new SelectRenderer('has_arrived'))->setOptionPrefix(trans('partymeister-core::backend/guests.has_arrived'))->setEmptyOption('-- ' . trans('partymeister-core::backend/guests.has_arrived') . ' --')->setOptions([
            1 => trans('motor-backend::backend/global.yes'),
            0 => trans('motor-backend::backend/global.no')
        ]);
    }
}