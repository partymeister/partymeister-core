<?php

namespace Partymeister\Core\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Motor\Backend\Services\BaseService;
use Partymeister\Core\Models\Visitor;

/**
 * Class VisitorService
 *
 * @package Partymeister\Core\Services
 */
class VisitorService extends BaseService
{
    /**
     * @var string
     */
    protected $model = Visitor::class;

    public function beforeCreate()
    {
        $this->data['password'] = bcrypt($this->data['password']);
        $this->data['api_token'] = Str::random(60);
        if ($this->data['email'] == '') {
            $this->data['email'] = null;
        }
    }

    public function beforeUpdate()
    {
        // Special case to filter out the users api token when calling over the api
        if (Arr::get($this->data, 'api_token')) {
            unset($this->data['api_token']);
        }

        if (Arr::get($this->data, 'password') == '') {
            unset($this->data['password']);
        } else {
            $this->data['password'] = bcrypt($this->data['password']);
        }

        if ($this->data['email'] == '') {
            $this->data['email'] = null;
        }
    }
}
