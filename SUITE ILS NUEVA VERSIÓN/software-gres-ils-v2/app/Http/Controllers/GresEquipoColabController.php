<?php

namespace App\Http\Controllers;

use App\Models\GresEquipoColab;
use Illuminate\Http\Request;

class GresEquipoColabController extends Controller
{
    /**
     * Obtiene todos los colaboradores de equipos de un buque.
     */
    public function index($buqueId)
    {
        $colaboradores = GresEquipoColab::where('buque_id', $buqueId)->get();
        return response()->json(['colaboradores' => $colaboradores]);
    }

    /**
     * Obtiene un colaborador específico.
     */
    public function show($buqueId, $id)
    {
        $colaborador = GresEquipoColab::where('buque_id', $buqueId)
            ->where('id', $id)
            ->first();

        if (!$colaborador) {
            return response()->json(['message' => 'Colaborador no encontrado'], 404);
        }

        return response()->json($colaborador);
    }

    /**
     * Crea un nuevo colaborador.
     */
    public function store(Request $request)
    {
        $request->validate([
            'buque_id' => 'required|exists:buques,id',
            'cargo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'entidad' => 'required|string|max:255',
        ]);

        $colaborador = GresEquipoColab::create($request->all());
        return response()->json($colaborador, 201);
    }

    /**
     * Actualiza un colaborador existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cargo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'entidad' => 'required|string|max:255',
        ]);

        $colaborador = GresEquipoColab::find($id);
        if (!$colaborador) {
            return response()->json(['message' => 'Colaborador no encontrado'], 404);
        }

        $colaborador->update($request->all());
        return response()->json($colaborador);
    }

    /**
     * Elimina un colaborador.
     */
    public function destroy($id)
    {
        $colaborador = GresEquipoColab::find($id);
        if (!$colaborador) {
            return response()->json(['message' => 'Colaborador no encontrado'], 404);
        }

        $colaborador->delete();
        return response()->json(null, 204);
    }
} 