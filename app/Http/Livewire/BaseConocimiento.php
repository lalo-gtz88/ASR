<?php

namespace App\Http\Livewire;

use App\Models\Base;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BaseConocimiento extends Component
{
    use WithPagination;

    public $buscar="";

    protected function updatedBuscar()
    {

        $this->resetPage();
    }

    public function render()
    {
        $articulos = Base::with('username')
            ->where('tema', 'like', '%' . $this->buscar . '%')
            ->where('detalles', 'like', '%' . $this->buscar . '%')
            ->get();

        return view('livewire.base-conocimiento', compact('articulos'));
    }
}
