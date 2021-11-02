<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /* custom */

    // \vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {

        Log::debug('login ' . $request->input('email') . ' == ' . env('LOGIN_USERNAME') . ' && ' . $request->input('password') . ' == ' . env('LOGIN_PASSWORD'));

        if ($request->input('password') === env('LOGIN_PASSWORD') && $request->input('email') === env('LOGIN_USERNAME')) {
            $request->session()->put('authenticated', time());
            return redirect()->intended('home');
        }

        return view('auth.login', [
            'message' => 'Provided PIN is invalid. ',
        ]);
    }

}
