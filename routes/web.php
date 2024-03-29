<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\{MovimientoController, OperacionController, EstadoDeResultadosController, BalanzaComprobacionController};


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

Route::get('/', function () {
    return redirect("/dashboard");
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// Rutas de movimiento
Route::middleware(['auth'])->group(function () {
    Route::resource('movimiento', MovimientoController::class);
    Route::resource('operacion', OperacionController::class);
    Route::resource('eresultados', EstadoDeResultadosController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('balanzacomprobacion', [BalanzaComprobacionController::class, 'index'])->name('balanzacomprobacion.index');
    Route::get('estadocostos', function () {
        return Inertia::render("EstadoCostos");
    })->name('estadocostos.index');
});
