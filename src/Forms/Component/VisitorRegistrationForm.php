<?php

namespace Partymeister\Core\Forms\Component;

use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Form;
use Symfony\Component\Intl\Countries;

/**
 * Class VisitorRegistrationForm
 *
 * @package Partymeister\Core\Forms\Component
 */
class VisitorRegistrationForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => trans('partymeister-core::backend/visitors.name'),
            'rules' => ['required', 'max:255', Rule::unique('visitors', 'name')],
        ])
             ->add('group', 'text', ['label' => trans('partymeister-core::backend/visitors.group')]);

        if (config('partymeister-core-visitor-registration.require_access_key')) {
            $this->add('access_key', 'text', [
                'label' => trans('partymeister-competitions::backend/access_keys.access_key'),
                'rules' => [
                    'required',
                    Rule::exists('access_keys', 'access_key')
                        ->where(function ($query) {
                            $query->where('visitor_id', null);
                        }),
                ],
            ]);
        }
        $countryList = config('partymeister-core-visitor-registration.countries', []);
        if (count($countryList) == 0) {
            $countryList = Countries::getNames();
        }
        $this->add('country_iso_3166_1', 'select', ['label'   => trans('motor-backend::backend/global.address.country'),
                                                    'choices' => $countryList,
            ]);

        $this->add('password', 'password', [
            'value' => '',
            'label' => trans('motor-backend::backend/users.password'),
            'rules' => 'required|min:6|confirmed',
        ])
             ->add('password_confirmation', 'password', [
                 'value' => '',
                 'label' => trans('motor-backend::backend/users.password_confirm'),
                 'rules' => 'required|min:6',
             ])
             ->add('submit', 'submit', ['attr' => ['class' => 'success button expanded'], 'label' => 'Register']);
    }
}
