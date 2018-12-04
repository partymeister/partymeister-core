<?php

namespace Partymeister\Core\Models;

class User extends \Motor\Backend\Models\User
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function message_groups()
    {
        return $this->belongsToMany(MessageGroup::class);
    }
}
