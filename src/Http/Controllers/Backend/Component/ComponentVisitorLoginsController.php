<?php

namespace Partymeister\Core\Http\Controllers\Backend\Component;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\CMS\Http\Controllers\Component\ComponentController;
use Partymeister\Core\Forms\Backend\Component\ComponentVisitorLoginForm;
use Partymeister\Core\Models\Component\ComponentVisitorLogin;
use Partymeister\Core\Services\Component\ComponentVisitorLoginService;

/**
 * Class ComponentVisitorLoginsController
 *
 * @package Partymeister\Core\Http\Controllers\Backend\Component
 */
class ComponentVisitorLoginsController extends ComponentController
{
    use FormBuilderTrait;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $this->form = $this->form(ComponentVisitorLoginForm::class);

        return response()->json($this->getFormData('component.visitor-logins.store', ['mediapool' => false]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->form = $this->form(ComponentVisitorLoginForm::class);

        if (! $this->isValid()) {
            return $this->respondWithValidationError();
        }

        ComponentVisitorLoginService::createWithForm($request, $this->form);

        return response()->json(['message' => trans('partymeister-core::component/visitor-logins.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ComponentVisitorLogin $record
     * @return JsonResponse
     */
    public function edit(ComponentVisitorLogin $record)
    {
        $this->form = $this->form(ComponentVisitorLoginForm::class, [
            'model' => $record,
        ]);

        return response()->json($this->getFormData('component.visitor-logins.update', ['mediapool' => false]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ComponentVisitorLogin $record
     * @return JsonResponse
     */
    public function update(Request $request, ComponentVisitorLogin $record)
    {
        $form = $this->form(ComponentVisitorLoginForm::class);

        if (! $this->isValid()) {
            return $this->respondWithValidationError();
        }

        ComponentVisitorLoginService::updateWithForm($record, $request, $form);

        return response()->json(['message' => trans('partymeister-core::component/visitor-logins.updated')]);
    }
}
