<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function reset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'token' => 'required',
            'password' => 'required|confirmed',
        ]);

        $password = $request->password;// Validate the token
        $tokenData = \DB::table('password_resets')
            ->where('token', $request->token)->where('email', $request->email)->first();// Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData){
            $request->session()->flash('error', 'Invalid Password Reset Link');
            return redirect(route('admin.login'));
        }

        $user = \App\Admin::where('email', $tokenData->email)->first();
        if (!$user) return redirect()->back()->withErrors(['email' => 'Email not found']);//Hash and update the new password
        $user->password = \Hash::make($password);
        $user->save();
        \Auth::guard('admin')->login($user);
        \DB::table('password_resets')->where('email', $user->email)->delete();
        return redirect()->to(route('admin.dashboard'));

    }

    public function showLinkRequestForm($token){
        $data['token'] = $token;
        return view('admin.auth.reset')->with($data);
    }

}
