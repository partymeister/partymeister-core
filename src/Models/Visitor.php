<?php

namespace Partymeister\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\Core\Traits\Searchable;
use Motor\Core\Traits\Filterable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Visitor extends Authenticatable
{

    use Searchable;
    use Filterable;

    protected $guard_name = 'visitor';

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [ 'name', 'group', 'country_iso_3166_1' ];

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
        'api_token'
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
}
