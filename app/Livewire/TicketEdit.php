<?php

namespace App\Livewire;

use App\Mail\SendTicket;
use Livewire\Component;
use App\Models\Ticket;
use App\Models\Seguimiento;
use App\Models\User;
use App\Models\Categoria;
use App\Models\departamento;
use App\Models\edificio;
use App\Models\Plantilla;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Livewire\WithFileUploads;
use Symfony\Component\Mailer\Exception\TransportException;

class TicketEdit extends Component
{
    use WithFileUploads;


    public $ticket;
    public $ticketEdit = "";

    public $usuarios = [];
    public $prioridad = "Media";
    public $categorias = [];

    public $descripcion = "";
    public $quien_reporta = "";
    public $tema = "";
    public $telefono = "";
    public $edificio = "";
    public $departamento = "";
    public $ip = "";
    public $usuario_red = "";
    public $creador = "";
    public $asignado = "";
    public $nombre_asignado;
    public $fotoAsignado = "";
    public $categoria = "";
    public $autoriza = "";
    public $fecha_de_atencion;
    public $status = "Abierto";
    public $archivoAdjunto = [];

    public $seguimientos = [];
    public $message = "";

    public $comentarios_print = "";
    public $readyToLoad = false;

    public $colorPrio;
    public $para;
    public $cc;
    public $mensaje;
    public $photoShow;

    public $nombreDePlantilla;
    public $descripcionDePlantilla;
    public $plantilla;
    public $unidadSiNo = false;
    public $unidad;

    public $backUrl;

    protected $listeners = ['delAttachment', 'update', 'delete'];

