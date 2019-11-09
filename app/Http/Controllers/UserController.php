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
                    $this->authenticate($email, $password);
                    $dateTime = Carbon::now("Europe/Ljubljana");
                    $seen = $user->lastSeen($email, $dateTime);
                    $allCars = $cars->getAll();
                    return view('main', [
                        'cars' => $allCars
                    ]);
                } else {
                    return back()->with('error', 'Napačno geslo');
                }
            } else {
                return back()->with('error', 'Prijava ni mogoča');
            }
        } else {
            return back()->with('error', 'Email ne obstaja');
        }
    }

    function register(Request $request)
    {
        $email = $request->input('email');
        $password1 = $request->input('password1');
        $password2 = $request->input('password2');

        $user = new User();
        $cars = new Cars();

        $emailExists = $user->emailExists($email);

        switch (true) {
            case ($password1 != $password2):
                return back()->with('error', 'Gesli se ne ujemata');
                break;
            case (strlen($password1) < 6):
                return back()->with('error', 'Geslo je prekratko');
                break;
            default:
                if ($emailExists) {
                    return back()->with('error', 'Email že obstaja');
                } else {
                    $register = $user->register($email, $password2);
                    if ($register) {
                        $adminEmail = env('ADMIN_EMAIL');
                        $allCars = $cars->getAll();
                        \Mail::to($email)->send(new NewUser($email));
                        \Mail::to($adminEmail)->send(new NewAccount($email));
                        return redirect('/login')->with('success', 'Registracija je uspela');
                    } else {
                        return back()->with('error', 'Račun ni potrjen');
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
            return back()->with('error', 'Email ne obstaja');
        }

        $approvedEmailExists = $user->loginApproved($email);

        if ($approvedEmailExists) {
            $token = $this->generateStringToken();
            $user->insertResetPasswordToken($token, $email);
            \Mail::to($email)->send(new NewPassword($token));
            return redirect('token')->with('success', 'Žeton je poslan na vaš email');
        } else {
            return back()->with('error', 'Račun ni potrjen');
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
                    return back()->with('error', 'Žeton je potekel');
                } else {
                    switch (true) {
                        case ($password1 != $password2):
                            return back()->with('error', 'Gesli se ne ujemata');
                            break;
                        case (strlen($password1) < 6):
                            return back()->with('error', 'Geslo je prekratko');
                            break;
                        default:
                            return redirect('/login')->with('success', 'Geslo je spremenjeno');
                    }
                }
            } else {
                return back()->with('error', 'Napačen žeton');
            }
        } else {
            return back()->with('error', 'Email ne obstaja');
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

    function deleteUser($id)
    {
        $adminEmail = env('ADMIN_EMAIL');
        $user = new User();
        $usersEmail = $user->getUsersEmail($id);
        $onlineUsers = $this->onlineUsers();

        if ($usersEmail != $adminEmail) {
            $delete = $user->deleteUser($id);
            $info = trans('messages.userIsRemoved');
        } else {
            $info = trans('messages.cannotDeleteAdmin');
        }

        $users = $user->getUsers();

        return view('users', [
            'users' => $users,
            'info' => $info,
            'onlineUsers' => $onlineUsers
        ]);
    }

    function lockUser($id)
    {
        $adminEmail = env('ADMIN_EMAIL');
        $user = new User();
        $usersEmail = $user->getUsersEmail($id);
        $onlineUsers = $this->onlineUsers();

        if ($usersEmail != $adminEmail) {
            $lock = $user->lockUser($id);
            $info = trans('messages.userIsLocked');
        } else {
            $info = trans('messages.cannotLockAdmin');
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
