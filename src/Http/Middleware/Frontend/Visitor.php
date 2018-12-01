<?php

namespace Partymeister\Core\Http\Middleware\Frontend;

use Closure;
use Illuminate\Support\Facades\Auth;

class Visitor
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \View::share('visitor', Auth::guard('visitor')->user());

        return $next($request);
    }
}
