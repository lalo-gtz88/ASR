<?php

namespace App\Livewire;

use App\Events\CambiosTicket;
use App\Listeners\RegistrarCambiosTicket;
use App\Models\Seguimiento;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ComentariosTicket extends Component
{

    use WithFileUploads;

    #[Reactive]
    public $ticketID;
    public $ticket;
    public $ticketNew;
    public $tema;
    public $descripcion;
    public $mensaje = '';
    public $attachments = [];

    protected $listeners = ['ticket-actualizado' => 'ticketActualizado'];

    public function render()
    {
        $this->ticket = $this->obtenerDatos();
        $this->tema = $this->ticket->tema;
        $this->descripcion = strip_tags($this->ticket->descripcion);
        return view('livewire.comentarios-ticket');
    }

    function obtenerDatos()
    {

        return Ticket::find($this->ticketID);
    }

    function guardar($status = null)
    {        

        //guardamos el comentario
        $this->guardarComentario();
        
        //actualizamos el status del ticket 
        $this->guardarStatus($status);

        //guardamos archivos adjuntos
        $this->guardarAdjuntos();

        //enviamos eventos para hacer el scroll hacia abajo al ultimo comentario
        $this->dispatch('setScroll');

        //limpiamos la caja de summernote
        $this->dispatch('limpiarSummerNote');
    }


    function guardarComentario()
    {

        if ($this->mensaje == "" ) {

            return;
        }

        $seguimiento = new Seguimiento();
        $seguimiento->notas = $this->mensaje;
        $seguimiento->ticket = $this->ticketID;
        $seguimiento->usuario = Auth::user()->id;
        $seguimiento->print = 1;
        $seguimiento->save();
        $this->reset('mensaje');
        $this->dispatch('limpiarMensaje');
    }

    function guardarStatus($status = null)
    {

        if ($status) {

            $this->ticketNew = $this->obtenerDatos();
            $this->ticketNew->status = $status;
            $this->ticketNew->save();
            if ($this->ticket->status != $this->ticketNew->status) {

                $this->dispatch('alerta', type:"success", msg: "Status ha cambiado a " . $this->ticketNew->status);

                //enviamos evento para registrar cambios
                CambiosTicket::dispatch($this->ticket, $this->ticketNew);
            }
        }
    }

    function guardarAdjuntos()
    {

        if (count($this->attachments) > 0) {

            $this->validate([
                'attachments.*' => 'mimes:jpg,pdf'
            ]);

            foreach ($this->attachments as $item) {

                if ($item != null) {

                    $filename = $item->store('public/documents');
                    $basename = explode('/', $filename)[2];
                    $path = asset('storage/documents') . '/' . $basename;

                    $seguimiento = new Seguimiento;
                    $seguimiento->notas = "<a href=\"{$path}\" target='_blank'><img src=\"{$path}\" class='imgAttachment' alt='archivo adjunto' /></a><span class='deleteAttachment' title='Eliminar'><i class='fa fa-times-circle text-danger'></i></span>";
                    $seguimiento->ticket = $this->ticketID;
                    $seguimiento->file = $basename;
                    $seguimiento->usuario = Auth::user()->id;
                    $seguimiento->save();
                }
            }
        }

        //reseteamos los attachments
        $this->reset('attachments');
    }

    function deleteAttachment($index)
    {

        unset($this->attachments[$index]);
    }

    #[On('borrarArchivo')]
    function borrarComentarioArchivo($id)
    {

        $s = Seguimiento::find($id);
        //borramos el archivo 
        Storage::delete("public/documents/{$s->file}");

        //borramos el comentario de la base de datos
        $s->delete();
    }

    function actualizarTema()  {
        
        $this->ticket->tema = $this->tema;
        $this->ticket->save();
        $this->dispatch('alerta', type:"success", msg: "Cambios guardados!");

    }

    function actualizarDescripcion() {
        
        $this->ticket->descripcion = $this->descripcion;
        $this->ticket->save();
        $this->dispatch('alerta', type:"success", msg: "Cambios guardados!");

    }

    function cancelEditarDesc() {
        $this->reset('descripcion');
        $this->dispatch('cancelEditarDesc');
    }

    function ticketActualizado() {
        $this->dispatch('$refresh');
        $this->dispatch('setScroll');
    }
}
