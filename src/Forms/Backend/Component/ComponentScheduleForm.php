<?php

namespace Partymeister\Core\Forms\Backend\Component;

use Kris\LaravelFormBuilder\Form;
use Partymeister\Core\Models\Schedule;

class ComponentScheduleForm extends Form
{

    public function buildForm()
    {
        $this->add('schedule_id', 'select', [
                'label'   => trans('partymeister-core::backend/schedules.schedule'),
                'choices' => Schedule::pluck('name', 'id')->toArray()
            ]);
    }
}
