<?php

namespace App\Http\Controllers;

use App\Cars;
use App\Mail\NewAccount;
use App\Mail\NewPassword;
use App\Mail\NewUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    function index(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        $user = new User();
        $users = User::where('silent', false)
            ->get();
        $onlineUsers = $this->onlineUsers();

        return view('users', [
            'users' => $users,
            'onlineUsers' => $onlineUsers,
        ]);
    }

    function authenticate($email, $password)
    {
        Auth::attempt(['email' => $email, 'password' => $password]);
    }

    function createLoginCookie($email)
    {
        $user = new User();
        $cookieName = 'AVLogin';
        $token = Hash::make(Str::random(10));
        $data = [
            'email' => $email,
            'token' => $token
        ];
        $user->insertLoginToken($token, $email);
        setcookie($cookieName, json_encode($data), time() + 86400 * 365);
    }

    function checkCookie(Request $request)
    {
        $user = new User();

        if (isset($_COOKIE['AVLogin'])) {
            $cookieValue = json_decode($_COOKIE['AVLogin']);
            $email = $cookieValue->email;
            $loginToken = $cookieValue->token;

            $match = $user->checkTokenMatch($email, $loginToken);

            if ($match) {
                $email = $cookieValue->email;
                $name = $user->getUserName($email);
                return view('login', [
                    'email' => $email,
                    'name' => $name
                ]);
            } else {
                return view('login');
            }
        } else {
            return view('login');
        }
    }

    function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = new User();

        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], $this->messages());

        $emailExists = $user->emailExists($email);
        if ($emailExists) {
            $approved = $user->loginApproved($email);
            if ($approved) {
                $passwordMatch = $user->login($email, $password);
                if ($passwordMatch) {
                    session(['email' => $email]);
                    $this->authenticate($email, $password);
                    $dateTime = Carbon::now("Europe/Ljubljana")->format('d.m.Y H:i');
                    $user->lastSeen($email, $dateTime);
                    $this->createLoginCookie($email);
                    $allCars = Cars::all();
                    return view('main', [
                        'cars' => $allCars
                    ]);
                } else {
                    return back()->with('error', trans('messages.wrongPassword'));
                }
            } else {
                return back()->with('error', trans('messages.cannotLogin'));
            }
        } else {
            return back()->with('error', trans('messages.emailNotExists'));
        }
    }

    function register(Request $request)
    {
        $email = $request->input('email');
        $name = $request->input('name');
        $password1 = $request->input('password');
        $password2 = $request->input('password_confirmation');

        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|unique:users|max:60',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'

        ], $this->messages());

        $user = new User();

        $emailExists = $user->emailExists($email);

        $register = $user->register($email, $name, $password2);

        if ($register) {
            $adminEmail = env('ADMIN_EMAIL');
            \Mail::to($email)->send(new NewUser($email));
            \Mail::to($adminEmail)->send(new NewAccount($email));
            return redirect('/login')->with('success', trans('messages.registrationSuccessful'));
        } else {
            return back()->with('error', trans('messages.accountNotConfirmed'));
        }
    }

    function sendToken(Request $request)
    {
        $email = $request->input('email');
        $user = new User();

        $validatedData = $request->validate([
            'email' => 'required'
        ], $this->messages());

        $emailExists = $user->emailExists($email);
        if (!$emailExists) {
            return back()->with('error', trans('messages.emailNotExists'));
        }

        $approvedEmailExists = $user->loginApproved($email);

        if ($approvedEmailExists) {
            $token = Str::random(10);
            $user->insertResetPasswordToken($token, $email);
            \Mail::to($email)->send(new NewPassword($token));
            return redirect('token')->with('success', trans('messages.tokenSent'));
        } else {
            return back()->with('error', trans('messages.accountNotConfirmed'));
        }
    }

    function validateToken(Request $request)
    {
        $token = $request->input('token');
        $email = $request->input('email');
        $password1 = $request->input('password');
        $password2 = $request->input('password_confirmation');

        $user = new User();

        $validatedData = $request->validate([
            'token' => 'required',
            'email' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ], $this->messages());

        $emailExists = $user->emailExists($email);

        if ($emailExists) {
            $emailAndTokenMatch = $user->emailAndTokenMatch($email, $token);
            if ($emailAndTokenMatch) {
                $tokenHasExpired = $this->checkTokenExpirationTime($token, $email);
                if ($tokenHasExpired) {
                    return back()->with('error', trans('messages.tokenExpired'));
                } else {
                    $user->updatePassword($email, $password1);
                    return redirect('/login')->with('success', trans('messages.passwordChanged'));
                }
            } else {
                return back()->with('error', trans('messages.wrongToken'));
            }
        } else {
            return back()->with('error', trans('messages.emailNotExists'));
        }
    }

    function checkTokenExpirationTime($token, $email)
    {
        $user = new User();

        $tokenCreationTime = $user->getTokenCreationTime($token, $email);
        $timeNow = date('Y-m-d H:i');

        $datetime1 = strtotime($tokenCreationTime);
        $datetime2 = strtotime($timeNow);
        $minutes = ($datetime2 - $datetime1) / 60;

        return $minutes < 60 ? false : true;
    }

    function deleteUser(Request $request, $id)
    {
        $adminEmail = env('ADMIN_EMAIL');
        $user = new User();
        $usersEmail = $user->getUsersEmail($id);
        $onlineUsers = $this->onlineUsers();

        $currentEmail = $request->session()->get('email');

        if ($usersEmail == $adminEmail) {
            $info = trans('messages.cannotRemoveAdmin');
        } else if ($usersEmail == $currentEmail) {
            $info = trans('messages.selfDelete');
        } else {
            $user = User::find($id);
            $user->delete();
            $info = trans('messages.userIsRemoved');
        }

        $users = User::where('silent', false)
            ->get();

        return view('users', [
            'users' => $users,
            'info' => $info,
            'onlineUsers' => $onlineUsers
        ]);
    }

    function lockUser(Request $request, $id)
    {
        $adminEmail = env('ADMIN_EMAIL');
        $user = new User();
        $usersEmail = $user->getUsersEmail($id);
        $onlineUsers = $this->onlineUsers();

        $currentEmail = $request->session()->get('email');

        if ($usersEmail == $adminEmail) {
            $info = trans('messages.cannotLockAdmin');
        } else if ($usersEmail == $currentEmail) {
            $info = trans('messages.selfUnlock');
        } else {
            $user->lockUser($id);
            $info = trans('messages.userIsLocked');
        }

        $users = User::where('silent', false)
            ->get();

        return view('users', [
            'users' => $users,
            'info' => $info,
            'onlineUsers' => $onlineUsers
        ]);
    }

    function unLockUser($id)
    {
        $user = new User();

        $user->unLockUser($id);
        $users = User::where('silent', false)
            ->get();
        $onlineUsers = $this->onlineUsers();

        return view('users', [
            'info' => trans('messages.userIsUnlocked'),
            'users' => $users,
            'onlineUsers' => $onlineUsers,
        ]);
    }

    function onlineUsers()
    {
        $user = new User();
        $allUserIds = $user->allUserIds();

        for ($i = 0; $i < sizeof($allUserIds); $i++) {
            if (Cache::has('user-is-online-' . $allUserIds[$i]) == true) {
                $userStatus[$i] = 'online';
            } else {
                $userStatus[$i] = 'offline';
            }
        }
        return $userStatus;
    }

    function messages()
    {
        return [
            'email.required' => trans('messages.emailRequired'),
            'password.required' => trans('messages.passwordRequired'),
            'name.required' => trans('messages.nameRequired'),
            'name.min' => trans('messages.nameTooShort'),
            'email.unique' => trans('messages.emailAlreadyExists'),
            'password.min' => trans('messages.passwordTooShort'),
            'password_confirmation.same' => trans('messages.passwordMissmatch'),
            'password_confirmation.required' => trans('messages.passConfirmationRequired'),
            'token.required' => trans('messages.tokenRequired')
        ];
    }

    function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
