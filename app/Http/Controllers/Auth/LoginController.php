<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller {
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
    protected $redirectTo = '/calculations';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function username() {
        return "username";
    }

    public function authenticate(Request $request) {

        if (Auth::attempt([$this->username() => $request->username, 'password' => $request->password])) {
            // Authentication passed...
            return $this->sendLoginResponse($request);
        }

        if (auth()->check()): //necessario, pois após a falha do attempt é invocado o Listener. O listener autentica o usuário mas não redireciona de imediato
            return $this->sendLoginResponse($request);
        endif;

        return $this->sendFailedLoginResponse($request);
    }

}
