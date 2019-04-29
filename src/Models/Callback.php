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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read \Motor\Backend\Models\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback filteredBy(\Motor\Core\Filter\Filter $filter, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback filteredByMultiple(\Motor\Core\Filter\Filter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback search($q, $full_text = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereDestination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereEmbargoUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereFiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereHasFired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereIsTimed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Callback whereUpdatedBy($value)
 * @mixin \Eloquent
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
    protected $blameable = [ 'created', 'updated', 'deleted' ];

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [
        'name',
        'title',
        'body',
        'hash'
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
        'is_timed'
    ];
}
