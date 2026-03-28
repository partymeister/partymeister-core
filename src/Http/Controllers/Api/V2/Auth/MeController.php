<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\Auth;

use Illuminate\Http\Request;
use Motor\Admin\Http\Controllers\Controller;
use Partymeister\Core\Http\Resources\V2\VisitorResource;

/**
 * @tags Core: Visitor Auth
 */
class MeController extends Controller
{
    public function show(Request $request): VisitorResource
    {
        $visitor = $request->user();

        return (new VisitorResource($visitor))
            ->additional(['meta' => ['message' => 'Profile loaded']]);
    }
}
