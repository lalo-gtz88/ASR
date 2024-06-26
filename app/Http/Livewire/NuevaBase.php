<?php

namespace App\Http\Livewire;

use App\Models\Base;
use App\Models\BaseDoc;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class NuevaBase extends Component
{
    use WithFileUploads;

    public $tema;
    public $detalles;
    public $documento = [];
    public $privado= false;

    public function render()
    {
        return view('livewire.nueva-base');
    }

    function guardar()
    {

        $this->validate([

            'tema' => 'required',
            'detalles' => 'required'
        ]);

        $art = new Base();
        $art->tema = $this->tema;
        $art->detalles = $this->detalles;
        $art->user_id = Auth::user()->id;
        $art->private = $this->privado;
        $art->save();

        if ($this->documento > 0) {

            foreach($this->documento as $item){

                $doc = $item->store('public/knowledge');

                $bdoc = new BaseDoc();
                $bdoc->base_id = $art->id;
                $bdoc->path = explode('/', $doc)[2];
                $bdoc->name = $item->getClientOriginalName();
                $bdoc->save();
            }
            
        }

        $this->dispatchBrowserEvent('alerta', ['msg' => 'Registro guardado!', 'type' => 'success']);

        $this->reset();
    }
}