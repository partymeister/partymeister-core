<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Core\Models\EventType;
use Partymeister\Core\Http\Requests\Backend\EventTypeRequest;
use Partymeister\Core\Services\EventTypeService;
use Partymeister\Core\Transformers\EventTypeTransformer;

class EventTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = EventTypeService::collection()->getPaginator();
        $resource = $this->transformPaginator($paginator, EventTypeTransformer::class);

        return $this->respondWithJson('EventType collection read', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EventTypeRequest $request)
    {
        $result = EventTypeService::create($request)->getResult();
        $resource = $this->transformItem($result, EventTypeTransformer::class);

        return $this->respondWithJson('EventType created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(EventType $record)
    {
        $result = EventTypeService::show($record)->getResult();
        $resource = $this->transformItem($result, EventTypeTransformer::class);

        return $this->respondWithJson('EventType read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EventTypeRequest $request, EventType $record)
    {
        $result = EventTypeService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, EventTypeTransformer::class);

        return $this->respondWithJson('EventType updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventType $record)
    {
        $result = EventTypeService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('EventType deleted', ['success' => true]);
        }
        return $this->respondWithJson('EventType NOT deleted', ['success' => false]);
    }
}