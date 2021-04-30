<?php

namespace Partymeister\Core\Http\Controllers\Backend;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Core\Forms\Backend\EventForm;
use Partymeister\Core\Grids\EventGrid;
use Partymeister\Core\Http\Requests\Backend\EventRequest;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Services\EventService;
use ReflectionException;

/**
 * Class EventsController
 *
 * @package Partymeister\Core\Http\Controllers\Backend
 */
class EventsController extends Controller
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
        $grid = new EventGrid(Event::class);

        $service = EventService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator = $service->getPaginator();

        return view('partymeister-core::backend.events.index', compact('paginator', 'grid'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventRequest $request
     * @return RedirectResponse|Redirector
     */
    public function store(EventRequest $request)
    {
        $form = $this->form(EventForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        EventService::createWithForm($request, $form);

        flash()->success(trans('partymeister-core::backend/events.created'));

        return redirect('backend/events');
    }

    /**
     * @param Event $record
     * @return Factory|View
     */
    public function duplicate(Event $record)
    {
        $newRecord = $record->replicate();
        $newRecord->name = 'Duplicate of '.$newRecord->name;

        return $this->create($newRecord);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Event $record
     * @return Factory|View
     */
    public function create(Event $record)
    {
        $form = $this->form(EventForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.events.store',
            'enctype' => 'multipart/form-data',
            'model'   => $record,
        ]);

        return view('partymeister-core::backend.events.create', compact('form'));
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
     * @param Event $record
     * @return Factory|View
     */
    public function edit(Event $record)
    {
        $form = $this->form(EventForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.events.update', [$record->id]),
            'enctype' => 'multipart/form-data',
            'model'   => $record,
        ]);

        return view('partymeister-core::backend.events.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EventRequest $request
     * @param Event $record
     * @return RedirectResponse|Redirector
     */
    public function update(EventRequest $request, Event $record)
    {
        $form = $this->form(EventForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        EventService::updateWithForm($record, $request, $form);

        flash()->success(trans('partymeister-core::backend/events.updated'));

        return redirect('backend/events');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $record
     * @return RedirectResponse|Redirector
     */
    public function destroy(Event $record)
    {
        EventService::delete($record);

        flash()->success(trans('partymeister-core::backend/events.deleted'));

        return redirect('backend/events');
    }
}
