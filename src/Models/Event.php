<?php

namespace Partymeister\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\Core\Traits\Searchable;
use Motor\Core\Traits\Filterable;
use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;

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
