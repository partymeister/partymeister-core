<?php

namespace Partymeister\Core\Services;

use Motor\Backend\Services\BaseService;
use Motor\Core\Filter\Renderers\SelectRenderer;
use Partymeister\Core\Models\Callback;

/**
 * Class CallbackService
 *
 * @package Partymeister\Core\Services
 */
class CallbackService extends BaseService
{
    /**
     * @var string
     */
    protected $model = Callback::class;

    public function filters()
    {
        $this->filter->add(new SelectRenderer('destination'))
                     ->setOptionPrefix(trans('partymeister-core::backend/callbacks.destination'))
                     ->setEmptyOption('-- '.trans('partymeister-core::backend/callbacks.destination').' --')
                     ->setOptions(trans('partymeister-core::backend/callbacks.destinations'));
    }

    public function beforeCreate()
    {
        $this->record->hash = hash_hmac('sha256', $this->request->get('payload').$this->request->get('name').$this->request->get('title').$this->request->get('body').$this->request->get('embargo_until'), 20);
    }
}
