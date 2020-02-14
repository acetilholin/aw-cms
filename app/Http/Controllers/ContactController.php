<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Mail\Povprasevanje;
use Illuminate\Http\Request;
use App\User;

class ContactController extends Controller
{
    function sendContactEmail(Request $request)   /* TODO add server validation */
    {
        $email = $request->input('email');
        $fullname = $request->input('fullname');
        $message = $request->input('message');

        $user = new User();
        $geoData = $user->geoData();

        $recipient1 = env('RECIPIENT1');
        $recipient2 = env('RECIPIENT2');
        $admin = env('ADMIN_EMAIL');

        \Mail::to($recipient1, $recipient2, $admin)->send(new Contact($email, $fullname, $message, $geoData['country'], $geoData['city']));

        return [
            'resp' => 'Sporočilo je bilo poslano'
        ];
    }

    function sendContactEmailEnglish(Request $request) /* TODO add server validation */
    {
        $email = $request->input('email');
        $fullname = $request->input('fullname');
        $message = $request->input('message');

        $user = new User();
        $geoData = $user->geoData();

        $recipient1 = env('RECIPIENT1');
        $recipient2 = env('RECIPIENT2');
        $admin = env('ADMIN_EMAIL');

        \Mail::to($recipient1, $recipient2, $admin)->send(new Contact($email, $fullname, $message, $geoData['country'], $geoData['city']));

        return [
            'resp' => 'Message sent'
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

        \Mail::to($recipient1, $recipient2, $admin)->send(new Povprasevanje($data, $email));

        return [
            'resp' => 'Povpraševanje je poslano'
        ];
    }
}
