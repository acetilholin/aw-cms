<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::where('silent', false)->get();
        $helper = new UserHelper();

        return view('users', [
            'users' => $users,
            'onlineUsers' => $helper->onlineUsers()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    public function lockUnlock(Request $request, $id)
    {
        $userEmail = User::where('id', $id)->pluck('email')->toArray();
        $currentUserEmail = $request->session()->get('email');

        if ($userEmail[0] === $currentUserEmail) {
            $info = trans('messages.selfUnlock');
        } else {
            $status = User::where('id', $id)->pluck('approved')->toArray();
            $status = (boolean) $status[0] === false;
            $info = $status === true ? trans('messages.userIsUnlocked') : trans('messages.userIsLocked');

            $user = User::where('id', $id)
                ->update([
                    'approved' => $status
                ]);
        }

        $users = User::where('silent', false)
            ->get();

        $helper = new UserHelper();

        return view('users', [
            'users' => $users,
            'info' => $info,
            'onlineUsers' => $helper->onlineUsers()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $userEmail = User::where('id', $id)->pluck('email')->toArray();
        $currentUserEmail = $request->session()->get('email');

        if ($userEmail[0] === $currentUserEmail) {
            $info = trans('messages.selfDelete');
        } else {
            User::where('id', $id)->delete();
            $info = trans('messages.userIsRemoved');
        }

        $helper = new UserHelper();
        $users = User::all();

        return view('users', [
            'users' => $users,
            'info' => $info,
            'onlineUsers' => $helper->onlineUsers()
        ]);
    }
}
