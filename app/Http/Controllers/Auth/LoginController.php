<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

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

    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');

        $this->username = $this->findUsername();
    }

    public function findUsername() {

        $login = request()->input('login');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function redirectTo() {
        $user = Auth::user();
        if ($user->admin) {
            return '/';
        }
        return '/user/' . $user->id;
    }

    public function getUser($request) {
        return $request->user();
    }

    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request) {
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => Lang::get('auth.failed'),
            ])->with('error_code', 'bad_login');
    }

    public function username() {
        return $this->username;
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if(!$user->active()){
            Auth::logout();
            switch($user->buyer->status){
                case 'Banned':
                    return redirect()->back()
                                    ->withInput($request->only($this->username(), 'remember'))
                                    ->with('error_code', 'bad_login')
                                    ->with('login_error', 'banned');
                default:
                    return redirect()->back()
                                    ->withInput($request->only($this->username(), 'remember'))
                                    ->with('error_code', 'bad_login')
                                    ->with('login_error', 'not_active');
            }
        }
    }

}
