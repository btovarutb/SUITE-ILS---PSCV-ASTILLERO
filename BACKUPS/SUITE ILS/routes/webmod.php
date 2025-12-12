<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuquesController;
use App\Http\Controllers\UserController;


// Redirigir la raíz a la ruta de inicio de sesión
Route::redirect('/', '/login');

// Agrupación de rutas que requieren autenticación
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $buques = Auth::user()->buques;
        return view('dashboard', compact('buques'));
    })->name('dashboard');

    Route::get('/buques/create', [BuquesController::class, 'create'])->name('buques.create');
    Route::post('/buques', [BuquesController::class, 'store'])->name('buques.store');
    Route::get('/buques/{buque}/edit', [BuquesController::class, 'edit'])->name('buques.edit');
    Route::put('/buques/{buque}', [BuquesController::class, 'update'])->name('buques.update');
    Route::delete('/buques/{buque}', [BuquesController::class, 'destroy'])->name('buques.destroy');
    Route::get('/buques/{buque}', [BuquesController::class, 'show'])->name('buques.show');
    Route::get('/buques', [BuquesController::class, 'index'])->name('buques.index');
    Route::get('/buques/{buque}/sistemas-equipos', [BuquesController::class, 'getSistemasEquipos']);

    Route::get('/buques/{buque}/mod_gres', [BuquesController::class, 'showGres'])->name('buques.gres');
    Route::get('/buques/{buque}/mod_gres_sistema', [BuquesController::class, 'showGresSistema'])->name('buques.mod_gres_sistema');
    Route::get('/buques/{buque}/mod_fua', [BuquesController::class, 'showFua'])->name('buques.fua');

    Route::put('/buques/{buque}/sistemas-equipos/{equipo}/mec', [BuquesController::class, 'updateMEC']);
    Route::put('/buques/{buque}/sistemas/{sistema}/mec', [BuquesController::class, 'updateMecSistema'])->name('buques.sistemas.updateMec');
    Route::put('/buques/{buque}/sistemas-equipos/{equipo}/titulo', [BuquesController::class, 'updateEquipoTitulo']);
    Route::post('/buques/{buque}/sistemas-equipos', [BuquesController::class, 'storeSistemaEquipo']);

    Route::get('/buques/{buque}/view-pdf', [BuquesController::class, 'showPdf'])->name('buques.viewPdf');
    Route::get('/buques/{buque}/export-pdf', [BuquesController::class, 'exportPdf'])->name('buques.exportPdf');

    Route::get('/buques/{buque}/mod_gres2', [BuquesController::class, 'showGres2'])->name('buques.gres2');


    // Ruta para guardar colaboradores
    Route::post('/buques/{buque}/save-collaborators', [BuquesController::class, 'saveCollaborators'])->name('buques.saveCollaborators');
    Route::delete('/buques/colaborador/{id}', [BuquesController::class, 'deleteCollaborator'])->name('buques.deleteCollaborator');

    // Ruta para guardar observaciones

    Route::post('/buques/{buque}/sistemas-equipos/{equipo}/save-observations', [BuquesController::class, 'saveObservations']);



    Route::put('/buques/{buque}/sistemas-equipos/{equipo}/mec', [BuquesController::class, 'updateMec']);
    Route::post('/buques/{buque}/sistemas-equipos/{equipo}/save-observations', [BuquesController::class, 'saveObservations']);


    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    
    Route::get('/acceder-lsa/{buqueId}', [BuquesController::class, 'accederLSA'])->name('acceder.lsa');



});

