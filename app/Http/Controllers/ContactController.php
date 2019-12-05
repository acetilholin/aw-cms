<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use App\User;

class ContactController extends Controller
{
    function sendContactEmail(Request $request)
    {
        $email = $request->input('email');
        $fullname = $request->input('fullname');
        $message = $request->input('message');

        $user = new User();
        $geoData = $user->geoData();

        $recipient1 = env('RECIPIENT1');
        $recipient2 = env('RECIPIENT2');
        $recipient3 = env('ADMIN_EMAIL');

        \Mail::to($recipient1, $recipient2, $recipient3)->send(new Contact($email, $fullname, $message, $geoData['country'], $geoData['city']));

        return [
            'resp' => 'Sporočilo je bilo poslano'
        ];
    }

    function sendContactEmailEnglish(Request $request)
    {
        $email = $request->input('email');
        $fullname = $request->input('fullname');
        $message = $request->input('message');

        $user = new User();
        $geoData = $user->geoData();

        $recipient1 = env('RECIPIENT1');
        $recipient2 = env('RECIPIENT2');
        $recipient3 = env('ADMIN_EMAIL');

        \Mail::to($recipient1, $recipient2, $recipient3)->send(new Contact($email, $fullname, $message, $geoData['country'], $geoData['city']));

        return [
            'resp' => 'Message sent'
        ];
    }
}
