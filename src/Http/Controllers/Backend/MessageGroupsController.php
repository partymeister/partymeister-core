<?php

namespace Partymeister\Core\Http\Controllers\Backend;

use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Core\Models\MessageGroup;
use Partymeister\Core\Http\Requests\Backend\MessageGroupRequest;
use Partymeister\Core\Services\MessageGroupService;
use Partymeister\Core\Grids\MessageGroupGrid;
use Partymeister\Core\Forms\Backend\MessageGroupForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class MessageGroupsController extends Controller
{

    use FormBuilderTrait;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = new MessageGroupGrid(MessageGroup::class);

        $service = MessageGroupService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator = $service->getPaginator();

        return view('partymeister-core::backend.message-groups.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(MessageGroupForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.message-groups.store',
            'enctype' => 'multipart/form-data'
        ]);

        return view('partymeister-core::backend.message-groups.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(MessageGroupRequest $request)
    {
        $form = $this->form(MessageGroupForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        MessageGroupService::createWithForm($request, $form);

        flash()->success(trans('partymeister-core::backend/message-groups.created'));

        return redirect('backend/message-groups');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(MessageGroup $record)
    {
        $form = $this->form(MessageGroupForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.message-groups.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('partymeister-core::backend.message-groups.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(MessageGroupRequest $request, MessageGroup $record)
    {
        $form = $this->form(MessageGroupForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        MessageGroupService::updateWithForm($record, $request, $form);

        flash()->success(trans('partymeister-core::backend/message-groups.updated'));

        return redirect('backend/message-groups');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(MessageGroup $record)
    {
        MessageGroupService::delete($record);

        flash()->success(trans('partymeister-core::backend/message-groups.deleted'));

        return redirect('backend/message-groups');
    }
}
