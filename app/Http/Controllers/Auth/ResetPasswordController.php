<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /**
     * Validate token
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function resetPassword(Request $request)
    {
        $helper = new UserHelper();
        $validatedData = $request->validate([
            'token' => 'required',
            'email' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ], $helper->messages());

        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->with('error', trans('messages.emailNotExists'));
        } else {
            $token = $request->input('token');
            $match = $helper->emailAndTokenMatch($email, $token);
            if ($match) {
                $expired = $helper->checkTokenExpirationTime($token, $email);
                if ($expired) {
                    return back()->with('error', trans('messages.tokenExpired'));
                } else {
                    $password = $request->input('password');
                    $password = Hash::make($password);
                    User::where('email', $email)
                        ->update(['password' => $password]);
                    return redirect('/login')->with('success', trans('messages.passwordChanged'));
                }
            } else {
                return back()->with('error', trans('messages.wrongToken'));
            }
        }
    }
}
