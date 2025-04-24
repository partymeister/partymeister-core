<?php

namespace Partymeister\Core\Forms\Component;

use Kris\LaravelFormBuilder\Form;

/**
 * Class PasswordResetForm
 */
class PasswordResetForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {

        $this->add('password', 'password', [
            'value' => '',
            'label' => trans('motor-backend::backend/users.password'),
            'rules' => 'required|min:6|confirmed',
        ])
            ->add('password_confirmation', 'password', [
                'value' => '',
                'label' => trans('motor-backend::backend/users.password_confirm'),
                'rules' => 'required|min:6',
            ]);
    }
}
