<?php

namespace Partymeister\Core\Services;

use Illuminate\Support\Arr;
use Motor\Backend\Services\BaseService;
use Partymeister\Core\Models\MessageGroup;
use Partymeister\Core\Models\User;

/**
 * Class MessageGroupService
 *
 * @package Partymeister\Core\Services
 */
class MessageGroupService extends BaseService
{
    /**
     * @var string
     */
    protected $model = MessageGroup::class;

    public function beforeCreate()
    {
        $this->record->uuid = uniqid();
    }

    public function afterCreate()
    {
        $this->addUsers();
    }

    protected function addUsers()
    {
        foreach (Arr::get($this->data, 'users', []) as $user) {
            $this->record->users()
                         ->attach($user);
        }
    }

    public function afterUpdate()
    {
        if (is_array(Arr::get($this->data, 'users'))) {
            foreach (User::all() as $user) {
                $this->record->users()
                             ->detach($user);
            }
        }
        $this->addUsers();
    }
}
