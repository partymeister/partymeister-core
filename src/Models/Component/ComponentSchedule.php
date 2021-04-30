<?php

namespace Partymeister\Core\Models\Component;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Motor\CMS\Models\ComponentBaseModel;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Core\Models\Schedule;

/**
 * Partymeister\Core\Models\Component\ComponentSchedule
 *
 * @property int $id
 * @property int $schedule_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|PageVersionComponent[] $component
 * @property-read Schedule $schedule
 * @method static Builder|ComponentSchedule newModelQuery()
 * @method static Builder|ComponentSchedule newQuery()
 * @method static Builder|ComponentSchedule query()
 * @method static Builder|ComponentSchedule whereCreatedAt($value)
 * @method static Builder|ComponentSchedule whereId($value)
 * @method static Builder|ComponentSchedule whereScheduleId($value)
 * @method static Builder|ComponentSchedule whereUpdatedAt($value)
 * @mixin Eloquent
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
     * @return BelongsTo
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
