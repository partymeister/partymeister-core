<?php

namespace Partymeister\Core\Models;

use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Motor\Backend\Models\Category;
use Motor\Core\Filter\Filter;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $deleted_by
 * @property-read Category|null $category
 * @property-read \Motor\Backend\Models\User $creator
 * @property-read \Motor\Backend\Models\User|null $eraser
 * @property-read \Motor\Backend\Models\User $updater
 * @method static Builder|Guest filteredBy(Filter $filter, $column)
 * @method static Builder|Guest filteredByMultiple(Filter $filter)
 * @method static Builder|Guest newModelQuery()
 * @method static Builder|Guest newQuery()
 * @method static Builder|Guest query()
 * @method static Builder|Guest search($q, $full_text = false)
 * @method static Builder|Guest whereArrivedAt($value)
 * @method static Builder|Guest whereCategoryId($value)
 * @method static Builder|Guest whereComment($value)
 * @method static Builder|Guest whereCompany($value)
 * @method static Builder|Guest whereCountry($value)
 * @method static Builder|Guest whereCreatedAt($value)
 * @method static Builder|Guest whereCreatedBy($value)
 * @method static Builder|Guest whereDeletedBy($value)
 * @method static Builder|Guest whereEmail($value)
 * @method static Builder|Guest whereHandle($value)
 * @method static Builder|Guest whereHasArrived($value)
 * @method static Builder|Guest whereHasBadge($value)
 * @method static Builder|Guest whereId($value)
 * @method static Builder|Guest whereName($value)
 * @method static Builder|Guest whereTicketCode($value)
 * @method static Builder|Guest whereTicketCodeScanned($value)
 * @method static Builder|Guest whereTicketOrderNumber($value)
 * @method static Builder|Guest whereTicketType($value)
 * @method static Builder|Guest whereUpdatedAt($value)
 * @method static Builder|Guest whereUpdatedBy($value)
 * @mixin Eloquent
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
    protected $blameable = ['created', 'updated', 'deleted'];

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
        'arrived_at',
    ];

    /**
     * @return BelongsTo
     */
    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
