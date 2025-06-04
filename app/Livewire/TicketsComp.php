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
    function editar($id)
    {

        $this->dispatch('setearValores', id: $id)->to('EditTicket');
        $this->dispatch('abrirModalEdit', id: $id);
    }

    #[On('limpiar')]
    function Limpiar()
    {

        $this->reset();
    }
}
