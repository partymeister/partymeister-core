<?php

namespace Partymeister\Core\Services;

use Illuminate\Support\Arr;
use Partymeister\Core\Models\MessageGroup;
use Motor\Backend\Services\BaseService;
use Partymeister\Core\Models\User;

class MessageGroupService extends BaseService
{

    protected $model = MessageGroup::class;


    protected function addUsers()
    {
        foreach (Arr::get($this->data, 'users', []) as $key => $user) {
            $this->record->users()->attach($user);
        }
    }

    public function beforeCreate()
    {
        $this->record->uuid = uniqid();
    }


    public function afterCreate()
    {
        $this->addUsers();
    }


    public function afterUpdate()
    {
        if (is_array(Arr::get($this->data, 'users'))) {
            foreach (User::all() as $user) {
                $this->record->users()->detach($user);
            }
        }
        $this->addUsers();
    }
}
