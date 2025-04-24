<?php

namespace Partymeister\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Motor\Backend\Models\User;
use Partymeister\Core\Models\Visitor;

class VisitorPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  string  $ability
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
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('visitors.read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return mixed
     */
    public function view(User $user, Visitor $visitor)
    {
        return $user->hasPermissionTo('visitors.read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('visitors.write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     */
    public function update(User $user, Visitor $visitor)
    {
        return $user->hasPermissionTo('visitors.write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete(User $user, Visitor $visitor)
    {
        return $user->hasPermissionTo('visitors.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return mixed
     */
    public function restore(User $user, Visitor $visitor)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return mixed
     */
    public function forceDelete(User $user, Visitor $visitor)
    {
        //
    }
}
