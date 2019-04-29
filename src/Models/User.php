<?php

namespace Partymeister\Core\Models;

/**
 * Partymeister\Core\Models\User
 *
 * @property int $id
 * @property int|null $client_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $api_token
 * @property string|null $remember_token
 * @property string|null $password_last_changed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Motor\Backend\Models\Client|null $client
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read \Illuminate\Database\Eloquent\Collection|\Partymeister\Core\Models\MessageGroup[] $message_groups
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\User filteredBy(\Motor\Core\Filter\Filter $filter, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\User filteredByMultiple(\Motor\Core\Filter\Filter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\Backend\Models\User search($q, $full_text = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\User whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\User wherePasswordLastChangedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
