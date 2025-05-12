<?php

namespace App\Console;

use App\DeviceMonitor;
use App\Models\Monitoreo;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // $schedule->call(function(){

        //     $dispositivos = Monitoreo::all();

        //     //comprobamos cada dispositivo
        //     foreach($dispositivos as $disp){

        //         (new DeviceMonitor)->validarConexion($disp);
        //     }
        // })->everyFiveMinutes();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
