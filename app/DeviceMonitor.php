<?php

namespace App;

use App\Mail\NotificationHostChanged;
use App\Notifications\DeviceStatusChanged;
use Illuminate\Support\Facades\Mail;

class DeviceMonitor
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    
    function validarConexion($dispositivo)
    {

        $salida = shell_exec("nmap -sn " . $dispositivo->direccion_ip);

        $isOnline = strpos($salida, 'Host is up');

        if ($dispositivo->status === 'online' && !$isOnline) {

            $dispositivo->status = 'offline';

            if($dispositivo->alerta == 1){
                
                $this->sendAlert($dispositivo, 'offline');
            }
                
            
        } elseif ($dispositivo->status === 'offline' && $isOnline) {

            $dispositivo->status = 'online';

            if($dispositivo->alerta == 1){
                
                $this->sendAlert($dispositivo, 'online');
            }
        }

        $dispositivo->save();
    }


    public function sendAlert($device, $newStatus)
    {
        
         Mail::to('egutierrez@jmasjuarez.gob.mx')->send(new NotificationHostChanged($device, $newStatus));
    }
}
