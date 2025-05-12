<?php

namespace App\Livewire;

use App\Models\DocumentoMemoria;
use App\Models\MemoriaTecnica;
use App\Models\MemoriaUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MemoriasTecnicas extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $nombre;
    public $documentos = [];
    public $search;
    public $users = [];
    public $usuariosCompartidos = [];
    public $selectAll = false;


    public function mount()
    {
        $this->getUsers();
    }

    public function render()
    {
        $memorias = $this->getMemorias();
        return view('livewire.memorias-tecnicas', compact('memorias'));
    }


    function updatingSearch()
    {

        $this->resetPage();
    }

    function updatedCompartir() {
        
        if($this->compartir != 'with'){
            $this->reset('usuariosCompartidos');
        }
    }

    function updatedSelectAll($value) {
        
        if($value){
            foreach($this->users as $user){
                array_push($this->usuariosCompartidos, $user->id);
            }
        }else{
            $this->reset('usuariosCompartidos');
            array_push($this->usuariosCompartidos, Auth::user()->id); 
        }
    }

    function getMemorias()
    {

        return MemoriaTecnica::where('nombre', 'LIKE', "%{$this->search}%")
            ->paginate(15);
    }

    function store()
    {

        $this->validate([
            'nombre' => 'required',
            'documentos' => 'required|array|min:1',
            'usuariosCompartidos' => 'required|array|min:1'
        ]);

        $m = new MemoriaTecnica();
        $m->nombre = $this->nombre;
        $m->user_id = Auth::user()->id;
        $m->save();

        foreach ($this->documentos as $item) {

            $filename = $item->store('public/memorias');
            $basename = explode('/', $filename)[2];
            $path = asset('storage/memorias') . '/' . $basename;
            $dm = new DocumentoMemoria();
            $dm->memoria_id = $m->id;
            $dm->documento = $path;
            $dm->save();
        }

        if(count($this->usuariosCompartidos) > 0){

            foreach($this->usuariosCompartidos as $key => $value){

                $mu = new MemoriaUser();
                $mu->user_id = $value;
                $mu->memoria_id = $m->id;
                $mu->save();
            }

        }

        $this->dispatch('alerta', msg: "Registro guardado!", type: 'success');
        $this->resetExcept('usuariosCompartidos');
        $this->getUsers();
    }


    function delFile($index)
    {

        unset($this->documentos[$index]);
    }


    function getUsers()
    {
        $this->reset('usuariosCompartidos');

        $this->users = User::where('activo', 1)
            ->where('id', '!=', 1)
            ->orderBy('name')
            ->get();
        
        array_push($this->usuariosCompartidos, Auth::user()->id); 
    }


    #[On('deleteMemoria')]
    function deleteMemoria($id) {
        
        MemoriaTecnica::find($id)->delete();

        MemoriaUser::where('memoria_id', $id)->delete();

        $archivos = DocumentoMemoria::where('memoria_id', $id)->get();

        foreach($archivos as $archivo){

            $file = basename($archivo->documento);
            
            if(Storage::exists($file)){
                Storage::delete('public/memorias/'. $file);
            }
            
        }

        DocumentoMemoria::where('memoria_id', $id)->delete();

        $this->dispatch('alerta', msg: "Registro eliminado!", type: 'success');
    }

}
