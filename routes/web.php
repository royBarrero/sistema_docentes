<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirigir la raíz "/" directamente al login o dashboard
Route::get('/', function () {
    return redirect('/login'); // 👈 o '/dashboard' si querés que entre directo
});

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // CRUD de Roles
    Route::resource('roles', RolController::class);
    //CRUD de docentes 
    Route::resource('docentes', App\Http\Controllers\DocenteController::class);
    //CRUD DE MATERIAS
    Route::resource('materias', App\Http\Controllers\MateriaController::class);
    //CRUD DE GRUPOS
    Route::resource('grupos', App\Http\Controllers\GrupoController::class);
    //CRUD DE AULAS
    Route::resource('aulas', App\Http\Controllers\AulaController::class);





});

require __DIR__.'/auth.php';
