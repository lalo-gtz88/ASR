<?php

namespace App\Livewire;

use App\Models\Proveedor;
use App\Models\ProveedorContacto;
use Illuminate\Console\ContainerCommandLoader;
use Livewire\Attributes\On;
use Livewire\Component;

class CatProveedores extends Component
{

    public $lista = [];
    public $proveedor;
    public $nombre;

    public $contactos = [];

    protected $listeners = [
        'resetModal',
    ];

    function mount()
    {
        $this->lista = $this->getLista();
    }
    public function render()
    {

        return view('livewire.cat-proveedores');
    }

    function getLista()
    {

        return Proveedor::orderBy('nombre')->get();
    }


    function enviarProveedor()
    {

        $this->dispatch('obtenerProveedor', proveedor: $this->proveedor);
    }

    function addInputContacto()
    {

        $this->contactos[] = ['nombre' => '', 'tel' => ''];
    }

    function removeInput($index)
    {

        unset($this->contactos[$index]);
        $this->contactos = array_values($this->contactos); // Reindexa el array
    }

    function guardar()
    {
        $this->validate([
            'nombre' => 'required'
        ]);

        $p = new Proveedor();
        $p->nombre = $this->nombre;
        $p->save();

        if ($this->contactos) {

            foreach ($this->contactos as $item) {

                $c = new ProveedorContacto();
                $c->proveedor_id = $p->id;
                $c->nombre = $item['nombre'];
                $c->telefono = $item['tel'];
                $c->save();
            }
        }

        $this->lista = $this->getLista();
        $this->dispatch('alerta', msg: 'Registro guardado', type: 'success');
        $this->resetModal();
    }

    function resetModal()
    {
        $this->reset('nombre', 'contactos');
    }

    #[On('setProveedor')]
    function setProveedor($id)
    {
        $this->proveedor = $id;
    }
}
