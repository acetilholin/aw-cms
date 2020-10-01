<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class ContactNotification extends Notification
{
    use Queueable;

    public $email, $fullname, $message, $rcp1, $rcp2, $country, $city;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email, $fullname, $message, $rcp1, $rcp2, $country, $city)
    {
        $this->email = $email;
        $this->fullname = $fullname;
        $this->message = $message;
        $this->rcp1 = $rcp1;
        $this->rcp2 = $rcp2;
        $this->country = $country;
        $this->city = $city;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $timestamp = date('H:i d-m-Y');
        return (new MailMessage)
            ->from($this->email)
            ->subject('Novo sporočilo')
            ->line('Prejeli ste novo sporočilo:')
            ->cc($this->rcp1)
            ->cc($this->rcp2)
            ->line(new HtmlString('<b>Email: </b>'.$this->email))
            ->line(new HtmlString('<b>Pošiljatelj: </b>'.$this->fullname))
            ->line(new HtmlString('<b>Država: </b>'.$this->country))
            ->line(new HtmlString('<b>Mesto: </b>'.$this->city))
            ->line(new HtmlString('<b>Čas: </b>'.$timestamp))
            ->line(new HtmlString('<br><br><div class="text-red">Sporočilo: </div>'))
            ->line($this->message);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
