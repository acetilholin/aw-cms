<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $fullname;
    public $msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $fullname, $message)
    {
        $this->email = $email;
        $this->fullname = $fullname;
        $this->msg = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $timeNow = date('Y-m-d H:i');
        return $this->view('emails.contact', [
            'email' => $this->email,
            'fullname' => $this->fullname,
            'msg' => $this->msg,
            'datetime' => $timeNow
        ]);
    }
}
