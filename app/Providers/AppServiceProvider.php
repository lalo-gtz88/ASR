<?php

namespace App\Providers;

use App\Models\UsuarioActividades;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        //compose all the views....
        view()->composer('*', function () {
            if (Auth::check()) {
                $actividades = UsuarioActividades::leftJoin('actividades', 'actividades.id', 'usuario_actividades.actividad')
                    ->where('usuario', Auth::user()->id)
                    ->where('actividades.status', 1)
                    ->select(DB::raw('usuario_actividades.actividad'))
                    ->get()->toArray();

                $notificaciones = 0;
                if (count($actividades) > 0) {
                    $notificaciones = +1;
                }

                View::share(['todolist' => $actividades, 'notificaciones' => $notificaciones]);
            }
        });


    
    }
}
