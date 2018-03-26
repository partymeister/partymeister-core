<?php

namespace Partymeister\Core\Http\Controllers\Backend;

use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Core\Models\Visitor;
use Partymeister\Core\Http\Requests\Backend\VisitorRequest;
use Partymeister\Core\Services\VisitorService;
use Partymeister\Core\Grids\VisitorGrid;
use Partymeister\Core\Forms\Backend\VisitorForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class VisitorsController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = new VisitorGrid(Visitor::class);

        $service = VisitorService::collection($grid);
        $grid->filter = $service->getFilter();
        $paginator    = $service->getPaginator();

        return view('partymeister-core::backend.visitors.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(VisitorForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.visitors.store',
            'enctype' => 'multipart/form-data',
            'model' => ['country_iso_3166_1' => 'DE']
        ]);

        return view('partymeister-core::backend.visitors.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(VisitorRequest $request)
    {
        $form = $this->form(VisitorForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        VisitorService::createWithForm($request, $form);

        flash()->success(trans('partymeister-core::backend/visitors.created'));

        return redirect('backend/visitors');
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
    public function edit(Visitor $record)
    {
        $form = $this->form(VisitorForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.visitors.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('partymeister-core::backend.visitors.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(VisitorRequest $request, Visitor $record)
    {
        $form = $this->form(VisitorForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        VisitorService::updateWithForm($record, $request, $form);

        flash()->success(trans('partymeister-core::backend/visitors.updated'));

        return redirect('backend/visitors');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitor $record)
    {
        VisitorService::delete($record);

        flash()->success(trans('partymeister-core::backend/visitors.deleted'));

        return redirect('backend/visitors');
    }
}
