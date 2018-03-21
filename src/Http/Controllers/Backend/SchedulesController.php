<?php

namespace Partymeister\Core\Http\Controllers\Backend;

use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Core\Models\Schedule;
use Partymeister\Core\Http\Requests\Backend\ScheduleRequest;
use Partymeister\Core\Services\ScheduleService;
use Partymeister\Core\Grids\ScheduleGrid;
use Partymeister\Core\Forms\Backend\ScheduleForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class SchedulesController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = new ScheduleGrid(Schedule::class);

        $service = ScheduleService::collection($grid);
        $grid->filter = $service->getFilter();
        $paginator    = $service->getPaginator();

        return view('partymeister-core::backend.schedules.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(ScheduleForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.schedules.store',
            'enctype' => 'multipart/form-data'
        ]);

        return view('partymeister-core::backend.schedules.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleRequest $request)
    {
        $form = $this->form(ScheduleForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        ScheduleService::createWithForm($request, $form);

        flash()->success(trans('partymeister-core::backend/schedules.created'));

        return redirect('backend/schedules');
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
    public function edit(Schedule $record)
    {
        $form = $this->form(ScheduleForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.schedules.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('partymeister-core::backend.schedules.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleRequest $request, Schedule $record)
    {
        $form = $this->form(ScheduleForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        ScheduleService::updateWithForm($record, $request, $form);

        flash()->success(trans('partymeister-core::backend/schedules.updated'));

        return redirect('backend/schedules');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $record)
    {
        ScheduleService::delete($record);

        flash()->success(trans('partymeister-core::backend/schedules.deleted'));

        return redirect('backend/schedules');
    }
}
