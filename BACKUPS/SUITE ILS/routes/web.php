<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuquesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

// Redirigir la raíz a la ruta de inicio de sesión
Route::redirect('/', '/login');

// Agrupación de rutas que requieren autenticación
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Ruta del dashboard
    Route::get('/dashboard', function () {
        $buques = Auth::user()->buques;
        return view('dashboard', compact('buques'));
    })->name('dashboard');

    // Rutas CRUD para Buques
    Route::get('/buques/create', [BuquesController::class, 'create'])->name('buques.create');
    Route::post('/buques', [BuquesController::class, 'store'])->name('buques.store');
    Route::get('/buques/{buque}/edit', [BuquesController::class, 'edit'])->name('buques.edit');
    Route::put('/buques/{buque}', [BuquesController::class, 'update'])->name('buques.update');
    Route::delete('/buques/{buque}', [BuquesController::class, 'destroy'])->name('buques.destroy');
    Route::get('/buques/{buque}', [BuquesController::class, 'show'])->name('buques.show');
    Route::get('/buques', [BuquesController::class, 'index'])->name('buques.index');

    // Rutas para el módulo GRES y FUA
    Route::get('/buques/{buque}/mod_gres', [BuquesController::class, 'showGres'])->name('buques.gres');
    Route::get('/buques/{buque}/mod_gres_sistema', [BuquesController::class, 'showGresSistema'])->name('buques.mod_gres_sistema');
    Route::get('/buques/{buque}/mod_fua', [BuquesController::class, 'showFua'])->name('buques.fua');
    Route::get('/buques/{buque}/mod_gres2', [BuquesController::class, 'showGres2'])->name('buques.gres2');

    // Rutas para actualizar MEC y Título de sistemas_buque
    Route::put('/buques/{buque}/sistemas-buque/{sistemaBuque}/mec', [BuquesController::class, 'updateMec']);
    Route::put('/buques/{buque}/sistemas-buque/{sistemaBuque}/titulo', [BuquesController::class, 'updateSistemaTitulo']);

    // Ruta para guardar observaciones de sistemas_buque
    Route::post('/buques/{buque}/sistemas-buque/{sistemaBuque}/save-observations', [BuquesController::class, 'saveObservations']);

    // Rutas para exportar y visualizar PDF
    Route::get('/buques/{buque}/view-pdf', [BuquesController::class, 'showPdf'])->name('buques.viewPdf');
    Route::get('/buques/{buque}/export-pdf', [BuquesController::class, 'exportPdf'])->name('buques.exportPdf');

    // Rutas para colaboradores
    Route::post('/buques/{buque}/save-collaborators', [BuquesController::class, 'saveCollaborators'])->name('buques.saveCollaborators');
    Route::delete('/buques/colaborador/{id}', [BuquesController::class, 'deleteCollaborator'])->name('buques.deleteCollaborator');

    // Rutas para usuarios
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('/lsa/{buque}', [BuquesController::class, 'LSA'])->name('lsa');
    Route::get('/acceder-lsa/{buqueId}', [BuquesController::class, 'accederLSA'])->name('acceder.lsa');
});
