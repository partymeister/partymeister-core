<?php

namespace Partymeister\Core\Services;

use Illuminate\Support\Arr;
use Motor\Admin\Services\BaseService;
use Partymeister\Core\Models\MessageGroup;
use Partymeister\Core\Models\User;

/**
 * Class MessageGroupService
 */
class MessageGroupService extends BaseService
{
    /**
     * @var string
     */
    protected string $model = MessageGroup::class;

    protected array $loadColumns = ['users'];

    public function beforeCreate(): void
    {
        $this->record->uuid = uniqid();
    }

    public function afterCreate(): void
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

    public function afterUpdate(): void
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
