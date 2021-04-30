<?php

namespace Partymeister\Core\Models;

use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Motor\Core\Filter\Filter;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;

/**
 * Partymeister\Core\Models\MessageGroup
 *
 * @property int $id
 * @property string $name
 * @property string $uuid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read int $user_count
 * @property-read \Motor\Backend\Models\User $updater
 * @property-read Collection|\Motor\Backend\Models\User[] $users
 * @method static Builder|MessageGroup filteredBy(Filter $filter, $column)
 * @method static Builder|MessageGroup filteredByMultiple(Filter $filter)
 * @method static Builder|MessageGroup newModelQuery()
 * @method static Builder|MessageGroup newQuery()
 * @method static Builder|MessageGroup query()
 * @method static Builder|MessageGroup search($q, $full_text = false)
 * @method static Builder|MessageGroup whereCreatedAt($value)
 * @method static Builder|MessageGroup whereCreatedBy($value)
 * @method static Builder|MessageGroup whereDeletedBy($value)
 * @method static Builder|MessageGroup whereId($value)
 * @method static Builder|MessageGroup whereName($value)
 * @method static Builder|MessageGroup whereUpdatedAt($value)
 * @method static Builder|MessageGroup whereUpdatedBy($value)
 * @method static Builder|MessageGroup whereUuid($value)
 * @mixin Eloquent
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
    protected $blameable = ['created', 'updated', 'deleted'];

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
        'uniqid',
    ];

    /**
     * @return int
     */
    public function getUserCountAttribute()
    {
        return $this->users()
                    ->count();
    }

    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('motor-backend.models.user'));
    }
}
