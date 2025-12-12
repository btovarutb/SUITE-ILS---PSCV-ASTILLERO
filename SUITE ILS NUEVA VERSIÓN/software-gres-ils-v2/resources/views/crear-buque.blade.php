<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Embarcación</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Embarcación') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto py-8 px-6">
            <!-- Pestañas de navegación -->
            <div class="grid grid-cols-5 gap-4 mb-6">
                <button onclick="showTab('datos-basicos')" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 focus:outline-none">
                    Datos Básicos
                </button>
                <button onclick="showTab('ciclo-operacional')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded shadow hover:bg-blue-500 hover:text-white focus:outline-none">
                    Ciclo Operacional
                </button>
                <button onclick="showTab('misiones')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded shadow hover:bg-blue-500 hover:text-white focus:outline-none">
                    Misiones
                </button>
                <button onclick="showTab('sistemas')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded shadow hover:bg-blue-500 hover:text-white focus:outline-none">
                    Sistemas
                </button>
                <button onclick="showTab('equipos')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded shadow hover:bg-blue-500 hover:text-white focus:outline-none">
                    Equipos
                </button>
            </div>

            <!-- Datos Básicos -->
            <div id="datos-basicos" class="tab-content">
                <form action="{{ route('buques.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="nombre">Nombre del Proyecto o Buque:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div>
                        <label for="tipo">Tipo de Buque:</label>
                        <input type="text" id="tipo" name="tipo" required>
                    </div>
                    <div>
                        <label for="descripcion">Descripción del Proyecto:</label>
                        <textarea id="descripcion" name="descripcion"></textarea>
                    </div>
                    <div>
                        <label for="autonomia_horas">Autonomía en Horas:</label>
                        <input type="number" id="autonomia_horas" name="autonomia_horas" required>
                    </div>
                    <div>
                        <label for="vida_diseno_anios">Vida de Diseño en Años:</label>
                        <input type="number" id="vida_diseno_anios" name="vida_diseno_anios" required>
                    </div>
                    <div>
                        <label for="horas_navegacion_anio">Horas de Navegación por Año:</label>
                        <input type="number" id="horas_navegacion_anio" name="horas_navegacion_anio" required>
                    </div>
                    <div>
                        <label for="imagen">Imagen del Buque:</label>
                        <input type="file" id="imagen" name="imagen">
                    </div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 mt-4 rounded shadow hover:bg-green-600">
                        Guardar Datos Básicos
                    </button>
                </form>
            </div>

            <!-- Ciclo Operacional -->
            <div id="ciclo-operacional" class="tab-content hidden">
                <div class="flex items-center space-x-8">
                    <div class="w-1/2 bg-white p-4 rounded shadow">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Misiones Disponibles</h3>
                        <ul id="availableMissions" class="space-y-2">
                            @foreach ($misiones as $mision)
                                <li>
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" class="mission-checkbox" value="{{ $mision->id }}">
                                        <span>{{ $mision->nombre }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="w-1/2 bg-white p-4 rounded shadow">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Misiones Seleccionadas</h3>
                        <ul id="selectedMissions" class="space-y-2">
                            <!-- Aquí se añadirán las misiones seleccionadas -->
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Misiones -->
            <div id="misiones" class="tab-content hidden">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Misiones Asignadas</h3>
                <form action="{{ route('buques.misiones.store') }}" method="POST">
                    @csrf
                    <div class="overflow-x-auto bg-white p-4 rounded shadow">
                        <table class="table-auto w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Misión</th>
                                <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Porcentaje (%)</th>
                                <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Descripción</th>
                            </tr>
                            </thead>
                            <tbody id="missionsTableBody">
                            <!-- Las misiones seleccionadas aparecerán aquí -->
                            </tbody>

                            <!-- Fila de total -->
                            <tr class="bg-gray-200 font-bold">
                                <td class="text-right pr-4">Total:</td>
                                <td id="totalPorcentaje" class="text-center">0%</td>
                                <td></td> <!-- Celda vacía para mantener alineación -->
                            </tr>
                        </table>
                    </div>

                    <!-- Botón de guardar -->
                    <button id="guardarMisionesBtn" type="submit" class="bg-green-500 text-white px-4 py-2 mt-4 rounded shadow hover:bg-green-600">
                        Guardar Misiones
                    </button>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function showTab(tabId) {
                document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
                document.getElementById(tabId).classList.remove('hidden');
            }

            const availableMissions = document.getElementById('availableMissions');
            const selectedMissions = document.getElementById('selectedMissions');
            const missionsTableBody = document.getElementById('missionsTableBody');
            const guardarMisionesBtn = document.querySelector('button[type="submit"]'); // Botón de guardar misiones

            function updateMissionsTable() {
                missionsTableBody.innerHTML = '';

                selectedMissions.querySelectorAll('.mission-checkbox').forEach(checkbox => {
                    const missionName = checkbox.nextElementSibling.textContent;
                    const missionId = checkbox.value;

                    const row = `
                <tr>
                    <td class="border border-gray-300 px-4 py-2">${missionName}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <input type="number" name="misiones[${missionId}][porcentaje]"
                               class="porcentaje-mision w-full border-gray-300 rounded px-2 py-1"
                               min="0" max="100" value="0">
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        <textarea name="misiones[${missionId}][descripcion]" class="w-full border-gray-300 rounded px-2 py-1"></textarea>
                    </td>
                </tr>
            `;

                    missionsTableBody.insertAdjacentHTML('beforeend', row);
                });

                // Agregar fila de total
                missionsTableBody.insertAdjacentHTML('beforeend', `
            <tr class="bg-gray-200 font-bold">
                <td class="text-right pr-4">Total:</td>
                <td id="totalPorcentaje" class="text-center">0%</td>
                <td></td> <!-- Celda vacía para mantener alineación -->
            </tr>
        `);

                // Agregar eventos a los inputs para actualizar la sumatoria en tiempo real
                missionsTableBody.querySelectorAll('.porcentaje-mision').forEach(input => {
                    input.addEventListener('input', actualizarSumatoria);
                });

                // Inicializar la sumatoria
                actualizarSumatoria();
            }

            function actualizarSumatoria() {
                let total = 0;
                const totalPorcentajeCell = document.getElementById('totalPorcentaje');

                missionsTableBody.querySelectorAll('.porcentaje-mision').forEach(input => {
                    let valor = parseInt(input.value) || 0; // Si está vacío, toma 0
                    total += valor;
                });

                totalPorcentajeCell.textContent = total + '%'; // Mostrar la suma en la celda

                // Si la sumatoria supera el 100%, deshabilitar el botón de guardar y marcar en rojo
                if (total > 100) {
                    totalPorcentajeCell.classList.add('text-red-600', 'font-bold');
                    guardarMisionesBtn.disabled = true;
                    guardarMisionesBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                } else {
                    totalPorcentajeCell.classList.remove('text-red-600', 'font-bold');
                    guardarMisionesBtn.disabled = false;
                    guardarMisionesBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                }
            }

            // Manejar la selección de misiones y actualizar la tabla
            availableMissions.addEventListener('change', (event) => {
                if (event.target.classList.contains('mission-checkbox')) {
                    if (event.target.checked) {
                        const li = event.target.closest('li');
                        selectedMissions.appendChild(li);
                        updateMissionsTable();
                    }
                }
            });
        });
    </script>

</x-app-layout>
</body>
</html>
