<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CamperInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->replyTo($this->data['email'], $this->data['fullname'])
            ->subject('Najem kamperja - povpraševanje')
            ->markdown('emails.camper-inquiry', [
                'data' => $this->data
            ]);
    }
}
