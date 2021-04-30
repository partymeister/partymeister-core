<?php

namespace Partymeister\Core\Models;

use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Motor\Core\Filter\Filter;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;

/**
 * Partymeister\Core\Models\Callback
 *
 * @property int $id
 * @property string $name
 * @property string $action
 * @property mixed $payload
 * @property string $title
 * @property string $body
 * @property string $link
 * @property string $destination
 * @property string $hash
 * @property int $is_timed
 * @property int $has_fired
 * @property string|null $fired_at
 * @property string|null $embargo_until
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read \Motor\Backend\Models\User $updater
 * @method static Builder|Callback filteredBy(Filter $filter, $column)
 * @method static Builder|Callback filteredByMultiple(Filter $filter)
 * @method static Builder|Callback newModelQuery()
 * @method static Builder|Callback newQuery()
 * @method static Builder|Callback query()
 * @method static Builder|Callback search($q, $full_text = false)
 * @method static Builder|Callback whereAction($value)
 * @method static Builder|Callback whereBody($value)
 * @method static Builder|Callback whereCreatedAt($value)
 * @method static Builder|Callback whereCreatedBy($value)
 * @method static Builder|Callback whereDeletedBy($value)
 * @method static Builder|Callback whereDestination($value)
 * @method static Builder|Callback whereEmbargoUntil($value)
 * @method static Builder|Callback whereFiredAt($value)
 * @method static Builder|Callback whereHasFired($value)
 * @method static Builder|Callback whereHash($value)
 * @method static Builder|Callback whereId($value)
 * @method static Builder|Callback whereIsTimed($value)
 * @method static Builder|Callback whereLink($value)
 * @method static Builder|Callback whereName($value)
 * @method static Builder|Callback wherePayload($value)
 * @method static Builder|Callback whereTitle($value)
 * @method static Builder|Callback whereUpdatedAt($value)
 * @method static Builder|Callback whereUpdatedBy($value)
 * @mixin Eloquent
 */
class Callback extends Model
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
        'title',
        'body',
        'hash',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'action',
        'payload',
        'title',
        'body',
        'link',
        'destination',
        'hash',
        'embargo_until',
        'fired_at',
        'has_fired',
        'is_timed',
    ];
}
