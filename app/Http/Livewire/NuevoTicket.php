<?php

namespace App\Http\Livewire;

use App\Jobs\ProccessEmail;
use App\Models\Categoria;
use App\Models\departamento;
use App\Models\edificio;
use App\Models\Seguimiento;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class NuevoTicket extends Component
{
    use WithFileUploads;

    public $tema = "";
    public $descripcion = "";
    public $prioridad = "Media";
    public $quien_reporta = "";
    public $telefono = "";
    public $edificio = "";
    public $departamento = "";
    public $ip = "";
    public $usuario_red = "";
    public $asignado = "";
    public $categoria = "";
    public $autoriza = "";
    public $attachment;


    protected $listeners = [
        'copy',
        'restore',
    ];

    public function render()
    {
    
        $usuarios = User::orderBy('name')->get();
        $categorias = Categoria::orderBy('name')->get();
        $departamentos = departamento::orderBy('nombre')->get();
        $edificios = edificio::orderBy('nombre')->get();
        return view('livewire.nuevo-ticket', compact('usuarios', 'categorias', 'departamentos', 'edificios'));
    }
    
    public function store()
    {
        //validamos campos
        $this->validate([
            'tema' => 'required',
            'descripcion' => 'required',
            // 'telefono' => 'required',
            // 'departamento' => 'required',
            'attachment' => 'mimes:jpg,pdf|nullable' //validamos que sea de tipo pdf o jpg
        ]);

        //Guardamos el ticket
        $ticket = new Ticket();
        $ticket->tema = mb_strtoupper($this->tema);
        $ticket->descripcion = $this->descripcion;
        $ticket->reporta = $this->quien_reporta;
        $ticket->asignado = ($this->asignado != "") ? $this->asignado : null;
        $ticket->creador = Auth::user()->id;
        $ticket->prioridad = $this->prioridad;
        $ticket->categoria = $this->categoria;
        $ticket->usuario_red = $this->usuario_red;
        $ticket->status = "Abierto";
        $ticket->telefono = $this->telefono;
        $ticket->departamento = $this->departamento;
        $ticket->edificio = $this->edificio;
        $ticket->ip = $this->ip;
        $ticket->autoriza = $this->autoriza;
        $ticket->usuario = Auth::user()->id;
        $ticket->save();

        //Guardamos la primera nota del ticket
        $seguimiento = new Seguimiento();
        $seguimiento->notas = $this->descripcion;
        $seguimiento->ticket = $ticket->id;
        $seguimiento->usuario = Auth::user()->id;
        $seguimiento->save();

        //Si contiene un archivo adjunto lo guardamos en la carpeta public 
        if ($this->attachment) {

            $fileName = $this->attachment->store('public/documents');

            // //Luego lo guardamos como nota de seguimiento con el nombre del archivo generado
            $seguimiento = new Seguimiento();
            $seguimiento->notas = 'Archivo adjunto';
            $seguimiento->ticket = $ticket->id;
            $seguimiento->usuario = Auth::user()->id;
            $seguimiento->file = explode('/',$fileName)[2];
            $seguimiento->save();
        }
        
            //Enviar correo
            //Seteamos datos del ticket
            // $details['tipo'] = 'open';
            // $details['user'] = Auth::user()->name . ' ' . Auth::user()->lastname;
            
            // $usr = User::find($ticket->creador);
            // $details['creator']= $usr->name.' '.$usr->lastname;
            // $details['header'] = '#'.$ticket->id.' '.$ticket->tema;
            // $details['descripcion'] = $ticket->descripcion;
            // $details['prioridad'] = $ticket->prioridad;
            // $details['cambios'] = '';

            // //Validamos si se ha asignado a alguien 
            // if($ticket->asignado != null){
            //     $userAssigned = User::find($ticket->asignado);
            //     $details['asignado'] = $userAssigned->name.' '. $userAssigned->lastname;

            //     //verificamos que tenga registrado un correo
            //     if($userAssigned->email != null){
            //         $details['email']= $userAssigned->email;
            //         dispatch(new ProccessEmail($details));
            //     }

            //     //despues mandamos email a todos los usuarios que tienen activada la opcion de 
            //     //recibir notificaciones de todos los tickets
            //     $usersSend = User::permission('Recibir notificación de todos los tickets')->get();
            //     foreach($usersSend as $item){
            //         //comprobamos que email de la persona asignada no sea el mismo para no enviar
            //         //doble el correo
            //         if($item->email != $userAssigned->email){
            //             $details['email']= $item->email;
            //             dispatch(new ProccessEmail($details));
            //         }
            //     }
            // }else{

            //      //si no se asigno a nadie
            //      //mandamos email a todos los usuarios que tienen activada la opcion de 
            //      //recibir notificaciones de todos los tickets
            //      $usersSend = User::permission('Recibir notificación de todos los tickets')->get();
            //      foreach($usersSend as $item){
            //          $details['email']= $item->email;
            //          $details['asignado']= 'Aun no se ha asignado';
            //          dispatch(new ProccessEmail($details));
            //      }
            // }

        
        //Limpiamos y mandamos alerta de registro guardado
        $this->reset();
        $this->dispatchBrowserEvent('alerta', ['msg' => 'Registro guardado!', 'type' => 'success']);
        $this->dispatchBrowserEvent('closeModal');
        $this->emitUp('render');

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
        
        $this->dispatchBrowserEvent('copied');
    }

    public function restore()
    {
        $this->reset();
    }
    
}
