<?php

namespace App\Providers;

use App\Events\CambiosTicket;
use App\Listeners\RegistrarCambiosTicket;
use App\Models\UsuarioActividades;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;

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

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });


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


        Event::listen(
            CambiosTicket::class,
            RegistrarCambiosTicket::class,
        );
    }
}
