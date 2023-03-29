<?php

namespace Partymeister\Core\Forms\Component;

use Kris\LaravelFormBuilder\Form;
use Partymeister\Core\Rules\VisitorEmail;

/**
 * Class PasswordForgottenForm
 */
class PasswordForgottenForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('email', 'email', [
            'label' => trans('motor-backend::backend/global.contact.email'),
            'rules' => ['required', 'email', new VisitorEmail()],
        ]);
    }
}
