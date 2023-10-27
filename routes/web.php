<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\EgresadoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AyudaController;

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

Route::middleware("auth")->group(function () {
    Route::middleware("desactivado")->group(function () {
       
        Route::resource('carreras', 'App\Http\Controllers\CarreraController');

       Route::resource('/egresado', 'App\Http\Controllers\EgresadoController');

        Route::put('/egresado/{id}/editar', [EgresadoController::class, 'update'])
        ->name('egresado.editar')->where('id','[0-9]+');

        Route::put('/carreras/{id}/editar', [CarreraController::class, 'update'])
       ->name('carrera.update')->where('id','[0-9]+');
        
   
        Route::get('/contrasenia',[UserController::class, 'formularioclave'])
        ->name('contrasenia.cambiar');
    
        //ruta guardar
        Route::post('/contrasenia',[UserController::class, 'guardarclave'])
            ->name('contrasenia.cambiada');
    
        Route::get('/usuario',[UserController::class, 'usuario'])
        ->name('usuario.datos');

        Route::get('/usuario/editar',[UserController::class, 'editar'])
        ->name('usuario.editar');

        Route::put('/usuario/editar',[UserController::class, 'actualizar'])
        ->name('usuario.actualizar'); 
    
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
              
        //ruta  formulario
     Route::get('/registrar',[UserController::class, 'registrar'])
    ->name('usuario.registrar');

    //ruta guardar
    Route::post('/registrar',[UserController::class, 'guardar'])->name('usuario.guardar');
        //ruta  formulario
        Route::get('/listadousuario',[UserController::class, 'listado'])
        ->name('usuario.listado');
    
        Route::get('/usuario/desactivar/{id}',[UserController::class, 'desactivar'])
        ->name('user.desactivar');

    
        Route::get('/usuario/activar/{id}',[UserController::class, 'activar'])
        ->name('user.activar');
        
        Route::delete('/usuario/eliminar/{id}',[UserController::class, 'destroy'])
        ->name('user.destroy');

        //ruta de editar usuario
        
        Route::get('/usuario/{id}/edit',[UserController::class, 'editaru'])
        ->name('usuario.editaru');

        Route::put('/usuario/{id}/edit',[UserController::class, 'update'])
        ->name('usuario.update'); 


        Route::get('/ayudaindex',[AyudaController::class, 'index'])
        ->name('ayuda.index');

        Route::get('/infoegresados',[AyudaController::class, 'egresados'])
        ->name('info.egresados');

        Route::get('/infocarreras',[AyudaController::class, 'infcarrera'])
        ->name('info.carreras');
        
        Route::get('/infousuario',[AyudaController::class, 'usuario'])
        ->name('info.usuario');
        
        Route::get('/infoperfil',[AyudaController::class, 'perfil'])
        ->name('info.perfil');

        Route::get('/infografico',[AyudaController::class, 'grafico'])
        ->name('info.grafico');
        



    });
   
    
});

Auth::routes(["register" => false]);

