<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendTicket extends Mailable
{
    use Queueable, SerializesModels;

    public $datos;
    public $archivos = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datos, $archivos = [])
    {
        $this->datos = $datos;
        $this->archivos = $archivos;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Ticket ' . $this->datos['id'],
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.ticket',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        if (count($this->archivos)) {
            $adjuntos = [];
            for ($i = 0; $i < count($this->archivos); $i++) {

                $adjuntos[$i] = Attachment::fromPath($this->archivos[$i]);
            }

            return $adjuntos;
        }
    }
}
