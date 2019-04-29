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
 * Partymeister\Core\Models\EventType
 *
 * @property int $id
 * @property string $name
 * @property string $web_color
 * @property string $slide_color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read \Motor\Backend\Models\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType filteredBy(\Motor\Core\Filter\Filter $filter, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType filteredByMultiple(\Motor\Core\Filter\Filter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType search($q, $full_text = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType whereSlideColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\EventType whereWebColor($value)
 * @mixin \Eloquent
 */
class EventType extends Model
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
        'name'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'web_color',
        'slide_color',
    ];
}
