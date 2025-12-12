<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuqueController;
use App\Http\Controllers\SistemaController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Ruta para obtener el usuario autenticado (requiere autenticación con Sanctum)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Ruta para obtener las misiones relacionadas a un buque
Route::get('/buques/{buque}/misiones', [BuqueController::class, 'getMisiones']);
Route::get('/api/sistemas/by-codigo', [SistemaController::class, 'getByCodigo']);