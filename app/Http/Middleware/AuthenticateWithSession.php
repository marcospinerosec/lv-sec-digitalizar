<?php

namespace App\Http\Middleware;
use App\Models\User;
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


        echo base64_encode(hash("sha256",mb_convert_encoding("abcdefg","UTF-16LE"),true));

        foreach ($request as $v){
            //print_r($v);

            if ($v->get('userId')){
                Log::debug('user: '.$v->get('userId'));
                $request->session()->put('authenticated', time());
                $user = new User();
                $user->id=$v->get('userId');
                $request->session()->put('user', $user);
            }

        }
        if (!empty(session('authenticated'))) {
            //Log::debug('logueado');
            $request->session()->put('authenticated', time());
            //return $next($request);
        }

        //return redirect('/login');
    }
}
