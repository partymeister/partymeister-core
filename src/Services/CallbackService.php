<?php

namespace Partymeister\Core\Services;

use Partymeister\Core\Models\Callback;
use Motor\Backend\Services\BaseService;

class CallbackService extends BaseService
{

    protected $model = Callback::class;

    public function beforeCreate()
    {
        $this->record->hash = hash_hmac('sha256', $this->record->payload . $this->record->name . $this->record->title . $this->record->body, 20);
    }
}
