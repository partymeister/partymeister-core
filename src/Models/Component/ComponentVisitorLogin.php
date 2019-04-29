<?php

namespace Partymeister\Core\Models\Component;

use Motor\CMS\Models\ComponentBaseModel;
use Motor\CMS\Models\Navigation;

/**
 * Partymeister\Core\Models\Component\ComponentVisitorLogin
 *
 * @property int $id
 * @property int|null $visitor_registration_page_id
 * @property int|null $entries_page_id
 * @property int|null $voting_page_id
 * @property int|null $comments_page_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Motor\CMS\Models\Navigation|null $comments_page
 * @property-read \Illuminate\Database\Eloquent\Collection|\Motor\CMS\Models\PageVersionComponent[] $component
 * @property-read \Motor\CMS\Models\Navigation|null $entries_page
 * @property-read \Motor\CMS\Models\Navigation|null $visitor_registration_page
 * @property-read \Motor\CMS\Models\Navigation|null $voting_page
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentVisitorLogin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentVisitorLogin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentVisitorLogin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentVisitorLogin whereCommentsPageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentVisitorLogin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentVisitorLogin whereEntriesPageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentVisitorLogin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentVisitorLogin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentVisitorLogin whereVisitorRegistrationPageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentVisitorLogin whereVotingPageId($value)
 * @mixin \Eloquent
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
        'comments_page_id'
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
            'preview' => 'Preview for ComponentVisitorLogin component'
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitor_registration_page()
    {
        return $this->belongsTo(Navigation::class, 'visitor_registration_page_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entries_page()
    {
        return $this->belongsTo(Navigation::class, 'entries_page_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comments_page()
    {
        return $this->belongsTo(Navigation::class, 'comments_page_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function voting_page()
    {
        return $this->belongsTo(Navigation::class, 'voting_page_id');
    }
}
