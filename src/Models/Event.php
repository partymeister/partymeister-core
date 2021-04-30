<?php

namespace Partymeister\Core\Models;

use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Motor\Core\Filter\Filter;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;

/**
 * Partymeister\Core\Models\Event
 *
 * @property int $id
 * @property int $schedule_id
 * @property int|null $event_type_id
 * @property string $name
 * @property string|null $starts_at
 * @property string|null $ends_at
 * @property int $is_visible
 * @property int $is_organizer_only
 * @property int $notify_minutes
 * @property string $link
 * @property int $sort_position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read EventType|null $event_type
 * @property-read Schedule $schedule
 * @property-read \Motor\Backend\Models\User $updater
 * @method static Builder|Event filteredBy(Filter $filter, $column)
 * @method static Builder|Event filteredByMultiple(Filter $filter)
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static Builder|Event query()
 * @method static Builder|Event search($q, $full_text = false)
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereCreatedBy($value)
 * @method static Builder|Event whereDeletedBy($value)
 * @method static Builder|Event whereEndsAt($value)
 * @method static Builder|Event whereEventTypeId($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereIsOrganizerOnly($value)
 * @method static Builder|Event whereIsVisible($value)
 * @method static Builder|Event whereLink($value)
 * @method static Builder|Event whereName($value)
 * @method static Builder|Event whereNotifyMinutes($value)
 * @method static Builder|Event whereScheduleId($value)
 * @method static Builder|Event whereSortPosition($value)
 * @method static Builder|Event whereStartsAt($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @method static Builder|Event whereUpdatedBy($value)
 * @mixin Eloquent
 */
class Event extends Model
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
        'events.name',
        'event_type.name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'schedule_id',
        'event_type_id',
        'starts_at',
        'ends_at',
        'is_visible',
        'is_organizer_only',
        'sort_position',
        'notify_minutes',
        'link',
    ];

    /**
     * @return BelongsTo
     */
    /**
     * @return BelongsTo
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }


    /**
     * @return BelongsTo
     */
    /**
     * @return BelongsTo
     */
    public function event_type()
    {
        return $this->belongsTo(EventType::class);
    }
}
