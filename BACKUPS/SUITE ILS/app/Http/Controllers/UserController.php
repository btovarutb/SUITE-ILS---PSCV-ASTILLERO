<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->input('sort_field', 'name');
        $sortOrder = $request->input('sort_order', 'asc');

        $roles = Role::with(['users' => function ($query) use ($sortField, $sortOrder) {
            $query->orderBy($sortField, $sortOrder);
        }])->get();

        return view('users.index', compact('roles', 'sortField', 'sortOrder'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string|exists:roles,name'
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ]);

        $user->syncRoles([$request->input('role')]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }
}
