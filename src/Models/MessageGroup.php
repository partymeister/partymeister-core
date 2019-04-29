<?php

namespace Partymeister\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\Backend\Models\User;
use Motor\Core\Traits\Searchable;
use Motor\Core\Traits\Filterable;
use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;

/**
 * Partymeister\Core\Models\MessageGroup
 *
 * @property int $id
 * @property string $name
 * @property string $uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read int $user_count
 * @property-read \Motor\Backend\Models\User $updater
 * @property-read \Illuminate\Database\Eloquent\Collection|\Motor\Backend\Models\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\MessageGroup filteredBy(\Motor\Core\Filter\Filter $filter, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\MessageGroup filteredByMultiple(\Motor\Core\Filter\Filter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\MessageGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\MessageGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\MessageGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\MessageGroup search($q, $full_text = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\MessageGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\MessageGroup whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\MessageGroup whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\MessageGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\MessageGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\MessageGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\MessageGroup whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\MessageGroup whereUuid($value)
 * @mixin \Eloquent
 */
class MessageGroup extends Model
{

    use Searchable;
    use Filterable;
    use Blameable, CreatedBy, UpdatedBy, DeletedBy;

    /**
     * Columns for the Blameable trait
     *
     * @var array
     */
    protected $blameable = [ 'created', 'updated', 'deleted' ];

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'uniqid'
    ];


    /**
     * @return int
     */
    public function getUserCountAttribute()
    {
        return $this->users()->count();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('motor-backend.models.user'));
    }
}
