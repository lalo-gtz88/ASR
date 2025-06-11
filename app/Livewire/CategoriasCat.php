<?php

namespace App\Livewire;

use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriasCat extends Component
{
    use WithPagination;

    public $idEd;
    public $nombre;
    public $search = "";
    public $editar = false;

    protected $paginationTheme = "bootstrap";

    protected $listeners = [

        'delItem',
    ];

    function updatedSearch()
    {

        $this->resetPage();
    }

    public function render()
    {
        $categorias = Categoria::where('active', 1)
            ->where('name', 'like', "%{$this->search}%")
            ->orderBy("name")
            ->paginate(10);

        return view('livewire.categorias-cat', compact('categorias'));
    }


    public function guardar()
    {

        $this->validate([
            'nombre' => 'required'
        ]);

        if (!$this->editar) {
            $ed = new Categoria();
            $ed->name = $this->nombre;
            $ed->save();
        } else {

            $ed = Categoria::find($this->idEd);
            $ed->name = $this->nombre;
            $ed->save();
        }

        $this->restore();
        $this->dispatch('alerta', msg: 'Cambios guardados!', type: 'success');
    }

    public function edit($id)
    {
        $ed = Categoria::find($id);
        $this->idEd = $ed->id;
        $this->nombre = $ed->name;
        $this->editar = true;
    }

    public function restore()
    {
        $this->reset('editar', 'nombre', 'idEd');
    }

    public function delItem($id)
    {
        $ed = Categoria::find($id);
        $ed->active = 0;
        $ed->save();
        $this->dispatch('alerta', msg: 'Registro eliminado!', type: 'success');
        $this->reset();
    }
}
