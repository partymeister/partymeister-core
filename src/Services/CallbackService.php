<?php

namespace Partymeister\Core\Services;

use Motor\Core\Filter\Renderers\SelectRenderer;
use Partymeister\Core\Models\Callback;
use Motor\Backend\Services\BaseService;

class CallbackService extends BaseService
{

    protected $model = Callback::class;


    public function filters()
    {
        $this->filter->add(new SelectRenderer('destination'))
                     ->setOptionPrefix(trans('partymeister-core::backend/callbacks.destination'))
                     ->setEmptyOption('-- ' . trans('partymeister-core::backend/callbacks.destination') . ' --')
                     ->setOptions(trans('partymeister-core::backend/callbacks.destinations'));

    }


    public function beforeCreate()
    {
        $this->record->hash = hash_hmac('sha256',
            $this->record->payload . $this->record->name . $this->record->title . $this->record->body, 20);
    }
}
