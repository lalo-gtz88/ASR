<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportToExcel;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PlantillaController;
use App\Http\Controllers\SendEventController;
use App\Http\Controllers\TelegramSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Livewire\RolesComponent;
use App\Http\Livewire\TicketsComp;
use App\Http\Livewire\TicketEdit;
use App\Http\Livewire\UsersComponent;
use App\Http\Livewire\CatalogosComp;
use App\Http\Livewire\Edificios;
use App\Http\Livewire\EditarDiagnostico;
use App\Http\Livewire\ListDiagnosticos;
use App\Http\Livewire\Monitoreo;
use App\Http\Livewire\NuevoDiagnostico;
use App\Http\Livewire\ToDoList;
use App\Http\Livewire\Perfil;
use App\Http\Livewire\RptUnidades;
use App\Http\Livewire\AlmacenComp;
use App\Http\Livewire\BaseConocimiento;
use App\Http\Livewire\EditarBase;
use App\Http\Livewire\NuevaBase;

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

//Monitoreo
Route::get('/monitoreo', Monitoreo::class)->name('monitoreo');
//Login
Route::view('/', 'login')->name('login');
Route::post('/loginned', [UserController::class, 'authenticate'])->name('loginned');


//Auth
Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('welcome');

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/user/add', [UserController::class, 'create'])->name('users.create');
    Route::post('/user/save', [UserController::class, 'store'])->name('users.store');

    //Tickets
    Route::get('/tickets', TicketsComp::class)->name('tickets');
    Route::get('/tickets/editar/{ticket}', TicketEdit::class)->name('tickets.editar');
    Route::get('/ticket/document/{id}', [PDFController::class, 'viewDocTicket'])->name('ticketDocument');



    //Base de conocimiento
    Route::get('/baseConocimiento', BaseConocimiento::class)->name('base');
    Route::get('/baseConocimiento/nueva', NuevaBase::class)->name('nuevaBase');
    Route::get('/baseConocimiento/editar/{id}', EditarBase::class)->name('editarBase');

    //Red


    //Catalogos
    Route::group(['middleware' => ['permission:Catalogos']], function () {
        Route::get('/admin/catalogos', CatalogosComp::class)->name('catalogos');
    });

    //Perfil
    Route::get('/perfil', Perfil::class)->name('perfil');

    //Actividades
    Route::get('/actividades', ToDoList::class)->name('todolist');

    //Diagnosticos
    Route::get('/diagnosticos/', ListDiagnosticos::class)->name('diagnosticos');
    Route::get('/diagnosticos/nuevo', NuevoDiagnostico::class)->name('nuevo.diagnostico');
    Route::get('/diagnosticos/editar/{id}', EditarDiagnostico::class)->name('editar.diagnostico');
    Route::get('/diagnosticos/document/{id}', [PDFController::class, 'getDocDiagnostico'])->name('docDiagnostico');


    //Reportes de unidades
    Route::group(['middleware' => ['permission:Reporte de unidades']], function () {
        Route::get('/reportes/unidades', RptUnidades::class)->name('reporte.unidades');
    });

    //Almacén
    Route::group(['middleware' => ['permission:Almacen']], function () {
        Route::get('/almacen', AlmacenComp::class)->name('almacenes');
    });

    //Users
    Route::group(['middleware' => ['permission:Seccion usuarios']], function () {
        Route::get('/usuarios', UsersComponent::class)->name('usuarios');
        Route::get('/user/roles/{id}', RolesComponent::class)->name('roles');
    });




    Route::post('/plantillas/add', [PlantillaController::class, 'save'])->name('plantillas.save');
    Route::get('/eventServ', [SendEventController::class, 'send'])->name('sendEvent');
    Route::post('/uploadEquipos', [ImportToExcel::class, 'import'])->name('uploadEquipos');
});
