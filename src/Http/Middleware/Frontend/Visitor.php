<?php

namespace Partymeister\Core\Http\Middleware\Frontend;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use View;

/**
 * Class Visitor
 *
 * @package Partymeister\Core\Http\Middleware\Frontend
 */
class Visitor
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        View::share('visitor', Auth::guard('visitor')
                                   ->user());

        return $next($request);
    }
}
