<!-- resources/views/buques/edit.blade.php -->
<x-app-layout>
    @section('title', 'Editar Buque')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Editar Buque</h1>
        <div x-data="tabData()" x-init="init()" class="bg-white shadow rounded-lg p-6">
            <!-- Pestañas -->
            <nav class="flex mb-4 space-x-2">
                <button type="button" @click="tab = 'datos_basicos'" :class="{'bg-blue-700 text-white': tab === 'datos_basicos', 'bg-gray-200 text-gray-700': tab !== 'datos_basicos'}" class="px-4 py-2 rounded flex items-center">
                    <i class="fas fa-ship mr-2"></i>
                    Datos Básicos
                </button>
                <button type="button" @click="tab = 'ciclo_operacional'" :class="{'bg-blue-700 text-white': tab === 'ciclo_operacional', 'bg-gray-200 text-gray-700': tab !== 'ciclo_operacional'}" class="px-4 py-2 flex rounded items-center">
                    <i class="fas fa-pencil-alt mr-2"></i>
                    Ciclo Operacional
                </button>
                <button type="button" @click="tab = 'misiones'" :class="{'bg-blue-700 text-white': tab === 'misiones', 'bg-gray-200 text-gray-700': tab !== 'misiones'}" class="px-4 py-2 rounded flex items-center">
                    <i class="fa-solid fa-tasks mr-2"></i>
                    Misiones
                </button>
                <button type="button" @click="tab = 'colaboradores'" :class="{'bg-blue-700 text-white': tab === 'colaboradores', 'bg-gray-200 text-gray-700': tab !== 'colaboradores'}" class="px-4 py-2 rounded flex items-center">
                    <i class="fa-solid fa-user-plus mr-2"></i>
                    Colaboradores
                </button>
                <button type="button" @click="tab = 'sistema_equipos'" :class="{'bg-blue-700 text-white': tab === 'sistema_equipos', 'bg-gray-200 text-gray-700': tab !== 'sistema_equipos'}" class="px-4 py-2 rounded flex items-center">
                    <i class="fas fa-cogs mr-2"></i>
                    Sistemas
                </button>
            </nav>

            <form action="{{ route('buques.update', $buque->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Campo oculto para enviar los sistemas al servidor -->
                <input type="hidden" name="sistemas_buque" :value="JSON.stringify(sistemasBuque)">

                <!-- Contenido de Datos Básicos -->
                <div x-show="tab === 'datos_basicos'">
                    <!-- Código de Datos Básicos -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="nombre_proyecto" class="block text-sm font-medium text-gray-700">Nombre del Proyecto o Buque</label>
                            <input type="text" name="nombre_proyecto" id="nombre_proyecto" value="{{ $buque->nombre_proyecto }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="tipo_buque" class="block text-sm font-medium text-gray-700">Tipo de Buque</label>
                            <input type="text" name="tipo_buque" id="tipo_buque" value="{{ $buque->tipo_buque }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="descripcion_proyecto" class="block text-sm font-medium text-gray-700">Descripción del Proyecto</label>
                            <textarea name="descripcion_proyecto" id="descripcion_proyecto" class="mt-1 block w-full h-24 border border-gray-300 rounded-md shadow-sm" maxlength="500" required>{{ $buque->descripcion_proyecto }}</textarea>
                        </div>
                        <!-- Campo de Autonomía en Horas -->
                        <div>
                            <label for="autonomia_horas" class="block text-sm font-medium text-gray-700">Autonomía en Horas</label>
                            <input type="number" name="autonomia_horas" id="autonomia_horas" value="{{ $buque->autonomia_horas }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <!-- Campo de Vida de Diseño -->
                        <div>
                            <label for="vida_diseño" class="block text-sm font-medium text-gray-700">Vida de Diseño en Años</label>
                            <input type="number" name="vida_diseno" id="vida_diseño" value="{{ $buque->vida_diseno }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <!-- Nuevo campo: Horas de Navegación por Año -->
                        <div>
                            <label for="horas_navegacion_anual" class="block text-sm font-medium text-gray-700">Horas de Navegación por Año</label>
                            <input type="number" name="horas_navegacion_anual" id="horas_navegacion_anual" value="{{ $buque->horas_navegacion_anual }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <!-- Campo de Imagen del Buque -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Imagen del Buque</label>
                            <input type="file" name="image" id="image" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                            <!-- Mostrar imagen actual si existe -->
                            @if($buque->image_path)
                                <img src="{{ asset('storage/' . $buque->image_path) }}" alt="Imagen del Buque" class="mt-2 h-32">
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Contenido de Misiones -->
                <div x-show="tab === 'misiones'">
                    <div class="mb-5 opacity-65">
                        <p><i class="fa-solid fa-circle-info text-gray-700"></i> Aquí puedes asignar porcentajes y descripciones a las misiones seleccionadas.</p>
                    </div>
                    <!-- Tabla de Misiones -->
                    <div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Misión</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Porcentaje (%)</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <template x-for="(mision, index) in misionesSeleccionadas" :key="index">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="mision"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <input type="number" x-model.number="misionesDetalles[index].porcentaje" min="0" max="100" class="w-20 border border-gray-300 rounded-md shadow-sm">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <input type="text" x-model="misionesDetalles[index].descripcion" class="w-full border border-gray-300 rounded-md shadow-sm">
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Total</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    <input type="text" :value="totalPorcentaje.toFixed(2)" readonly class="w-20 border border-gray-300 rounded-md shadow-sm bg-gray-100">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Campos ocultos para enviar los datos de misiones -->

                </div>

                <!-- Contenido de Colaboradores -->
                <div x-show="tab === 'colaboradores'">
                    <!-- Código de Colaboradores -->
                    <div class="mb-5 opacity-65">
                        <p><i class="fa-solid fa-circle-info text-gray-700"></i> Los colaboradores ingresados en esta sección son los mismos que aparecerán en los anexos generales exportados en PDF de los diferentes módulos.</p>
                    </div>
                    <div id="colaboradores-container" class="space-y-4 mb-4">
                        @foreach ($buque->colaboradores as $index => $colaborador)
                            <div id="colaborador-{{ $index }}" class="colaborador-item grid grid-cols-4 gap-4" data-index="{{ $index }}">
                                <div>
                                    <label for="col_cargo_{{ $index }}" class="block text-sm font-medium text-gray-700">Cargo</label>
                                    <input type="text" name="colaboradores[{{ $index }}][col_cargo]" id="col_cargo_{{ $index }}" value="{{ $colaborador->col_cargo }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                                </div>
                                <div>
                                    <label for="col_nombre_{{ $index }}" class="block text-sm font-medium text-gray-700">Nombres y Apellidos Completos</label>
                                    <input type="text" name="colaboradores[{{ $index }}][col_nombre]" id="col_nombre_{{ $index }}" value="{{ $colaborador->col_nombre }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                                </div>
                                <div>
                                    <label for="col_entidad_{{ $index }}" class="block text-sm font-medium text-gray-700">Entidad</label>
                                    <input type="text" name="colaboradores[{{ $index }}][col_entidad]" id="col_entidad_{{ $index }}" value="{{ $colaborador->col_entidad }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                                </div>
                                <div class="flex items-end">
                                    <button type="button" class="bg-red-700 text-white px-4 py-1 rounded remove-colaborador" data-id="{{ $colaborador->id }}" onclick="confirmarEliminarColaborador({{ $index }})">Eliminar</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="bg-blue-700 text-white px-4 py-2 rounded" onclick="agregarColaborador()">Agregar Colaborador</button>
                </div>

                <!-- Contenido de Sistemas -->
                <div x-show="tab === 'sistema_equipos'">
                    <!-- Código de Sistemas -->
                    <!-- Pestañas de sistemas -->
                    <nav class="flex mb-4 space-x-2">
                        @foreach (['100' => 'Casco y Estructuras', '200' => 'Maquinaria y Propulsión', '300' => 'Planta Eléctrica', '400' => 'Comando y Vigilancia', '500' => 'Sistemas Auxiliares', '600' => 'Acabados y Amoblamiento', '700' => 'Armamento'] as $grupo => $nombreGrupo)
                            <button type="button" @click="grupoTab = '{{ $grupo }}'"
                                    :class="{'bg-blue-700 text-white': grupoTab === '{{ $grupo }}', 'bg-gray-200 text-gray-700': grupoTab !== '{{ $grupo }}'}"
                                    class="px-4 py-2 rounded flex items-center">
                                <i class="mdi mdi-ferry mr-2 text-2xl"></i> {{ $grupo }} - {{ $nombreGrupo }}
                            </button>
                        @endforeach
                    </nav>

                    @foreach (['100', '200', '300', '400', '500', '600', '700'] as $grupo)
                        <div x-show="grupoTab === '{{ $grupo }}'">
                            <div class="mb-4">
                                <button type="button" @click="openCreateSistemaModal('{{ $grupo }}')" class="bg-green-500 text-white px-4 py-2 rounded">
                                    Crear Nuevo Sistema
                                </button>
                            </div>

                            <div>
                                <template x-if="sistemasBuque['{{ $grupo }}'] && sistemasBuque['{{ $grupo }}'].length > 0">
                                    <div>
                                        <h2 class="text-lg font-bold mb-2">Sistemas en el Grupo <span>{{ $grupo }}</span></h2>
                                        <ul class="list-disc pl-5 space-y-2">
                                            <template x-for="(sistema, index) in sistemasBuque['{{ $grupo }}']" :key="sistema.cj">
                                                <li class="flex items-center justify-between">
                                                    <span x-text="sistema.cj + ' - ' + sistema.nombre"></span>
                                                    <div class="space-x-2">
                                                        <button type="button" @click="openEditSistemaModal('{{ $grupo }}', index)"
                                                                class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</button>
                                                        <button type="button" @click="confirmarEliminarSistema('{{ $grupo }}', index)"
                                                                class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
                                                    </div>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </template>
                                <template x-if="!sistemasBuque['{{ $grupo }}'] || sistemasBuque['{{ $grupo }}'].length === 0">
                                    <p>No hay sistemas creados en este grupo.</p>
                                </template>
                            </div>
                        </div>
                    @endforeach

                    <!-- Modal para Crear o Editar Sistemas -->
                    <template x-if="showCreateSistemaModal">
                        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                <h2 class="text-xl font-bold mb-4" x-text="isEditing ? 'Editar Sistema' : 'Crear Nuevo Sistema'"></h2>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">CJ del Sistema (3 dígitos)</label>
                                    <div class="flex items-center space-x-2">
                                        <span class="font-bold text-lg" x-text="newSistema.grupo.charAt(0)"></span>
                                        <input type="text" x-model="newSistema.cjDigit1" maxlength="1"
                                               class="w-12 text-center border border-gray-300 rounded-md shadow-sm" placeholder="0" required>
                                        <input type="text" x-model="newSistema.cjDigit2" maxlength="1"
                                               class="w-12 text-center border border-gray-300 rounded-md shadow-sm" placeholder="0" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Nombre del Sistema</label>
                                    <input type="text" x-model="newSistema.nombre"
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Descripción (Opcional)</label>
                                    <textarea x-model="newSistema.descripcion"
                                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" @click="closeSistemaModal()" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancelar</button>
                                    <button type="button" @click="isEditing ? updateSistema() : createSistema()"
                                            class="bg-blue-700 text-white px-4 py-2 rounded"
                                            x-text="isEditing ? 'Guardar Cambios' : 'Crear'"></button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Contenido de Ciclo Operacional -->
                <div x-show="tab === 'ciclo_operacional'">
                    <!-- Información adicional -->
                    <div class="mb-5 opacity-65">
                        <p><i class="fa-solid fa-circle-info text-gray-700"></i> Misiones extraídas de Armada República de Colombia (ARC), "Doctrina de Material Naval. Tomo III. Mantenimiento. Segunda edición," Dirección de Doctrina Naval, Bogotá, D.C., Colombia, 2022.</p>
                    </div>

                    <!-- Sección Navegación -->
                    <div class="mb-4">
                        <h2 class="font-bold text-lg mb-2">Navegación</h2>
                        <!-- Misiones disponibles -->
                        <div class="ml-4">
                            <div class="grid grid-cols-3 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- Bucle x-for con clave única -->
                                <template x-for="(mision, index) in misionesDisponibles" :key="mision">
                                    <div class="flex items-center">
                                        <input type="checkbox" :value="mision" x-model="misionesSeleccionadas" class="mr-2">
                                        <label x-text="mision"></label>
                                    </div>
                                </template>
                                <!-- Botón para añadir nueva misión -->
                                <div>
                                    <button type="button" @click="agregarNuevaMision()" class="bg-blue-700 text-white px-4 py-2 rounded">
                                        Añadir nueva misión
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección Puerto Extranjero -->
                    <div class="mb-4">
                        <h2 class="font-bold text-lg mb-2">Puerto Extranjero</h2>
                        <div class="ml-4">
                            <!-- Checkbox: Puerto Extranjero -->
                            <div class="flex items-center mb-2">
                                <input type="checkbox" id="puerto_extranjero" x-model="puertoExtranjeroSeleccionado" class="mr-2">
                                <label for="puerto_extranjero" class="font-medium">Visita a Puerto Extranjero</label>
                            </div>
                            <!-- Mostrar input si Puerto Extranjero está seleccionado -->
                            <div x-show="puertoExtranjeroSeleccionado" class="ml-4">
                                <label for="tiempo_puerto_extranjero" class="block text-sm font-medium text-gray-700">Digite el tiempo en horas</label>
                                <input type="number" min="0" x-model.number="tiempoPuertoExtranjero" id="tiempo_puerto_extranjero" class="mt-1 block w-44 border border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Mostrar las tarjetas de detalles de misiones -->
                    <div x-show="misionesSeleccionadas.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <template x-for="(detalle, index) in misionesDetalles" :key="detalle.nombre">
                            <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 shadow">
                                <h2 class="text-lg font-bold mb-2" x-text="detalle.nombre"></h2>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Rango de velocidad</label>
                                        <input type="text" x-model="misionesDetalles[index].velocidad" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Número de Motores</label>
                                        <input type="number" x-model.number="misionesDetalles[index].motores" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Potencia/Energía (%)</label>
                                        <input type="number" x-model.number="misionesDetalles[index].potencia" min="0" max="100" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea x-model="misionesDetalles[index].descripcion" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"></textarea>
                                </div>
                            </div>
                        </template>

                    </div>

                    <!-- Campos ocultos para enviar los datos -->

                    <!-- Sección Puerto Base -->
                    <div class="mb-4 mt-6">
                        <h2 class="font-bold text-lg mb-2">Puerto Base</h2>
                        <!-- Contenido de Puerto Base (puedes agregar campos o información adicional aquí) -->
                    </div>

                    <!-- Sección de Cálculos para los 3 años -->
                    <div class="mt-6">
                        <!-- Botones de Años -->
                        <div class="flex justify-center mb-4">
                            <div class="flex space-x-4">
                                <button type="button" @click="anioSeleccionado = '1er_anio'" :class="{'bg-blue-700 text-white': anioSeleccionado === '1er_anio', 'bg-gray-200 text-gray-700': anioSeleccionado !== '1er_anio'}" class="px-6 py-2 rounded flex items-center w-32 justify-center">
                                    1er Año
                                </button>
                                <button type="button" @click="anioSeleccionado = '3er_anio'" :class="{'bg-blue-700 text-white': anioSeleccionado === '3er_anio', 'bg-gray-200 text-gray-700': anioSeleccionado !== '3er_anio'}" class="px-6 py-2 rounded flex items-center w-32 justify-center">
                                    3er Año
                                </button>
                                <button type="button" @click="anioSeleccionado = '5to_anio'" :class="{'bg-blue-700 text-white': anioSeleccionado === '5to_anio', 'bg-gray-200 text-gray-700': anioSeleccionado !== '5to_anio'}" class="px-6 py-2 rounded flex items-center w-32 justify-center">
                                    5to Año
                                </button>
                            </div>
                        </div>

                        <!-- Contenido para el 1er Año -->
                        <div x-show="anioSeleccionado === '1er_anio'">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Disponible para Misiones -->
                                <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 shadow">
                                    <h2 class="text-lg font-bold mb-2">Disponible para Misiones - 1er Año</h2>
                                    <div class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-gray-200 p-3">
                                        <!-- Mostrar desglose del cálculo -->
                                        <p class="text-sm text-gray-600">
                                            8760 - (
                                            <span class="font-semibold">Mantenimiento Básico 1er Año:</span> {{ $buque->fua->mant_basico_1 ?? 0 }} +
                                            <span class="font-semibold">ROH 1er Año:</span> {{ $buque->fua->roh_1 ?? 0 }} +
                                            <span class="font-semibold">Horas de Navegación:</span> {{ $buque->horas_navegacion_anual ?? 0 }})
                                        </p>
                                        <!-- Mostrar resultado del cálculo -->
                                        <p class="font-bold text-lg text-gray-800">
                                            Resultado: {{
                                8760 - (
                                    ($buque->fua->mant_basico_1 ?? 0) +
                                    ($buque->fua->roh_1 ?? 0) +
                                    ($buque->horas_navegacion_anual ?? 0)
                                )
                            }}
                                        </p>
                                    </div>
                                </div>
                                <!-- Disponibilidad de Mantenimiento -->
                                <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 shadow">
                                    <h2 class="text-lg font-bold mb-2">Disponibilidad de Mantenimiento - 1er Año</h2>
                                    <input
                                        type="text"
                                        value="{{ $buque->fua->disponibilidad_mantenimiento_1 ?? 'Calculando...' }}"
                                        readonly
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-gray-200">
                                    <h3 class="text-md font-semibold mt-2">Plan de Mantenimiento Básico</h3>
                                    <!-- Campo conectado al backend -->
                                    <input
                                        type="number"
                                        name="mant_basico_1"
                                        id="mant_basico_1"
                                        value="{{ $buque->fua->mant_basico_1 ?? '' }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                </div>

                                <!-- Revisión Periódica (ROH) - 1er Año -->
                                <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 shadow">
                                    <h2 class="text-lg font-bold mb-2">Revisión Periódica (ROH) - 1er Año</h2>
                                    <!-- Campo conectado al backend -->
                                    <input
                                        type="number"
                                        name="roh_1"
                                        id="roh_1"
                                        value="{{ $buque->fua->roh_1 ?? '' }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Contenido para el 3er Año -->
                        <div x-show="anioSeleccionado === '3er_anio'">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Disponible para Misiones -->
                                <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 shadow">
                                    <h2 class="text-lg font-bold mb-2">Disponible para Misiones - 3er Año</h2>
                                    <div class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-gray-200 p-3">
                                        <!-- Mostrar desglose del cálculo -->
                                        <p class="text-sm text-gray-600">
                                            8760 - (
                                            <span class="font-semibold">Mantenimiento Básico 3er Año:</span> {{ $buque->fua->mant_basico_3 ?? 0 }} +
                                            <span class="font-semibold">Mantenimiento Intermedio 3er Año:</span> {{ $buque->fua->mant_intermedio_3 ?? 0 }} +
                                            <span class="font-semibold">ROH 3er Año:</span> {{ $buque->fua->roh_3 ?? 0 }} +
                                            <span class="font-semibold">Horas de Navegación:</span> {{ $buque->horas_navegacion_anual ?? 0 }})
                                        </p>
                                        <!-- Mostrar resultado del cálculo -->
                                        <p class="font-bold text-lg text-gray-800">
                                            Resultado: {{
                                8760 - (
                                    ($buque->fua->mant_basico_3 ?? 0) +
                                    ($buque->fua->mant_intermedio_3 ?? 0) +
                                    ($buque->fua->roh_3 ?? 0) +
                                    ($buque->horas_navegacion_anual ?? 0)
                                )
                            }}
                                        </p>
                                    </div>
                                </div>
                                <!-- Disponibilidad de Mantenimiento -->
                                <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 shadow">
                                    <h2 class="text-lg font-bold mb-2">Disponibilidad de Mantenimiento - 3er Año</h2>
                                    <div class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-gray-200 p-3">
                                        <!-- Mostrar desglose del cálculo -->
                                        <p class="text-sm text-gray-600">
                                            Mantenimiento Básico 3er Año: {{ $buque->fua->mant_basico_3 ?? 0 }} +
                                            Mantenimiento Intermedio 3er Año: {{ $buque->fua->mant_intermedio_3 ?? 0 }}
                                        </p>
                                        <!-- Mostrar resultado del cálculo -->
                                        <p class="font-bold text-lg text-gray-800">
                                            Resultado: {{
                                ($buque->fua->mant_basico_3 ?? 0) +
                                ($buque->fua->mant_intermedio_3 ?? 0)
                            }}
                                        </p>
                                    </div>
                                    <h3 class="text-md font-semibold mt-2">Plan de Mantenimiento Intermedio</h3>
                                    <input
                                        type="number"
                                        name="mant_intermedio_3"
                                        id="mant_intermedio_3"
                                        value="{{ $buque->fua->mant_intermedio_3 ?? '' }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">

                                    <h3 class="text-md font-semibold mt-2">Plan de Mantenimiento Básico</h3>
                                    <input
                                        type="number"
                                        name="mant_basico_3"
                                        id="mant_basico_3"
                                        value="{{ $buque->fua->mant_basico_3 ?? '' }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                </div>

                                <!-- Revisión Periódica (ROH) - 3er Año -->
                                <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 shadow">
                                    <h2 class="text-lg font-bold mb-2">Revisión Periódica (ROH) - 3er Año</h2>
                                    <input
                                        type="number"
                                        name="roh_3"
                                        id="roh_3"
                                        value="{{ $buque->fua->roh_3 ?? '' }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Contenido para el 5to Año -->
                        <div x-show="anioSeleccionado === '5to_anio'">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Disponible para Misiones -->
                                <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 shadow">
                                    <h2 class="text-lg font-bold mb-2">Disponible para Misiones - 5to Año</h2>
                                    <div class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-gray-200 p-3">
                                        <!-- Mostrar desglose del cálculo -->
                                        <p class="text-sm text-gray-600">
                                            8760 - (
                                            <span class="font-semibold">Plan de Mantenimiento Mayor:</span> {{ $buque->fua->mant_mayor_5 ?? 0 }} +
                                            <span class="font-semibold">ROH 5to Año:</span> {{ $buque->fua->roh_5 ?? 0 }} +
                                            <span class="font-semibold">Horas de Navegación:</span> {{ $buque->horas_navegacion_anual ?? 0 }})
                                        </p>
                                        <!-- Mostrar resultado del cálculo -->
                                        <p class="font-bold text-lg text-gray-800">
                                            Resultado: {{
                                8760 - (
                                    ($buque->fua->mant_mayor_5 ?? 0) +
                                    ($buque->fua->roh_5 ?? 0) +
                                    ($buque->horas_navegacion_anual ?? 0)
                                )
                            }}
                                        </p>
                                    </div>
                                </div>
                                <!-- Disponibilidad de Mantenimiento -->
                                <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 shadow">
                                    <h2 class="text-lg font-bold mb-2">Disponibilidad de Mantenimiento - 5to Año</h2>
                                    <div class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-gray-200 p-3">
                                        <!-- Mostrar desglose del cálculo -->
                                        <p class="text-sm text-gray-600">
                                            <span class="font-semibold">Plan de Mantenimiento Mayor:</span> {{ $buque->fua->mant_mayor_5 ?? 0 }}
                                        </p>
                                        <!-- Mostrar resultado del cálculo -->
                                        <p class="font-bold text-lg text-gray-800">
                                            Resultado: {{ $buque->fua->mant_mayor_5 ?? 0 }}
                                        </p>
                                    </div>
                                    <h3 class="text-md font-semibold mt-2">Plan de Mantenimiento Mayor</h3>
                                    <input
                                        type="number"
                                        name="mant_mayor_5"
                                        id="mant_mayor_5"
                                        value="{{ $buque->fua->mant_mayor_5 ?? '' }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                </div>

                                <!-- Revisión Periódica (ROH) - 5to Año -->
                                <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 shadow">
                                    <h2 class="text-lg font-bold mb-2">Revisión Periódica (ROH) - 5to Año</h2>
                                    <input
                                        type="number"
                                        name="roh_5"
                                        id="roh_5"
                                        value="{{ $buque->fua->roh_5 ?? '' }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Campos ocultos para enviar otros datos -->
                    <input type="hidden" name="navegacion_seleccionada" :value="navegacionSeleccionada">
                    <input type="hidden" name="puerto_extranjero_seleccionado" :value="puertoExtranjeroSeleccionado">
                    <input type="hidden" name="tiempo_puerto_extranjero" :value="tiempoPuertoExtranjero">
                    <!-- Campos ocultos para ROH -->
                    <input type="hidden" name="roh1erAnio" :value="roh1erAnio">
                    <input type="hidden" name="roh3erAnio" :value="roh3erAnio">
                    <input type="hidden" name="roh5toAnio" :value="roh5toAnio">
                </div>


                <!-- Botón de Guardar -->
                <div class="mt-4">
                    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded">Guardar</button>
                </div>

                <template x-for="(detalle, index) in misionesDetalles" :key="index">
                    <div>
                        <input type="hidden" :name="'misiones[' + index + '][nombre]'" :value="detalle.nombre">
                        <input type="hidden" :name="'misiones[' + index + '][velocidad]'" :value="detalle.velocidad">
                        <input type="hidden" :name="'misiones[' + index + '][motores]'" :value="detalle.motores">
                        <input type="hidden" :name="'misiones[' + index + '][potencia]'" :value="detalle.potencia">
                        <input type="hidden" :name="'misiones[' + index + '][porcentaje]'" :value="detalle.porcentaje">
                        <input type="hidden" :name="'misiones[' + index + '][descripcion]'" :value="detalle.descripcion">
                    </div>
                </template>

            </form>
        </div>
    </div>
