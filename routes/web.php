<?php

use App\Http\Controllers\Actividades;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\VerEnlace;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Enlaces;
use App\Http\Controllers\EditarTicket;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportToExcel;
use App\Http\Controllers\NuevoEnlace;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EditarEnlace;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\RedMapas;
use App\Http\Controllers\TicketsController;
use App\Livewire\RolesComponent;
use App\Livewire\UsersComponent;
use App\Livewire\CatalogosComp;
use App\Livewire\ToDoList;
use App\Livewire\Perfil;
use App\Livewire\RptUnidades;
use App\Livewire\AlmacenComp;
use App\Livewire\EditarEquipo;
use App\Livewire\EquipoDetails;
use App\Livewire\InventarioEquipos;
use App\Livewire\MapaEnlaces;
use App\Livewire\MemoriasTecnicas;
use App\Livewire\MonitorEquipos;
use App\Livewire\NuevoEquipo;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Login
Route::view('/', 'login')->name('login');
Route::post('/loginned', [UserController::class, 'authenticate'])->name('loginned');
Route::get('/route-cache', function() { Artisan::call('route:cache'); return 'Routes cache cleared'; });


//Auth
Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('welcome');

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/user/add', [UserController::class, 'create'])->name('users.create');
    Route::post('/user/save', [UserController::class, 'store'])->name('users.store');

    //Tickets
    Route::view('/tickets', 'tickets')->name('tickets');
    Route::get('/nuevo/ticket',[TicketsController::class, 'newTicket'] )->name('nuevoTicket');
    Route::get('/copia/ticket/{id}',[TicketsController::class, 'copy'] )->name('copyTicket');
    Route::get('/ticket/{id}',[EditarTicket::class, 'index'] )->name('editarTicket');
    Route::get('/ticket/document/{id}', [PDFController::class, 'viewDocTicket'])->name('ticketDocument');

    //Catalogos
    Route::group(['middleware' => ['permission:Catalogos']], function () {
        Route::get('/admin/catalogos',  [AdminController::class, 'indexCat'])->name('catalogos');
    });

    //Perfil
    Route::get('/perfil', Perfil::class)->name('perfil');

    //Actividades
    Route::get('/actividades', [Actividades::class,'index'])->name('todolist');

    //Red
    Route::get('/enlaces', [Enlaces::class, 'index'])->name('enlaces');
    Route::get('/nuevo/enlace', [NuevoEnlace::class, 'index' ])->name('nuevoEnlace');
    Route::get('/editar/enlace/{id}', [EditarEnlace::class, 'index'])->name('editarEnlace');
    Route::get('/details/enlace/{id}', [VerEnlace::class, 'index'])->name('verEnlace');
    Route::get('/mapa/enlaces/', [RedMapas::class, 'index'])->name('mapaEnlaces');

    //Equipos
    Route::view('/equipos', 'equipos-inventario')->name('equipos');
    Route::get('equipo/nuevo', [EquipoController::class, 'create'])->name('equipo.create');
    Route::get('/equipo/details/{id}', [EquipoController::class, 'index'])->name('detalleEquipo');
    Route::get('/equipo/editar/{id}', [EquipoController::class, 'edit'])->name('editarEquipo');

    //Monitoreo equipos
    Route::get('/monitoreo/equipos', MonitorEquipos::class)->name('monitoreoEquipos');
    
    //Documentos
    Route::get('/memorias', MemoriasTecnicas::class)->name('memorias');

    //Reportes de unidades
    Route::group(['middleware' => ['permission:Reporte de unidades']], function () {
        Route::get('/reportes/unidades', RptUnidades::class)->name('reporte.unidades');
    });

    //Almacén
    Route::group(['middleware' => ['permission:Almacen']], function () {
        Route::get('/almacen', [AlmacenController::class, 'index'])->name('almacenes');
    });

    //Excel
    Route::post('/uploadEquipos', [ImportToExcel::class, 'import'])->name('uploadEquipos');

    //Users
    Route::group(['middleware' => ['permission:Seccion usuarios']], function () {

        Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');
        Route::get('/user/roles/{id}', [UserController::class, 'roles'])->name('roles');
    });
    
});
