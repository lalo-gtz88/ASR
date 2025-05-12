<?php

namespace App\Livewire;

use App\Jobs\ProccessEmail;
use App\Mail\NotificationTickets;
use App\Models\Actividad;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Categoria;
use App\Models\departamento;
use App\Models\edificio;
use App\Models\Seguimiento;
use App\Models\TicketMerge;
use Carbon\Carbon;
use Exception;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;

class TicketsComp extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $filtro_status = "ABIERTO";
    public $search = "";
    public $usuarios = [];
    public $userFilter;
    public $categorias = [];
    public $modalshow = false;

    //datos para nuevo ticket
    public $tema = "";
    public $descripcion = "";
    public $prioridad = "Baja";
    public $quien_reporta = "";
    public $telefono = "";
    public $edificio = "";
    public $edificios = [];
    public $departamento = "";
    public $departamentos = [];
    public $ip = "";
    public $usuario_red = "";
    public $asignado = "";
    public $categoria = "";
    public $autoriza = "";
    public $fecha_de_atencion;
    public $attachment = [];
    public $onlyMe = false;

    public $ticketMerge1;
    public $ticketUnir;
    public $buscaTicketMerge;
    public $ticketsToMerge = [];
    public $tecnicos = [];

    
    public function updatingSearch()
    {
        $this->resetPage(); //para resetear a la primera pagina cuando tenemos paginacion y filtrado 
    }

    public function updatedFiltroStatus()
    {
        $this->resetPage(); //para resetear a la primera pagina cuando tenemos paginacion y filtrado 
    }

    public function render()
    {

        return view('livewire.tickets-comp');

        //cargamos las actividades
        // $actividades = Actividad::leftJoin('usuario_actividades', 'usuario_actividades.actividad', 'actividades.id')
        //     ->leftJoin('users', 'usuario_actividades.usuario', 'users.id')
        //     ->select(DB::raw("actividades.*"))
        //     ->where('actividades.active', 1)
        //     ->where('usuario_actividades.usuario', Auth::user()->id)->get();


        //cargamos los tickets
        // $tickets = Ticket::leftJoin('users as asignados', 'asignados.id', 'tickets.asignado')
        //     ->leftJoin('users as creadores', 'creadores.id', 'tickets.creador')
        //     ->select(DB::raw("tickets.*,
        //                                     asignados.name as asignadoName, 
        //                                     asignados.lastname as asignadoLastname,
        //                                     CONCAT_WS(' ', creadores.name, creadores.lastname) as creador,
        //                                     asignados.photo"))
        //     ->where('tickets.active', 1)
        //     ->where('tickets.status', $this->filtro_status)
        //     ->where('tickets.asignado', 'like', '%' . $this->userFilter . '%')
        //     ->where(function ($q) {
        //         $q->where('tickets.id', 'LIKE', $this->search);
        //         $q->orWhere('tickets.tema', 'LIKE', "%" . $this->search . "%");
        //         $q->orWhere('tickets.descripcion', 'LIKE', "%" . $this->search . "%");
        //     })
        //     ->orderBy('id', 'DESC')
        //     ->paginate(14);

        // $totalTickets = Ticket::where('status', $this->filtro_status)->where('active', 1)->get();
        // $ticketsByUser = Ticket::where('status', $this->filtro_status)->where('active', 1)->where('asignado', Auth::user()->id)->get();


        //si el usuario no tiene privilegio de ver todos los tickets
        // $user = Auth::user();
        // if (!$user->hasPermissionTo('Mostrar todos los tickets')) {

        //     $this->userFilter = Auth::user()->id;
        //     $this->dispatch('disabledFiltro');
        // }


    }

    public function copy($id)
    {
        //Get datos de ticket
        $ticket = Ticket::leftJoin('users as asignados', 'asignados.id', 'tickets.asignado')
            ->leftJoin('users as creadores', 'creadores.id', 'tickets.creador')
            ->select(DB::raw("tickets.*,
            CONCAT_WS(' ',creadores.name,creadores.lastname) as creadorName"))->where('tickets.id', $id)
            ->first();

        //Setear datos
        $this->tema = $ticket->tema;
        $this->descripcion = $ticket->descripcion;
        $this->quien_reporta = $ticket->reporta;
        $this->telefono = $ticket->telefono;
        $this->edificio = $ticket->edificio;
        $this->departamento = $ticket->departamento;
        $this->usuario_red = $ticket->usuario_red;
        $this->ip = $this->ip;
        $this->edificio = $ticket->edificio;
        $this->autoriza = $ticket->autoriza;
        $this->categoria = $ticket->categoria;
        $this->asignado = $ticket->asignado;
        $this->prioridad = $ticket->prioridad;

        $this->dispatch('copied', ['descripcion' => $this->descripcion]);
    }

    public function openModalMerge($id)
    {
        $this->ticketUnir = "";
        $this->ticketMerge1 = $id;
        $this->ticketsToMerge = Ticket::where('active', 1)
            ->where('id', '!=', $this->ticketMerge1)
            ->where('usuario', Auth::user()->id)
            ->get();

        $this->dispatch('openModalMerge');
    }

    public function mergeTicket()
    {
        //validamos que el ticket sea obligatorio y sea numerico
        $this->validate([
            'ticketUnir' => 'required|numeric'
        ]);

        //se valida que el ticket que ingresa el usuario sea valido
        $ts = Ticket::where('active', 1)
            ->where('id', '!=', $this->ticketMerge1)
            ->where('id', $this->ticketUnir)
            ->first();
        if ($ts != null) {
            $sg = new Seguimiento();
            $sg->notas = "TICKET #" . $ts->id . '.-' .  Str::upper($ts->tema);
            $sg->ticket = $this->ticketMerge1;
            $sg->usuario = Auth::user()->id;
            $sg->created_at = null;
            $sg->unido = 1;

            $sg->save();
            sleep(1);
            $sgs = Seguimiento::where('ticket', $ts->id)->get();
            foreach ($sgs as $s) {
                $s->ticket = $this->ticketMerge1;
                $s->save();
            }

            $tkDel = Ticket::find($this->ticketUnir);
            $tkDel->active = 0;
            $tkDel->save();

            $this->dispatch('alerta', ['msg' => 'Cambios guardados!', 'type' => 'success']);
        } else {
            $this->addError('noExiste', 'Número de ticket no existe');
        }
    }

    public function delete($id)
    {
        $ticket = Ticket::find($id);
        Seguimiento::where('ticket', $ticket->id)->delete();
        $ticket->delete();
        $this->dispatch('alerta', ['type' => 'success', 'msg' => 'Registro eliminado!']);
    }

    function eliminar_tildes($cadena)
    {

        //Codificamos la cadena en formato utf8 en caso de que nos de errores
        $cadena = utf8_encode($cadena);

        //Ahora reemplazamos las letras
        $cadena = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $cadena
        );

        $cadena = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $cadena
        );

        $cadena = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $cadena
        );

        $cadena = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $cadena
        );

        $cadena = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $cadena
        );

        $cadena = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $cadena
        );

        return $cadena;
    }

    #[On('editar')]
    function editar($id) {
        
        $this->dispatch('setearValores', id: $id)->to('EditTicket');
        $this->dispatch('abrirModalEdit', id: $id);
    }
    
    #[On('limpiar')]
    function Limpiar() {
        
        $this->reset();
    }

    // public function store()
    // {
    //     //validamos campos
    //     $this->validate([
    //         'tema' => 'required',
    //         'descripcion' => 'required',
    //         'attachment.*' => 'mimes:jpg,pdf|nullable' //validamos que sea de tipo pdf o jpg
    //     ]);


        //Guardamos el ticket
        // $ticket = new Ticket();
        // $ticket->tema = mb_strtoupper($this->tema);
        // $ticket->descripcion = $this->descripcion;
        // $ticket->reporta = $this->quien_reporta;
        // $ticket->asignado = ($this->asignado != "") ? $this->asignado : 0;
        // $ticket->creador = Auth::user()->id;
        // $ticket->prioridad = $this->prioridad;
        // $ticket->categoria = $this->categoria;
        // $ticket->usuario_red = $this->usuario_red;
        // $ticket->status = "Abierto";
        // $ticket->telefono = $this->telefono;
        // $ticket->departamento = $this->departamento;
        // $ticket->edificio = $this->edificio;
        // $ticket->ip = $this->ip;
        // $ticket->autoriza = $this->autoriza;
        // $ticket->fecha_atencion = $this->fecha_de_atencion;
        // $ticket->usuario = Auth::user()->id;
        // $ticket->save();

        //Guardamos la primera nota del ticket
        // $seguimiento = new Seguimiento();
        // $seguimiento->notas = $this->descripcion;
        // $seguimiento->ticket = $ticket->id;
        // $seguimiento->usuario = Auth::user()->id;
        // $seguimiento->save();


        //Si contiene un archivo adjunto lo guardamos en la carpeta public 
        // if (count($this->attachment) > 0) {

        //     foreach ($this->attachment as $item) {
        //         if ($item != null) {
        //             $fileName = $item->store('public/documents');
        //             // //Luego lo guardamos como nota de seguimiento con el nombre del archivo generado
        //             $seguimiento = new Seguimiento();
        //             $seguimiento->notas = 'Archivo adjunto';
        //             $seguimiento->ticket = $ticket->id;
        //             $seguimiento->usuario = Auth::user()->id;
        //             $seguimiento->file = explode('/', $fileName)[2];
        //             $seguimiento->save();
        //         }
        //     }
        // }

        //************************************************************ */
        //PROCESO PARA EL ENVIO DE CORREO ELECTRONICO
        //************************************************************ */

        //si se ha asignado el ticket a alguien obtenemos el usuario asignado 
        //         if ($ticket->asignado != '') {

        //             // creamos un archivo de texto plano para enviar el mail
        //             $archivo = fopen('C:\ASR\public\body.txt', 'w+');
        //             $tema = "Ticket_#_$ticket->id-" . mb_strtoupper($ticket->tema);
        //             //agregamos el contenido
        //             $contenido = "Se te ha asignado un ticket con prioridad ". $ticket->prioridad. ", creado por " . Auth::user()->name . ' ' . Auth::user()->lastname . " 

        // DETALLES:".
        // strip_tags($this->eliminar_tildes($ticket->descripcion));

        // //colocamos el contenido en el archivo
        //     fputs($archivo, $contenido);

        //     //cerramos el documento
        //     fclose($archivo);

        //     $asignado =  User::find($ticket->asignado);
        //     echo exec("START C:\ASR\public\sendMail.bat $asignado->email $tema");

        //     //enviamos notificacion por telegram en caso de que tenga registrado el chat_id
        //     if ($asignado->telegram != null) {

        //         // $contenido = "Ticket No $ticket->id .-". mb_strtoupper($ticket->tema )."
        //         //     \nSe te ha asignado un ticket con prioridad $ticket->prioridad, creado por". Auth::user()->name.' '.Auth::user()->lastname."
        //         //     \n
        //         //     DETALLES:\n
        //         //     $ticket->descripcion ";
        //         $contenido = "[ TICKET $ticket->id .-" . mb_strtoupper($ticket->tema) . " ]\n Se te ha asignado un ticket con prioridad ". $ticket->prioridad . ", favor de atender\nDETALLES:\n". strip_tags($this->eliminar_tildes($ticket->descripcion))." \n\nATRIBUTOS:\nPrioridad: $ticket->prioridad \nAsignado: $asignado->name" . " " . $asignado->lastname . "\nCreador: " . Auth::user()->name . ' ' . Auth::user()->lastname;

        //         $this->sendTelegram($asignado->telegram, $contenido);
        //     }
        // }

        // //despues mandamos email a todos los usuarios que tienen activada la opcion de 
        // //recibir notificaciones de todos los tickets

        // $usersSend = User::permission('Recibir notificación de todos los tickets')->get();

        // //comprobamos que existan usuarios con esta opcion habilitada
        // if (count($usersSend) > 0) {

        //     $asignadoToAll = null;
        //     if ($ticket->asignado != '') {
        //         $as = User::find($ticket->asignado);
        //         $asignadoToAll = $as->name . " " . $as->lastname;
        //     } else {
        //         $asignadoToAll = 'SIN ASIGNAR';
        //     }

        //     $creador = Auth::user()->name . ' ' . Auth::user()->lastname;
        //     // creamos un archivo de texto plano para enviar el mail
        //     $archivo = fopen('C:\ASR\public\body.txt', 'w+');
        //     $tema = "Ticket_#_$ticket->id-" . mb_strtoupper($ticket->tema);
        // //agregamos el contenido
        //             $contenido = "Se ha creado un nuevo ticket con prioridad $ticket->prioridad, creado por $creador

        // DETALLES: ".
        // strip_tags($this->eliminar_tildes($ticket->descripcion)).

        // "ATRIBUTOS:
        //  Prioridad: $ticket->prioridad
        //  Asignado: $asignadoToAll
        //  Creador: $creador";

        //             //colocamos el contenido en el archivo
        //             fputs($archivo, $contenido);
        //             //cerramos el documento
        //             fclose($archivo);


        //             foreach ($usersSend as $item) {
        //                 //comprobamos que email de la persona asignada no sea el mismo para no enviar
        //                 //doble el correo
        //                 if ($item->email != $asignado->email) {
        //                     //mandamos el correo
        //                     echo exec("START C:\ASR\public\sendMail.bat $item->email $tema");
        //                 }
        //             }

        //             foreach ($usersSend as $item) {
        //                 //comprobamos que tengan registrado el chat_id
        //                 if ($item->telegram != null) {

        //                     $contenido = "[TICKET $ticket->id .-" . mb_strtoupper($ticket->tema) . "]\nDETALLES:\n". strip_tags($ticket->descripcion). "\n\nATRIBUTOS:\nPrioridad: $ticket->prioridad \nAsignado: $asignadoToAll \nCreador: $creador";
        //                     //enviamos notificacion por telegram
        //                     $this->sendTelegram($item->telegram, $contenido);
        //                 }
        //             }
        // }


        //limpiamos modal
    //     $this->reset(
    //         'tema',
    //         'descripcion',
    //         'prioridad',
    //         'quien_reporta',
    //         'telefono',
    //         'edificio',
    //         'departamento',
    //         'descripcion',
    //         'ip',
    //         'usuario_red',
    //         'asignado',
    //         'categoria',
    //         'autoriza',
    //         'attachment'
    //     );

    //     //mandamos alerta de registro guardado y cerramos modal
    //     $this->dispatch('alerta', ['msg' => 'Registro guardado!', 'type' => 'success']);
    //     // return redirect(request()->header('Referer'));
    //     $this->dispatch('closeModal');
    //     // $this->emit('$refresh');
    //     return route('sendEvent');
    // }



}
