<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
class LoginController extends Controller
{
    use ThrottlesLogins;
    public $maxAttempts = 100;

    public $decayMinutes = 3;

    /**
     * Only guests for "admin" guard are allowed except
     * for logout.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:users')->except('logout');
    }
    public function showLoginForm()
    {
        return view('auth.login',[
            'title' => 'Login',
            'loginRoute' => 'user.login', 
        ]);
    }

     public function login(Request $request)
    {
        $this->validator($request);

        //check if the user has too many login attempts.
        if ($this->hasTooManyLoginAttempts($request)){
            //Fire the lockout event
            $this->fireLockoutEvent($request);

            //redirect the user back after lockout.
            return $this->sendLockoutResponse($request);
        }

        //attempt login.
        if(Auth::guard('users')->attempt($request->only('email','password'),$request->filled('remember'))){
            //Authenticated, redirect to the intended route
            //if available else admin dashboard.
            return redirect()
                ->intended(route('user.books'))
                ->with('status','You are Logged!');
        }

        //keep track of login attempts from the user.
        $this->incrementLoginAttempts($request);

        //Authentication failed, redirect back with input.
        return $this->loginFailed();
    }

    public function logout()
    {
        Auth::guard('users')->logout();
        return redirect()
            ->route('login')
            ->with('status','Admin has been logged out!');
    }

    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email'    => 'required|email|exists:users|min:5|max:191',
            'password' => 'required|string|min:4|max:255',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => 'Wrong Account',
        ];

        //validate the request.
        $request->validate($rules,$messages);
    }

    private function loginFailed(){
        return redirect()
            ->back()
            ->withInput()
            ->with('error','Login failed!');
    }

    public function username(){
        return 'email';
    }

}
