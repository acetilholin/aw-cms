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

class UserController extends Controller
{
    function index(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        $user = new User();
        $users = $user->getUsers();
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
        $cookieName = 'Login';
        $token = Hash::make($this->generateStringToken());
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
        $cars = new Cars();

        if (isset($_COOKIE['Login'])) {
            $cookieValue = json_decode($_COOKIE['Login']);
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
        $cars = new Cars();

        $emailExists = $user->emailExists($email);
        if ($emailExists) {
            $approved = $user->loginApproved($email);
            if ($approved) {
                $passwordMatch = $user->login($email, $password);
                if ($passwordMatch) {
                    session(['email' => $email]);
                    $this->authenticate($email, $password);
                    $dateTime = Carbon::now("Europe/Ljubljana");
                    $seen = $user->lastSeen($email, $dateTime);
                    $this->createLoginCookie($email);
                    $allCars = $cars->getAll();
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
        $password1 = $request->input('password1');
        $password2 = $request->input('password2');

        $user = new User();
        $cars = new Cars();

        $emailExists = $user->emailExists($email);

        switch (true) {
            case ($password1 != $password2):
                return back()->with('error', trans('messages.passwordMissmatch'));
                break;
            case (strlen($password1) < 6):
                return back()->with('error', trans('messages.passwordTooShort'));
                break;
            default:
                if ($emailExists) {
                    return back()->with('error', trans('messages.emailAlreadyExists'));
                } else {
                    $register = $user->register($email, $name, $password2);
                    if ($register) {
                        $adminEmail = env('ADMIN_EMAIL');
                        $allCars = $cars->getAll();
                        \Mail::to($email)->send(new NewUser($email));
                        \Mail::to($adminEmail)->send(new NewAccount($email));
                        return redirect('/login')->with('success', trans('messages.registrationSuccessful'));
                    } else {
                        return back()->with('error', trans('messages.accountNotConfirmed'));
                    }
                }
        }
    }

    function sendToken(Request $request)
    {
        $email = $request->input('email');
        $user = new User();

        $emailExists = $user->emailExists($email);
        if (!$emailExists) {
            return back()->with('error', trans('messages.emailNotExists'));
        }

        $approvedEmailExists = $user->loginApproved($email);

        if ($approvedEmailExists) {
            $token = $this->generateStringToken();
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
        $password1 = $request->input('password1');
        $password2 = $request->input('password2');

        $user = new User();

        $emailExists = $user->emailExists($email);

        if ($emailExists) {
            $emailAndTokenMatch = $user->emailAndTokenMatch($email, $token);
            if ($emailAndTokenMatch) {
                $tokenHasExpired = $this->checkTokenExpirationTime($token, $email);
                if ($tokenHasExpired) {
                    return back()->with('error', trans('messages.tokenExpired'));
                } else {
                    switch (true) {
                        case ($password1 != $password2):
                            return back()->with('error', trans('messages.passwordMissmatch'));
                            break;
                        case (strlen($password1) < 6):
                            return back()->with('error', trans('messages.passwordTooShort'));
                            break;
                        default:
                            $updatePassword = $user->updatePassword($email, $password1);
                            return redirect('/login')->with('success', trans('messages.passwordChanged'));
                    }
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
            $delete = $user->deleteUser($id);
            $info = trans('messages.userIsRemoved');
        }

        $users = $user->getUsers();

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
            $delete = $user->lockUser($id);
            $info = trans('messages.userIsLocked');
        }

        $users = $user->getUsers();

        return view('users', [
            'users' => $users,
            'info' => $info,
            'onlineUsers' => $onlineUsers
        ]);
    }

    function unLockUser($id)
    {
        $user = new User();

        $unlock = $user->unLockUser($id);
        $users = $user->getUsers();
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

    function generateStringToken()
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10 / strlen($x)))), 1, 10);
    }

    function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
