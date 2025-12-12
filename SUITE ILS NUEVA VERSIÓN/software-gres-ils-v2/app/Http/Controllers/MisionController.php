<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mision;

class MisionController extends Controller
{
    public function index(Request $request)
    {
        // Buscar por el término en el campo "nombre"
        $search = $request->input('search');

        $query = Mision::query();

        if ($search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        }

        // Paginación: limitar a 10 resultados por página
        $misiones = $query->paginate(10);

        // Retornar la vista con las misiones paginadas
        return view('gestion-misiones', compact('misiones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:misiones,nombre',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        Mision::create($validated);

        return response()->json(['message' => 'Misión creada exitosamente']);
    }

    public function show(Mision $mision)
    {
        return response()->json($mision);
    }

    public function update(Request $request, Mision $mision)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:misiones,nombre,' . $mision->id,
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $mision->update($validated);

        return response()->json(['message' => 'Misión actualizada exitosamente']);
    }

    public function destroy(Mision $mision)
    {
        $mision->delete();

        return response()->json(['message' => 'Misión eliminada exitosamente']);
    }
}
