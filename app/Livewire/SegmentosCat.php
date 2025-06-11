<?php

namespace App\Livewire;

use App\Models\edificio;
use App\Models\Ip;
use App\Models\Segmento;
use Livewire\Component;

class SegmentosCat extends Component
{
    public $idSegmento;
    public $nombre, $subred, $mascara;
    public $search = "";
    public $modoEdicion = false;
    public $edificios = [];
    public $edificio;

    protected $paginationTheme = "bootstrap";

    protected $listeners = [

        'delItem',
    ];

    function updatedSearch()
    {

        $this->resetPage();
    }

    function mount()
    {
        $this->getEdificios();
    }

    public function render()
    {
        $segmentos = Segmento::where('nombre', 'like', "%{$this->search}%")
            ->orderBy("nombre")
            ->paginate(10);

        return view('livewire.segmentos-cat', compact('segmentos'));
    }


    public function store()
    {

        if (!$this->modoEdicion) {

            $this->guardar();
        } else {

            $this->actualizar();
        }
    }


    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|string|max:100',
            'subred' => 'required|ipv4',
            'mascara' => 'required|integer|min:1|max:32',
        ]);

        $base = ip2long($this->subred); // convierte IP base a entero
        $maskBits = (int) $this->mascara;
        $mask = -1 << (32 - $maskBits);

        $subredInicio = $base & $mask; // primer IP
        $subredFin = $subredInicio | (~$mask & 0xFFFFFFFF); // última IP del segmento


        // Omitir IP de red y broadcast si aplica
        $usable_start = $this->mascara >= 31 ? $subredInicio : $subredInicio + 1;
        $usable_end = $this->mascara >= 31 ? $subredFin : $subredFin - 1;
        $hosts = ($maskBits >= 31) ? 0 : pow(2, 32 - $maskBits) - 2; // número de IPs utilizables

        $segmento = Segmento::create([
            'nombre' => $this->nombre,
            'subred_inicio' => $subredInicio,
            'subred_fin' => $subredFin,
            'mascara' => $maskBits,
            'hosts_disponibles' => $hosts,
            'edificio_id' => $this->edificio
        ]);


        // Generar las IPs
        $ips = [];
        for ($ip = $usable_start; $ip <= $usable_end; $ip++) {
            $ips[] = [
                'segmento_id' => $segmento->id,
                'ip' => $ip,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Ip::insert($ips); // Inserción masiva

        $this->reset(['nombre', 'subred', 'mascara']);

        $this->dispatch('alerta', msg: 'Cambios guardados!', type: 'success');
    }

    public function editar($id)
    {
        $seg = Segmento::find($id);
        $this->idSegmento = $seg->id;
        $this->nombre = $seg->nombre;
        $this->edificio = $seg->edificio_id;
        $this->modoEdicion = true;
    }

    public function actualizar()
    {
        $this->validate([
            'nombre' => 'required|string|max:100',
        ]);

        $segmento = Segmento::find($this->idSegmento);
        $segmento->nombre = $this->nombre;
        $segmento->edificio_id = $this->edificio;
        $segmento->save();

        $this->reset('nombre', 'idSegmento', 'modoEdicion', 'edificio');

        $this->dispatch('alerta', msg: 'Cambios guardados!', type: 'success');
    }

    public function restore()
    {
        $this->reset('nombre', 'idSegmento', 'modoEdicion', 'edificio');
    }

    public function delItem($id)
    {
        $seg = Segmento::find($id);
        $seg->delete();
        $this->dispatch('alerta', msg: 'Registro eliminado!', type: 'success');
        $this->reset();
    }

    function getEdificios()
    {

        $this->edificios = edificio::where('active', 1)->get();
    }
}
