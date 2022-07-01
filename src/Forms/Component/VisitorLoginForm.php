<?php

namespace Partymeister\Core\Forms\Component;

use Kris\LaravelFormBuilder\Form;
use Partymeister\Core\Rules\VisitorLogin;

/**
 * Class VisitorLoginForm
 */
class VisitorLoginForm extends Form
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
             ->add('password', 'password', [
                 'label' => trans('motor-backend::backend/users.password'),
                 'rules' => ['required', new VisitorLogin],
             ]);
    }
}
