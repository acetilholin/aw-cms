<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\UserHelper;
use App\User;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\NewUser;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    /**
     * Register user
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function register(Request $request)
    {
        $helper = new UserHelper();

        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|unique:users|max:60',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'

        ], $helper->messages());

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        $email = $request->input('email');

        $user->notify(new NewUser($email));
        return redirect('/login')->with('success', trans('messages.registrationSuccessful'));
    }
}
