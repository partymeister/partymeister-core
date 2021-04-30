<?php

namespace Partymeister\Core\Forms\Backend;

use Kris\LaravelFormBuilder\Form;
use Motor\Backend\Models\Category;

/**
 * Class GuestForm
 *
 * @package Partymeister\Core\Forms\Backend
 */
class GuestForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('category_id', 'select', [
            'label'   => trans('motor-backend::backend/categories.category'),
            'rules'   => 'required',
            'choices' => Category::where('scope', 'guest')
                                 ->where('_lft', '>', 1)
                                 ->orderBy('name', 'ASC')
                                 ->pluck('name', 'id')
                                 ->toArray(),
        ])
             ->add('name', 'text', ['label' => trans('motor-backend::backend/global.name'), 'rules' => 'required'])
             ->add('handle', 'text', ['label' => trans('partymeister-core::backend/guests.handle')])
             ->add('email', 'text', ['label' => trans('partymeister-core::backend/guests.email')])
             ->add('company', 'text', ['label' => trans('partymeister-core::backend/guests.company')])
             ->add('country', 'text', ['label' => trans('partymeister-core::backend/guests.country')])
             ->add('ticket_code', 'text', ['label' => trans('partymeister-core::backend/guests.ticket_code')])
             ->add('ticket_type', 'text', ['label' => trans('partymeister-core::backend/guests.ticket_type')])
             ->add('ticket_order_number', 'text', ['label' => trans('partymeister-core::backend/guests.ticket_order_number')])
             ->add('comment', 'textarea', ['label' => trans('partymeister-core::backend/guests.comment')])
             ->add('has_badge', 'checkbox', ['label' => trans('partymeister-core::backend/guests.has_badge')])
             ->add('has_arrived', 'checkbox', ['label' => trans('partymeister-core::backend/guests.has_arrived')])
             ->add('ticket_code_scanned', 'checkbox', ['label' => trans('partymeister-core::backend/guests.ticket_code_scanned')])
             ->add('arrived_at', 'static', ['label' => trans('partymeister-core::backend/guests.arrived_at')])
             ->add('submit', 'submit', [
                 'attr'  => ['class' => 'btn btn-primary competition-submit'],
                 'label' => trans('partymeister-core::backend/guests.save'),
             ]);
    }
}
