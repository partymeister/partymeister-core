<?php

namespace Partymeister\Core\Forms\Backend;

use Kris\LaravelFormBuilder\Form;
use Partymeister\Core\Models\EventType;
use Partymeister\Core\Models\Schedule;

/**
 * Class EventForm
 *
 * @package Partymeister\Core\Forms\Backend
 */
class EventForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('name', 'text', ['label' => trans('motor-backend::backend/global.name'), 'rules' => 'required'])
             ->add('schedule_id', 'select', [
                 'label'   => trans('partymeister-core::backend/schedules.schedule'),
                 'choices' => Schedule::pluck('name', 'id')
                                      ->toArray(),
             ])
             ->add('event_type_id', 'select', [
                 'label'   => trans('partymeister-core::backend/event_types.event_type'),
                 'choices' => EventType::pluck('name', 'id')
                                       ->toArray(),
             ])
             ->add('starts_at', 'datetimepicker', ['label' => trans('partymeister-core::backend/events.starts_at')])
             ->add('is_visible', 'checkbox', ['label' => trans('partymeister-core::backend/events.is_visible')])
             ->add('is_organizer_only', 'checkbox', ['label' => trans('partymeister-core::backend/events.is_organizer_only')])
             ->add('sort_position', 'text', ['label' => trans('partymeister-core::backend/events.sort_position')])
             ->add('submit', 'submit', [
                 'attr'  => ['class' => 'btn btn-primary'],
                 'label' => trans('partymeister-core::backend/events.save'),
             ]);
    }
}
