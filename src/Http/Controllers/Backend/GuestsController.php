<?php

namespace Partymeister\Core\Http\Controllers\Backend;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Core\Forms\Backend\GuestForm;
use Partymeister\Core\Grids\GuestGrid;
use Partymeister\Core\Http\Requests\Backend\GuestRequest;
use Partymeister\Core\Models\Guest;
use Partymeister\Core\Services\GuestService;
use ReflectionException;

/**
 * Class GuestsController
 *
 * @package Partymeister\Core\Http\Controllers\Backend
 */
class GuestsController extends Controller
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
        $grid = new GuestGrid(Guest::class);

        $service = GuestService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator = $service->getPaginator();

        return view('partymeister-core::backend.guests.index', compact('paginator', 'grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $form = $this->form(GuestForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.guests.store',
            'enctype' => 'multipart/form-data',
        ]);

        return view('partymeister-core::backend.guests.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GuestRequest $request
     * @return RedirectResponse|Redirector
     */
    public function store(GuestRequest $request)
    {
        $form = $this->form(GuestForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        GuestService::createWithForm($request, $form);

        flash()->success(trans('partymeister-core::backend/guests.created'));

        return redirect('backend/guests');
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
     * @param Guest $record
     * @return Factory|View
     */
    public function edit(Guest $record)
    {
        $form = $this->form(GuestForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.guests.update', [$record->id]),
            'enctype' => 'multipart/form-data',
            'model'   => $record,
        ]);

        return view('partymeister-core::backend.guests.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GuestRequest $request
     * @param Guest $record
     * @return RedirectResponse|Redirector
     */
    public function update(GuestRequest $request, Guest $record)
    {
        $form = $this->form(GuestForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        GuestService::updateWithForm($record, $request, $form);

        flash()->success(trans('partymeister-core::backend/guests.updated'));

        return redirect('backend/guests');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Guest $record
     * @return RedirectResponse|Redirector
     */
    public function destroy(Guest $record)
    {
        GuestService::delete($record);

        flash()->success(trans('partymeister-core::backend/guests.deleted'));

        return redirect('backend/guests');
    }
}
