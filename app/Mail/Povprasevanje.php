<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Povprasevanje extends Mailable
{
    use Queueable, SerializesModels;

    public $data, $email, $recipient1, $recipient2;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $email)
    {
        $this->data = $data;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email)
            ->subject('Povpraševanje')
            ->view('emails.inquiry', [
                'data' => $this->data
            ]);
    }
}
