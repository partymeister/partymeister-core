<?php

namespace Partymeister\Core\Models\Component;

use Motor\CMS\Models\ComponentBaseModel;
use Partymeister\Core\Models\Schedule;

/**
 * Partymeister\Core\Models\Component\ComponentSchedule
 *
 * @property int $id
 * @property int $schedule_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Motor\CMS\Models\PageVersionComponent[] $component
 * @property-read \Partymeister\Core\Models\Schedule $schedule
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentSchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentSchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentSchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentSchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentSchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentSchedule whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Partymeister\Core\Models\Component\ComponentSchedule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
