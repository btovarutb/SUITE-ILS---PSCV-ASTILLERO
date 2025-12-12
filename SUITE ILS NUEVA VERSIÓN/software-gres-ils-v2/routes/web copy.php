<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\BuqueController;
use App\Http\Controllers\MisionController;

// Redirigir la raíz a la ruta de inicio de sesión
Route::redirect('/', '/login');


// Rutas para usuarios autenticados
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas para el administrador
    Route::middleware(['role:admin'])->group(function () {
        // Rutas de gestión de buques
        Route::get('/buques', [BuqueController::class, 'index'])->name('buques.index'); // Vista principal
        Route::post('/buques', [BuqueController::class, 'store'])->name('buques.store'); // Guardar buque
        Route::get('/buques/{buque}/edit', [BuqueController::class, 'edit'])->name('buques.edit'); // Editar buque
        Route::put('/buques/{buque}', [BuqueController::class, 'update'])->name('buques.update'); // Actualizar datos básicos del buque
        Route::post('/buques/{buque}/misiones', [BuqueController::class, 'saveMisiones'])->name('buques.misiones.store'); // Guardar misiones asociadas al buque
        Route::delete('/buques/{buque}', [BuqueController::class, 'destroy'])->name('buques.destroy'); // Eliminar buque
        Route::get('/dashboard', [BuqueController::class, 'dashboard'])->name('dashboard');
        Route::get('/{buque}/modulos', [BuqueController::class, 'modulos'])->name('buques.modulos');

        // Rutas de gestión de usuarios
        Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('usuarios.show');
        Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('usuarios.destroy');

        // Rutas de gestión de sistemas
        Route::get('/sistemas', [SistemaController::class, 'index'])->name('sistemas.index'); // Vista principal
        Route::get('/grupos/{grupoId}/sistemas', [SistemaController::class, 'getSistemasByGrupo'])->name('sistemas.byGrupo'); // Sistemas por grupo
        Route::post('/sistemas', [SistemaController::class, 'store'])->name('sistemas.store'); // Crear sistema
        Route::put('/sistemas/{sistema}', [SistemaController::class, 'update'])->name('sistemas.update'); // Actualizar sistema
        Route::delete('/sistemas/{sistema}', [SistemaController::class, 'destroy'])->name('sistemas.destroy'); // Eliminar sistema
        Route::get('/sistemas/{sistema}', [SistemaController::class, 'show'])->name('sistemas.show'); // Mostrar detalles del sistema
        Route::post('/buques/{buque}/sistemas', [BuqueController::class, 'saveSistemas'])->name('buques.sistemas.store');
        Route::get('/buques/{buque}/mod_gres', [BuqueController::class, 'modGres'])->name('buques.mod_gres');
        Route::post('/gres/save', [BuqueController::class, 'saveGresSistema'])->name('gres.save');
        Route::get('/gres/sistemas/{buqueId}/gres', [BuqueController::class, 'getSistemasGres'])
            ->name('gres.sistemas');
        Route::get('/buques/{buque}/sistemas', [BuqueController::class, 'sistemas'])->name('buques.sistemas');

        Route::delete('/gres/observations/clear/{systemId}', [BuqueController::class, 'clearObservations'])->name('gres.clearObservations');



        Route::post('/gres/export-pdf', [BuqueController::class, 'exportPdf'])
            ->name('gres.export-pdf');


        Route::get('/gres/colaboradores/{buqueId}', [BuqueController::class, 'getColaboradores']);
        Route::get('/gres/colaboradores/{buqueId}/{colaboradorId}', [BuqueController::class, 'getColaborador']);
        Route::post('/gres/colaboradores', [BuqueController::class, 'createColaborador']);
        Route::put('/gres/colaboradores/{colaboradorId}', [BuqueController::class, 'updateColaborador']);
        Route::delete('/gres/colaboradores/{colaboradorId}', [BuqueController::class, 'deleteColaborador']);


        // Rutas de gestión de misiones
        Route::get('/misiones', [MisionController::class, 'index'])->name('misiones.index'); // Vista principal
        Route::post('/misiones', [MisionController::class, 'store'])->name('misiones.store'); // Crear misión
        Route::put('/misiones/{mision}', [MisionController::class, 'update'])->name('misiones.update'); // Actualizar misión
        Route::delete('/misiones/{mision}', [MisionController::class, 'destroy'])->name('misiones.destroy'); // Eliminar misión
        Route::get('/misiones/{mision}', [MisionController::class, 'show'])->name('misiones.show'); // Mostrar misión específica

        Route::get('/lsa/{buque}', [BuqueController::class, 'LSA'])->name('lsa');
        Route::get('/acceder-lsa/{buqueId}', [BuquesController::class, 'accederLSA'])->name('acceder.lsa');
    });

    Route::middleware(['role:admin'])->get('/admin-test', function () {
        return 'Bienvenido, Administrador';
    });
});
