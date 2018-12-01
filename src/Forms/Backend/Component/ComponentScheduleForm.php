<?php

namespace Partymeister\Core\Forms\Backend\Component;

use Kris\LaravelFormBuilder\Form;
use Partymeister\Core\Models\Schedule;

class ComponentScheduleForm extends Form
{

    public function buildForm()
    {
        $this->add('schedule_id', 'select', [
            'label'       => trans('partymeister-core::backend/schedules.schedule'),
            'empty_value' => trans('motor-backend::backend/global.please_choose'),
            'choices'     => Schedule::pluck('name', 'id')->toArray()
        ]);
    }
}
