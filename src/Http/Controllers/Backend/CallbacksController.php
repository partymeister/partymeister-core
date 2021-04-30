<?php

namespace Partymeister\Core\Http\Controllers\Backend;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Core\Forms\Backend\CallbackForm;
use Partymeister\Core\Grids\CallbackGrid;
use Partymeister\Core\Http\Requests\Backend\CallbackRequest;
use Partymeister\Core\Models\Callback;
use Partymeister\Core\Services\CallbackService;
use ReflectionException;

/**
 * Class CallbacksController
 *
 * @package Partymeister\Core\Http\Controllers\Backend
 */
class CallbacksController extends Controller
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
        $grid = new CallbackGrid(Callback::class);

        $service = CallbackService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator = $service->getPaginator();

        return view('partymeister-core::backend.callbacks.index', compact('paginator', 'grid'));
    }

    /**
     * @param Callback $record
     * @return Factory|View
     */
    public function duplicate(Callback $record)
    {
        $newRecord = $record->replicate();
        $newRecord->name = 'Duplicate of '.$newRecord->name;
        $newRecord->hash = '';

        return $this->create($newRecord);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Callback $record
     * @return Factory|View
     */
    public function create(Callback $record)
    {
        $form = $this->form(CallbackForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.callbacks.store',
            'enctype' => 'multipart/form-data',
            'model'   => $record,
        ]);

        return view('partymeister-core::backend.callbacks.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CallbackRequest $request
     * @return RedirectResponse|Redirector
     */
    public function store(CallbackRequest $request)
    {
        $form = $this->form(CallbackForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        CallbackService::createWithForm($request, $form);

        flash()->success(trans('partymeister-core::backend/callbacks.created'));

        return redirect('backend/callbacks');
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
     * @param Callback $record
     * @return Factory|View
     */
    public function edit(Callback $record)
    {
        $form = $this->form(CallbackForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.callbacks.update', [$record->id]),
            'enctype' => 'multipart/form-data',
            'model'   => $record,
        ]);

        return view('partymeister-core::backend.callbacks.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CallbackRequest $request
     * @param Callback $record
     * @return RedirectResponse|Redirector
     */
    public function update(CallbackRequest $request, Callback $record)
    {
        $form = $this->form(CallbackForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        CallbackService::updateWithForm($record, $request, $form);

        flash()->success(trans('partymeister-core::backend/callbacks.updated'));

        return redirect('backend/callbacks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Callback $record
     * @return RedirectResponse|Redirector
     */
    public function destroy(Callback $record)
    {
        CallbackService::delete($record);

        flash()->success(trans('partymeister-core::backend/callbacks.deleted'));

        return redirect('backend/callbacks');
    }
}
