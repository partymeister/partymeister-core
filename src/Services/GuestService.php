<?php

namespace Partymeister\Core\Services;

use Motor\Admin\Models\Category;
use Motor\Admin\Services\BaseService;
use Motor\Core\Filter\Renderers\SelectRenderer;
use Partymeister\Core\Models\Guest;

/**
 * Class GuestService
 */
class GuestService extends BaseService
{
    /**
     * @var string
     */
    protected string $model = Guest::class;

    public function filters(): void
    {
        $categories = Category::where('scope', 'guest')
                              ->where('_lft', '>', 1)
                              ->orderBy('name', 'ASC')
                              ->pluck('name', 'id');
        $this->filter->add(new SelectRenderer('category_id'))
                     ->setEmptyOption('-- '.trans('motor-admin::backend/categories.categories').' --')
                     ->setOptions($categories);

        $this->filter->add(new SelectRenderer('has_arrived'))
                     ->setOptionPrefix(trans('partymeister-core::backend/guests.has_arrived'))
                     ->setEmptyOption('-- '.trans('partymeister-core::backend/guests.has_arrived').' --')
                     ->setOptions([
                         1 => trans('motor-admin::backend/global.yes'),
                         0 => trans('motor-admin::backend/global.no'),
                     ]);
    }
}
