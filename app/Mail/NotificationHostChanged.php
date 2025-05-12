<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationHostChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $device;
    public $status;
    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct($device, $status)
    {
        $this->device = $device;
        $this->status = $status;

        $this->subject = ($status == 'offline')? "🚨 [ALERTA] " : "✅ [OK] "; 
        $this->subject .= $this->device->direccion_ip .'-'. $this->device->relDispositivo->relTipoEquipo->nombre;
        
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notificationHostChanged',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
