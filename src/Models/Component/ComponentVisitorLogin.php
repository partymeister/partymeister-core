<?php

namespace Partymeister\Core\Models\Component;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Motor\CMS\Models\ComponentBaseModel;
use Motor\CMS\Models\Navigation;
use Motor\CMS\Models\PageVersionComponent;

/**
 * Partymeister\Core\Models\Component\ComponentVisitorLogin
 *
 * @property int $id
 * @property int|null $visitor_registration_page_id
 * @property int|null $entries_page_id
 * @property int|null $voting_page_id
 * @property int|null $comments_page_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Navigation|null $comments_page
 * @property-read Collection|PageVersionComponent[] $component
 * @property-read Navigation|null $entries_page
 * @property-read Navigation|null $visitor_registration_page
 * @property-read Navigation|null $voting_page
 * @method static Builder|ComponentVisitorLogin newModelQuery()
 * @method static Builder|ComponentVisitorLogin newQuery()
 * @method static Builder|ComponentVisitorLogin query()
 * @method static Builder|ComponentVisitorLogin whereCommentsPageId($value)
 * @method static Builder|ComponentVisitorLogin whereCreatedAt($value)
 * @method static Builder|ComponentVisitorLogin whereEntriesPageId($value)
 * @method static Builder|ComponentVisitorLogin whereId($value)
 * @method static Builder|ComponentVisitorLogin whereUpdatedAt($value)
 * @method static Builder|ComponentVisitorLogin whereVisitorRegistrationPageId($value)
 * @method static Builder|ComponentVisitorLogin whereVotingPageId($value)
 * @mixin Eloquent
 */
class ComponentVisitorLogin extends ComponentBaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'visitor_registration_page_id',
        'entries_page_id',
        'voting_page_id',
        'comments_page_id',
    ];

    /**
     * Preview function for the page editor
     *
     * @return mixed
     */
    public function preview()
    {
        return [
            'name'    => trans('partymeister-core::component/visitor-logins.component'),
            'preview' => 'Preview for ComponentVisitorLogin component',
        ];
    }

    /**
     * @return BelongsTo
     */
    public function visitor_registration_page()
    {
        return $this->belongsTo(Navigation::class, 'visitor_registration_page_id');
    }

    /**
     * @return BelongsTo
     */
    public function entries_page()
    {
        return $this->belongsTo(Navigation::class, 'entries_page_id');
    }

    /**
     * @return BelongsTo
     */
    public function comments_page()
    {
        return $this->belongsTo(Navigation::class, 'comments_page_id');
    }

    /**
     * @return BelongsTo
     */
    public function voting_page()
    {
        return $this->belongsTo(Navigation::class, 'voting_page_id');
    }
}
