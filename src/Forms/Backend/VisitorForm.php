<?php

namespace Partymeister\Core\Forms\Backend;

use Kris\LaravelFormBuilder\Form;
use Symfony\Component\Intl\Countries;

/**
 * Class VisitorForm
 *
 * @package Partymeister\Core\Forms\Backend
 */
class VisitorForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('name', 'text', [
                'label' => trans('partymeister-core::backend/visitors.name'),
                'rules' => 'required',
            ])
             ->add('group', 'text', ['label' => trans('partymeister-core::backend/visitors.group')])
             ->add('email', 'text', ['label' => trans('motor-backend::backend/users.email')])
             ->add('country_iso_3166_1', 'select2', [
                 'label'   => trans('motor-backend::backend/global.address.country'),
                 'choices' => Countries::getNames(),
             ])
             ->add('password', 'password', ['value' => '', 'label' => trans('motor-backend::backend/users.password')])
             ->add('submit', 'submit', [
                 'attr'  => ['class' => 'btn btn-primary'],
                 'label' => trans('partymeister-core::backend/visitors.save'),
             ]);
    }
}
