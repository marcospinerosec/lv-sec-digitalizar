<?php

namespace App\Http\Middleware;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Closure;

class AuthenticateWithSession
{

    function cryptoJsAesDecrypt($passphrase, $jsonString){
        $jsondata = json_decode($jsonString, true);
        $salt = hex2bin($jsondata["s"]);
        $ct = base64_decode($jsondata["ct"]);
        $iv  = hex2bin($jsondata["iv"]);
        $concatedPassphrase = $passphrase.$salt;
        $md5 = array();
        $md5[0] = md5($concatedPassphrase, true);
        $result = $md5[0];
        for ($i = 1; $i < 3; $i++) {
            $md5[$i] = md5($md5[$i - 1].$concatedPassphrase, true);
            $result .= $md5[$i];
        }
        $key = substr($result, 0, 32);
        $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
        return json_decode($data, true);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $userID='';
        foreach ($request as $v){
            //print_r($v);

            if ($v->get('userId')){
                Log::debug('user: '.$v->get('userId'));


                $userID=$v->get('userId');

            }

        }
        //if ($userID){

            $userIDDecrypt = $this->cryptoJsAesDecrypt("myPass",$userID);

            Log::debug('user decrypt: '.$userIDDecrypt);
            //if ($userIDDecrypt){
                $request->session()->put('authenticated', time());
                $user = new User();
                $user->id=1;
                $request->session()->put('user', $user);
            //}

        //}
        if (!empty(session('authenticated'))) {
            //Log::debug('logueado');
            $request->session()->put('authenticated', time());
            return $next($request);
        }

        return redirect('no_session');
    }
}
