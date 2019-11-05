<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    function sendContactEmail(Request $request)
    {
        $email = $request->input('email');
        $fullname = $request->input('fullname');
        $message = $request->input('message');

        $recipient1 = env('RECIPIENT1');
        $recipient2 = env('RECIPIENT2');

        \Mail::to($recipient1, $recipient2)->send(new Contact($email, $fullname, $message));

        return [
            'resp' => 'Sporočilo je bilo poslano'
        ];
    }

    function sendContactEmailEnglish(Request $request)
    {
        $email = $request->input('email');
        $fullname = $request->input('fullname');
        $message = $request->input('message');

        $recipient1 = env('RECIPIENT1');
        $recipient2 = env('RECIPIENT2');

        \Mail::to($recipient1)->send(new Contact($email, $fullname, $message));
        \Mail::to($recipient2)->send(new Contact($email, $fullname, $message));

        return [
            'resp' => 'Message sent'
        ];
    }
}
