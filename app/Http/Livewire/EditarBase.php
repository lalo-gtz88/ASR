<?php

namespace App\Http\Livewire;

use App\Models\Base;
use App\Models\BaseDoc;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class EditarBase extends Component
{

    public $artId;
    public $tema;
    public $detalles;
    public $documento; //para cargar nuevos documentos
    public $docs; //para obtener los docs que se van a mostrar

    public function mount($id)
    {
        $art = Base::find($id);
        $this->artId = $art->id;
        $this->getDatos();
    }

    public function render()
    {
        
        return view('livewire.editar-base');
        
    }

    function guardarCambios()
    {

        $this->validate([

            'tema' => 'required',
            'detalles' => 'required'
        ]);

        $art = Base::find($this->artId);
        $art->tema = $this->tema;
        $art->detalles = $this->detalles;
        $art->user_id = Auth::user()->id;
        $art->save();

        if ($this->documento != null) {

            $doc = $this->documento->store('public/knowledge');

            $bdoc = new  BaseDoc();
            $bdoc->base_id = $art->id;
            $bdoc->path = explode('/', $doc)[2];
            $bdoc->name = $doc->getClientOriginalName();
            $bdoc->save();
        }


        $this->dispatchBrowserEvent('alerta', ['msg' => 'Cambios guardados!', 'type' => 'success']);
    }

    public function getDatos(){
        
        $art = Base::find($this->artId);
        $this->tema = $art->tema;
        $this->detalles = $art->detalles;
        $this->docs = $art->documentos;
        
    }

    public function descargar($doc, $name)
    {
        return response()->download(storage_path('app/public/knowledge/'). $doc, $name);
    }
}