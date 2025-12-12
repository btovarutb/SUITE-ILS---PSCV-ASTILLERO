<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Sistemas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Sistemas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto py-8 px-6">
            <!-- Botones de los grupos constructivos -->
            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-7 gap-4 mb-6">
                @foreach ($grupos as $grupo)
                    <button
                        onclick="fetchSistemasByGrupo({{ $grupo->id }})"
                        class="bg-gray-200 hover:bg-blue-500 text-gray-700 hover:text-white px-4 py-2 rounded shadow">
                        {{ $grupo->codigo }} - {{ $grupo->nombre }}
                    </button>
                @endforeach
            </div>

            <!-- Botón para crear un nuevo sistema -->
            <div class="flex justify-between mb-6">
                <button onclick="showCreateSistemaModal()" class="bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600 focus:outline-none">
                    Crear Nuevo Sistema
                </button>
            </div>

            <!-- Lista de sistemas -->
            <div id="sistemas-container" class="overflow-x-auto bg-white rounded shadow p-4">
                <h3 class="text-gray-800 text-lg font-bold">Sistemas en el Grupo</h3>
                <p id="no-sistemas" class="text-gray-500">Seleccione un grupo para ver sus sistemas.</p>
                <ul id="sistemas-list" class="list-disc pl-5 hidden"></ul>
            </div>
        </div>
    </div>

    <script>
        let currentGrupoId = null;

        // Función para obtener sistemas por grupo
        function fetchSistemasByGrupo(grupoId) {
            currentGrupoId = grupoId; // Almacenar el grupo actual seleccionado
            fetch(`/grupos/${grupoId}/sistemas`)
                .then(response => response.json())
                .then(data => {
                    const sistemasList = document.getElementById('sistemas-list');
                    const noSistemas = document.getElementById('no-sistemas');
                    sistemasList.innerHTML = ''; // Limpiar la lista

                    if (data.length > 0) {
                        sistemasList.classList.remove('hidden');
                        noSistemas.classList.add('hidden');
                        data.forEach(sistema => {
                            const li = document.createElement('li');
                            li.innerHTML = `
                                ${sistema.codigo} - ${sistema.nombre}
                                <button onclick="showEditSistemaModal(${sistema.id})" class="bg-blue-500 text-white px-3 py-1 rounded shadow hover:bg-blue-600 focus:outline-none ml-2">
                                    Editar
                                </button>
                                <button onclick="showDeleteConfirmation(${sistema.id})" class="bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600 focus:outline-none ml-2">
                                    Eliminar
                                </button>
                            `;
                            sistemasList.appendChild(li);
                        });
                    } else {
                        sistemasList.classList.add('hidden');
                        noSistemas.classList.remove('hidden');
                        noSistemas.textContent = 'No hay sistemas creados en este grupo.';
                    }
                })
                .catch(error => console.error('Error al obtener sistemas:', error));
        }

        // Función para mostrar el modal de creación de sistemas
        function showCreateSistemaModal() {
            if (!currentGrupoId) {
                Swal.fire('Atención', 'Por favor, seleccione un grupo constructivo primero.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Crear Nuevo Sistema',
                html: `
                    <form id="createSistemaForm" class="text-left">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Código (máximo 3 dígitos)</label>
                            <input type="text" id="codigo" name="codigo" maxlength="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Descripción (opcional)</label>
                            <textarea id="descripcion" name="descripcion" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm"></textarea>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                focusConfirm: false,
                preConfirm: () => {
                    const form = document.getElementById('createSistemaForm');
                    const formData = new FormData(form);

                    return fetch(`/sistemas`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            codigo: formData.get('codigo'),
                            nombre: formData.get('nombre'),
                            descripcion: formData.get('descripcion'),
                            grupo_constructivo_id: currentGrupoId,
                        }),
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Error al crear sistema');
                            return response.json();
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Error: ${error.message}`);
                        });
                }
            }).then(result => {
                if (result.isConfirmed) {
                    Swal.fire('¡Éxito!', 'Sistema creado correctamente.', 'success')
                        .then(() => fetchSistemasByGrupo(currentGrupoId)); // Actualizar lista de sistemas
                }
            });
        }

        // Función para mostrar el modal de edición de sistemas
        function showEditSistemaModal(sistemaId) {
            fetch(`/sistemas/${sistemaId}`)
                .then(response => response.json())
                .then(sistema => {
                    Swal.fire({
                        title: 'Editar Sistema',
                        html: `
                            <form id="editSistemaForm" class="text-left">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Código</label>
                                    <input type="text" id="edit-codigo" name="codigo" value="${sistema.codigo}" maxlength="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                                    <input type="text" id="edit-nombre" name="nombre" value="${sistema.nombre}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea id="edit-descripcion" name="descripcion" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded shadow-sm">${sistema.descripcion || ''}</textarea>
                                </div>
                            </form>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Guardar Cambios',
                        cancelButtonText: 'Cancelar',
                        preConfirm: () => {
                            const codigo = document.getElementById('edit-codigo').value;
                            const nombre = document.getElementById('edit-nombre').value;
                            const descripcion = document.getElementById('edit-descripcion').value;

                            return fetch(`/sistemas/${sistema.id}`, {
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({ codigo, nombre, descripcion }),
                            })
                                .then(response => {
                                    if (!response.ok) throw new Error('Error al actualizar sistema');
                                    return response.json();
                                })
                                .catch(error => Swal.showValidationMessage(`Error: ${error.message}`));
                        }
                    }).then(result => {
                        if (result.isConfirmed) {
                            Swal.fire('¡Éxito!', 'Sistema actualizado correctamente.', 'success')
                                .then(() => fetchSistemasByGrupo(currentGrupoId));
                        }
                    });
                })
                .catch(error => Swal.fire('Error', 'No se pudo cargar el sistema.', 'error'));
        }

        // Función para mostrar confirmación de eliminación
        function showDeleteConfirmation(sistemaId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`/sistemas/${sistemaId}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Error al eliminar sistema');
                            Swal.fire('¡Eliminado!', 'Sistema eliminado correctamente.', 'success')
                                .then(() => fetchSistemasByGrupo(currentGrupoId));
                        })
                        .catch(error => Swal.fire('Error', 'No se pudo eliminar el sistema.', 'error'));
                }
            });
        }
    </script>
</x-app-layout>
</body>
</html>
