<?php

namespace Partymeister\Core\Models\Component;

use Motor\CMS\Models\ComponentBaseModel;
use Partymeister\Core\Models\Schedule;

class ComponentSchedule extends ComponentBaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schedule_id',
    ];

    /**
     * Preview function for the page editor
     *
     * @return mixed
     */
    public function preview()
    {
        return [
            'name'    => trans('partymeister-core::component/schedules.component'),
            'preview' => ! is_null($this->schedule) ? $this->schedule->name : 'nothing selected',
        ];
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
