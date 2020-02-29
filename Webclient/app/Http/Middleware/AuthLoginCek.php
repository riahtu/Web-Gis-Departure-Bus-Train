<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Closure;

class AuthLoginCek
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
        if(!session()->has('WebclientSession')) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}
