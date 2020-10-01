<?php


namespace App\Helpers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserHelper
{
    public function createLoginCookie($email)
    {
        $cookieName = 'AVLogin';
        $token = Hash::make(Str::random(10));
        $data = [
            'email' => $email,
            'token' => $token
        ];

        $user = User::where('email', $email)
            ->update(['login_token' => $token]);

        setcookie($cookieName, json_encode($data), time() + 86400 * 365);
    }

    public function lastSeen($email, $dateTime)
    {
        $country = $this->geoData();
        $country = $country['code'] == null ? 'SI' : $country['code'];
        $update = DB::table('users')
            ->where('email', $email)
            ->update([
                'last_seen' => $dateTime,
                'country' => $country
            ]);
    }

    public function geoData()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $data = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
        return $geoData = [
            'code' => $data->geoplugin_countryCode,
            'country' => $data->geoplugin_countryName,
            'city' => $data->geoplugin_city
        ];
    }

    public function insertResetPasswordToken($token, $email)
    {
        $timeNow = date('Y-m-d H:i');
        User::where('email', $email)->update([
            'reset_token' => $token,
            'token_time' => $timeNow
        ]);
    }

    public function emailAndTokenMatch($email, $token)
    {
        $match = User::where('email', $email)
            ->where('reset_token', $token)
            ->first();
        return $match !== null;
    }

    public function authenticate($email, $password)
    {
        Auth::attempt(['email' => $email, 'password' => $password]);
    }

    public function checkTokenExpirationTime($token, $email)
    {
        $tokenCreationTime = User::where('email', $email)
            ->where('reset_token', $token)
            ->get();

        $tokenTime = $tokenCreationTime->pluck('token_time')->toArray();
        $timeNow = date('Y-m-d H:i');

        $datetime1 = strtotime($tokenTime[0]);
        $datetime2 = strtotime($timeNow);
        $minutes = ($datetime2 - $datetime1) / 60;

        return $minutes < 60 ? false : true;
    }

    public function allUserIds()
    {
        $ids = [];
        $users = User::where('silent', 0)->get();

        foreach ($users as $user) {
            $userData = $user->getAttributes();
            $ids[] = $userData['id'];
        }
        return $ids;
    }

    public function onlineUsers()
    {
        $allUserIds = $this->allUserIds();
        for ($i = 0; $i < sizeof($allUserIds); $i++) {
            if (Cache::has('user-is-online-'.$allUserIds[$i]) == true) {
                $userStatus[$i] = 'online';
            } else {
                $userStatus[$i] = 'offline';
            }
        }
        return $userStatus;
    }

    public function messages()
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
}
