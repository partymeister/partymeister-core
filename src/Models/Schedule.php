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
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Motor\Core\Filter\Filter;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;

/**
 * Partymeister\Core\Models\Schedule
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read Collection|Event[] $events
 * @property-read mixed $event_count
 * @property-read \Motor\Backend\Models\User $updater
 * @method static Builder|Schedule filteredBy(Filter $filter, $column)
 * @method static Builder|Schedule filteredByMultiple(Filter $filter)
 * @method static Builder|Schedule newModelQuery()
 * @method static Builder|Schedule newQuery()
 * @method static Builder|Schedule query()
 * @method static Builder|Schedule search($q, $full_text = false)
 * @method static Builder|Schedule whereCreatedAt($value)
 * @method static Builder|Schedule whereCreatedBy($value)
 * @method static Builder|Schedule whereDeletedBy($value)
 * @method static Builder|Schedule whereId($value)
 * @method static Builder|Schedule whereName($value)
 * @method static Builder|Schedule whereUpdatedAt($value)
 * @method static Builder|Schedule whereUpdatedBy($value)
 * @mixin Eloquent
 */
class Schedule extends Model
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
    protected $searchableColumns = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @return int
     */
    public function getEventCountAttribute()
    {
        return $this->events()
                    ->count();
    }

    /**
     * @return HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class)
                    ->orderBy('starts_at', 'ASC')
                    ->orderBy('sort_position', 'ASC')
                    ->orderBy('event_type_id', 'ASC')
                    ->orderBy('name', 'ASC');
    }
}
