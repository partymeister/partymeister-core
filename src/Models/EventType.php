<?php

namespace Partymeister\Core\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Kra8\Snowflake\HasShortflakePrimary;
use Motor\Core\Filter\Filter;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * Partymeister\Core\Models\EventType
 *
 * @property int $id
 * @property string $name
 * @property string $web_color
 * @property string $slide_color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read \Motor\Backend\Models\User $updater
 *
 * @method static Builder|EventType filteredBy(Filter $filter, $column)
 * @method static Builder|EventType filteredByMultiple(Filter $filter)
 * @method static Builder|EventType newModelQuery()
 * @method static Builder|EventType newQuery()
 * @method static Builder|EventType query()
 * @method static Builder|EventType search($q, $full_text = false)
 * @method static Builder|EventType whereCreatedAt($value)
 * @method static Builder|EventType whereCreatedBy($value)
 * @method static Builder|EventType whereDeletedBy($value)
 * @method static Builder|EventType whereId($value)
 * @method static Builder|EventType whereName($value)
 * @method static Builder|EventType whereSlideColor($value)
 * @method static Builder|EventType whereUpdatedAt($value)
 * @method static Builder|EventType whereUpdatedBy($value)
 * @method static Builder|EventType whereWebColor($value)
 *
 * @mixin Eloquent
 */
class EventType extends Model
{
    use BlameableTrait;
    use Filterable;
    use HasShortflakePrimary;
    use Searchable;

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
        'web_color',
        'slide_color',
    ];
}
