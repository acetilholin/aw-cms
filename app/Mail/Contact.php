<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $fullname;
    public $msg;
    public $country;
    public $city;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $fullname, $message, $country, $city)
    {
        $this->email = $email;
        $this->fullname = $fullname;
        $this->msg = $message;
        $this->city = $city;
        $this->country = $country;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $timeNow = date('Y-m-d H:i');

        return $this->from($this->email)
            ->view('emails.contact', [
                'email' => $this->email,
                'fullname' => $this->fullname,
                'msg' => $this->msg,
                'datetime' => $timeNow,
                'city' => $this->city,
                'country' => $this->country
            ]);
    }
}
