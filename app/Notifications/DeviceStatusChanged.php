<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Notifications\Notification;

class DeviceStatusChanged extends Notification
{

    public $device;
    public $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($device, $status)
    {
        $this->device = $device;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Host '. $this->status)
                    ->line('El dispositivo '.$this->device->direccion_ip . 'esta '. $this->status)
                    ->line('Favor de verificar!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
