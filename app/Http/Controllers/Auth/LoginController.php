<?php

namespace App\Http\Controllers\Auth;

use App\Car;
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class LoginController extends Controller
{
    /**
     * Check for login cookie
     *
     */
    public function checkCookie()
    {
        if (isset($_COOKIE['AVLogin'])) {
            $cookieValue = json_decode($_COOKIE['AVLogin']);
            $email = $cookieValue->email;
            $loginToken = $cookieValue->token;

            if (User::where('email', $email)->exists()) {
                $token = User::where('email', $email)->pluck('login_token');
                $name = User::where('email', $email)->pluck('name');

                if ($token[0] === $loginToken) {
                    return view('login', [
                        'email' => $email,
                        'name' => $name[0]
                    ]);
                }
            }
            return view('login');
        } else {
            return view('login');
        }
    }

    /**
     * Login user
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $helper = new UserHelper();

        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], $helper->messages());

        $exists = User::where('email', $email)->first();

        if (!$exists) {
            return back()->with('error', trans('messages.emailNotExists'));
        } else {
            $user = $exists->getAttributes();
            $locked = $user['locked'];

            if ($locked > 2) {
                return back()->with('error', trans('messages.reachedMaxLoginAttempts'));
            }
            if ($exists->getAttributes()) {
                $approved = User::where('email', $email)->pluck('approved')->toArray();
            }
            if (!(boolean) $approved[0]) {
                return back()->with('error', trans('messages.accountNotConfirmed'));
            }

            $userPassword = User::where('email', $email)->pluck('password')->toArray();
            if (!Hash::check($password, $userPassword[0])) {
                $locked++;
                User::where('email', $email)->update(['locked' => $locked]);
                return redirect()->back()->with([
                    'error' => trans('messages.wrongPassword'),
                    'poizkus' => 1
                ]);
            } else {
                session(['email' => $email]);
                $helper->authenticate($email, $password);
                $dateTime = Carbon::now("Europe/Ljubljana")->format('Y-m-d H:i');
                $helper->lastSeen($email, $dateTime);
                $helper->createLoginCookie($email);
                $allCars = Car::all();
                return view('main', [
                    'cars' => $allCars
                ]);
            }
        }
    }

    /**
     * User logout
     *
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
