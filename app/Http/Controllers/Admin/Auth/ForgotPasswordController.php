<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    private function sendResetEmail($email, $token)
    {
        $link = route('admin.password.reset', [$token, urlencode($email)]);
        try {
            $data['email'] = $email;
            $data['link'] = $link;
            Mail::to($email)->send(new ResetEmail($data));
        } catch (\Exception $e) { }

        return true;
    }

    public function sendResetLinkEmail(Request $request)
    {
        $email = $request->email;
        $admin = \App\User::where('email', $email)->where('status', 'active')->where('type', 'admin')->get();
        if ($admin->count() == 0) {
            return redirect()->back()->with('error', 'L\'utilisateur n\'existe pas avec cet e-mail');
        }

        \DB::table('password_resets')->insert([
            'email'      => $email,
            'token'      => Str::random(64),
            'created_at' => Carbon::now(),
            'admin'      => 1
        ]);
        $tokenData = \DB::table('password_resets')->where('email', $email)->first();

        if ($this->sendResetEmail($email, $tokenData->token)) {
            return redirect()->back()->with('success', 'Un lien de reinitialisation a été envoyé à votre adresse e-mail.');
        } else {
            return redirect()->back()->with('error', 'Une erreur réseau s\'est produite. Veuillez réessayer.');
        }
    }


    public function showLinkRequestForm()
    {
        return view('admin.auth.forgot-password');
    }
}
