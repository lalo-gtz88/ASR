<?php

namespace App\Http\Livewire;

use App\Models\Actividad;
use App\Models\User;
use App\Models\UsuarioActividades;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class ToDoList extends Component
{

    public $usuariosAdd = [];
    public $descripcion;
    public $showLimpiarList = false;
    public $actividadSelect;
    public $miembros = [];
    public $fecha;

    protected $listeners = ['delTodo','delete'];

    public function render()
    {
        $usuarios = User::where('activo', 1)
            ->where('id', '<>', Auth::user()->id)
            ->get();

        $listaActividades = [];
        $listaActividades = $this->getTodoList();
        $this->showList();
        return view('livewire.to-do-list', compact('usuarios', 'listaActividades'));
    }

    public function store()
    {

        $this->validate([
            'descripcion' => 'required'
        ]);

        $ac =  new Actividad();
        $ac->descripcion = Str::upper($this->descripcion);
        $ac->fecha = ($this->fecha != null) ? $this->fecha : null;
        $ac->save();

        $usr_act = new UsuarioActividades();
        $usr_act->usuario = Auth::user()->id;
        $usr_act->actividad = $ac->id;
        $usr_act->creador = true;
        $usr_act->save();

        foreach ($this->usuariosAdd as $item) {

            $miembro_act = new UsuarioActividades();
            $miembro_act->usuario = $item;
            $miembro_act->actividad = $ac->id;
            $miembro_act->save();
        }

        //alerta
        $this->reset('usuariosAdd', 'descripcion');
        $this->dispatchBrowserEvent('alerta', ['msg' => 'Registro guardado!', 'type' => 'success']);
        $this->dispatchBrowserEvent('cerrarModal');
    }

    public function getTodoList()
    {
        $lista = UsuarioActividades::leftJoin('actividades', 'actividades.id', 'usuario_actividades.actividad')
            ->leftJoin('users', 'users.id', 'usuario_actividades.usuario')
            ->select(DB::raw('actividades.*, COUNT(usuario_actividades.usuario) AS miembros, usuario_actividades.creador'))
            ->where('active', 1)
            ->where('usuario_actividades.usuario', Auth::user()->id)
            ->groupBy('actividades.id')
            ->orderBy('actividades.status', 'DESC')
            ->orderBy('actividades.updated_at')
            ->get();
        return $lista;
    }

    public function checkUnckeck($id, $status)
    {
        $act = Actividad::find($id);
        $act->status = $status;
        $act->save();

        $this->showList();
    }

    public function delTodos()
    {
        $acts = Actividad::where('status', 0)->get();
        foreach ($acts as $act) {
            $act->active = 0;
            $act->save();
        }
    }

    public function showList()
    {
        $acts = Actividad::where('status', 0)
            ->where('active', 1)
            ->get();
        if (count($acts) > 0) {
            $this->showLimpiarList = true;
        } else {
            $this->showLimpiarList = false;
        }
    }

    public function showMiembros($id)
    {
        $this->miembros = UsuarioActividades::leftJoin('users', 'users.id', 'usuario_actividades.usuario')
            ->select(DB::raw("CONCAT_WS(' ',users.name,users.lastname) as nombre"))
            ->where('actividad', $id)->get();

        $act = Actividad::find($id);
        $this->actividadSelect = $act->descripcion;
        $this->dispatchBrowserEvent('showMembers');
    }

    public function delete($id)
    {
        $t = Actividad::find($id);

        UsuarioActividades::where('actividad', $t->id)->delete();
        $t->delete();

        $this->dispatchBrowserEvent('alerta', ['msg' => 'Registro eliminado!', 'type' => 'success']);


    }
}
