<?php

namespace App\Livewire;

use App\Models\AlertasUsers;
use App\Models\Categoria;
use App\Models\departamento;
use App\Models\edificio;
use App\Models\Seguimiento;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithFileUploads;

class NuevoTicket extends Component
{
    use WithFileUploads;

    //Propiedades
    #[Reactive]
    public $uniqueId;  //para en caso de hacer un copy de otro ticket tomarlo como referencia
    public $tema = "";
    public $descripcion = "";
    public $prioridad = "Baja";
    public $colorPrioridad = "success";
    public $quien_reporta = "";
    public $telefono = "";
    public $edificio = "";
    public $departamento = "";
    public $ip = "";
    public $usuario_red = "";
    public $asignado = "";
    public $categoria = "";
    public $autoriza = "";
    public $attachment = [];
    public $fecha_de_atencion;
    public $unidad;
    public $direccionIp;
    public $usuariosNotificar = [];
    public $tempImage;


    public function mount() {
        
        if($this->uniqueId){

            $ticket = Ticket::find($this->uniqueId);
            $this->descripcion = $ticket->descripcion;
            $this->tema = $ticket->tema;
            $this->quien_reporta = $ticket->reporta;
            $this->telefono = $ticket->telefono;
            $this->edificio = $ticket->edificio;
            $this->departamento = $ticket->departamento;
            $this->ip = $ticket->ip;
            $this->autoriza = $ticket->autoriza;
            $this->categoria = $ticket->categoria;
            $this->asignado = $ticket->asignado;
            $this->prioridad = $ticket->prioridad;

                    
            //lanzamos un evento para setear trix editor 
            $this->dispatch('setEditor', contenido: $this->descripcion);
        
        }
        
    }

    public function render()
    {
        $tecnicos = $this->getTecnicos();
        $categorias = $this->getCategorias();
        $edificios = $this->getEdificios();
        $departamentos = $this->getDepartamentos();

        return view('livewire.nuevo-ticket', compact('tecnicos', 'categorias', 'departamentos', 'edificios'));
    }

    function getCategorias()
    {

        return Categoria::where('active', 1)
            ->orderBy('name')
            ->get();
    }

    function getEdificios()
    {

        return edificio::where('active', 1)
            ->orderBy('nombre')
            ->get();
    }

    function getDepartamentos()
    {

        return departamento::where('active', 1)
            ->orderBy('nombre')
            ->get();
    }

    function getTecnicos()
    {

        return User::where('activo', 1)
            ->where('tecnico', 1)
            ->orderBy('name')
            ->get();
    }

    function guardar()
    {
        $this->getUsersNotifications();

        if ($this->direccionIp)
            $this->ip = "172.16." . $this->direccionIp;

        //validacion
        $validated = $this->validate([
            'tema' => 'required|max:100',
            'descripcion' => 'required',
            'telefono' => 'required',
            'attachment.*' => 'nullable|mimes:jpg,png',
            'ip' => 'nullable|ip'
        ]);

        //guardar ticket
        $ticket = new Ticket();
        $ticket->tema = mb_strtoupper($this->tema);
        $ticket->descripcion = $this->descripcion;
        $ticket->reporta = $this->quien_reporta;
        $ticket->asignado = ($this->asignado != "") ? $this->asignado : 0;
        $ticket->creador = Auth::user()->id;
        $ticket->prioridad = $this->prioridad;
        $ticket->categoria = $this->categoria;
        $ticket->usuario_red = $this->usuario_red;
        $ticket->status = "Abierto";
        $ticket->telefono = $this->telefono;
        $ticket->departamento = $this->departamento;
        $ticket->edificio = $this->edificio;
        $ticket->ip = $this->direccionIp;
        $ticket->autoriza = $this->autoriza;
        $ticket->usuario = Auth::user()->id;
        $ticket->save();


        //guardamos adjuntos
        $this->adjuntarArchivos($this->attachment, $ticket->id);

        //eventos
        $this->dispatch('alerta', msg: 'Registro guardado!', type: 'success');
        $this->dispatch('cerrarModal');
        $this->dispatch('ticket-saved')->to(TicketsList::class);
        $this->dispatch('ticket-saved')->to(CajaEstadistica::class);

        //if ($ticket->asignado != 0 && $ticket->tecnico->telegram != null) {
        
        $alertaUsers = $this->getUsersNotifications();
        $contenido = "Nuevo Ticket ". $ticket->id; 

        foreach($alertaUsers as $item){
            $contenido = "Nuevo Ticket ". $ticket->id; 
            $this->enviarTelegram($ticket->tecnico->telegram, $contenido);
        }
            
            //$contenido = "[TICKET $ticket->id .-" . mb_strtoupper($ticket->tema) . "]\nDETALLES:\n" . strip_tags($ticket->descripcion) . "\n\nATRIBUTOS:\nPrioridad: $ticket->prioridad \nAsignado: " . $ticket->tecnico->name . "\nCreador: " . $ticket->userCreador->name . "";
            
            $this->enviarTelegram($ticket->tecnico->telegram, $contenido);
        //}

        //limpiamos
        $this->resetExcept('uniqueId');
        $this->dispatch('limpiarDescripcion');
    }

    //borrar archivos que se van adjuntar
    public function delFile($index)
    {
        $this->attachment[$index] = null;
    }

    function adjuntarArchivos($attachment = [], $id)
    {

        if (count($attachment) > 0) {

            foreach ($attachment as $item) {

                if ($item != null) {

                    $filename = $item->store('public/documents');
                    $basename = explode('/', $filename)[2];
                    $path = asset('storage/documents') . '/' . $basename;

                    $seguimiento = new Seguimiento;
                    $seguimiento->notas = "<a href=\"{$path}\" target='_blank'><img src=\"{$path}\" class='imgAttachment' alt='archivo adjunto' /></a><span class='deleteAttachment' title='Eliminar'><i class='fa fa-times-circle text-danger'></i></span>";
                    $seguimiento->ticket = $id;
                    $seguimiento->file = $basename;
                    $seguimiento->usuario = Auth::user()->id;
                    $seguimiento->save();   
                }
            }
        }
    }

    function enviarTelegram($destino, $mensaje)
    {

       // $this->dispatch('enviar-notificacion-telegram', destino: $destino, msj: $mensaje);
    }

    #[On('limpiar')]
    function limpiar()
    {

        $this->reset();
    }

    function getUsersNotifications() {
        
        $usuarios = AlertasUsers::select('user_id')->where('categoria', 'Tickets')->get()->toArray();
        $usuarios = array_column($usuarios, 'user_id');
        array_push($usuarios, (int)($this->asignado));
        $unicos = array_unique($usuarios);
        return $unicos;
        
    }

}
