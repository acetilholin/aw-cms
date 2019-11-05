<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
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

    function register($email, $password)
    {
        $hashedPassword = Hash::make($password);

        $values = array(
            'email' => $email,
            'password' => $hashedPassword,
            'approved' => false
        );
        return $result = DB::table('users')->insert($values);
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
}
