<?php

namespace Partymeister\Core\Http\Controllers\Backend;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Core\Forms\Backend\EventTypeForm;
use Partymeister\Core\Grids\EventTypeGrid;
use Partymeister\Core\Http\Requests\Backend\EventTypeRequest;
use Partymeister\Core\Models\EventType;
use Partymeister\Core\Services\EventTypeService;
use ReflectionException;

/**
 * Class EventTypesController
 *
 * @package Partymeister\Core\Http\Controllers\Backend
 */
class EventTypesController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     * @throws ReflectionException
     */
    public function index()
    {
        $grid = new EventTypeGrid(EventType::class);

        $service = EventTypeService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator = $service->getPaginator();

        return view('partymeister-core::backend.event_types.index', compact('paginator', 'grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $form = $this->form(EventTypeForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.event_types.store',
            'enctype' => 'multipart/form-data',
        ]);

        return view('partymeister-core::backend.event_types.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventTypeRequest $request
     * @return RedirectResponse|Redirector
     */
    public function store(EventTypeRequest $request)
    {
        $form = $this->form(EventTypeForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        EventTypeService::createWithForm($request, $form);

        flash()->success(trans('partymeister-core::backend/event_types.created'));

        return redirect('backend/event_types');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EventType $record
     * @return Factory|View
     */
    public function edit(EventType $record)
    {
        $form = $this->form(EventTypeForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.event_types.update', [$record->id]),
            'enctype' => 'multipart/form-data',
            'model'   => $record,
        ]);

        return view('partymeister-core::backend.event_types.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EventTypeRequest $request
     * @param EventType $record
     * @return RedirectResponse|Redirector
     */
    public function update(EventTypeRequest $request, EventType $record)
    {
        $form = $this->form(EventTypeForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        EventTypeService::updateWithForm($record, $request, $form);

        flash()->success(trans('partymeister-core::backend/event_types.updated'));

        return redirect('backend/event_types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EventType $record
     * @return RedirectResponse|Redirector
     */
    public function destroy(EventType $record)
    {
        EventTypeService::delete($record);

        flash()->success(trans('partymeister-core::backend/event_types.deleted'));

        return redirect('backend/event_types');
    }
}
