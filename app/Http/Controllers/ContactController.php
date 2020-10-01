<?php

namespace App\Http\Controllers;

use App\Helpers\ContactHelper;
use App\Helpers\UserHelper;
use App\Mail\Povprasevanje;
use App\Notifications\ContactNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    function sendContactEmail(Request $request)
    {
        $contactHelper = new ContactHelper();
        if (url()->current() === env('APP_URL').'/en') {
            $messages = $contactHelper->messagesEN();
            $response = trans('messages.sent');
        } else {
            $messages = $contactHelper->messagesSI();
            $response = trans('messages.poslano');
        }

        $email = $request->input('email');
        $fullname = $request->input('fullname');
        $message = $request->input('message');

        $userHelper = new UserHelper();

        $validatedData = $request->validate([
            'email' => 'required',
            'fullname' => 'required|min:5',
            'message' => 'required|min:29'

        ], $messages);

        $geoData = $userHelper->geoData();

        $recipient1 = env('RECIPIENT1');
        $recipient2 = env('RECIPIENT2');
        $admin = env('ADMIN_EMAIL');

        $user = User::where('email', $admin)->first();

        $user->notify(new ContactNotification($email, $fullname, $message, $recipient1, $recipient2,
            $geoData['country'], $geoData['city']));

        return [
            'resp' => $response,
            'loading' => false
        ];
    }

    function inquiry(Request $request)
    {
        $email = $request->input('email');
        $data = [
            'znamka' => $request->input('znamka'),
            'oprema' => $request->input('oprema'),
            'sedezi' => $request->input('sedezi'),
            'vrata' => $request->input('vrata'),
            'karoserija' => $request->input('karoserija'),
            'letaMin' => $request->input('letaMin'),
            'letaMax' => $request->input('letaMax'),
            'kilometri' => $request->input('kilometri'),
            'barva' => $request->input('barva'),
            'menjalnik' => $request->input('menjalnik'),
            'moc' => $request->input('moc'),
            'gorivo' => $request->input('gorivo'),
            'imePriimek' => $request->input('imePriimek'),
            'email' => $email,
            'cena' => $request->input('cena'),
            'telefon' => $request->input('telefon'),
            'notranja1' => $request->input('notranja1') == 'true' ? trans('inquiry.notranja1') : null,
            'notranja2' => $request->input('notranja2') == 'true' ? trans('inquiry.notranja2') : null,
            'notranja3' => $request->input('notranja3') == 'true' ? trans('inquiry.notranja3') : null,
            'notranja4' => $request->input('notranja4') == 'true' ? trans('inquiry.notranja4') : null,
            'notranja5' => $request->input('notranja5') == 'true' ? trans('inquiry.notranja5') : null,
            'notranja6' => $request->input('notranja6') == 'true' ? trans('inquiry.notranja6') : null,
            'notranja7' => $request->input('notranja7') == 'true' ? trans('inquiry.notranja7') : null,
            'varnost1' => $request->input('varnost1') == 'true' ? trans('inquiry.varnost1') : null,
            'varnost2' => $request->input('varnost2') == 'true' ? trans('inquiry.varnost2') : null,
            'varnost3' => $request->input('varnost3') == 'true' ? trans('inquiry.varnost3') : null,
            'varnost4' => $request->input('varnost4') == 'true' ? trans('inquiry.varnost4') : null,
            'varnost5' => $request->input('varnost5') == 'true' ? trans('inquiry.varnost5') : null,
            'varnost6' => $request->input('varnost6') == 'true' ? trans('inquiry.varnost6') : null,
            'pomoc1' => $request->input('pomoc1') == 'true' ? trans('inquiry.pomoc1') : null,
            'pomoc2' => $request->input('pomoc2') == 'true' ? trans('inquiry.pomoc2') : null,
            'pomoc3' => $request->input('pomoc3') == 'true' ? trans('inquiry.pomoc3') : null,
            'klima1' => $request->input('klima1') == 'true' ? trans('inquiry.klima1') : null,
            'klima2' => $request->input('klima2') == 'true' ? trans('inquiry.klima2') : null,
            'ostalo1' => $request->input('ostalo1') == 'true' ? trans('inquiry.ostalo1') : null,
            'ostalo2' => $request->input('ostalo2') == 'true' ? trans('inquiry.ostalo2') : null,
        ];

        $recipient1 = env('RECIPIENT1');
        $recipient2 = env('RECIPIENT2');
        $admin = env('ADMIN_EMAIL');

        Mail::to($recipient1)
            ->cc($recipient2)
            ->bcc($admin)
            ->send(new Povprasevanje($data, $email));

        return [
            'resp' => trans('messages.poslano'),
            'loading' => false
        ];
    }
}
