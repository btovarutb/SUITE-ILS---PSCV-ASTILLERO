<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('gestion-usuarios', compact('users'));
    }

    public function show(User $user)
    {
        // Retorna los datos del usuario con su rol en formato JSON
        return response()->json($user->load('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|string|in:admin,user',
        ]);

        $user = User::create([
            'nombres' => $validated['nombres'],
            'apellidos' => $validated['apellidos'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'role' => 'required|string|in:admin,user',
        ]);

        $userData = [
            'nombres' => $validated['nombres'],
            'apellidos' => $validated['apellidos'],
            'email' => $validated['email'],
        ];

        // Solo actualizar la contraseña si se proporciona
        if (!empty($validated['password'])) {
            $userData['password'] = bcrypt($validated['password']);
        }

        $user->update($userData);

        // Sincronizar roles si han cambiado
        if (!$user->hasRole($validated['role'])) {
            $user->syncRoles([$validated['role']]);
        }

        return response()->json([
            'message' => 'Usuario actualizado exitosamente',
            'user' => $user
        ]);
    }

    public function destroy(User $user)
    {
        // Prevenir la auto-eliminación
        if ($user->id === auth()->id()) {
            return response()->json([
                'message' => 'No puedes eliminar tu propio usuario.'
            ], 403);
        }

        // Eliminar roles y luego el usuario
        $user->syncRoles([]);
        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente'
        ]);
    }
}
