<?php

namespace App\Livewire;

use App\Mail\NotificationHostChanged;
use App\Models\AlertasUsers;
use App\Models\Monitoreo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class MonitorEquipos extends Component
{

    public $dispositivos = [];
    public $estados = [];
    public $estadosOld = [];
    public $msj;
    public $users = [];

    function mount()
    {
        $this->getEquipos();
        $this->getUsers();
    }

    public function render()
    {
        return view('livewire.monitor-equipos');
    }

    function getEquipos()
    {
        //obtenemos los equipos que se van a monitorear
        $this->dispositivos = Monitoreo::leftJoin('equipos', 'equipos.id', 'monitoreo.dispositivo')
            ->select(DB::raw("monitoreo.*,INET_NTOA(direccion_ip) as direccion_ip"))
            ->get();

        //comprobamos cada dispositivo
        foreach($this->dispositivos as $disp){

                $this->validarConexion($disp);
        }

    }

    function getUsers() {
        
        $this->users = AlertasUsers::where('categoria', 'Hosts')->get();
    }


    function validarConexion($dispositivo)
    {

        $salida = shell_exec("nmap -sn " . $dispositivo->direccion_ip);

        $isOnline = strpos($salida, 'Host is up');

        if ($dispositivo->status === 'online' && !$isOnline) {

            $dispositivo->status = 'offline';

            if($dispositivo->alerta == 1){
                
                foreach($this->users as $user){
                    
                    $this->sendAlert($dispositivo,"offline", $user->relUser->email);
                    $this->sendTelegram($user->relUser->telegram, $dispositivo->relDispositivo->relTipoEquipo->nombre ." ". $dispositivo->direccion_ip. " FUERA DE SERVICIO" );
                }
                
            }
                
            
        } elseif ($dispositivo->status === 'offline' && $isOnline) {

            $dispositivo->status = 'online';

            if($dispositivo->alerta == 1){
                
                foreach($this->users as $user){
                    
                    $this->sendAlert($dispositivo,"online", $user->relUser->email);
                    $this->sendTelegram($user->relUser->telegram, $dispositivo->relDispositivo->relTipoEquipo->nombre ." ". $dispositivo->direccion_ip. " EN LINEA" );
                }
            }
        }

        $dispositivo->save();
    }


    function sendAlert($device, $newStatus, $email)
    {
         Mail::to($email)->send(new NotificationHostChanged($device, $newStatus));

    }

    function sendTelegram($destino, $mensaje)
    {

        $this->dispatch('enviar-notificacion-telegram', destino: $destino, msj: $mensaje);
    }

}
