<?php

namespace App\Livewire;

use App\Models\edificio;
use Livewire\Component;
use Livewire\WithPagination;

class Edificios extends Component
{
    use WithPagination;

    public $idEd;
    public $nombre;
    public $search = "";
    public $editar = false;

    protected $paginationTheme = "bootstrap";
    protected $listeners =[

        'delItem',
    ];

    public function render()
    {
        $edificios = edificio::where('active', 1)
            ->orderBy("nombre")
            ->paginate(10);

        return view('livewire.edificios', compact('edificios'));
    }

    public function store()
    {

        $this->validate([
            'nombre' => 'required'
        ]);

        $ed = new edificio();
        $ed->nombre = $this->nombre;
        $ed->save();
        $this->dispatchBrowserEvent('alerta', ['msg' => 'Registro guardado']);
        $this->reset();
    }

    public function edit($id)
    {
        $ed = edificio::find($id);
        $this->idEd = $ed->id;
        $this->nombre = $ed->nombre;
        $this->editar = true;
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required'
        ]);

        $ed = edificio::find($this->idEd);
        $ed->nombre = $this->nombre;
        $ed->save();
        $this->dispatchBrowserEvent('alerta', ['msg' => 'Cambios guardados!']);
        $this->reset();
    }

    public function restore()
    {
        $this->reset();
    }

    public function delItem($id)
    {
        $ed = edificio::find($id);
        $ed->active = 0;
        $ed->save();
        $this->dispatchBrowserEvent('alerta', ['msg' => 'Registro eliminado!']);
        $this->reset();
    }
}
