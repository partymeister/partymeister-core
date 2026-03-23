<?php

namespace Partymeister\Core\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Motor\Admin\Services\BaseService;
use Partymeister\Core\Models\Visitor;

/**
 * Class VisitorService
 */
class VisitorService extends BaseService
{
    /**
     * @var string
     */
    protected string $model = Visitor::class;

    public function beforeCreate(): void
    {
        $this->data['password'] = bcrypt($this->data['password']);
        $this->data['api_token'] = Str::random(60);
        if (! Arr::has($this->data, 'additional_data')) {
            $this->data['additional_data'] = [];
        }
        if (Arr::get($this->data, 'email') == '') {
            $this->data['email'] = null;
        }
    }

    public function beforeUpdate(): void
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

        if (Arr::get($this->data, 'email') == '') {
            $this->data['email'] = null;
        }
    }
}
