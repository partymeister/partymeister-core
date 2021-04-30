<?php

namespace Partymeister\Core\Forms\Backend;

use Kris\LaravelFormBuilder\Form;

/**
 * Class CallbackForm
 *
 * @package Partymeister\Core\Forms\Backend
 */
class CallbackForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('name', 'text', ['label' => trans('motor-backend::backend/global.name'), 'rules' => 'required'])
             ->add('action', 'select', [
                 'label'   => trans('partymeister-core::backend/callbacks.action'),
                 'choices' => (trans('partymeister-core::backend/callbacks.actions')),
             ])
             ->add('payload', 'static', ['label' => trans('partymeister-core::backend/callbacks.payload')])
             ->add('title', 'text', [
                     'label' => trans('partymeister-core::backend/callbacks.title'),
                     'rules' => 'required',
                 ])
             ->add('body', 'text', ['label' => trans('partymeister-core::backend/callbacks.body')])
             ->add('link', 'text', ['label' => trans('partymeister-core::backend/callbacks.link')])
             ->add('hash', 'static', ['label' => trans('partymeister-core::backend/callbacks.hash')])
             ->add('embargo_until', 'datetimepicker', ['label' => trans('partymeister-core::backend/callbacks.embargo_until')])
             ->add('fired_at', 'static', ['label' => trans('partymeister-core::backend/callbacks.fired_at')])
             ->add('is_timed', 'checkbox', ['label' => trans('partymeister-core::backend/callbacks.is_timed')])
             ->add('destination', 'select', [
                 'label'   => trans('partymeister-core::backend/callbacks.destination'),
                 'choices' => (trans('partymeister-core::backend/callbacks.destinations')),
             ])
             ->add('has_fired', 'checkbox', ['label' => trans('partymeister-core::backend/callbacks.has_fired')])
             ->add('submit', 'submit', [
                 'attr'  => ['class' => 'btn btn-primary competition-submit'],
                 'label' => trans('partymeister-core::backend/callbacks.save'),
             ]);
    }
}
