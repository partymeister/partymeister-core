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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \ReflectionException
     */
    public function index()
    {
        $grid = new ScheduleGrid(Schedule::class);

        $service = ScheduleService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator = $service->getPaginator();

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
     * @param ScheduleRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
     * @param Schedule $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Schedule $record)
    {
        return view('partymeister-core::backend.schedules.show', compact('record'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Schedule $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @param ScheduleRequest $request
     * @param Schedule        $record
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
     * @param Schedule $record
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Schedule $record)
    {
        ScheduleService::delete($record);

        flash()->success(trans('partymeister-core::backend/schedules.deleted'));

        return redirect('backend/schedules');
    }
}
