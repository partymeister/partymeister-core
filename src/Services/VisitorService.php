<?php

namespace Partymeister\Core\Services;

use Partymeister\Core\Models\Visitor;
use Motor\Backend\Services\BaseService;

class VisitorService extends BaseService
{

    protected $model = Visitor::class;


    public function beforeCreate()
    {
        $this->data['password']  = bcrypt($this->data['password']);
        $this->data['api_token'] = str_random(60);
    }


    public function beforeUpdate()
    {
        // Special case to filter out the users api token when calling over the api
        if (array_get($this->data, 'api_token')) {
            unset($this->data['api_token']);
        }

        if (array_get($this->data, 'password') == '') {
            unset($this->data['password']);
        } else {
            $this->data['password'] = bcrypt($this->data['password']);
        }

    }
}
