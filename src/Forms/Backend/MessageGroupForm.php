<?php

namespace Partymeister\Core\Forms\Backend;

use Illuminate\Database\Eloquent\Collection;
use Kris\LaravelFormBuilder\Form;
use Partymeister\Core\Models\User;

/**
 * Class MessageGroupForm
 *
 * @package Partymeister\Core\Forms\Backend
 */
class MessageGroupForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $selected = [];
        if (is_object($this->model) && $this->model->users instanceof Collection) {
            foreach ($this->model->users as $user) {
                $selected[] = $user->id;
            }
        }

        $this->add('name', 'text', ['label' => trans('motor-backend::backend/global.name'), 'rules' => 'required'])
             ->add('users', 'choice', [
                 'label'          => trans('motor-backend::backend/users.users'),
                 'choice_options' => [
                     'wrapper'    => ['class' => 'choice-wrapper'],
                     'label_attr' => ['class' => 'label-class'],
                 ],
                 'selected'       => $selected,
                 'expanded'       => true,
                 'multiple'       => true,
                 'choices'        => User::pluck('name', 'id')
                                         ->toArray(),
             ])
             ->add('submit', 'submit', [
                 'attr'  => ['class' => 'btn btn-primary'],
                 'label' => trans('partymeister-core::backend/message-groups.save'),
             ]);
    }
}
