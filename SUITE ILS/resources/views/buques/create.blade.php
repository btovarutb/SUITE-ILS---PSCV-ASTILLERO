<!-- resources/views/buques/create.blade.php -->
<x-app-layout>
    @section('title', 'Crear Buque')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Nuevo Registro de Buque</h1>
        <div x-data="tabData()" class="bg-white shadow rounded-lg p-6">
            <!-- Pestañas -->
            <nav class="flex mb-4 space-x-2">
                <button @click="tab = 'datos_basicos'" :class="{'bg-blue-700 text-white': tab === 'datos_basicos', 'bg-gray-200 text-gray-700': tab !== 'datos_basicos'}" class="px-4 py-2 rounded flex items-center">
                    <i class="fas fa-ship mr-2"></i>
                    Datos Básicos
                </button>
                <button @click="tab = 'misiones'" :class="{'bg-blue-700 text-white': tab === 'misiones', 'bg-gray-200 text-gray-700': tab !== 'misiones'}" class="px-4 py-2 flex rounded items-center">
                    <i class="fas fa-pencil-alt mr-2"></i>
                    Misiones
                </button>
                <button @click="tab = 'colaboradores'" :class="{'bg-blue-700 text-white': tab === 'colaboradores', 'bg-gray-200 text-gray-700': tab !== 'colaboradores'}" class="px-4 py-2 rounded flex items-center">
                    <i class="fa-solid fa-user-plus mr-2"></i>
                    Colaboradores
                </button>
                <button @click="tab = 'sistema_equipos'" :class="{'bg-blue-700 text-white': tab === 'sistema_equipos', 'bg-gray-200 text-gray-700': tab !== 'sistema_equipos'}" class="px-4 py-2 rounded flex items-center">
                    <i class="fas fa-cogs mr-2"></i>
                    Sistema y Equipos
                </button>
            </nav>

            <form action="{{ route('buques.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="sistemas_buque" :value="JSON.stringify(sistemas)">

                <!-- Contenido de Datos Básicos -->
                <div x-show="tab === 'datos_basicos'">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="nombre_proyecto" class="block text-sm font-medium text-gray-700">Nombre del Proyecto o Buque</label>
                            <input type="text" name="nombre_proyecto" id="nombre_proyecto" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="tipo_buque" class="block text-sm font-medium text-gray-700">Tipo de Buque</label>
                            <input type="text" name="tipo_buque" id="tipo_buque" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="descripcion_proyecto" class="block text-sm font-medium text-gray-700">Descripción del Proyecto</label>
                            <textarea name="descripcion_proyecto" id="descripcion_proyecto" class="mt-1 block w-full h-24 border border-gray-300 rounded-md shadow-sm" maxlength="500" required></textarea>
                        </div>
                        <!-- Campo de Autonomía en Horas -->
                        <div>
                            <label for="autonomia_horas" class="block text-sm font-medium text-gray-700">Autonomía en Horas</label>
                            <input type="number" name="autonomia_horas" id="autonomia_horas" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <!-- Nuevo campo: Horas de Navegación por Año -->
                        <div>
                            <label for="horas_navegacion_anual" class="block text-sm font-medium text-gray-700">Horas de Navegación por Año</label>
                            <input type="number" name="horas_navegacion_anual" id="horas_navegacion_anual" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <!-- Campo de Imagen del Buque -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Imagen del Buque</label>
                            <input type="file" name="image" id="image" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                        </div>

                    </div>
                    <div>
                        <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded">Guardar</button>
                    </div>
                </div>

                <!-- Contenido de Misiones -->
                <div x-show="tab === 'misiones'">
                    <!-- Información adicional -->
                    <div class="mb-5 opacity-65">
                        <p><i class="fa-solid fa-circle-info text-gray-700"></i> Misiones extraídas de Armada República de Colombia (ARC), "Doctrina de Material Naval. Tomo III. Mantenimiento. Segunda edición," Dirección de Doctrina Naval, Bogotá, D.C., Colombia, 2022.</p>
                    </div>

                    <!-- Checkboxes padres -->
                    <div class="mb-4">
                        <!-- Checkbox Padre: Fuera de Puerto -->
                        <div class="flex items-center mb-2">
                            <input type="checkbox" id="fuera_de_puerto"
                                   x-model="fueraDePuerto" @change="toggleFueraDePuerto()"
                                   :disabled="puertoBase"
                                   class="mr-2"
                                   :class="{'opacity-30 cursor-not-allowed': puertoBase}">
                            <label for="fuera_de_puerto"
                                   class="font-bold text-lg"
                                   :class="{'text-gray-500': puertoBase}">Fuera de Puerto</label>
                        </div>
                        <!-- Misiones desplegables al marcar Fuera de Puerto -->
                        <div x-show="fueraDePuerto" class="ml-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- Lista de misiones -->
                                @foreach (['Ayuda Humanitaria', 'Búsqueda y Rescate', 'Combate a la piratería', 'Combate contra el terrorismo', 'Interdicción Marítima', 'Operaciones de Desembarco', 'Operaciones de paz y ayuda humanitaria', 'Operaciones de soporte logístico', 'Seguridad y control de tráfico marítimo', 'Soporte interdicción marítima', 'Soporte y colaboración a autoridades civiles en caso de disturbios y revueltas'] as $mision)
                                    <div class="flex items-center">
                                        <input type="checkbox" :value="'{{ $mision }}'" x-model="misionesSeleccionadas" class="mr-2">
                                        <label>{{ $mision }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Checkbox Padre: Puerto Base -->
                        <div class="flex items-center mt-4">
                            <input type="checkbox" id="puerto_base"
                                   x-model="puertoBase" @change="togglePuertoBase()"
                                   :disabled="fueraDePuerto"
                                   class="mr-2"
                                   :class="{'opacity-30 cursor-not-allowed': fueraDePuerto}">
                            <label for="puerto_base"
                                   class="font-bold text-lg"
                                   :class="{'text-gray-500': fueraDePuerto}">Puerto Base</label>
                        </div>
                    </div>

                    <!-- Sección para configurar las misiones seleccionadas -->
                    <div x-show="fueraDePuerto && misionesSeleccionadas.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <template x-for="(mision, index) in misionesSeleccionadas" :key="mision">
                            <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 shadow">
                                <h2 class="text-lg font-bold mb-2" x-text="mision"></h2>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Velocidad (Nudos)</label>
                                        <input type="number" min="0" x-model.number="misionesDetalles[index].velocidad" @input="ensurePositiveValue($event, index, 'velocidad')" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Número de Motores</label>
                                        <input type="number" min="0" x-model.number="misionesDetalles[index].motores" @input="ensurePositiveValue($event, index, 'motores')" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Potencia/Energía (%)</label>
                                        <input type="text"
                                               x-model="misionesDetalles[index].potencia"
                                               @input="formatPotencia($event, index)"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Campos ocultos para enviar los datos -->
                    <input type="hidden" name="fuera_de_puerto" :value="fueraDePuerto">
                    <input type="hidden" name="puerto_base" :value="puertoBase">
                    <template x-for="(mision, index) in misionesSeleccionadas" :key="mision">
                        <!-- Campos ocultos para cada misión seleccionada -->
                        <input type="hidden" :name="'misiones[' + index + '][nombre]'" :value="mision">
                        <input type="hidden" :name="'misiones[' + index + '][velocidad]'" :value="misionesDetalles[index].velocidad">
                        <input type="hidden" :name="'misiones[' + index + '][motores]'" :value="misionesDetalles[index].motores">
                        <input type="hidden" :name="'misiones[' + index + '][potencia]'" :value="misionesDetalles[index].potencia">
                    </template>
                </div>

                <!-- Contenido de Colaboradores -->
                <div x-show="tab === 'colaboradores'">
                    <div class="mb-5 opacity-65">
                        <p><i class="fa-solid fa-circle-info text-gray-700"></i> Los colaboradores ingresados en esta sección son los mismos que aparecerán en los anexos generales exportados en PDF de los diferentes módulos.</p>
                    </div>
                    <div id="colaboradores-container" class="space-y-4 mb-4"></div>
                    <button type="button" class="bg-blue-700 text-white px-4 py-2 rounded" onclick="agregarColaborador()">Agregar Colaborador</button>
                </div>

                <!-- Contenido de Sistema y Equipos -->
                <div x-show="tab === 'sistema_equipos'">
                    <!-- Pestañas de Grupos con Títulos e Iconos -->
                    <nav class="flex mb-4 space-x-2">
                        <!-- Grupo 100 - Casco y Estructuras -->
                        <button @click="grupoTab = '100'" :class="{'bg-blue-700 text-white': grupoTab === '100', 'bg-gray-200 text-gray-700': grupoTab !== '100'}" class="px-4 py-2 rounded flex items-center">
                            <i class="mdi mdi-ferry mr-2 text-2xl"></i>
                            100 - Casco y Estructuras
                        </button>
                        <!-- Grupo 200 - Maquinaria y Propulsión -->
                        <button @click="grupoTab = '200'" :class="{'bg-blue-700 text-white': grupoTab === '200', 'bg-gray-200 text-gray-700': grupoTab !== '200'}" class="px-4 py-2 rounded flex items-center">
                            <i class="mdi mdi-engine mr-2 text-2xl"></i>
                            200 - Maquinaria y Propulsión
                        </button>
                        <!-- Grupo 300 - Planta Eléctrica -->
                        <button @click="grupoTab = '300'" :class="{'bg-blue-700 text-white': grupoTab === '300', 'bg-gray-200 text-gray-700': grupoTab !== '300'}" class="px-4 py-2 rounded flex items-center">
                            <i class="mdi mdi-lightning-bolt mr-2 text-2xl"></i>
                            300 - Planta Eléctrica
                        </button>
                        <!-- Grupo 400 - Comando y Vigilancia -->
                        <button @click="grupoTab = '400'" :class="{'bg-blue-700 text-white': grupoTab === '400', 'bg-gray-200 text-gray-700': grupoTab !== '400'}" class="px-4 py-2 rounded flex items-center">
                            <i class="mdi mdi-ship-wheel mr-2 text-2xl"></i>
                            400 - Comando y Vigilancia
                        </button>
                        <!-- Grupo 500 - Sistemas Auxiliares -->
                        <button @click="grupoTab = '500'" :class="{'bg-blue-700 text-white': grupoTab === '500', 'bg-gray-200 text-gray-700': grupoTab !== '500'}" class="px-4 py-2 rounded flex items-center">
                            <i class="mdi mdi-robot-industrial mr-2 text-2xl"></i>
                            500 - Sistemas Auxiliares
                        </button>
                        <!-- Grupo 600 - Acabados y Amoblamiento -->
                        <button @click="grupoTab = '600'" :class="{'bg-blue-700 text-white': grupoTab === '600', 'bg-gray-200 text-gray-700': grupoTab !== '600'}" class="px-4 py-2 rounded flex items-center">
                            <i class="fa-solid fa-couch mr-2 text-2xl"></i>
                            600 - Acabados y Amoblamiento
                        </button>
                        <!-- Grupo 700 - Armamento -->
                        <button @click="grupoTab = '700'" :class="{'bg-blue-700 text-white': grupoTab === '700', 'bg-gray-200 text-gray-700': grupoTab !== '700'}" class="px-4 py-2 rounded flex items-center">
                            <i class="fa-solid fa-triangle-exclamation mr-2 text-2xl"></i>
                            700 - Armamento
                        </button>
                    </nav>

                    <!-- Contenido de cada Grupo -->
                    <!-- Grupo 100 -->
                    <div x-show="grupoTab === '100'">
                        <!-- Botón para crear un nuevo sistema -->
                        <div class="mb-4">
                            <button @click="openCreateSistemaModal('100')" class="bg-green-500 text-white px-4 py-2 rounded">Crear Nuevo Sistema</button>
                        </div>
                        <!-- Lista de sistemas creados en el Grupo 100 -->
                        <div>
                            <template x-if="sistemas['100'] && sistemas['100'].length > 0">
                                <div>
                                    <h2 class="text-lg font-bold mb-2">Sistemas en el Grupo 100</h2>
                                    <ul class="list-disc pl-5 space-y-2">
                                        <template x-for="(sistema, index) in sistemas['100']" :key="sistema.cj">
                                            <li class="flex items-center justify-between">
                                                <span x-text="sistema.cj + ' - ' + sistema.nombre"></span>
                                                <div class="space-x-2">
                                                    <button @click="openEquiposModal('100', index)" class="bg-blue-500 text-white px-2 py-1 rounded flex items-center">
                                                        <i class="fas fa-plus mr-1"></i> Añadir Equipos
                                                    </button>
                                                    <button @click="openEditSistemaModal('100', index)" class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</button>
                                                    <button @click="confirmarEliminarSistema('100', index)" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </template>
                            <template x-if="!sistemas['100'] || sistemas['100'].length === 0">
                                <p>No hay sistemas creados en este grupo.</p>
                            </template>
                        </div>
                    </div>

                    <!-- Contenido de los demás grupos... -->

                    <!-- Modal para crear o editar un Sistema -->
                    <div x-show="showCreateSistemaModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                            <h2 class="text-xl font-bold mb-4" x-text="isEditing ? 'Editar Sistema' : 'Crear Nuevo Sistema'"></h2>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">CJ del Sistema (3 dígitos)</label>
                                <div class="flex items-center space-x-2">
                                    <span class="font-bold text-lg" x-text="newSistema.grupo.charAt(0)"></span>
                                    <!-- Campos para ingresar los 2 dígitos restantes -->
                                    <input type="text" x-model="newSistema.cjDigit1" maxlength="1" class="w-12 text-center border border-gray-300 rounded-md shadow-sm" placeholder="0">
                                    <input type="text" x-model="newSistema.cjDigit2" maxlength="1" class="w-12 text-center border border-gray-300 rounded-md shadow-sm" placeholder="0">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nombre del Sistema <span class="text-red-500">*</span></label>
                                <input type="text" x-model="newSistema.nombre" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" placeholder="Nombre del sistema" :required="showCreateSistemaModal">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Descripción (Opcional)</label>
                                <textarea x-model="newSistema.descripcion" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" placeholder="Descripción del sistema"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button @click="closeSistemaModal()" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancelar</button>
                                <button @click="isEditing ? updateSistema() : createSistema()" class="bg-blue-700 text-white px-4 py-2 rounded" x-text="isEditing ? 'Guardar Cambios' : 'Crear'"></button>
                            </div>
                        </div>
                    </div>
                    <div x-show="showEquiposModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl">
                            <h2 class="text-xl font-bold mb-4">Equipos Disponibles</h2>
                            <!-- Lista de Equipos -->
                            <div>
                                <template x-if="equiposDisponibles && equiposDisponibles.length > 0">
                                    <ul class="divide-y divide-gray-200">
                                        <template x-for="equipo in equiposDisponibles" :key="equipo.id">
                                            <li class="py-2 flex items-center justify-between">
                                                <span x-text="equipo.codigo + ' - ' + equipo.nombre"></span>
                                                <!-- Aquí puedes agregar una opción para seleccionar el equipo -->
                                            </li>
                                        </template>
                                    </ul>
                                </template>
                                <template x-if="!equiposDisponibles || equiposDisponibles.length === 0">
                                    <p>No hay equipos disponibles para este grupo.</p>
                                </template>
                            </div>
                            <div class="flex justify-end mt-4">
                                <button @click="closeEquiposModal()" class="bg-blue-700 text-white px-4 py-2 rounded">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>

<!-- Incluir Alpine.js antes del cierre de </body> -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Scripts adicionales -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Mover el código de x-data a una función en un script separado -->
<script>
    function tabData() {
        return {
            // Variables principales
            tab: 'datos_basicos',
            grupoTab: '100',  // Variable para controlar las pestañas de grupos en 'Sistema y Equipos'
            fueraDePuerto: false,
            puertoBase: false,
            misionesSeleccionadas: [],
            misionesDetalles: [],
            search: '',
            // Variables para el manejo de sistemas
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
            sistemas: {
                '100': [],
                '200': [],
                '300': [],
                '400': [],
                '500': [],
                '600': [],
                '700': []
            },
            // Variables para el manejo de equipos
            showEquiposModal: false,
            equiposDisponibles: [],
            // Simulación de la base de datos de equipos
            equiposDB: [
                { id: 1, codigo: '101', nombre: 'Equipo A' },
                { id: 2, codigo: '102', nombre: 'Equipo B' },
                { id: 3, codigo: '103', nombre: 'Equipo C' },
                { id: 4, codigo: '201', nombre: 'Equipo D' },
                { id: 5, codigo: '202', nombre: 'Equipo E' },
                // Agrega más equipos según sea necesario
            ],
            // Métodos
            toggleFueraDePuerto() {
                if (this.fueraDePuerto) {
                    this.puertoBase = false;
                }
                this.misionesSeleccionadas = [];
                this.misionesDetalles = [];
            },
            togglePuertoBase() {
                if (this.puertoBase) {
                    this.fueraDePuerto = false;
                    this.misionesSeleccionadas = [];
                    this.misionesDetalles = [];
                }
            },
            ensurePositiveValue(event, index, field) {
                let value = parseInt(event.target.value);
                if (isNaN(value) || value < 0) {
                    value = 0;
                }
                this.misionesDetalles[index][field] = value;
            },
            formatPotencia(event, index) {
                let value = event.target.value.replace(/[^0-9]/g, '');
                value = Math.min(Math.max(parseInt(value) || 0), 100);
                this.misionesDetalles[index].potencia = value + '%';
            },
            // Método para abrir el modal de crear sistema
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
            // Método para crear un nuevo sistema
            createSistema() {
                // Validaciones (mismas que antes)
                if (!this.newSistema.nombre.trim()) {
                    Swal.fire('Error', 'El nombre del sistema es obligatorio.', 'error');
                    return;
                }
                if (!/^\d$/.test(this.newSistema.cjDigit1) || !/^\d$/.test(this.newSistema.cjDigit2)) {
                    Swal.fire('Error', 'Cada dígito del CJ debe ser un número del 0 al 9.', 'error');
                    return;
                }
                const cjCompleto = this.newSistema.grupo.charAt(0) + this.newSistema.cjDigit1 + this.newSistema.cjDigit2;
                if (this.sistemas[this.newSistema.grupo].some(sistema => sistema.cj === cjCompleto)) {
                    Swal.fire('Error', 'Ya existe un sistema con este CJ.', 'error');
                    return;
                }
                this.sistemas[this.newSistema.grupo].push({
                    cj: cjCompleto,
                    nombre: this.newSistema.nombre,
                    descripcion: this.newSistema.descripcion
                });
                this.closeSistemaModal();
                Swal.fire('Éxito', 'Sistema creado correctamente.', 'success');
            },
            // Método para abrir el modal de editar sistema
            openEditSistemaModal(grupo, index) {
                this.isEditing = true;
                this.editSistemaIndex = index;
                const sistema = this.sistemas[grupo][index];
                this.newSistema = {
                    grupo: grupo,
                    cjDigit1: sistema.cj.charAt(1),
                    cjDigit2: sistema.cj.charAt(2),
                    nombre: sistema.nombre,
                    descripcion: sistema.descripcion
                };
                this.showCreateSistemaModal = true;
            },
            // Método para actualizar un sistema existente
            updateSistema() {
                // Validaciones (mismas que antes)
                if (!this.newSistema.nombre.trim()) {
                    Swal.fire('Error', 'El nombre del sistema es obligatorio.', 'error');
                    return;
                }
                if (!/^\d$/.test(this.newSistema.cjDigit1) || !/^\d$/.test(this.newSistema.cjDigit2)) {
                    Swal.fire('Error', 'Cada dígito del CJ debe ser un número del 0 al 9.', 'error');
                    return;
                }
                const cjCompleto = this.newSistema.grupo.charAt(0) + this.newSistema.cjDigit1 + this.newSistema.cjDigit2;
                const sistemaActual = this.sistemas[this.newSistema.grupo][this.editSistemaIndex];
                if (sistemaActual.cj !== cjCompleto) {
                    if (this.sistemas[this.newSistema.grupo].some((sistema, idx) => sistema.cj === cjCompleto && idx !== this.editSistemaIndex)) {
                        Swal.fire('Error', 'Ya existe otro sistema con este CJ.', 'error');
                        return;
                    }
                    sistemaActual.cj = cjCompleto;
                }
                sistemaActual.nombre = this.newSistema.nombre;
                sistemaActual.descripcion = this.newSistema.descripcion;
                this.closeSistemaModal();
                Swal.fire('Éxito', 'Sistema actualizado correctamente.', 'success');
            },
            // Método para cerrar el modal y limpiar los datos
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
            // Método para confirmar eliminación de un sistema
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
            // Método para eliminar un sistema
            eliminarSistema(grupo, index) {
                this.sistemas[grupo].splice(index, 1);
                Swal.fire('Eliminado', 'El sistema ha sido eliminado.', 'success');
            },
            // Método para abrir el modal de Equipos
            openEquiposModal(grupo, index) {
                // Filtrar los equipos de la base de datos que comiencen con el número del grupo
                const grupoNumero = grupo.charAt(0);
                this.equiposDisponibles = this.equiposDB.filter(equipo => equipo.codigo.startsWith(grupoNumero));
                this.showEquiposModal = true;
            },
            // Método para cerrar el modal de Equipos
            closeEquiposModal() {
                this.showEquiposModal = false;
                this.equiposDisponibles = [];
            },
            // Observadores
            watch: {
                misionesSeleccionadas(newVal) {
                    this.misionesDetalles = newVal.map((mision, index) => this.misionesDetalles[index] || { velocidad: '', motores: '', potencia: '' });
                }
            },
            // Inicialización
            init() {
                // Inicializar los grupos en el objeto 'sistemas' si no están definidos
                const grupos = ['100', '200', '300', '400', '500', '600', '700'];
                grupos.forEach(grupo => {
                    if (!this.sistemas[grupo]) {
                        this.sistemas[grupo] = [];
                    }
                });
            }
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
        colaboradorItem.remove();
    }

    // Si necesitas agregar lógica para la búsqueda de equipos con las nuevas pestañas, puedes hacerlo aquí

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-equipment');
        if (searchInput) {
            searchInput.addEventListener('input', function(event) {
                tabData().searchEquipment(event);
            });
        }
    });
</script>




