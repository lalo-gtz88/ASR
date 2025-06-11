<?php

namespace App\Livewire;

use App\Models\Equipo;
use App\Models\Ip;
use App\Models\Segmento;
use Livewire\Component;
use Livewire\WithPagination;

class IpsList extends Component
{
    use WithPagination;

    public $search = '';
    public $segmentos = [];
    public $segmento;
    public $ipAsignar;
    public $busEq;
    public $equipos_encontrados = [];
    public $idEq;

    function mount()
    {
        $this->segmentos = Segmento::get();
    }

    public function render()
    {

        $ips = $this->getIps();

        return view('livewire.ips-list', compact('ips'));
    }

    function updatedSearch()
    {
        $this->resetPage();
    }

    function getIps()
    {

        $query = Ip::query();

        // Filtro por segmento si existe
        if ($this->segmento) {
            $query->where('segmento_id', $this->segmento);
        }

        // Filtro por IP usando LIKE sobre INET_NTOA
        if (!empty($this->search)) {
            $termino = preg_replace('/[^0-9\.]/', '', $this->search); // limpia caracteres inválidos
            $query->whereRaw("INET_NTOA(ip) LIKE ?", ["%$termino%"]);
        }

        return $query->paginate(20);
    }


    public function buscarIpDisponible()
    {
        if (!$this->segmento) {
            $this->dispatch('alerta', msg: 'Selecciona un segmento primero', type: 'warning');
            return;
        }

        $this->resetPage();

        $ip = Ip::where('segmento_id', $this->segmento)
            ->where('en_uso', false)
            ->orderBy('ip')
            ->first();

        if ($ip) {
            $this->search = long2ip($ip->ip); // lo almacenas como string
        } else {
            $this->search = null;
            $this->dispatch('alerta', msg: 'No hay IPs disponibles en este segmento', type: 'warning');
        }
    }

    function showModalAsignarIp($ip)
    {

        $this->ipAsignar = $ip;
        $this->dispatch('showModal');
    }

    function buscarEquipo()
    {
        $this->equipos_encontrados = Equipo::where('service_tag', 'like', "%{$this->busEq}%")->get();
    }

    function selectEquipo($id)
    {

        $eq = Equipo::find($id);
        $this->busEq = "{$eq->service_tag} [{$eq->relTipoEquipo->nombre}]";
        $this->idEq = $eq->id;
        $this->equipos_encontrados = [];
    }

    function asginarIp()
    {
        //buscamos el equipo
        $eq = Equipo::find($this->idEq);

        //si el equipo existe 
        if ($eq != null) {

            //si el equipo tiene una ip asignada anteriormente
            if ($eq->direccion_ip) {

                //esto para dejar disponible el ip 
                $ip = Ip::where('ip', $eq->direccion_ip)->first();
                $ip->en_uso = false;
                $ip->save();
            }

            //asignamos el ip al equipo
            $eq->direccion_ip = ip2long($this->ipAsignar);
            $eq->save();

            //marcamos la ip asignada como en uso (no disponible)
            $ip = Ip::where('ip', ip2long($this->ipAsignar))->first();
            $ip->en_uso = true;
            $ip->save();

            $this->dispatch('alerta', msg: 'Dirección IP asignada correctamente!', type: 'success');
            $this->dispatch('cerrarModal');
        } else {

            $this->dispatch('alerta', msg: 'Equipo no existe', type: 'warning');
        }
    }

    function liberarIp($id)
    {

        //la dejamos disponible
        $ip = Ip::where('ip', ip2long($id))->first();
        $ip->en_uso = false;
        $ip->save();

        //la liberamos del equipo
        $eq = Equipo::where('direccion_ip', $ip->ip)->first();
        if ($eq) {
            $eq->direccion_ip = '';
            $eq->save();
        }

        $this->dispatch('alerta', msg: 'Dirección IP liberada', type: 'success');
    }
}
