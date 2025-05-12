<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserPrivilegio;


class UsersComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $idUser = '';
    public $usuario = '';
    public $nombre = '';
    public $apellido = '';
    public $password = '';
    public $confirmaPassword = '';
    public $correo = '';
    public $telefono= '';
    public $editarRegistro = false;
    public $readyToLoad = false;

    protected $listeners = [
        'delete'
    ];

    public function render()
    {
        $users = User::where('activo', 1)
            ->where('username', '!=', 'admin')
            ->where(function ($q) {
                $q->where('username', 'like', '%' . $this->search . '%');
                $q->orWhere('name', 'like', '%' . $this->search . '%');
            })->paginate(10);

        return view('livewire.users-component', compact('users'));
    }

    public function store()
    {

        $this->validate([
            'usuario' => 'required|unique:users,username,0,activo',
            'password' => 'required',
            'confirmaPassword' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'correo' => 'email|nullable|unique:users,email,0,activo'
        ]);

        if ($this->password != $this->confirmaPassword) {
            $this->addError('nomatch', 'Las contraseñas no coinciden');
            return;
        }


        $user = User::where('activo', 1)
            ->where('username', $this->usuario)->first();

        if ($user != null) {
            $this->addError('exist', 'El usuario ya existe, favor de verificar');
            return;
        }

        $user = new User;
        $user->name = $this->nombre;
        $user->lastname = $this->apellido;
        $user->username = $this->usuario;
        $user->password = bcrypt($this->password);
        $user->email = $this->correo;
        $user->telefono = $this->telefono;
        $user->save();
        $this->clear();

        $this->dispatchBrowserEvent('alerta', ['msg'=>'Registro guardado!']);
    }

    public function clear()
    {
        $this->reset('idUser','usuario','nombre','apellido','password','confirmaPassword', 'editarRegistro','telefono','correo');
    }

    public function delete($id)
    {

        $user = User::find($id);
        $user->activo = 0;
        $user->save();
    }

    public function edit($id)
    {

        $this->editarRegistro = true;
        $user = User::find($id);
        $this->idUser = $user->id;
        $this->nombre = $user->name;
        $this->apellido = $user->lastname;
        $this->usuario = $user->username;
        $this->telefono = $user->telefono;
        $this->correo = $user->email;
    }

    public function cancel()
    {
        $this->clear();
    }

    public function update()
    {
        $this->validate([
            'usuario' => 'required',
            'password' => 'nullable',
            'confirmaPassword' => 'nullable',
            'nombre' => 'required',
            'apellido' => 'required',
            'correo' => 'email|nullable'

        ]);

        if ($this->password != $this->confirmaPassword) {
            $this->addError('nomatch', 'Las contraseñas no coinciden');
            return;
        }

        $user = User::find($this->idUser);

        $users = User::where('activo', 1)
            ->where('username', '!=', $user->username)
            ->get();

        foreach ($users as $item) {
            if ($this->usuario == $item->username) {
                $this->addError(
                    'exist',
                    'El nombre de usuario al que intentas actualizar ya existe, favor de verificar'
                );
                return;
            }
        }

        $user->name = $this->nombre;
        $user->lastname = $this->apellido;
        $user->username = $this->usuario;
        $user->email = $this->correo;
        $user->telefono = $this->telefono;
        if ($this->password != '' && $this->confirmaPassword) {
            $user->password = bcrypt($this->password);
        }

        $user->save();
        $this->cancel();

        $this->dispatchBrowserEvent('alerta', ['msg'=>'Cambios guardados!']);
    }
}
