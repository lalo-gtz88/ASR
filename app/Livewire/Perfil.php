<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Livewire\WithFileUploads;

class Perfil extends Component
{
    use WithFileUploads; 

    public $archivo = "";
    public $privilegios=[];
    public $foto;
    public $password;
    public $confirmaPassword;

    protected $listeners = [
        'clearModal',
    ];

    public function render()
    {   
        $user = Auth::user();
        $this->privilegios = $user->getPermissionNames();
        $this->archivo =  $user->photo;
        return view('livewire.perfil');
    }

    public function storePhoto()
    {
        $this->validate([
            'foto'=> 'required|mimes:jpg,png'
        ]);

        $us = User::find(Auth::user()->id);
        if($us->photo != ''){

            unlink(storage_path('app/public/perfiles/'). $us->photo);
        }

        $name_photo = $this->foto->store('public/perfiles');

        $us->photo = explode("/",$name_photo)[2];
        $us->save();

        $this->dispatchBrowserEvent('alerta', ['msg' => 'Cambios guardados!', 'type' => 'success']);
        $this->dispatchBrowserEvent('closeModalPhoto');
    }


    public function update(){

        $this->validate([
            'password' => "required",
            'confirmaPassword' => "required",
        ]);

        if($this->password != $this->confirmaPassword){
            $this->addError('nomatch', "Las contraseñas no coinciden, favor de verificar");
            return;
        }

        $us = User::find(Auth::user()->id);
        $us->password = bcrypt($this->password);
        $us->save();
        
        $this->clearModal();
        $this->dispatchBrowserEvent('hideModal');
        $this->dispatchBrowserEvent('alerta', ['msg' => 'Cambios guardados!', 'type' => 'success']);
    }

    public function clearModal()
    {
        $this->reset('password','confirmaPassword');
        $this->resetValidation();
    }

    public function deletePhoto()
    {
        $us = User::find(Auth::user()->id);
        unlink(storage_path('app/public/perfiles/'). $us->photo);
        $us->photo = null;
        $us->save();
        $this->dispatchBrowserEvent('alerta', ['msg' => 'Foto eliminada!', 'type' => 'success']);
        //redireccionamos a la misma pagina para ver los cambios (no quizo renderizar en esta parte)
        return redirect(request()->header('Referer'));

    }
}
