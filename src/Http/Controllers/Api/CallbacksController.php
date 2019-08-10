<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Core\Models\Callback;
use Partymeister\Core\Http\Requests\Backend\CallbackRequest;
use Partymeister\Core\Services\CallbackService;
use Partymeister\Core\Transformers\CallbackTransformer;

class CallbacksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $paginator = Callback::whereIn('action', ['notification', 'competition_ends'])->orderBy('name', 'ASC')->where('is_timed', false)->paginate(500);
//        $paginator = CallbackService::collection()->getPaginator();
        $resource = $this->transformPaginator($paginator, CallbackTransformer::class);

        return $this->respondWithJson('Callback collection read', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CallbackRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CallbackRequest $request)
    {
        $result = CallbackService::create($request)->getResult();
        $resource = $this->transformItem($result, CallbackTransformer::class);

        return $this->respondWithJson('Callback created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param Callback $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Callback $record)
    {
        $result = CallbackService::show($record)->getResult();
        $resource = $this->transformItem($result, CallbackTransformer::class);

        return $this->respondWithJson('Callback read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param CallbackRequest $request
     * @param Callback        $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CallbackRequest $request, Callback $record)
    {
        $result = CallbackService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, CallbackTransformer::class);

        return $this->respondWithJson('Callback updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Callback $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Callback $record)
    {
        $result = CallbackService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('Callback deleted', ['success' => true]);
        }
        return $this->respondWithJson('Callback NOT deleted', ['success' => false]);
    }
}