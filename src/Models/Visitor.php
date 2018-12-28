<?php

namespace Partymeister\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\Core\Traits\Searchable;
use Motor\Core\Traits\Filterable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Competitions\Models\Vote;

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
