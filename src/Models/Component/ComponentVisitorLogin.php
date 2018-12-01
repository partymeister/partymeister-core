<?php

namespace Partymeister\Core\Models\Component;

use Motor\CMS\Models\ComponentBaseModel;
use Motor\CMS\Models\Navigation;

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
