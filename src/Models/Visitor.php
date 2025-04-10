<?php

namespace Partymeister\Core\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Kra8\Snowflake\HasShortflakePrimary;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Motor\Core\Filter\Filter;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;
use Partymeister\Competitions\Models\AccessKey;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Competitions\Models\Vote;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Partymeister\Core\Models\Visitor
 *
 * @property int $id
 * @property string $name
 * @property string $group
 * @property string $country_iso_3166_1
 * @property array $additional_data
 * @property string|null $email
 * @property string $password
 * @property string $api_token
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Entry[] $entries
 * @property-read mixed $new_comments
 * @property-read Collection|Vote[] $votes
 *
 * @method static Builder|Visitor filteredBy(Filter $filter, $column)
 * @method static Builder|Visitor filteredByMultiple(Filter $filter)
 * @method static Builder|Visitor newModelQuery()
 * @method static Builder|Visitor newQuery()
 * @method static Builder|Visitor query()
 * @method static Builder|Visitor search($q, $full_text = false)
 * @method static Builder|Visitor whereAdditionalData($value)
 * @method static Builder|Visitor whereApiToken($value)
 * @method static Builder|Visitor whereCountryIso31661($value)
 * @method static Builder|Visitor whereCreatedAt($value)
 * @method static Builder|Visitor whereEmail($value)
 * @method static Builder|Visitor whereGroup($value)
 * @method static Builder|Visitor whereId($value)
 * @method static Builder|Visitor whereName($value)
 * @method static Builder|Visitor wherePassword($value)
 * @method static Builder|Visitor whereRememberToken($value)
 * @method static Builder|Visitor whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Visitor extends Authenticatable
{
    use Searchable;
    use Filterable;
    use HasShortflakePrimary;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $guard = 'visitor';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'additional_data' => 'array',
    ];

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = ['name', 'group'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'group',
        'country_iso_3166_1',
        'email',
        'password',
        'api_token',
        'additional_data',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'api_token',
        'password',
        'remember_token',
    ];

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'name';
    }

    /**
     * @return int
     */
    /**
     * @return int
     */
    public function getNewCommentsAttribute()
    {
        $numberOfComments = 0;
        foreach ($this->entries()
                      ->get() as $entry) {
            $numberOfComments += $entry->comments()
                                       ->where('read_by_visitor', false)
                                       ->count();
        }

        return $numberOfComments;
    }

    /**
     * @return bool
     */
    public function getIsRemoteAttribute() {
        if (!is_null($this->access_key) && ($this->access_key->is_remote || $this->access_key->is_satellite)) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getIsSatelliteAttribute() {
        if (!is_null($this->access_key) && $this->access_key->is_satellite) {
            return $this->access_key->is_satellite;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getRemoteTypeAttribute() {
        if ($this->is_satellite) {
            return 'Satellite';
        } else if ($this->is_remote) {
            return 'Remote';
        }
        return '';
    }

    /**
     * @return HasMany
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    /**
     * @return HasMany
     */
    /**
     * @return HasMany
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function access_key() {
        return $this->hasOne(AccessKey::class);
    }
}
