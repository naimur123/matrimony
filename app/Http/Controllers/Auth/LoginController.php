<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
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

    /**
     * Show Login from Only JSON Respons
     */
    public function showLoginForm(Request $request)
    {
        if( $request->ajax() ){
            return view('frontEnd.account.login');
        }
        return redirect('/');        
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string|min:6',
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        $user->is_online = true;
        $user->login_at = Carbon::now();
        $user->save();
        $this->success('Login Successfully');
        $this->url = url($this->redirectPath());        
        $this->table = false;
        return $this->output();
    }
    
}
