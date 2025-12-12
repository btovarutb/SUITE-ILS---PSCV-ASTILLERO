<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\BuqueController;
use App\Http\Controllers\MisionController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\GresEquipoController;
use App\Http\Controllers\GresColabController;
use App\Http\Controllers\GresEquipoColabController;

// Redirigir la raíz a la ruta de inicio de sesión
Route::redirect('/', '/login');
Route::get('/api/sistemas', [SistemaController::class, 'getAllSistemas']);
Route::get('/api/sistemas/by-codigo', [SistemaController::class, 'getByCodigo']);

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
        Route::get('/buques/create', [BuqueController::class, 'create'])->name('buques.create');

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
    

        Route::post('/buques/{buque}/ciclo-operacional', [BuqueController::class, 'saveCicloOperacional'])
        ->name('buques.saveCicloOperacional');//un form

        Route::post('/buques/{buque}/guardar-todo', [BuqueController::class, 'guardarMisionesYCiclo'])
        ->name('buques.misionesYciclo.store');


        # Rutas de gestión de GRES Sistemas
        Route::get('/buques/{buque}/mod_gres', [BuqueController::class, 'modGres'])->name('buques.mod_gres');
        Route::post('/gres/save', [BuqueController::class, 'saveGresSistema'])->name('gres.save');
        Route::get('/gres/sistemas/{buqueId}/gres', [BuqueController::class, 'getSistemasGres'])
            ->name('gres.sistemas');


        #Rutas de gestión de FUA
        Route::get('/buques/{buque}/mod_fua', [BuqueController::class, 'modFua'])->name('buques.mod_fua');



        Route::get('/buques/{buque}/sistemas', [BuqueController::class, 'sistemas'])->name('buques.sistemas');

        Route::delete('/gres/observations/clear/{systemId}', [BuqueController::class, 'clearObservations'])->name('gres.clearObservations');

        Route::post('/gres/export-pdf', [BuqueController::class, 'exportPdf'])->name('gres.export-pdf');

        Route::get('/gres/colaboradores/{buqueId}', [GresColabController::class, 'index']);
        Route::get('/gres/colaboradores/{buqueId}/{id}', [GresColabController::class, 'show']);
        Route::post('/gres/colaboradores', [GresColabController::class, 'store']);
        Route::put('/gres/colaboradores/{id}', [GresColabController::class, 'update']);
        Route::delete('/gres/colaboradores/{id}', [GresColabController::class, 'destroy']);


        # Rutas de gestión de GRES Equipos
        Route::get('/buques/{buque}/mod_gres_equipo', [BuqueController::class, 'modGresEquipo'])
        ->name('buques.mod_gres_equipo');

        // Rutas de gestión de misiones
        Route::get('/misiones', [MisionController::class, 'index'])->name('misiones.index'); // Vista principal
        Route::post('/misiones', [MisionController::class, 'store'])->name('misiones.store'); // Crear misión
        Route::put('/misiones/{mision}', [MisionController::class, 'update'])->name('misiones.update'); // Actualizar misión
        Route::delete('/misiones/{mision}', [MisionController::class, 'destroy'])->name('misiones.destroy'); // Eliminar misión
        Route::get('/misiones/{mision}', [MisionController::class, 'show'])->name('misiones.show'); // Mostrar misión específica

        // Rutas de gestión de equipos
        Route::get('/equipos/{id}', [EquipoController::class, 'show'])->name('equipos.show');
        Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');
        Route::get('/sistemas/{sistemaId}/equipos', [EquipoController::class, 'getBySistema'])->name('equipos.bySistema');
        Route::put('/equipos/{id}', [EquipoController::class, 'update'])->name('equipos.update');
        Route::delete('/equipos/{id}', [EquipoController::class, 'destroy'])->name('equipos.destroy');


        Route::get('/lsa/{buque}', [BuqueController::class, 'LSA'])->name('lsa');
        Route::get('/acceder-lsa/{buqueId}', [BuqueController::class, 'accederLSA'])->name('acceder.lsa');
    
        Route::post('/buques/{id}/gres-equipo', [BuqueController::class, 'saveGresEquipo'])->name('buque.gres-equipo.store');

        Route::post('/gres/equipos/export-pdf', [GresEquipoController::class, 'exportPdf'])->name('gres.equipos.export-pdf');
    
        // Rutas para colaboradores de equipos
        Route::get('/gres/equipos/colaboradores/{buqueId}', [GresEquipoColabController::class, 'index']);
        Route::get('/gres/equipos/colaboradores/{buqueId}/{id}', [GresEquipoColabController::class, 'show']);
        Route::post('/gres/equipos/colaboradores', [GresEquipoColabController::class, 'store']);
        Route::put('/gres/equipos/colaboradores/{id}', [GresEquipoColabController::class, 'update']);
        Route::delete('/gres/equipos/colaboradores/{id}', [GresEquipoColabController::class, 'destroy']);

        // Rutas para colaboradores de equipos
        Route::get('/gres/equipos-colab/{buqueId}', [GresEquipoColabController::class, 'index']);
        Route::get('/gres/equipos-colab/{buqueId}/{id}', [GresEquipoColabController::class, 'show']);
        Route::post('/gres/equipos-colab', [GresEquipoColabController::class, 'store']);
        Route::put('/gres/equipos-colab/{id}', [GresEquipoColabController::class, 'update']);
        Route::delete('/gres/equipos-colab/{id}', [GresEquipoColabController::class, 'destroy']);
    });

    Route::middleware(['role:admin'])->get('/admin-test', function () {
        return 'Bienvenido, Administrador';
    });
});
