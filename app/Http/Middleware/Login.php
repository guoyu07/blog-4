<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Flash;

class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guest()) {
            Flash::warning('Please Login first!');
            return redirect()->back();
        }
        return $next($request);
    }
}
