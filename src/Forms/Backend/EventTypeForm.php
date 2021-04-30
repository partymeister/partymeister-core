<?php

namespace Partymeister\Core\Forms\Backend;

use Kris\LaravelFormBuilder\Form;

/**
 * Class EventTypeForm
 *
 * @package Partymeister\Core\Forms\Backend
 */
class EventTypeForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('name', 'text', ['label' => trans('motor-backend::backend/global.name'), 'rules' => 'required'])
             ->add('web_color', 'colorpicker', ['label' => trans('partymeister-core::backend/event_types.web_color')])
             ->add('slide_color', 'colorpicker', ['label' => trans('partymeister-core::backend/event_types.slide_color')])
             ->add('submit', 'submit', [
                 'attr'  => ['class' => 'btn btn-primary'],
                 'label' => trans('partymeister-core::backend/event_types.save'),
             ]);
    }
}