    public function mount()
    {

        //guardamos la URL anterior 
        $this->backUrl = URL::previous();

        //Get datos de ticket
        $this->ticketEdit = Ticket::leftJoin('users as asignados', 'asignados.id', 'tickets.asignado')
            ->leftJoin('users as creadores', 'creadores.id', 'tickets.creador')
            ->select(DB::raw("tickets.*,
            CONCAT_WS(' ',creadores.name,creadores.lastname) as creadorName"))->where('tickets.id', $this->ticket)
            ->first();

        //Setear datos
        $this->tema = $this->ticketEdit->tema;
        $this->descripcion = $this->ticketEdit->descripcion;
        $this->quien_reporta = $this->ticketEdit->reporta;
        $this->telefono = $this->ticketEdit->telefono;
        $this->edificio = $this->ticketEdit->edificio;
        $this->departamento = $this->ticketEdit->departamento;
        $this->usuario_red = $this->ticketEdit->usuario_red;
        $this->ip = $this->ticketEdit->ip;
        $this->edificio = $this->ticketEdit->edificio;
        $this->autoriza = $this->ticketEdit->autoriza;
        $this->categoria = $this->ticketEdit->categoria;
        $this->asignado = $this->ticketEdit->asignado;
        $this->unidad = $this->ticketEdit->unidad;
        $this->prioridad = $this->ticketEdit->prioridad;
        $this->status = $this->ticketEdit->status;
        $this->fecha_de_atencion = $this->ticketEdit->fecha_atencion;
        $this->creador = $this->ticketEdit->creadorName;
        $this->comentarios_print = $this->ticketEdit->comentarios_print;
        $this->renderPriority();

        $us = User::find($this->asignado);
        $this->fotoAsignado = ($us != null) ? $us->photo : null;
        $this->nombre_asignado = ($us != null) ? $us->name . ' ' . $us->lastname : null;
        $this->dispatchBrowserEvent('scrollingBottom');
    }

    public function render()
    {
        //Carga de selects
        $this->usuarios = User::where('activo', 1)->orderBy('name')->get();
        $this->categorias = Categoria::where('active', 1)->orderBy('name')->get();
        $departamentos = departamento::where('active', 1)->orderBy('nombre')->get();
        $edificios = edificio::where('active', 1)->orderBy('nombre')->get();

        $us = User::find($this->asignado);
        $this->fotoAsignado = ($us != null) ? $us->photo : null;
        $this->nombre_asignado = ($us != null) ? $us->name . ' ' . $us->lastname : null;

        //Renderizamos los seguimientos para que cada que ingresmos uno nuevo se muestre al momento
        $this->seguimientos = Seguimiento::leftJoin('users', 'users.id', 'seguimientos.usuario')
            ->select(DB::raw('seguimientos.*, 
                        users.name as nombre_usuario, users.lastname as apellido_usuario, users.photo'))
            ->where('ticket', $this->ticket)
            ->get();

        $plantillas = Plantilla::where('usuario', Auth::user()->id)->get();

        //Renderizamos el estado del ticket para que cambie cada vez que yo efectue un cambio 
        $this->status = $this->ticketEdit->status;
        //Renderizamos el color de la propiedad
        $this->renderPriority();

        return view('livewire.ticket-edit', compact('departamentos', 'edificios', 'plantillas'));
    }


    public function renderPriority()
    {
        switch ($this->prioridad) {
            case 'Media':
                $this->colorPrio = "alert-warning";
                break;
            case 'Baja':
                $this->colorPrio = "alert-success";
                break;
            case 'Alta':
                $this->colorPrio = "alert-danger";
                break;
        }
    }

    public function update()
    {
        //para validar si se ha cambiado la persona asignada
        $enviarNotificaciones = ($this->ticketEdit->asignado != $this->asignado) ? true : false;

        $this->ticketEdit->tema = $this->tema;
        $this->ticketEdit->reporta = $this->quien_reporta;
        $this->ticketEdit->telefono = $this->telefono;
        $this->ticketEdit->edificio = $this->edificio;
        $this->ticketEdit->departamento = $this->departamento;
        $this->ticketEdit->usuario_red = $this->usuario_red;
        $this->ticketEdit->ip = $this->ip;
        $this->ticketEdit->edificio = $this->edificio;
        $this->ticketEdit->autoriza = $this->autoriza;
        $this->ticketEdit->categoria = $this->categoria;
        $this->ticketEdit->asignado = ($this->asignado != "") ? $this->asignado : 0;
        $this->ticketEdit->prioridad = $this->prioridad;
        $this->ticketEdit->fecha_atencion = ($this->fecha_de_atencion == "") ? null : $this->fecha_de_atencion;
        $this->ticketEdit->usuario = Auth::user()->id;
        $this->ticketEdit->comentarios_print = $this->comentarios_print;
        $this->ticketEdit->unidad = $this->unidad;
        $this->ticketEdit->save();

        $ticket = $this->ticketEdit;

        //validamos que se halla cambiado la asignacion del ticket
                if ($enviarNotificaciones) {

                    // creamos un archivo de texto plano para enviar el mail
                    $archivo = fopen('C:\ASR\public\body.txt', 'w+');
                    $tema = "Ticket_#_$ticket->id_" . mb_strtoupper($ticket->tema);
                    //agregamos el contenido
                    $contenido = "Se te ha asignado un ticket con prioridad $ticket->prioridad, por " . Auth::user()->name . ' ' . Auth::user()->lastname . " 

        DETALLES:
        $ticket->descripcion";
                    //colocamos el contenido en el archivo
                    fputs($archivo, $contenido);
                    //cerramos el documento
                    fclose($archivo);

                    $asignado =  User::find($ticket->asignado);
                    echo exec("START C:\ASR\public\sendMail.bat $asignado->email $tema");

                    //enviamos notificacion por telegram en caso de que tenga registrado el chat_id
                    if ($asignado->telegram != null) {

                        $contenido = "[ TICKET $ticket->id .-" . mb_strtoupper($ticket->tema) . " ]\n Se te ha asignado un ticket con prioridad $ticket->prioridad por " . Auth::user()->name . ' ' . Auth::user()->lastname . ", favor de atender\n\nDETALLES:\n$ticket->descripcion \n\nATRIBUTOS:\nPrioridad: $ticket->prioridad \nAsignado: $asignado->name" . " " . $asignado->lastname . "\nCreador: " . Auth::user()->name . ' ' . Auth::user()->lastname;

                        $this->sendTelegram($asignado->telegram, $contenido);
                    }



                    //despues mandamos email a todos los usuarios que tienen activada la opcion de 
                    //recibir notificaciones de todos los tickets

                    $usersSend = User::permission('Recibir notificación de todos los tickets')->get();

                    //comprobamos que existan usuarios con esta opcion habilitada
                    if (count($usersSend) > 0) {

                        $asignadoToAll = null;
                        $as = User::find($ticket->asignado);
                        $nombreDelAsignado = $as->name . " " . $as->lastname;



                        $creador = Auth::user()->name . ' ' . Auth::user()->lastname;
                        // creamos un archivo de texto plano para enviar el mail
                        $archivo = fopen('C:\ASR\public\body.txt', 'w+');
                        $tema = "Ticket_#_$ticket->id-" . mb_strtoupper($ticket->tema);
                        //agregamos el contenido
                        $contenido = "Se ha asignado el ticket No. $ticket->id a $nombreDelAsignado
        DETALLES:
        $ticket->descripcion

        ATRIBUTOS:
        Prioridad: $ticket->prioridad
        Asignado: $nombreDelAsignado
        Creador: $creador";

                        //colocamos el contenido en el archivo
                        fputs($archivo, $contenido);
                        //cerramos el documento
                        fclose($archivo);

                        foreach ($usersSend as $item) {
                            //comprobamos que email de la persona asignada no sea el mismo para no enviar
                            //doble el correo
                            if ($item->email != $as->email) {
                                //mandamos el correo
                                echo exec("START C:\ASR\public\sendMail.bat $item->email $tema");
                            }
                        }

                        foreach ($usersSend as $item) {
                            //comprobamos que tengan registrado el chat_id y que no este repetido el correo
                            if ($item->telegram != null && $item->telegram != $as->telegram) {

                                $contenido = "[TICKET $ticket->id .-" . mb_strtoupper($ticket->tema) . "] se ha asignado a $nombreDelAsignado por " . Auth::user()->name . ' ' . Auth::user()->lastname . "\n\nATRIBUTOS:\nPrioridad: $ticket->prioridad por " . Auth::user()->name . ' ' . Auth::user()->lastname . "\nAsignado: $nombreDelAsignado \nCreador: $creador";
                                //enviamos notificacion por telegram
                                $this->sendTelegram($item->telegram, $contenido);
                            }
                        }
                    }
                }


        $this->dispatchBrowserEvent('alerta', ['msg' => 'Cambios guardados!!']);
        $this->dispatchBrowserEvent('scrollingBottom');
    }

    public function storeNotas()
    {
        if (strip_tags($this->message) != "" || $this->archivoAdjunto) {


            $this->validate([
                'archivoAdjunto.*' => 'mimes:jpg,pdf|nullable'
            ]);

            if ($this->message) {

                $seguimiento = new Seguimiento;
                $seguimiento->notas = $this->message;
                $seguimiento->ticket = $this->ticket;
                $seguimiento->usuario = Auth::user()->id;
                $seguimiento->print = 1;
                $seguimiento->save();

                $this->ticketEdit->last_coment = $this->message;
                $this->ticketEdit->user_coment = Auth::user()->name .' '.Auth::user()->lastname;
                $this->ticketEdit->date_coment = now();
                $this->ticketEdit->save();
            }

            if (count($this->archivoAdjunto) > 0) {

                foreach ($this->archivoAdjunto as $item) {

                    if ($item != null) {

                        $filename = $item->store('public/documents');
                        $seguimiento = new Seguimiento;
                        $seguimiento->notas = 'Archivo adjunto';
                        $seguimiento->ticket = $this->ticket;
                        $seguimiento->file = explode('/', $filename)[2];
                        $seguimiento->usuario = Auth::user()->id;
                        $seguimiento->save();
                    }
                }
            }

            $this->message = "";
            $this->archivoAdjunto = [];
            $this->dispatchBrowserEvent('scrollingBottom');
        }
    }

    public function saveStatus($stat)
    {
        $this->ticketEdit->status = $stat;
        $this->ticketEdit->usuario = Auth::user()->id;
        $this->ticketEdit->save();
        $this->dispatchBrowserEvent('alerta', ['msg' => 'El ticket cambio a ' . $this->ticketEdit->status]);
        $this->dispatchBrowserEvent('scrollingBottom');
    }

    public function clearAtt($index)
    {
        $this->archivoAdjunto[$index] = null;
    }

    public function verDocumento()
    {

        return redirect(route('ticketDocument', $this->ticket));
    }

    public function closeAndSend($status)
    {
        if($this->message){
            $this->storeNotas();
        }

        $this->saveStatus($status);
    }

    public function sendTelegram($destino, $msg)
    {
        $this->dispatchBrowserEvent('sendTelegram', ['destino' => $destino, 'mensaje' => $msg]);
    }

    public function delAttachment($id, $file)
    {

        if ($id != null && $file != null) {
            $sDel = Seguimiento::find($id);
            $sDel->delete();

            unlink(storage_path('app/public/documents/') . $file);
            $this->dispatchBrowserEvent('deletedAtt');
        }
    }

    public function sendByMail()
    {

        try {

            $this->validate([
                'para' => 'required'
            ]);

            $datos = [

                'id' => $this->ticketEdit->id,
                'tema' => $this->ticketEdit->tema,
                'usuario' => $this->ticketEdit->reporta,
                'telefono' => $this->ticketEdit->telefono,
                'edificio' => $this->ticketEdit->edificio,
                'departamento' => $this->ticketEdit->departamento,
                'ip' => $this->ticketEdit->ip,
                'usuario_red' => $this->ticketEdit->usuario_red,
                'autoriza' => $this->ticketEdit->autoriza,
                'categoria' => $this->ticketEdit->categoria,
                'seguimientos' => $this->seguimientos,
                'mensaje' => $this->mensaje
            ];

            $seguimientos =  Seguimiento::where('ticket', $this->ticketEdit->id)
                ->whereNotNull('file')
                ->get();

            $archivos = [];
            foreach ($seguimientos as $item) {

                array_push($archivos, public_path('storage/documents/') . $item->file);
            }

            $destinatarios = explode(',', $this->para);

            foreach ($destinatarios as $dest) {

                Mail::to(trim($dest))->send(new SendTicket($datos, $archivos));
            }

            $this->reset('para','mensaje');
            
            $this->dispatchBrowserEvent('alerta', ['msg' => 'Correo enviado!']);
            
            $this->dispatchBrowserEvent('closeModalMail');

        } catch (TransportException $e) {

            return  back()->with('correoNoEnviado', $e->getMessage());
        }
    }

    public function showFoto($foto)
    {
        $this->photoShow = $foto;
        $this->dispatchBrowserEvent('showFoto');
    }

    public function storePlantilla()
    {
        if (!$this->nombreDePlantilla || strip_tags($this->descripcionDePlantilla) == '') {
            $this->dispatchBrowserEvent('alerta', ['type' => 'error', 'msg' => 'Completa todos los campos']);
            return;
        }

        $plantilla = new Plantilla();
        $plantilla->nombre = $this->nombreDePlantilla;
        $plantilla->descripcion = $this->descripcionDePlantilla;
        $plantilla->usuario = Auth::user()->id;
        $plantilla->save();
        $this->dispatchBrowserEvent('alerta', ['type'=>'success', 'msg' => 'Registro guardado!']);
        $this->dispatchBrowserEvent('clearSummerEditor');
        $this->reset('nombreDePlantilla','descripcionDePlantilla');
    }

    public function pastePlantilla()
    {
        $this->message = $this->plantilla;
        $this->plantilla = "";
        $this->dispatchBrowserEvent('showMessage', ['msg'=> $this->message]);
    }

    public function updateTema()
    {
        $this->ticketEdit->tema = $this->tema;
        $this->ticketEdit->descripcion = $this->descripcion;
        $this->ticketEdit->save();

        //EDITAR TAMBIEN EL PRIMER SEGUIMIENTO DEL TICKET PORQUE ES LA DESCRIPCION 
        $s = Seguimiento::where('ticket' , $this->ticketEdit->id)->first();
        $s->notas = $this->descripcion;
        $s->save();

        $this->dispatchBrowserEvent('alerta', ['type'=>'success', 'msg' => 'Cambios guardados!']);
        $this->dispatchBrowserEvent('clearModalEdit');

    }

    public function delete()
    {
        Seguimiento::where('ticket', $this->ticketEdit->id)->delete();
        $this->ticketEdit->delete();
        $this->dispatchBrowserEvent('alerta', ['type'=>'success', 'msg' => 'Registro eliminado!']);
        return redirect($this->backUrl);
    }
}
