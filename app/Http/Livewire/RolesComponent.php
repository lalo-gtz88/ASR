<?php

namespace App\Http\Livewire;

use App\Models\Rol;
use App\Models\User;
use App\Models\UserPrivilegio;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class RolesComponent extends Component
{
    public $user;
    public $permisos = [];
    public $permisosAsignados = [];
    public $readyToLoad =false;

    public function mount($id){

         $this->user = User::find($id);
         $this->permisos = Permission::get();

         if(count($this->user->permissions)>0){
            $this->permisosAsignados = $this->user->getPermissionNames();
         }
         
        

    //     $this->roles =  Rol::get(); //obtenemos todos los roles
    //     $rolesAsignados = UserPrivilegio::where('user', $this->user->id)->get();//obtenemos los roles que tiene registrados el usuario como asignados
    
    //     //Si hay roles los asignamos a la variable publica roles asignados
    //     if($rolesAsignados != null){
    //         foreach($rolesAsignados as $item){
    //             array_push($this->rolesAsignados, $item->privilegio); 
    //         }
    //     }
    }

    public function render()
    {   
        
        return view('livewire.roles-component');
    }

    public function store(){

        if(count($this->user->permissions)>0){

            $permissionNames = $this->user->getPermissionNames();
            foreach($permissionNames as $item){
                $this->user->revokePermissionTo($item);
            }
        }

         $this->user->givePermissionTo($this->permisosAsignados);
         $this->dispatchBrowserEvent('alerta', ['msg'=>'Cambios guardados!!']);
        
    }

}
