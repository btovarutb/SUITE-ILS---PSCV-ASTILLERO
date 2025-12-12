<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto py-8 px-6">
            <!-- Botón para crear un nuevo usuario -->
            <div class="flex justify-between mb-6">
                <button onclick="showCreateUserModal()" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 focus:outline-none">
                    Crear Usuario
                </button>
            </div>

            <!-- Tabla de usuarios -->
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">#</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Nombre</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Apellido</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Rol</th>
                        <th class="border border-gray-300 px-4 py-2 text-center text-sm font-semibold text-gray-700">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr class="bg-white hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $loop->iteration }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $user->nombres }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $user->apellidos }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $user->email }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $user->getRoleNames()->join(', ') }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center text-sm text-gray-700">
                                <button onclick="showEditUserModal({{ $user->id }})" class="bg-yellow-500 text-white px-3 py-1 rounded shadow hover:bg-yellow-600 focus:outline-none mr-2">
                                    Editar
                                </button>
                                <button onclick="showDeleteConfirmation({{ $user->id }})" class="bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600 focus:outline-none">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function showCreateUserModal() {
            Swal.fire({
                title: 'Crear Usuario',
                html: `
                    <form id="createUserForm" class="text-left">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" id="nombres" name="nombres" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Apellido</label>
                            <input type="text" id="apellidos" name="apellidos" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                            <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Rol</label>
                            <select id="role" name="role" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Crear',
                cancelButtonText: 'Cancelar',
                focusConfirm: false,
                preConfirm: () => {
                    const form = document.getElementById('createUserForm');
                    const formData = new FormData(form);

                    return fetch('{{ route("usuarios.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(Object.fromEntries(formData))
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Error al crear usuario');
                            return response.json();
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Error: ${error}`);
                        });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('¡Éxito!', 'Usuario creado correctamente', 'success')
                        .then(() => {
                            window.location.reload();
                        });
                }
            });
        }

        async function showEditUserModal(userId) {
            try {
                const response = await fetch(`/usuarios/${userId}`);
                const user = await response.json();

                Swal.fire({
                    title: 'Editar Usuario',
                    html: `
                        <form id="editUserForm" class="text-left">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input type="text" id="edit_nombres" name="nombres" value="${user.nombres}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Apellido</label>
                                <input type="text" id="edit_apellidos" name="apellidos" value="${user.apellidos}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="edit_email" name="email" value="${user.email}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Contraseña (dejar en blanco para mantener)</label>
                                <input type="password" id="edit_password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Rol</label>
                                <select id="edit_role" name="role" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                                    <option value="admin" ${user.roles[0].name === 'admin' ? 'selected' : ''}>Admin</option>
                                    <option value="user" ${user.roles[0].name === 'user' ? 'selected' : ''}>User</option>
                                </select>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelButtonText: 'Cancelar',
                    focusConfirm: false,
                    preConfirm: () => {
                        const form = document.getElementById('editUserForm');
                        const formData = new FormData(form);

                        return fetch(`/usuarios/${userId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                ...Object.fromEntries(formData),
                                _method: 'PUT'
                            })
                        })
                            .then(response => {
                                if (!response.ok) throw new Error('Error al actualizar usuario');
                                return response.json();
                            })
                            .catch(error => {
                                Swal.showValidationMessage(`Error: ${error}`);
                            });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('¡Éxito!', 'Usuario actualizado correctamente', 'success')
                            .then(() => {
                                window.location.reload();
                            });
                    }
                });
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', 'No se pudo cargar la información del usuario', 'error');
            }
        }

        function showDeleteConfirmation(userId) {
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/usuarios/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Error al eliminar usuario');
                            Swal.fire(
                                '¡Eliminado!',
                                'El usuario ha sido eliminado.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error',
                                'No se pudo eliminar el usuario',
                                'error'
                            );
                        });
                }
            });
        }
    </script>
</x-app-layout>
</body>
</html>
