<?php

namespace Partymeister\Core\Services;

use Illuminate\Support\Arr;
use Motor\Backend\Services\BaseService;
use Motor\Core\Filter\Renderers\SelectRenderer;
use Partymeister\Core\Models\Callback;

/**
 * Class CallbackService
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
        $this->sanitizeData();
        $this->record->hash = hash_hmac('sha256', $this->request->get('payload').$this->request->get('name').$this->request->get('title').$this->request->get('body').$this->request->get('embargo_until'), 20);
    }

    public function beforeUpdate()
    {
        $this->sanitizeData();
    }

    private function sanitizeData()
    {
        if (isset($this->data['hash'])) {
            unset($this->data['hash']);
        }
        if (Arr::get($this->data, 'payload') === '') {
            $this->data['payload'] = '{}';
        }
    }
}
