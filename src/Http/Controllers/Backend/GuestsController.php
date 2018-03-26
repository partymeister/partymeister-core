<?php

namespace Partymeister\Core\Http\Controllers\Backend;

use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Core\Models\Guest;
use Partymeister\Core\Http\Requests\Backend\GuestRequest;
use Partymeister\Core\Services\GuestService;
use Partymeister\Core\Grids\GuestGrid;
use Partymeister\Core\Forms\Backend\GuestForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class GuestsController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = new GuestGrid(Guest::class);

        $service = GuestService::collection($grid);
        $grid->filter = $service->getFilter();
        $paginator    = $service->getPaginator();

        return view('partymeister-core::backend.guests.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(GuestForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.guests.store',
            'enctype' => 'multipart/form-data'
        ]);

        return view('partymeister-core::backend.guests.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(GuestRequest $request)
    {
        $form = $this->form(GuestForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        GuestService::createWithForm($request, $form);

        flash()->success(trans('partymeister-core::backend/guests.created'));

        return redirect('backend/guests');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Guest $record)
    {
        $form = $this->form(GuestForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.guests.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('partymeister-core::backend.guests.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(GuestRequest $request, Guest $record)
    {
        $form = $this->form(GuestForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        GuestService::updateWithForm($record, $request, $form);

        flash()->success(trans('partymeister-core::backend/guests.updated'));

        return redirect('backend/guests');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guest $record)
    {
        GuestService::delete($record);

        flash()->success(trans('partymeister-core::backend/guests.deleted'));

        return redirect('backend/guests');
    }
}
