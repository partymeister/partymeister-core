<?php

namespace Partymeister\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\Core\Traits\Searchable;
use Motor\Core\Traits\Filterable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Competitions\Models\Vote;

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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Partymeister\Competitions\Models\Entry[] $entries
 * @property-read mixed $new_comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\Partymeister\Competitions\Models\Vote[] $votes
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor filteredBy(\Motor\Core\Filter\Filter $filter, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor filteredByMultiple(\Motor\Core\Filter\Filter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor search($q, $full_text = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor whereAdditionalData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor whereCountryIso31661($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Visitor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Visitor extends Authenticatable
{

    use Searchable;
    use Filterable;

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


    public function getNewCommentsAttribute()
    {
        $numberOfComments = 0;
        foreach ($this->entries()->get() as $entry) {
            $numberOfComments += $entry->comments()->where('read_by_visitor', false)->count();
        }

        return $numberOfComments;
    }


    public function entries()
    {
        return $this->hasMany(Entry::class);
    }


    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
