<?php

namespace Partymeister\Core\Forms\Backend;

use Kris\LaravelFormBuilder\Form;

/**
 * Class ScheduleForm
 *
 * @package Partymeister\Core\Forms\Backend
 */
class ScheduleForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('name', 'text', ['label' => trans('motor-backend::backend/global.name'), 'rules' => 'required'])
             ->add('submit', 'submit', [
                 'attr'  => ['class' => 'btn btn-primary'],
                 'label' => trans('partymeister-core::backend/schedules.save'),
             ]);
    }
}