</x-app-layout>

<!-- Incluir Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Scripts adicionales -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Código JavaScript -->
<script>
    function tabData() {
        return {
            tab: 'datos_basicos',
            grupoTab: '100',
            sistemasBuque: {!! json_encode($sistemasBuqueData ?? []) !!} || {},
            showCreateSistemaModal: false,
            isEditing: false,
            editSistemaIndex: null,
            newSistema: {
                grupo: '',
                cjDigit1: '',
                cjDigit2: '',
                nombre: '',
                descripcion: ''
            },

            // Variables para Ciclo Operacional
            navegacionSeleccionada: true,
            puertoExtranjeroSeleccionado: false,
            tiempoPuertoExtranjero: null,
            misionesBase: [
                'Ayuda Humanitaria',
                'Búsqueda y Rescate',
                'Combate a la piratería',
                'Combate contra el terrorismo',
                'Interdicción Marítima',
                'Operaciones de Desembarco',
                'Operaciones de paz y ayuda humanitaria',
                'Operaciones de soporte logístico',
                'Seguridad y control de tráfico marítimo',
                'Soporte interdicción marítima',
                'Soporte y colaboración a autoridades civiles en caso de disturbios y revueltas'
            ],
            misionesDisponibles: [], // Se llenará en init()
            misionesSeleccionadas: {!! json_encode(array_unique(array_column($misiones_activas, 'nombre'))) !!},
            misionesDetalles: {!! json_encode($misiones_activas) !!},

            // Variables para ROH
            roh1erAnio: '',
            roh3erAnio: '',
            roh5toAnio: '',
            planMantBasico1erAnio: '',
            planMantIntermedio3erAnio: '',
            planMantBasico3erAnio: '', // Añadido para el 3er año
            planMantMayor5toAnio: '',

            // Variable para Año seleccionado
            anioSeleccionado: '1er_anio',

            // Getter para totalPorcentaje
            get totalPorcentaje() {
                return this.misionesDetalles.reduce((sum, detalle) => sum + (parseFloat(detalle.porcentaje) || 0), 0);
            },

            get disponibilidadMantenimiento1erAnio() {
                return this.planMantBasico1erAnio || '';
            },
            get disponibilidadMantenimiento3erAnio() {
                const basico = parseFloat(this.planMantBasico3erAnio) || 0;
                const intermedio = parseFloat(this.planMantIntermedio3erAnio) || 0;
                return basico + intermedio;
            },
            get disponibilidadMantenimiento5toAnio() {
                return this.planMantMayor5toAnio || '';
            },

            // Métodos para misiones
            ensurePositiveValue(event, index, field) {
                if (event.target.value < 0) {
                    event.target.value = 0;
                    this.misionesDetalles[index][field] = 0;
                }
            },
            formatPotencia(event, index) {
                const value = event.target.value.replace(/[^0-9]/g, '');
                if (value > 100) {
                    this.misionesDetalles[index].potencia = '100';
                } else {
                    this.misionesDetalles[index].potencia = value;
                }
            },
            agregarNuevaMision() {
                Swal.fire({
                    title: 'Añadir nueva misión',
                    input: 'text',
                    inputLabel: 'Nombre de la misión',
                    showCancelButton: true,
                    confirmButtonText: 'Agregar',
                    cancelButtonText: 'Cancelar',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Por favor ingrese un nombre para la misión';
                        }
                        value = value.trim();
                        if (this.misionesDisponibles.includes(value)) {
                            return 'Esta misión ya existe.';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const nuevaMision = result.value.trim();
                        // Agregar misión a misionesDisponibles
                        this.misionesDisponibles.push(nuevaMision);
                        // Agregar misión a misionesSeleccionadas
                        this.misionesSeleccionadas.push(nuevaMision);
                        // Actualizar detalles de misiones
                        this.actualizarMisionesDetalles();
                    }
                });
            },

            // Inicialización y observadores
            init() {
                // Inicializar misiones disponibles sin duplicados
                this.misionesDisponibles = [...new Set([...this.misionesBase, ...this.misionesSeleccionadas])];

                // Observador para sincronizar detalles de misiones seleccionadas
                this.$watch('misionesSeleccionadas', () => {
                    this.actualizarMisionesDetalles();
                });

                // Inicializar detalles de misiones seleccionadas
                this.actualizarMisionesDetalles();

                // Validación del total de porcentaje para misiones seleccionadas
                this.$watch('totalPorcentaje', (value) => {
                    if (value > 100) {
                        Swal.fire('Error', 'La suma de los porcentajes no puede exceder el 100%.', 'error');
                    }
                });

                // Inicializar grupos de sistemas si no existen
                const grupos = ['100', '200', '300', '400', '500', '600', '700'];
                grupos.forEach((grupo) => {
                    if (!this.sistemasBuque[grupo]) {
                        this.sistemasBuque[grupo] = [];
                    }
                });

                // Asegurar que todos los datos se reflejen correctamente en Alpine.js
                this.$nextTick(() => {
                    // Forzar actualización de Alpine.js para reflejar cambios en misionesDetalles
                    this.misionesDetalles = JSON.parse(JSON.stringify(this.misionesDetalles));

                    // Forzar actualización de Alpine.js para reflejar cambios en sistemasBuque
                    this.sistemasBuque = JSON.parse(JSON.stringify(this.sistemasBuque));
                });

                // Validar datos iniciales para evitar inconsistencias
                this.validarDatosIniciales();
            },

            validarDatosIniciales() {
                // Validar que la suma de los porcentajes no exceda el 100%
                const totalPorcentaje = this.misionesDetalles.reduce((sum, detalle) => {
                    return sum + (parseFloat(detalle.porcentaje) || 0);
                }, 0);

                if (totalPorcentaje > 100) {
                    Swal.fire('Advertencia', 'La suma inicial de porcentajes excede el 100%. Por favor, ajuste los valores.', 'warning');
                }

                // Verificar si hay sistemas duplicados en los grupos
                const sistemasDuplicados = [];
                Object.keys(this.sistemasBuque).forEach((grupo) => {
                    const codigos = this.sistemasBuque[grupo].map((sistema) => sistema.cj);
                    const duplicados = codigos.filter((cj, index, self) => self.indexOf(cj) !== index);
                    sistemasDuplicados.push(...duplicados);
                });

                if (sistemasDuplicados.length > 0) {
                    Swal.fire('Error', `Se encontraron códigos duplicados en los sistemas: ${sistemasDuplicados.join(', ')}`, 'error');
                }
            },


            actualizarMisionesDetalles() {
                // Crear una copia del estado actual para no perder ediciones del usuario
                const oldMisionesDetalles = [...this.misionesDetalles];

                // 1. Eliminar misiones que ya no estén seleccionadas
                let nuevasMisiones = oldMisionesDetalles.filter(detalle =>
                    this.misionesSeleccionadas.includes(detalle.nombre)
                );

                // 2. Agregar nuevas misiones que no estén en misionesDetalles
                this.misionesSeleccionadas.forEach(mision => {
                    if (!nuevasMisiones.find(detalle => detalle.nombre === mision)) {
                        nuevasMisiones.push({
                            nombre: mision,
                            velocidad: '',
                            motores: 0,
                            potencia: '',
                            porcentaje: 0,
                            descripcion: ''
                        });
                    }
                });

                // Actualizar misionesDetalles sin sobrescribir las existentes
                this.misionesDetalles = nuevasMisiones;
            },

            // Métodos para sistemas
            openCreateSistemaModal(grupo) {
                this.isEditing = false;
                this.editSistemaIndex = null;
                this.newSistema = {
                    grupo: grupo,
                    cjDigit1: '',
                    cjDigit2: '',
                    nombre: '',
                    descripcion: ''
                };
                this.showCreateSistemaModal = true;
            },

            createSistema() {
                if (!this.newSistema.nombre.trim()) {
                    Swal.fire('Error', 'El nombre del sistema es obligatorio.', 'error');
                    return;
                }
                if (!/^\d$/.test(this.newSistema.cjDigit1) || !/^\d$/.test(this.newSistema.cjDigit2)) {
                    Swal.fire('Error', 'Cada dígito del CJ debe ser un número del 0 al 9.', 'error');
                    return;
                }

                const cjCompleto = this.newSistema.grupo.charAt(0) + this.newSistema.cjDigit1 + this.newSistema.cjDigit2;

                // Evitar duplicados revisando si ya existe el sistema antes de agregarlo
                if (!this.sistemasBuque[this.newSistema.grupo]) {
                    this.sistemasBuque[this.newSistema.grupo] = [];
                }

                // Verificar si el sistema ya existe en el grupo
                const existeSistema = this.sistemasBuque[this.newSistema.grupo].some(sistema => sistema.cj === cjCompleto);
                if (existeSistema) {
                    Swal.fire('Error', 'Ya existe un sistema con este CJ en el grupo.', 'error');
                    return;
                }

                // Agregar el sistema si no existe
                this.sistemasBuque[this.newSistema.grupo].push({
                    id: null,
                    cj: cjCompleto,
                    nombre: this.newSistema.nombre,
                    descripcion: this.newSistema.descripcion
                });

                // Actualizar el estado de Alpine.js para reflejar cambios en la interfaz
                this.sistemasBuque = JSON.parse(JSON.stringify(this.sistemasBuque)); // Forzar actualización de Alpine.js

                // Limpiar newSistema después de la creación
                this.newSistema = {
                    grupo: this.newSistema.grupo,
                    cjDigit1: '',
                    cjDigit2: '',
                    nombre: '',
                    descripcion: ''
                };

                this.closeSistemaModal();
                Swal.fire('Éxito', 'Sistema creado correctamente.', 'success');
            },

            openEditSistemaModal(grupo, index) {
                this.isEditing = true;
                this.editSistemaIndex = index;
                const sistema = this.sistemasBuque[grupo][index];
                this.newSistema = {
                    grupo: grupo,
                    cjDigit1: sistema.cj.charAt(1),
                    cjDigit2: sistema.cj.charAt(2),
                    nombre: sistema.nombre,
                    descripcion: sistema.descripcion
                };
                this.showCreateSistemaModal = true;
            },

            updateSistema() {
                if (!this.newSistema.nombre.trim()) {
                    Swal.fire('Error', 'El nombre del sistema es obligatorio.', 'error');
                    return;
                }
                if (!/^\d$/.test(this.newSistema.cjDigit1) || !/^\d$/.test(this.newSistema.cjDigit2)) {
                    Swal.fire('Error', 'Cada dígito del CJ debe ser un número del 0 al 9.', 'error');
                    return;
                }
                const cjCompleto = this.newSistema.grupo.charAt(0) + this.newSistema.cjDigit1 + this.newSistema.cjDigit2;
                const sistemaActual = this.sistemasBuque[this.newSistema.grupo][this.editSistemaIndex];
                if (sistemaActual.cj !== cjCompleto) {
                    if (this.sistemasBuque[this.newSistema.grupo].some((sistema, idx) => sistema.cj === cjCompleto && idx !== this.editSistemaIndex)) {
                        Swal.fire('Error', 'Ya existe otro sistema con este CJ.', 'error');
                        return;
                    }
                    sistemaActual.cj = cjCompleto;
                }
                sistemaActual.nombre = this.newSistema.nombre;
                sistemaActual.descripcion = this.newSistema.descripcion;
                // El id se mantiene
                this.closeSistemaModal();
                Swal.fire('Éxito', 'Sistema actualizado correctamente.', 'success');
            },

            closeSistemaModal() {
                this.showCreateSistemaModal = false;
                this.isEditing = false;
                this.editSistemaIndex = null;
                this.newSistema = {
                    grupo: '',
                    cjDigit1: '',
                    cjDigit2: '',
                    nombre: '',
                    descripcion: ''
                };
            },

            confirmarEliminarSistema(grupo, index) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.eliminarSistema(grupo, index);
                    }
                });
            },

            eliminarSistema(grupo, index) {
                this.sistemasBuque[grupo].splice(index, 1);
                Swal.fire('Eliminado', 'El sistema ha sido eliminado.', 'success');
            },
        };
    }

    function agregarColaborador() {
        const contenedor = document.getElementById('colaboradores-container');
        const index = contenedor.children.length;
        const div = document.createElement('div');
        div.classList.add('grid', 'grid-cols-1', 'sm:grid-cols-2', 'lg:grid-cols-4', 'gap-4', 'mb-4');
        div.setAttribute('id', `colaborador-${index}`);
        div.innerHTML = `
            <div>
                <label for="col_cargo_${index}" class="block text-sm font-medium text-gray-700">Cargo</label>
                <input type="text" name="colaboradores[${index}][col_cargo]" id="col_cargo_${index}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label for="col_nombre_${index}" class="block text-sm font-medium text-gray-700">Nombres y Apellidos Completos</label>
                <input type="text" name="colaboradores[${index}][col_nombre]" id="col_nombre_${index}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label for="col_entidad_${index}" class="block text-sm font-medium text-gray-700">Entidad</label>
                <input type="text" name="colaboradores[${index}][col_entidad]" id="col_entidad_${index}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="flex items-end">
                <button type="button" class="bg-red-700 text-white px-4 py-1 rounded mt-2 remove-colaborador" onclick="confirmarEliminarColaborador(${index})">Eliminar</button>
            </div>
        `;
        contenedor.appendChild(div);
    }

    function confirmarEliminarColaborador(index) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarColaborador(index);
            }
        });
    }

    function eliminarColaborador(index) {
        const colaboradorItem = document.getElementById(`colaborador-${index}`);
        if (colaboradorItem) {
            colaboradorItem.remove();
        }
    }
</script>
