<?php

namespace App\Livewire;

use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithPagination;

class Categorias extends Component
{

    use WithPagination;

    public $idCat;
    public $nombre;
    public $search = "";
    public $editar = false;

    protected $paginationTheme = "bootstrap";

    protected $listeners =[

        'delItem',
    ];

    public function render()
    {
        $categorias = Categoria::where('active', 1)
            ->orderBy("name")
            ->paginate(10);

            return view('livewire.categorias', compact('categorias'));
    }

    public function store(){

        $this->validate([
            'nombre'=> 'required'
        ]);
        
        $ed = new Categoria();
        $ed->name = $this->nombre;
        $ed->save();
        $this->dispatch('alerta',['msg'=> 'Registro guardado']);
        $this->reset();

    }

    public function edit($id)
    {
        $cat = Categoria::find($id);
        $this->idCat = $cat->id;
        $this->nombre = $cat->name;
        $this->editar = true;
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required'
        ]);

        $cat = Categoria::find($this->idCat);
        $cat->name = $this->nombre;
        $cat->save();
        $this->dispatch('alerta', ['msg' => 'Cambios guardados!']);
        $this->reset();
    }

    public function restore()
    {
        $this->reset();
    }

    public function delItem($id)
    {
        $cat = Categoria::find($id);
        $cat->active = 0;
        $cat->save();
        $this->dispatch('alerta', ['msg' => 'Registro eliminado!']);
        $this->reset();
    }
}
