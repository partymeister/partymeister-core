<?php

namespace Partymeister\Core\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;
use Motor\Backend\Models\Client;
use Motor\Core\Filter\Filter;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Client|null $client
 * @property-read Collection|Media[] $media
 * @property-read Collection|MessageGroup[] $message_groups
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read Collection|Permission[] $permissions
 * @property-read Collection|Role[] $roles
 * @method static Builder|\Motor\Backend\Models\User filteredBy(Filter $filter, $column)
 * @method static Builder|\Motor\Backend\Models\User filteredByMultiple(Filter $filter)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|\Motor\Backend\Models\User permission($permissions)
 * @method static Builder|User query()
 * @method static Builder|\Motor\Backend\Models\User role($roles, $guard = null)
 * @method static Builder|\Motor\Backend\Models\User search($q, $full_text = false)
 * @method static Builder|User whereApiToken($value)
 * @method static Builder|User whereClientId($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePasswordLastChangedAt($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends \Motor\Backend\Models\User
{
    /**
     * @return BelongsToMany
     */
    public function message_groups()
    {
        return $this->belongsToMany(MessageGroup::class);
    }
}
