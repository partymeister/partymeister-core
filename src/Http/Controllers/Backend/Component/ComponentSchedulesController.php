<?php

namespace Partymeister\Core\Http\Controllers\Backend\Component;

use Motor\CMS\Http\Controllers\Component\ComponentController;
use Illuminate\Http\Request;

use Partymeister\Core\Models\Component\ComponentSchedule;
use Partymeister\Core\Services\Component\ComponentScheduleService;
use Partymeister\Core\Forms\Backend\Component\ComponentScheduleForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class ComponentSchedulesController extends ComponentController
{
    use FormBuilderTrait;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->form = $this->form(ComponentScheduleForm::class);

        return response()->json($this->getFormData('component.schedules.store', ['mediapool' => false]));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->form = $this->form(ComponentScheduleForm::class);

        if ( ! $this->isValid()) {
            return $this->respondWithValidationError();
        }

        ComponentScheduleService::createWithForm($request, $this->form);

        return response()->json(['message' => trans('partymeister-core::component/schedules.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ComponentSchedule $record)
    {
        $this->form = $this->form(ComponentScheduleForm::class, [
            'model' => $record
        ]);

        return response()->json($this->getFormData('component.schedules.update', ['mediapool' => false]));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ComponentSchedule $record)
    {
        $form = $this->form(ComponentScheduleForm::class);

        if ( ! $this->isValid()) {
            return $this->respondWithValidationError();
        }

        ComponentScheduleService::updateWithForm($record, $request, $form);

        return response()->json(['message' => trans('partymeister-core::component/schedules.updated')]);
    }
}
