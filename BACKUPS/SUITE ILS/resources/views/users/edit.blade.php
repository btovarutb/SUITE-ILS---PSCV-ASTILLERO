<!-- resources/views/users/edit.blade.php -->

<x-app-layout>
    <div class="container mx-auto px-20 py-5">
        <div class="px-2 sm:px-4">
            @section('title', 'Editar Usuario')
            <div class="container mx-auto px-4 py-8 sm:px-20">
                <div class="px-2 sm:px-4">
                    <h1 class="text-2xl font-bold mb-2 sm:mb-0" style="font-family: 'Inter', sans-serif;">Editar Usuario</h1>
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-input mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-input mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                            <select name="role" id="role" class="form-select mt-1 block w-full" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $user->roles->first()->name == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
