<?php

namespace Partymeister\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\Core\Traits\Searchable;
use Motor\Core\Traits\Filterable;
use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;

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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read \Partymeister\Core\Models\EventType|null $event_type
 * @property-read \Partymeister\Core\Models\Schedule $schedule
 * @property-read \Motor\Backend\Models\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event filteredBy(\Motor\Core\Filter\Filter $filter, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event filteredByMultiple(\Motor\Core\Filter\Filter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event search($q, $full_text = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereEventTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereIsOrganizerOnly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereIsVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereNotifyMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereSortPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Event whereUpdatedBy($value)
 * @mixin \Eloquent
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
    protected $blameable = [ 'created', 'updated', 'deleted' ];

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [
        'events.name',
        'event_type.name'
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


    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }


    public function event_type()
    {
        return $this->belongsTo(EventType::class);
    }
}
