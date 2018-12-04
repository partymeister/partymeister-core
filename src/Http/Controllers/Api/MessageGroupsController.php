<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Core\Models\MessageGroup;
use Partymeister\Core\Http\Requests\Backend\MessageGroupRequest;
use Partymeister\Core\Services\MessageGroupService;
use Partymeister\Core\Transformers\MessageGroupTransformer;

class MessageGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = MessageGroupService::collection()->getPaginator();
        $resource = $this->transformPaginator($paginator, MessageGroupTransformer::class);

        return $this->respondWithJson('MessageGroup collection read', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(MessageGroupRequest $request)
    {
        $result = MessageGroupService::create($request)->getResult();
        $resource = $this->transformItem($result, MessageGroupTransformer::class);

        return $this->respondWithJson('MessageGroup created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(MessageGroup $record)
    {
        $result = MessageGroupService::show($record)->getResult();
        $resource = $this->transformItem($result, MessageGroupTransformer::class);

        return $this->respondWithJson('MessageGroup read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(MessageGroupRequest $request, MessageGroup $record)
    {
        $result = MessageGroupService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, MessageGroupTransformer::class);

        return $this->respondWithJson('MessageGroup updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(MessageGroup $record)
    {
        $result = MessageGroupService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('MessageGroup deleted', ['success' => true]);
        }
        return $this->respondWithJson('MessageGroup NOT deleted', ['success' => false]);
    }
}