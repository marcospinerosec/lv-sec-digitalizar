<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Log;
use Closure;

class AuthenticateWithSession
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

        Log::debug('daleeee');
        if (!empty(session('authenticated'))) {
            $request->session()->put('authenticated', time());
            return $next($request);
        }

        return redirect('/login');
    }
}
