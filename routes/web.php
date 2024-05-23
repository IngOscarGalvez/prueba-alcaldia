<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Config\AcueductoController;
use App\Http\Controllers\Config\DepartamentoController;
use App\Http\Controllers\Config\ManejoResiduosController;
use App\Http\Controllers\Config\TallaVestimentaController;
use App\Http\Controllers\Config\TipoEstudioController;
use App\Http\Controllers\Config\TipoIdentificacionController;
use App\Http\Controllers\Config\TipoVestimentaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

Route::group(['middleware' => ['role:admin','auth']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    //users
    Route::resource('users', UserController::class);
    Route::post('user/getData', [UserController::class, 'getData'])->name('user.data');
    Route::get('user/getRoles', [UserController::class, 'getRoles'])->name('user.roles');

    //tipoIdentificacion
    Route::resource('tipoIdentificacion', TipoIdentificacionController::class);
    Route::post('tipoIdentificacion/getData', [TipoIdentificacionController::class, 'getData'])->name('tipoIdentificacion.data');

    //Departamento
    Route::resource('departamentos', DepartamentoController::class);
    Route::post('departamentos/getData', [DepartamentoController::class, 'getData'])->name('departamentos.data');

});




