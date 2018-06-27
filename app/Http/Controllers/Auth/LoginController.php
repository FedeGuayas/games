<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Sobreescribir el motodo authenticated para redireccionar a los usaurios segun su rol al autenticarse
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticated(Request $request)
    {
        // Reenviar al usuario despues de logeado segun rol
        if ($request->user()->hasRole('usuario')) {
            return redirect()->route('events.index');
        }
        if ($request->user()->hasRole('admin')) {
            return redirect()->route('home');
        }
    }
}
