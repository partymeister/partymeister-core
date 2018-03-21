<?php

namespace Partymeister\Core\Forms\Backend;

use Kris\LaravelFormBuilder\Form;

class ScheduleForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => trans('motor-backend::backend/global.name'), 'rules' => 'required'])
            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('partymeister-core::backend/schedules.save')]);
    }
}
