<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Misiones</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Misiones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto py-8 px-6">
            <!-- Header con botón y buscador -->
            <div class="flex justify-between items-center mb-6">
                <button onclick="showCreateMisionModal()" class="bg-blue-900 text-white px-4 py-2 rounded shadow hover:bg-blue-600 focus:outline-none">
                    Añadir Nueva Misión
                </button>
                <div class="relative">
                    <form method="GET" action="{{ route('misiones.index') }}">
                        <input type="text"
                               name="search"
                               placeholder="Buscar misiones..."
                               value="{{ request('search') }}"
                               class="w-64 px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="absolute right-3 top-2.5 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tabla de misiones -->
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700 w-1/4">Nombre</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700 w-2/3">Descripción</th>
                        <th class="border border-gray-300 px-4 py-2 text-center text-sm font-semibold text-gray-700 w-1/12">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($misiones as $mision)
                        <tr class="bg-white hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $mision->nombre }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $mision->descripcion }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center text-sm text-gray-700">
                                <div class="relative inline-block text-left" x-data="{ open: false }">
                                    <button @click="open = !open" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-md hover:bg-gray-50 focus:outline-none">
                                        Acciones
                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                         @click.away="open = false"
                                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                        <div class="py-1">
                                            <button onclick="showEditMisionModal({{ $mision->id }})"
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Editar
                                            </button>
                                            <button onclick="deleteMision({{ $mision->id }})"
                                                    class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                                                Eliminar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border border-gray-300 px-4 py-2 text-center text-gray-500">No se encontraron misiones.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($misiones->hasPages())
                <div class="mt-4">
                    {{ $misiones->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function showEditMisionModal(misionId) {
            fetch(`/misiones/${misionId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Error al cargar la misión');
                    return response.json();
                })
                .then(mision => {
                    Swal.fire({
                        title: 'Editar Misión',
                        html: `
                    <form id="editMisionForm" class="text-left">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" id="edit_nombre" name="nombre" value="${mision.nombre}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Descripción</label>
                            <textarea id="edit_descripcion" name="descripcion" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm">${mision.descripcion || ''}</textarea>
                        </div>
                    </form>
                `,
                        showCancelButton: true,
                        confirmButtonText: 'Guardar',
                        cancelButtonText: 'Cancelar',
                        preConfirm: () => {
                            const form = document.getElementById('editMisionForm');
                            const formData = new FormData(form);

                            return fetch(`/misiones/${misionId}`, {
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    nombre: formData.get('nombre'),
                                    descripcion: formData.get('descripcion'),
                                }),
                            })
                                .then(response => {
                                    if (!response.ok) throw new Error('Error al actualizar misión');
                                    return response.json();
                                })
                                .catch(error => Swal.showValidationMessage(`Error: ${error.message}`));
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire('¡Éxito!', 'Misión actualizada correctamente.', 'success').then(() => location.reload());
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'No se pudo cargar la misión.', 'error');
                });
        }

        function showCreateMisionModal() {
            Swal.fire({
                title: 'Añadir Nueva Misión',
                html: `
                    <form id="createMisionForm" class="text-left">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm"></textarea>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const form = document.getElementById('createMisionForm');
                    const formData = new FormData(form);

                    return fetch(`/misiones`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(Object.fromEntries(formData)),
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Error al crear misión');
                            return response.json();
                        })
                        .catch(error => Swal.showValidationMessage(`Error: ${error.message}`));
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('¡Éxito!', 'Misión creada correctamente.', 'success').then(() => location.reload());
                }
            });
        }

        function deleteMision(id) {
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/misiones/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Error al eliminar misión');
                            Swal.fire('¡Eliminada!', 'La misión ha sido eliminada.', 'success').then(() => location.reload());
                        })
                        .catch(error => Swal.fire('Error', 'No se pudo eliminar la misión.', 'error'));
                }
            });
        }
    </script>
</x-app-layout>
</body>
</html>
