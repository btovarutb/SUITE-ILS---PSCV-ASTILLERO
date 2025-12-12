<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrupoConstructivo;
use App\Models\SistemaSuite;

class SistemaController extends Controller
{
    public function index()
    {
        $grupos = GrupoConstructivo::all();
        return view('gestion-sistemas', compact('grupos'));
    }

    public function getSistemasByGrupo($grupoId)
    {
        $sistemas = SistemaSuite::where('grupo_constructivo_id', $grupoId)->get();
        return response()->json($sistemas);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'grupo_constructivo_id' => 'required|exists:grupos_constructivos,id',
            'codigo' => 'required|string|max:3|unique:sistemas_suite,codigo',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        SistemaSuite::create($validated);

        return response()->json(['message' => 'Sistema creado exitosamente']);
    }

    public function update(Request $request, SistemaSuite $sistema)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:3|unique:sistemas_suite,codigo,' . $sistema->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $sistema->update($validated);

        return response()->json(['message' => 'Sistema actualizado exitosamente']);
    }

    public function destroy(SistemaSuite $sistema)
    {
        $sistema->delete();

        return response()->json(['message' => 'Sistema eliminado exitosamente']);
    }

    public function show(SistemaSuite $sistema)
    {
        return response()->json($sistema);
    }

    public function getAllSistemas()
    {
        $sistemas = \App\Models\SistemaSuite::all();
        return response()->json($sistemas);
    }

    public function getByCodigo(Request $request)
    {
        $codigo = $request->query('codigo');

        if (!$codigo || !is_string($codigo)) {
            return response()->json(['message' => 'Parámetro "codigo" es requerido'], 422);
        }

        $codigoNorm = mb_strtolower(trim($codigo));

        $sistema = SistemaSuite::whereRaw('LOWER(TRIM(codigo)) = ?', [$codigoNorm])->first();

        if (!$sistema) {
            return response()->json(['message' => 'Sistema no encontrado'], 404);
        }

        return response()->json([
            'id' => $sistema->id,
            'codigo' => $sistema->codigo,
            'nombre' => $sistema->nombre,
            'grupo_constructivo_id' => $sistema->grupo_constructivo_id,
        ]);
    }
}
