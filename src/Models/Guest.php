<?php

namespace Partymeister\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\Backend\Models\Category;
use Motor\Core\Traits\Searchable;
use Motor\Core\Traits\Filterable;
use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;

class Guest extends Model
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
        'guests.name',
        'guests.handle',
        'guests.email',
        'guests.company',
        'guests.country',
        'guests.ticket_code',
        'guests.ticket_type',
        'guests.ticket_order_number',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'handle',
        'email',
        'company',
        'country',
        'ticket_code',
        'ticket_type',
        'ticket_order_number',
        'has_badge',
        'has_arrived',
        'ticket_code_scanned',
        'comment',
        'arrived_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
