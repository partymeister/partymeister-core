<?php

namespace Partymeister\Core\Forms\Component;

use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Form;
use Symfony\Component\Intl\Countries;

/**
 * Class VisitorWebsiteRegistrationForm
 *
 * @package Partymeister\Core\Forms\Component
 */
class VisitorWebsiteRegistrationForm extends Form
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
             ->add('group', 'text', ['label' => trans('partymeister-core::backend/visitors.group')])
             ->add('country_iso_3166_1', 'select', [
                 'label'         => trans('motor-backend::backend/global.address.country'),
                 'default_value' => (isset($_SERVER['GEOIP_COUNTRY_CODE']) ? $_SERVER['GEOIP_COUNTRY_CODE'] : 'DE'),
                 'choices'       => Countries::getNames(),
             ])
             ->add('submit', 'submit', ['attr' => ['class' => 'success button expanded'], 'label' => 'Register']);
    }
}
