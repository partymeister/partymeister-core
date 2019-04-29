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

/**
 * Partymeister\Core\Models\Guest
 *
 * @property int $id
 * @property int|null $category_id
 * @property string $name
 * @property string $handle
 * @property string $email
 * @property string $company
 * @property string $country
 * @property string $ticket_code
 * @property string $ticket_type
 * @property string $ticket_order_number
 * @property int $has_badge
 * @property int $has_arrived
 * @property int $ticket_code_scanned
 * @property string $comment
 * @property string|null $arrived_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property-read \Motor\Backend\Models\Category|null $category
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read \Motor\Backend\Models\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest filteredBy(\Motor\Core\Filter\Filter $filter, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest filteredByMultiple(\Motor\Core\Filter\Filter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest search($q, $full_text = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereArrivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereHandle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereHasArrived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereHasBadge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereTicketCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereTicketCodeScanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereTicketOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereTicketType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Guest whereUpdatedBy($value)
 * @mixin \Eloquent
 */
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
