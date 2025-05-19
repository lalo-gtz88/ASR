<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationTickets extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $tipo;
    public $creator;
    public $asignado;
    public $header;
    public $descripcion;
    public $prioridad;
    public $cambios;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tipo,$user,$creator,$asignado,$header,$descripcion,$prioridad,$cambios)
    {
        $this->user= $user;
        $this->tipo = $tipo;
        $this->creator = $creator;
        $this->asignado = $asignado;
        $this->header = $header;
        $this->descripcion = $descripcion;
        $this->prioridad = $prioridad;
        $this->cambios = $cambios;
        
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('asr@website', 'Notificacion de tickets'),
            subject: 'Notificación de Tickets',

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
            view: 'emails.notificationTicket',
            // with:[
            //     'user' => $this->asignado,
            //     'creator'=> $this->creator,
            //     'header'=>$this->header
            // ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
