<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Core\Models\Guest;
use Partymeister\Core\Http\Requests\Backend\GuestRequest;
use Partymeister\Core\Services\GuestService;
use Partymeister\Core\Transformers\GuestTransformer;

class GuestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = GuestService::collection()->getPaginator();
        $resource = $this->transformPaginator($paginator, GuestTransformer::class);

        return $this->respondWithJson('Guest collection read', $resource);
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
        $result = GuestService::create($request)->getResult();
        $resource = $this->transformItem($result, GuestTransformer::class);

        return $this->respondWithJson('Guest created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Guest $record)
    {
        $result = GuestService::show($record)->getResult();
        $resource = $this->transformItem($result, GuestTransformer::class);

        return $this->respondWithJson('Guest read', $resource);
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
        $result = GuestService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, GuestTransformer::class);

        return $this->respondWithJson('Guest updated', $resource);
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
        $result = GuestService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('Guest deleted', ['success' => true]);
        }
        return $this->respondWithJson('Guest NOT deleted', ['success' => false]);
    }
}