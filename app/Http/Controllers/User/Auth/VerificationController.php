<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:user');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify','resend');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user('users')->hasVerifiedEmail()
            ? redirect()->route('user.home')
            : view('auth.verify',[
                'resendRoute' => 'user.verification.resend',
            ]);
    }

    /**
     * Verfy the user email.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        if ($request->route('id') != $request->user('user')->getKey()) {
            //id value doesn't match.
            return redirect()
                ->route('user.verification.notice')
                ->with('error','Invalid user!');
        }

        if ($request->user('user')->hasVerifiedEmail()) {
            return redirect()
                ->route('user.home');
        }

        $request->user('user')->markEmailAsVerified();

        return redirect()
            ->route('user.home')
            ->with('status','Thank you for verifying your email!');
    }

    /**
     * Resend the verification email.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        if ($request->user('user')->hasVerifiedEmail()) {
            return redirect()->route('user.home');
        }

        $request->user('user')->sendEmailVerificationNotification();

        return redirect()
            ->back()
            ->with('status','We have sent you a verification email!');
    }

}
