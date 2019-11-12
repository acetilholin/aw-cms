<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    function login($email, $password)
    {
        $passwordMatch = $this->checkPasswordMatch($email, $password);
        return $passwordMatch;
    }

    function checkPasswordMatch($email, $password)
    {
        $sql = DB::select("SELECT password FROM users WHERE email ='" . $email . "'");
        $hashedPassword = $sql[0]->password;
        if (Hash::check($password, $hashedPassword)) {
            return true;
        } else {
            return false;
        }
    }

    function loginApproved($email)
    {
        $sql = DB::select("SELECT count(*) as cnt FROM users WHERE email ='" . $email . "' AND approved = 1");
        return $sql[0]->cnt > '0' ? true : false;
    }

    function emailExists($email)
    {
        $sql = DB::select("SELECT count(*) as cnt FROM users WHERE email ='" . $email . "'");
        return $sql[0]->cnt > '0' ? true : false;
    }

    function getUsersEmail($id)
    {
        $sql = DB::select("SELECT email FROM users WHERE id ='" . $id . "'");
        return $sql[0]->email;
    }

    function getUserName($email)
    {
        $sql = DB::select("SELECT name FROM users WHERE email ='" . $email . "'");
        return $sql[0]->name;
    }

    function countryByIP()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $country = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        return $country->geoplugin_countryCode;
    }

    function checkTokenMatch($email, $loginToken)
    {
        if (!$this->emailExists($email)) {
            return false;
        }
        $sql = DB::select("SELECT login_token FROM users WHERE email ='" . $email . "'");
        return $sql[0]->login_token == $loginToken ? true : false;
    }

    function allUserIds()
    {
        $i = 0;
        $sql = DB::select("SELECT id FROM users");
        foreach ($sql as $result) {
            $all[$i] = $result->id;
            $i++;
        }
        return $all;
    }

    function register($email, $name, $password)
    {
        $hashedPassword = Hash::make($password);
        $dateTime = Carbon::now("Europe/Ljubljana");
        $country = $this->countryByIP() == null ? 'SI' : $this->countryByIP();

        $values = array(
            'email' => $email,
            'name' => $name,
            'password' => $hashedPassword,
            'approved' => false,
            'last_seen' => $dateTime,
            'country' => $country
        );
        return $result = DB::table('users')->insert($values);
    }

    function insertLoginToken($token, $email)
    {
        $update = DB::table('users')
            ->where('email', $email)
            ->update([
                'login_token' => $token
            ]);
        return $update;
    }

    function insertResetPasswordToken($token, $email)
    {
        $timeNow = date('Y-m-d H:i');
        $update = DB::table('users')
            ->where('email', $email)
            ->update([
                'reset_token' => $token,
                'token_time' => $timeNow
            ]);
        return true;
    }

    function lockUser($id)
    {
        $update = DB::table('users')
            ->where('id', $id)
            ->update([
                'approved' => '0'
            ]);
        return true;
    }

    function unLockUser($id)
    {
        $update = DB::table('users')
            ->where('id', $id)
            ->update([
                'approved' => '1'
            ]);
        return true;
    }

    function lastSeen($email, $dateTime)
    {
        $country = $this->countryByIP() == null ? 'SI' : $this->countryByIP();
        $update = DB::table('users')
            ->where('email', $email)
            ->update([
                'last_seen' => $dateTime,
                'country' => $country
            ]);
    }

    function emailAndTokenMatch($email, $token)
    {
        $sql = DB::select("SELECT count(*) as cnt FROM users where reset_token ='" . $token . "' AND email ='" . $email . "'");
        if (empty($sql)) {
            return null;
        } else {
            return $response = ($sql[0]->cnt > 0) ? true : false;
        }
    }

    function getTokenCreationTime($token, $email)
    {
        $sql = DB::select("SELECT token_time as time FROM users where email = '" . $email . "' and reset_token ='" . $token . "'");
        return $sql[0]->time;
    }

    function getUsers()
    {
        $sql = DB::select("SELECT * FROM users");
        return $sql;
    }

    function deleteUser($id)
    {
        $request = DB::table('users')->where('id', $id)->delete();
        return $request;
    }
}
