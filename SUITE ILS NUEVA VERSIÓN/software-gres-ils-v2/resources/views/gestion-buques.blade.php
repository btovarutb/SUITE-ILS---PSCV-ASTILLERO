<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Buques | Suite ILS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
<x-app-layout>
    <x-slot name="header">
        <span class="font-bold mt-0 text-center text-azulCotecmar" style=" font-size: 1.5rem;">
            Gestión de Buques
        </span>
    </x-slot>


    <div class="py-0">
        <div class="container mx-auto" style="padding-left: 2rem; padding-right: 2rem; padding-top: 10px;">
            <!-- Header con botón y buscador -->
            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('buques.create') }}"
                class="bg-blue-900 text-white text-sm px-4 py-2 rounded shadow hover:bg-blue-600 focus:outline-none">
                    Nueva Embarcación
                </a>

                <div class="relative">
                    <input type="text" id="searchInput"
                           placeholder="Buscar buques..."
                           class="w-64 px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    <span class="absolute right-3 top-2.5 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Tabla de buques -->
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Nombre del Buque</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Tipo</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Etapa de Vida</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Descripción</th>
                        <th class="border border-gray-300 px-4 py-2 text-center text-sm font-semibold text-gray-700">Acciones</th>
                    </tr>
                    </thead>
                    <tbody id="buquesTableBody">
                    @foreach ($buques as $buque)
                        <tr class="bg-white hover:bg-gray-100" id="buque-row-{{ $buque->id }}">
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $buque->nombre }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $buque->tipo }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700 text-center">
                                <div class="inline-block bg-gray-800 text-white text-xs px-3 py-1 rounded text-center w-40">
                                    {{ $buque->etapa }}
                                </div>
                            </td>

                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $buque->descripcion }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center text-sm text-gray-700 relative">
                                <div class="relative inline-block text-left"
                                     x-data="{ open: false, position: 'bottom', x: 0, y: 0 }"
                                     x-init="document.addEventListener('click', (event) => {
             if (!$el.contains(event.target)) open = false;
         })"
                                     @open-menu.window="if ($event.detail !== $el) open = false">

                                    <button @click="if (open) { open = false; }
                        else {
                            $dispatch('open-menu', $el);
                            open = true;
                            $nextTick(() => {
                                let rect = $el.getBoundingClientRect();
                                position = (window.innerHeight - rect.bottom < 120) ? 'top' : 'bottom';
                                x = rect.left;
                                y = position === 'top' ? rect.top - 120 : rect.bottom;
                            });
                        }"
                                            class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-md hover:bg-gray-50 focus:outline-none">
                                        Acciones
                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                         class="fixed w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 p-2"
                                         :style="'top: ' + y + 'px; left: ' + x + 'px;'">
                                        <a href="{{ route('buques.edit', $buque->id) }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Editar
                                        </a>
                                        <a href="{{ route('buques.sistemas', $buque->id) }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Sistemas
                                        </a>
                                        <button onclick="deleteBuque({{ $buque->id }}, '{{ $buque->nombre }}')"
                                                class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para crear nueva embarcación -->
    <div id="crearBuqueModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
            <h2 class="text-lg font-bold mb-4">Crear Nueva Embarcación</h2>
            <form id="crearBuqueForm" action="{{ route('buques.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Buque:</label>
                    <input type="text" id="nombre" name="nombre" required class="w-full border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de Buque:</label>
                    <input type="text" id="tipo" name="tipo" required class="w-full border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" class="w-full border-gray-300 rounded"></textarea>
                </div>
                <div class="mb-4">
                    <label for="etapa" class="block text-sm font-medium text-gray-700">Etapa de Vida:</label>
                    <select id="etapa" name="etapa" class="w-full border-gray-300 rounded">
                        <option value="Fase de Diseño">Fase de Diseño</option>
                        <option value="Fase de Construcción">Fase de Construcción</option>
                        <option value="Fase de Operación" selected>Fase de Operación</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="autonomia_horas" class="block text-sm font-medium text-gray-700">Autonomía (horas):</label>
                    <input type="number" id="autonomia_horas" name="autonomia_horas" required class="w-full border-gray-300 rounded" min="1" step="1">
                </div>
                <div class="mb-4">
                    <label for="vida_diseno_anios" class="block text-sm font-medium text-gray-700">Vida de Diseño (años):</label>
                    <input type="number" id="vida_diseno_anios" name="vida_diseno_anios" required class="w-full border-gray-300 rounded" min="1" step="1">
                </div>
                <div class="mb-4">
                    <label for="horas_navegacion_anio" class="block text-sm font-medium text-gray-700">Horas de Navegación (año):</label>
                    <input type="number" id="horas_navegacion_anio" name="horas_navegacion_anio" required class="w-full border-gray-300 rounded" min="1" step="1">
                </div>
                <div class="mb-4">
                    <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" class="w-full border-gray-300 rounded">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="cerrarModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Crear</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function abrirModal() {
            document.getElementById('crearBuqueModal').classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('crearBuqueModal').classList.add('hidden');
        }

        function deleteBuque(id, nombre) {
            Swal.fire({
                title: '<div class="text-left"><span class="text-base font-semibold text-red-500">Eliminar Proyecto</span><hr class="mt-1 border-gray-300"></div>',
                html: `<p class="text-sm text-gray-600">¿Estás seguro de querer borrar este proyecto?</p><p class="text-base font-semibold text-gray-800 mt-1">${nombre}</p><div class="mt-4 flex justify-center space-x-2"><button id="confirmDeleteButton" class="bg-red-500 text-white px-4 py-2 text-sm rounded shadow hover:bg-red-600">Eliminar ${nombre}</button><button id="cancelDeleteButton" class="bg-purple-300 text-white px-4 py-2 text-sm rounded shadow hover:bg-purple-400">Cancelar</button></div>`,
                showConfirmButton: false,
                showCancelButton: false,
                customClass: {
                    popup: 'rounded-lg shadow-lg max-w-md',
                    title: 'text-gray-800'
                },
                didOpen: () => {
                    document.getElementById('cancelDeleteButton').addEventListener('click', () => Swal.close());
                    document.getElementById('confirmDeleteButton').addEventListener('click', () => {
                        Swal.fire({
                            title: '<div class="text-left"><span class="text-base font-semibold text-red-500">Advertencia</span><hr class="mt-1 border-gray-300"></div>',
                            html: `<p class="text-sm text-gray-600">Esta acción es <strong>permanente</strong>. Se borrarán todas las relaciones de sistemas, equipos, misiones, anexos, etc.</p><p class="text-sm text-gray-600 mt-3">Para confirmar, escribe: <strong class="text-red-500">eliminar/${nombre}</strong></p><input type="text" id="confirmTextInput" class="swal2-input rounded-lg" placeholder="eliminar/${nombre}"><div class="mt-4 flex justify-center space-x-2"><button id="finalDeleteButton" disabled class="bg-gray-400 text-white px-4 py-2 text-sm rounded">Borrar embarcación</button><button id="finalCancelButton" class="bg-purple-300 text-white px-4 py-2 text-sm rounded shadow hover:bg-purple-400">Cancelar</button></div>`,
                            showConfirmButton: false,
                            showCancelButton: false,
                            customClass: {
                                popup: 'rounded-lg shadow-lg max-w-md',
                                title: 'text-red-500'
                            },
                            didOpen: () => {
                                const confirmTextInput = document.getElementById('confirmTextInput');
                                const finalDeleteButton = document.getElementById('finalDeleteButton');
                                const finalCancelButton = document.getElementById('finalCancelButton');
                                finalCancelButton.addEventListener('click', () => Swal.close());
                                confirmTextInput.addEventListener('input', (event) => {
                                    if (event.target.value === `eliminar/${nombre}`) {
                                        finalDeleteButton.classList.remove('bg-gray-400');
                                        finalDeleteButton.classList.add('bg-red-500', 'hover:bg-red-600');
                                        finalDeleteButton.disabled = false;
                                    } else {
                                        finalDeleteButton.classList.add('bg-gray-400');
                                        finalDeleteButton.classList.remove('bg-red-500', 'hover:bg-red-600');
                                        finalDeleteButton.disabled = true;
                                    }
                                });
                                finalDeleteButton.addEventListener('click', () => {
                                    fetch(`/buques/${id}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json'
                                        },
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                Swal.fire('¡Eliminado!', 'El buque ha sido eliminado correctamente.', 'success');
                                                const row = document.getElementById(`buque-row-${id}`);
                                                if (row) row.remove();
                                            } else {
                                                throw new Error(data.message || 'Error al eliminar el buque');
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            Swal.fire('Error', 'Hubo un problema al eliminar el buque', 'error');
                                        });
                                });
                            }
                        });
                    });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const camposNumericos = ['autonomia_horas', 'vida_diseno_anios', 'horas_navegacion_anio'];

            camposNumericos.forEach(id => {
                document.getElementById(id).addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, ''); // Solo permite números enteros positivos
                    if (this.value < 1) this.value = 1; // Evita negativos y cero
                });
            });

            // Función para filtrar buques por nombre
            const searchInput = document.getElementById('searchInput');
            const buquesTableBody = document.getElementById('buquesTableBody');

            searchInput.addEventListener('input', function() {
                const searchText = this.value.toLowerCase();
                const rows = buquesTableBody.getElementsByTagName('tr');

                for (let row of rows) {
                    const nombre = row.getElementsByTagName('td')[0].textContent.toLowerCase();
                    if (nombre.includes(searchText)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    </script>
</x-app-layout>
</body>
</html>
