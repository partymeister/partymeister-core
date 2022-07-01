<?php

namespace Partymeister\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Motor\Admin\Models\User;
use Partymeister\Core\Models\MessageGroup;

class MessageGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param \Motor\Backend\Models\User $user
     * @param string $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->hasRole('SuperAdmin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param \Motor\Backend\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('message_groups.read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \Motor\Backend\Models\User $user
     * @param \Partymeister\Core\Models\MessageGroup $messageGroup
     * @return mixed
     */
    public function view(User $user, MessageGroup $messageGroup)
    {
        return $user->hasPermissionTo('message_groups.read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \Motor\Backend\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('message_groups.write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \Motor\Backend\Models\User $user
     * @param \Partymeister\Core\Models\MessageGroup $messageGroup
     * @return mixed
     */
    public function update(User $user, MessageGroup $messageGroup)
    {
        return $user->hasPermissionTo('message_groups.write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \Motor\Backend\Models\User $user
     * @param \Partymeister\Core\Models\MessageGroup $messageGroup
     * @return mixed
     */
    public function delete(User $user, MessageGroup $messageGroup)
    {
        return $user->hasPermissionTo('message_groups.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \Motor\Backend\Models\User $user
     * @param \Partymeister\Core\Models\MessageGroup $messageGroup
     * @return mixed
     */
    public function restore(User $user, MessageGroup $messageGroup)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \Motor\Backend\Models\User $user
     * @param \Partymeister\Core\Models\MessageGroup $messageGroup
     * @return mixed
     */
    public function forceDelete(User $user, MessageGroup $messageGroup)
    {
        //
    }
}
