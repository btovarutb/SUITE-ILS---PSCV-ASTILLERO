<!-- resources/views/buques/gres.blade.php -->
<x-app-layout>
    @section('title', 'GRES')
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('buques.show', $buque->id) }}" class="text-blue-900 hover:text-blue-900 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                    </a>
                    <h1 class="text-2xl font-bold ml-2" style="font-family: 'Inter', sans-serif;">
                        Módulo GRES SISTEMAS: <span style="text-transform: uppercase; color: #1862B0;">{{ $buque->nombre_proyecto }}</span>
                    </h1>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto p-4 flex flex-col lg:flex-row gap-4 fade-in" x-data="gresData()" x-init="initialize()">
        <div :class="expanded ? 'w-full' : 'lg:w-1/2'" class="transition-all duration-300 pr-4 h-full flex flex-col">
            @if($sistemasBuques->isEmpty())
                <p>No hay sistemas asignados a este buque.</p>
            @else
                <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-2 sm:space-y-0">
                    <div class="flex items-center space-x-4 w-full">
                        <input
                            type="text"
                            placeholder="Buscar por código"
                            x-model="search"
                            class="px-4 py-2 border rounded-lg mt-2 ml-4 flex-grow"
                            style="flex-grow: 0.8;"
                        />
                        <div class="flex space-between mt-2 gap-3 ml-2">
                            <button id="viewPdfButton" class="bg-blue-500 text-white px-4 py-2 rounded mr-4"><i class="fa-solid fa-file-export"></i></button>
                        </div>

                    </div>
                    <button @click="expanded = !expanded" class="text-blue-500 hover:text-blue-700 focus:outline-none">
                        <i :class="expanded ? 'fas fa-arrow-left' : 'fas fa-arrow-right'"></i>
                    </button>
                </div>

                <div class="flex-grow overflow-auto rounded-lg table-container" id="scrollable-table">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CÓDIGO</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MEC</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($sistemasBuques as $sistema)
                            <tr x-show="search === '' || '{{ $sistema->codigo }}'.toLowerCase().includes(search.toLowerCase())" class="hover:bg-gray-200">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $sistema->codigo }}</td>
                                <td class="px-6 py-4 break-words">
                                    <input type="text"
                                           class="border rounded px-2 py-1 w-full border-gray-300"
                                           :value="getSistemaTitulo('{{ $sistema->id }}', '{{ $sistema->nombre }}')"
                                           @keydown.enter="updateSistemaTitulo('{{ $sistema->id }}', $event.target.value)">
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap" x-text="getMec('{{ $sistema->id }}')"></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <i class="fa-solid fa-pen-to-square text-blue-500 cursor-pointer"
                                       @click="selectSistema('{{ $sistema->id }}', '{{ $sistema->codigo }}', '{{ $sistema->nombre }}', '{{ $sistema->pivot->mec }}', '{{ $sistema->pivot->image }}');
                                if (expanded) expanded = false"></i>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div :class="expanded ? 'hidden' : 'lg:w-1/2'" class="transition-all duration-300 pl-4">
            <div x-show="selectedSistema" class="p-4 bg-white h-full flex flex-col">
                <div class="flex items-center mb-4 relative-container" style="position: relative;">
                    <div class="flex flex-col mr-4">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">CÓDIGO</span>
                        <span class="px-4 py-2 border rounded bg-gray-100" x-text="selectedCodigo"></span>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nombre Sistema</span>
                        <span class="px-4 py-2 border rounded bg-gray-100" x-text="selectedNombre"></span>
                    </div>
                </div>

                <div class="flex items-start mb-4">
                    <div class="flex flex-col mr-4" style="min-width: 150px;">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">MEC</span>
                        <span class="px-4 py-2 border rounded bg-gray-100 mb-2" x-text="selectedMec ? selectedMec : 'MEC sin asignar'"></span>
                        <button @click="asignarMec" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Asignar MEC</button>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Diagrama de decisión</span>
                        <span class="px-4 py-2 border rounded bg-gray-100 flex justify-center items-center" style="min-width: 200px; min-height: 100px;">
                            <img :src="selectedImage ? getImageSrc(selectedImage) : '/storage/images/ImageNullGres.png'" alt="Diagrama" class="max-w-full h-auto cursor-pointer" @click="expandImage">
                        </span>
                    </div>
                </div>

                <div id="expanded-image-container" class="hidden fixed inset-0 bg-black bg-opacity-95 flex justify-center items-center z-50">
                    <button id="close-expanded-image" class="absolute top-4 right-4 text-white text-3xl">&times;</button>
                    <img id="expanded-image" src="" alt="Diagrama" class="max-w-full max-h-full">
                </div>

                <div class="flex flex-col mb-4" style="height: calc(100vh - 20rem);">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Observaciones</span>
                    <div id="observaciones-tabla" class="border rounded px-2 py-1 w-full h-24 overflow-auto mb-6"></div>
                    <div id="decision-path-display" class="border rounded px-2 py-1 w-full bg-gray-100 h-10 flex items-center justify-center"></div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function gresData() {
            return {
                expanded: false,
                search: '',
                selectedSistema: null,
                selectedCodigo: '',
                selectedNombre: '',
                selectedMec: '',
                selectedImage: '',
                imagesPorSistema: {},
                sistemas: @json($sistemasBuques),
                observacionesPorSistema: {},
                decisionPath: '',

                initialize() {
                    const firstSistema = this.sistemas[0];
                    this.sistemas.forEach(sistema => {
                        this.imagesPorSistema[sistema.id] = sistema.pivot.image || null;
                        if (sistema.pivot.image) {
                            this.selectSistema(sistema.id, sistema.codigo, sistema.nombre, sistema.pivot.mec, sistema.pivot.image);
                        }
                        if (sistema.pivot.observaciones) {
                            this.observacionesPorSistema[sistema.id] = JSON.parse(sistema.pivot.observaciones);
                        }
                    });

                    if (firstSistema) {
                        this.selectSistema(firstSistema.id, firstSistema.codigo, firstSistema.nombre, firstSistema.pivot.mec, firstSistema.pivot.image);
                    }

                    window.addEventListener('load', () => {
                        document.querySelector('.fade-in').classList.add('show');
                    });

                    document.querySelectorAll('.px-4.py-2.border.rounded.bg-gray-100.flex.justify-center.items-center img').forEach(img => {
                        img.addEventListener('click', this.expandImage.bind(this));
                    });

                    document.getElementById('close-expanded-image').addEventListener('click', this.closeExpandedImage.bind(this));
                    this.actualizarRutaRespuestas();
                },

                expandImage(event) {
                    const expandedImageContainer = document.getElementById('expanded-image-container');
                    const expandedImage = document.getElementById('expanded-image');
                    expandedImage.src = event.target.src;
                    expandedImageContainer.classList.remove('hidden');
                    expandedImageContainer.style.display = 'flex';
                },

                closeExpandedImage() {
                    const expandedImageContainer = document.getElementById('expanded-image-container');
                    expandedImageContainer.classList.add('hidden');
                    expandedImageContainer.style.display = 'none';
                },

                selectSistema(id, codigo, nombre, mec, image) {
                    this.selectedSistema = id;
                    this.selectedCodigo = codigo;
                    this.selectedNombre = nombre;
                    this.selectedMec = mec;
                    this.selectedImage = image || this.imagesPorSistema[id] || null;
                    this.actualizarObservacionesTabla();
                },

                getImageSrc(image) {
                    if (!image) {
                        return '/storage/images/ImageNullGres.png';
                    }
                    image = image.replace(/^diagramas\//, '');
                    return `/storage/diagramas/${image}`;
                },

                getMec(id) {
                    let sistema = this.sistemas.find(e => e.id == id);
                    return sistema ? sistema.pivot.mec : 'MEC sin asignar';
                },

                getSistemaTitulo(id, defaultNombre) {
                    let sistema = this.sistemas.find(e => e.id == id);
                    return sistema ? (sistema.pivot.titulo || defaultNombre) : defaultNombre;
                },

                updateSistemaTitulo(id, titulo) {
                    fetch(`/buques/{{ $buque->id }}/sistemas-buque/${id}/titulo`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ titulo: titulo })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message === 'Título actualizado correctamente') {
                                let sistema = this.sistemas.find(e => e.id == id);
                                if (sistema) {
                                    sistema.pivot.titulo = titulo;
                                }
                                Swal.fire('Actualizado', 'Título actualizado correctamente', 'success');
                            } else {
                                Swal.fire('Error', 'No se pudo actualizar el título', 'error');
                            }
                        });
                },

                asignarMec() {
                    this.decisionPath = '';
                    this.pregunta1();
                },

                retroceder() {
                    if (this.decisionPath.length > 0) {
                        this.decisionPath = this.decisionPath.slice(0, -1);
                        this.actualizarRutaRespuestas();

                        switch(this.decisionPath.length) {
                            case 0:
                                this.pregunta1();
                                break;
                            case 1:
                                this.pregunta2();
                                break;
                            case 2:
                                this.pregunta3();
                                break;
                            case 3:
                                this.pregunta4();
                                break;
                            case 4:
                                this.pregunta5();
                                break;
                            case 5:
                                this.pregunta6();
                                break;
                            case 6:
                                this.pregunta7();
                                break;
                        }
                    }
                },

                pregunta1() {
                    Swal.fire({
                        title: '¿SE PIERDE LA CAPACIDAD DE LA UNIDAD SI EL SISTEMA QUEDA INOPERATIVO?',
                        html: `
                            <div style="position: absolute; top: 20px; right: 45px;">
                                <button id="misiones" class="swal2-confirm swal2-styled"
                                    style="background-color: #F9F9F9; color: #464647; font-size: 16px;
                                    font-family: 'Inter', sans-serif; padding: 5px 10px;
                                    border: 1px solid black; border-radius: 10px;">
                                    Misiones
                                </button>
                                <button id="ayuda" class="swal2-cancel swal2-styled"
                                    style="background-color: white; color: #464647; font-size: 27px;">
                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                </button>
                            </div>
                            <p>Describa la capacidad que se pierde en caso de ser afirmativo</p>
                            <button id="atras" class="swal2-styled"
                                style="color: #464647; font-size: 16px; padding: 5px 10px;
                                position: absolute; top: 20px; left: 20px;">
                                <i class="fa-solid fa-arrow-left"></i>
                            </button>
                        `,
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Sí',
                        denyButtonText: 'No',
                        cancelButtonText: 'Observaciones',
                        cancelButtonColor: '#3dd960',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.decisionPath += '1';
                            this.actualizarRutaRespuestas();
                            this.pregunta2();
                        } else if (result.isDenied) {
                            this.decisionPath += '0';
                            this.actualizarRutaRespuestas();
                            this.updateMec('MEC 1', '0.png');
                        } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                            this.mostrarPopupObservaciones('pregunta1');
                        }
                    });

                    document.getElementById('misiones').addEventListener('click', () => {
                        this.popupMisiones('pregunta1');
                    });

                    document.getElementById('ayuda').addEventListener('click', () => {
                        this.popupAyudaPregunta1();
                    });

                    document.getElementById('atras').addEventListener('click', () => {
                        this.retroceder();
                    });
                },

                popupMisiones(preguntaActual) {
                    Swal.fire({
                        title: 'Misiones',
                        html: `
                            <div style="max-height: 70vh; overflow-y: auto;">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Operación</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sub-operación</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Funciones Operativas</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Velocidad (nudos)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">Max. Velocidad</td>
                                            <td class="px-6 py-4">Patrullaje y vigilancia</td>
                                            <td class="px-6 py-4">Todo poder</td>
                                            <td class="px-6 py-4">20 < Velocidad ≤ 25</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">Tránsito</td>
                                            <td class="px-6 py-4">Protección del medio ambiente, Búsqueda y rescate</td>
                                            <td class="px-6 py-4">Vel. sostenida de 2 motores</td>
                                            <td class="px-6 py-4">12 < Velocidad ≤ 20</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">Baja Velocidad</td>
                                            <td class="px-6 py-4">Operaciones de paz y ayuda humanitaria</td>
                                            <td class="px-6 py-4">Equivalencia 1 motor</td>
                                            <td class="px-6 py-4">7 ≤ Velocidad ≤ 11</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">Maniobra</td>
                                            <td class="px-6 py-4">Comando, control y comunicaciones</td>
                                            <td class="px-6 py-4">Baja velocidad</td>
                                            <td class="px-6 py-4">0 < Velocidad ≤ 6</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        `,
                        width: '80vw',
                        padding: '1rem',
                        showCancelButton: true,
                        confirmButtonText: 'Volver',
                        cancelButtonText: 'Cerrar',
                        cancelButtonColor: '#dc3545',
                        customClass: {
                            popup: 'custom-swal-popup',
                        }
                    }).then(() => {
                        this[preguntaActual]();
                    });
                },

                popupAyudaPregunta1() {
                    Swal.fire({
                        title: '¿SE PIERDE LA CAPACIDAD DE LA UNIDAD SI EL SISTEMA QUEDA INOPERATIVO?',
                        html: `
                            <p class="mb-6">Evalúe si la indisponibilidad del sistema afecta parcial o totalmente la funcionalidad de la unidad.</p>
                            <button id="volverPregunta1" class="swal2-styled" style="color: #464647; font-size: 16px; padding: 5px 10px; position: absolute; top: 20px; left: 20px;"><i class="fa-solid fa-arrow-left"></i></button>
                        `,
                        showConfirmButton: false,
                    });

                    document.getElementById('volverPregunta1').addEventListener('click', () => {
                        this.pregunta1();
                    });
                },

                pregunta2() {
                    Swal.fire({
                        title: '¿REPRESENTA UN EFECTO ADVERSO SOBRE EL PERSONAL, EL SISTEMA O EL MEDIO AMBIENTE?',
                        html: `
                            <div style="position: absolute; top: 20px; right: 45px;">
                                <button id="misiones" class="swal2-confirm swal2-styled" style="background-color: #F9F9F9; color: black; font-size: 16px; font-family: 'Inter', sans-serif; padding: 5px 10px; border: 1px solid black; border-radius: 10px;">Misiones</button>
                                <button id="ayuda" class="swal2-cancel swal2-styled" style="background-color: white; color: #464647; font-size: 27px; padding: 5px 10px;"><i class="fa fa-question-circle" aria-hidden="true"></i></button>
                            </div>
                            <button id="atras" class="swal2-styled" style="color: black; font-size: 16px; padding: 5px 10px; position: absolute; top: 20px; left: 20px;"><i class="fa-solid fa-arrow-left"></i></button>
                        `,
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Sí',
                        denyButtonText: 'No',
                        cancelButtonText: 'Observaciones',
                        cancelButtonColor: '#3dd960',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.decisionPath += '1';
                            this.actualizarRutaRespuestas();
                            this.pregunta3();
                        } else if (result.isDenied) {
                            this.decisionPath += '0';
                            this.actualizarRutaRespuestas();
                            this.pregunta4();
                        } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                            this.mostrarPopupObservaciones('pregunta2');
                        }
                    });

                    document.getElementById('misiones').addEventListener('click', () => {
                        this.popupMisiones('pregunta2');
                    });

                    document.getElementById('ayuda').addEventListener('click', () => {
                        this.popupAyudaPregunta2();
                    });

                    document.getElementById('atras').addEventListener('click', () => {
                        this.retroceder();
                    });
                },

                popupAyudaPregunta2() {
                    Swal.fire({
                        title: '¿REPRESENTA UN EFECTO ADVERSO SOBRE EL PERSONAL, EL SISTEMA O EL MEDIO AMBIENTE?',
                        html: `
                            <p class="mb-6">Evalúe si al quedar inoperativo el sistema, es decir, no cumplir su función, se refleja una consecuencia negativa sobre el personal, la unidad o el medio ambiente.</p>
                            <button id="volverPregunta2" class="swal2-styled" style="color: #464647; font-size: 16px; padding: 5px 10px; position: absolute; top: 20px; left: 20px;"><i class="fa-solid fa-arrow-left"></i></button>
                        `,
                        showConfirmButton: false,
                    });

                    document.getElementById('volverPregunta2').addEventListener('click', () => {
                        this.pregunta2();
                    });
                },

                pregunta3() {
                    Swal.fire({
                        title: '¿EXISTEN REDUNDANCIAS DENTRO DEL SISTEMA PARA MITIGAR EL EFECTO ADVERSO PROVOCADO?',
                        html: `
                <div style="position: absolute; top: 20px; right: 45px;">
                    <button id="misiones" class="swal2-confirm swal2-styled"
                        style="background-color: #F9F9F9; color: #464647; font-size: 16px;
                        font-family: 'Inter', sans-serif; padding: 5px 10px;
                        border: 1px solid black; border-radius: 10px;">
                        Misiones
                    </button>
                    <button id="ayuda" class="swal2-cancel swal2-styled"
                        style="background-color: white; color: #464647; font-size: 27px;">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </button>
                </div>
                <button id="atras" class="swal2-styled"
                    style="color: #464647; font-size: 16px; padding: 5px 10px;
                    position: absolute; top: 20px; left: 20px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            `,
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Sí',
                        denyButtonText: 'No',
                        cancelButtonText: 'Observaciones',
                        cancelButtonColor: '#3dd960',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.decisionPath += '1';
                            this.actualizarRutaRespuestas();
                            this.pregunta4();
                        } else if (result.isDenied) {
                            this.decisionPath += '0';
                            this.actualizarRutaRespuestas();
                            this.updateMec('MEC 4', '110.png');
                        } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                            this.mostrarPopupObservaciones('pregunta3');
                        }
                    });

                    document.getElementById('misiones').addEventListener('click', () => {
                        this.popupMisiones('pregunta3');
                    });

                    document.getElementById('ayuda').addEventListener('click', () => {
                        this.popupAyudaPregunta3();
                    });

                    document.getElementById('atras').addEventListener('click', () => {
                        this.retroceder();
                    });
                },

                popupAyudaPregunta3() {
                    Swal.fire({
                        title: '¿EXISTEN REDUNDANCIAS DENTRO DEL SISTEMA PARA MITIGAR EL EFECTO ADVERSO PROVOCADO?',
                        html: `
                <p class="mb-6">Considere que la respuesta es afirmativa si dentro del sistema existe un subsistema en paralelo que cumpla con la misma función y pueda suplir la funcionalidad de manera parcial.</p>
                <button id="volverPregunta3" class="swal2-styled"
                    style="color: #464647; font-size: 16px; padding: 5px 10px;
                    position: absolute; top: 20px; left: 20px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            `,
                        showConfirmButton: false,
                    });

                    document.getElementById('volverPregunta3').addEventListener('click', () => {
                        this.pregunta3();
                    });
                },

                pregunta4() {
                    Swal.fire({
                        title: '¿LA CADENA DE SUCESOS CAUSA ALGUNA LIMITACIÓN SOBRE ALGUNA DE LAS MISIONES?',
                        html: `
                <div style="position: absolute; top: 20px; right: 45px;">
                    <button id="misiones" class="swal2-confirm swal2-styled"
                        style="background-color: #F9F9F9; color: #464647; font-size: 16px;
                        font-family: 'Inter', sans-serif; padding: 5px 10px;
                        border: 1px solid black; border-radius: 10px;">
                        Misiones
                    </button>
                    <button id="ayuda" class="swal2-cancel swal2-styled"
                        style="background-color: white; color: #464647; font-size: 27px;">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </button>
                </div>
                <button id="atras" class="swal2-styled"
                    style="color: #464647; font-size: 16px; padding: 5px 10px;
                    position: absolute; top: 20px; left: 20px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            `,
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Sí',
                        denyButtonText: 'No',
                        cancelButtonText: 'Observaciones',
                        cancelButtonColor: '#3dd960',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.decisionPath += '1';
                            this.actualizarRutaRespuestas();
                            this.pregunta5();
                        } else if (result.isDenied) {
                            this.decisionPath += '0';
                            this.actualizarRutaRespuestas();
                            this.updateMec('MEC 1', '1110.png');
                        } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                            this.mostrarPopupObservaciones('pregunta4');
                        }
                    });

                    document.getElementById('misiones').addEventListener('click', () => {
                        this.popupMisiones('pregunta4');
                    });

                    document.getElementById('ayuda').addEventListener('click', () => {
                        this.popupAyudaPregunta4();
                    });

                    document.getElementById('atras').addEventListener('click', () => {
                        this.retroceder();
                    });
                },

                popupAyudaPregunta4() {
                    Swal.fire({
                        title: '¿LA CADENA DE SUCESOS CAUSA ALGUNA LIMITACIÓN SOBRE ALGUNA DE LAS MISIONES?',
                        html: `
                <p class="mb-6">Considere que la respuesta es afirmativa si dentro del sistema no existe un subsistema en paralelo que cumpla con la misma función y pueda suplir la exigencia necesaria de la unidad.</p>
                <button id="volverPregunta4" class="swal2-styled"
                    style="color: #464647; font-size: 16px; padding: 5px 10px;
                    position: absolute; top: 20px; left: 20px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            `,
                        showConfirmButton: false,
                    });

                    document.getElementById('volverPregunta4').addEventListener('click', () => {
                        this.pregunta4();
                    });
                },

                pregunta5() {
                    Swal.fire({
                        title: '¿EXISTEN REDUNDANCIAS DENTRO DEL SISTEMA?',
                        html: `
                <div style="position: absolute; top: 20px; right: 45px;">
                    <button id="misiones" class="swal2-confirm swal2-styled"
                        style="background-color: #F9F9F9; color: #464647; font-size: 16px;
                        font-family: 'Inter', sans-serif; padding: 5px 10px;
                        border: 1px solid black; border-radius: 10px;">
                        Misiones
                    </button>
                    <button id="ayuda" class="swal2-cancel swal2-styled"
                        style="background-color: white; color: #464647; font-size: 27px;">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </button>
                </div>
                <button id="atras" class="swal2-styled"
                    style="color: #464647; font-size: 16px; padding: 5px 10px;
                    position: absolute; top: 20px; left: 20px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            `,
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Sí',
                        denyButtonText: 'No',
                        cancelButtonText: 'Observaciones',
                        cancelButtonColor: '#3dd960',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.decisionPath += '1';
                            this.actualizarRutaRespuestas();
                            this.pregunta6();
                        } else if (result.isDenied) {
                            this.decisionPath += '0';
                            this.actualizarRutaRespuestas();
                            this.pregunta7();
                        } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                            this.mostrarPopupObservaciones('pregunta5');
                        }
                    });

                    document.getElementById('misiones').addEventListener('click', () => {
                        this.popupMisiones('pregunta5');
                    });

                    document.getElementById('ayuda').addEventListener('click', () => {
                        this.popupAyudaPregunta5();
                    });

                    document.getElementById('atras').addEventListener('click', () => {
                        this.retroceder();
                    });
                },

                popupAyudaPregunta5() {
                    Swal.fire({
                        title: '¿EXISTEN REDUNDANCIAS DENTRO DEL SISTEMA?',
                        html: `
                <p class="mb-6">Se habla de redundancia pasiva cuando se tiene un relevo disponible en stand-by para la función.</p>
                <button id="volverPregunta5" class="swal2-styled"
                    style="color: #464647; font-size: 16px; padding: 5px 10px;
                    position: absolute; top: 20px; left: 20px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            `,
                        showConfirmButton: false,
                    });

                    document.getElementById('volverPregunta5').addEventListener('click', () => {
                        this.pregunta5();
                    });
                },

                pregunta6() {
                    Swal.fire({
                        title: '¿MITIGA COMPLETAMENTE EL EFECTO DE LA LIMITACIÓN?',
                        html: `
                <div style="position: absolute; top: 20px; right: 45px;">
                    <button id="misiones" class="swal2-confirm swal2-styled"
                        style="background-color: #F9F9F9; color: #464647; font-size: 16px;
                        font-family: 'Inter', sans-serif; padding: 5px 10px;
                        border: 1px solid black; border-radius: 10px;">
                        Misiones
                    </button>
                    <button id="ayuda" class="swal2-cancel swal2-styled"
                        style="background-color: white; color: #464647; font-size: 27px;">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </button>
                </div>
                <button id="atras" class="swal2-styled"
                    style="color: #464647; font-size: 16px; padding: 5px 10px;
                    position: absolute; top: 20px; left: 20px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            `,
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Sí',
                        denyButtonText: 'No',
                        cancelButtonText: 'Observaciones',
                        cancelButtonColor: '#3dd960',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.decisionPath += '1';
                            this.actualizarRutaRespuestas();
                            this.updateMec('MEC 1', '111111.png');
                        } else if (result.isDenied) {
                            this.decisionPath += '0';
                            this.actualizarRutaRespuestas();
                            this.pregunta7();
                        } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                            this.mostrarPopupObservaciones('pregunta6');
                        }
                    });

                    document.getElementById('misiones').addEventListener('click', () => {
                        this.popupMisiones('pregunta6');
                    });

                    document.getElementById('ayuda').addEventListener('click', () => {
                        this.popupAyudaPregunta6();
                    });

                    document.getElementById('atras').addEventListener('click', () => {
                        this.retroceder();
                    });
                },

                popupAyudaPregunta6() {
                    Swal.fire({
                        title: '¿MITIGA COMPLETAMENTE EL EFECTO DE LA LIMITACIÓN?',
                        html: `
                <p class="mb-6">Considere si el subsistema de relevo es capaz de dar el mismo rendimiento del sistema durante un tiempo adecuado.</p>
                <button id="volverPregunta6" class="swal2-styled"
                    style="color: #464647; font-size: 16px; padding: 5px 10px;
                    position: absolute; top: 20px; left: 20px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            `,
                        showConfirmButton: false,
                    });

                    document.getElementById('volverPregunta6').addEventListener('click', () => {
                        this.pregunta6();
                    });
                },

                pregunta7() {
                    Swal.fire({
                        title: '¿DE QUÉ TAMAÑO SERÍAN LAS PÉRDIDAS?',
                        html: `
                <div style="position: absolute; top: 20px; right: 45px;">
                    <button id="misiones" class="swal2-confirm swal2-styled"
                        style="background-color: #F9F9F9; color: #464647; font-size: 16px;
                        font-family: 'Inter', sans-serif; padding: 5px 10px;
                        border: 1px solid black; border-radius: 10px;">
                        Misiones
                    </button>
                    <button id="ayuda" class="swal2-cancel swal2-styled"
                        style="background-color: white; color: #464647; font-size: 27px;">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </button>
                </div>
                <button id="atras" class="swal2-styled"
                    style="color: #464647; font-size: 16px; padding: 5px 10px;
                    position: absolute; top: 20px; left: 20px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            `,
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Menores o una misión',
                        denyButtonText: 'Más de una misión',
                        cancelButtonText: 'Observaciones',
                        cancelButtonColor: '#3dd960',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.decisionPath += '1';
                            this.actualizarRutaRespuestas();
                            this.updateMec('MEC 2', this.getDiagramImage());
                        } else if (result.isDenied) {
                            this.decisionPath += '0';
                            this.actualizarRutaRespuestas();
                            this.updateMec('MEC 3', this.getDiagramImage());
                        } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                            this.mostrarPopupObservaciones('pregunta7');
                        }
                    });

                    document.getElementById('misiones').addEventListener('click', () => {
                        this.popupMisiones('pregunta7');
                    });

                    document.getElementById('ayuda').addEventListener('click', () => {
                        this.popupAyudaPregunta7();
                    });

                    document.getElementById('atras').addEventListener('click', () => {
                        this.retroceder();
                    });
                },

                popupAyudaPregunta7() {
                    Swal.fire({
                        title: '¿DE QUÉ TAMAÑO SERÍAN LAS PERDIDAS?',
                        html: `
                <p class="mb-6">Se consideran pérdidas menores cuando el buque es capaz de realizar las misiones sin ningún inconveniente aún teniendo el sistema inoperativo.</p>
                <button id="volverPregunta7" class="swal2-styled"
                    style="color: #464647; font-size: 16px; padding: 5px 10px;
                    position: absolute; top: 20px; left: 20px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            `,
                        showConfirmButton: false,
                    });

                    document.getElementById('volverPregunta7').addEventListener('click', () => {
                        this.pregunta7();
                    });
                },

                updateMec(mec, image) {
                    const sistemaSeleccionado = this.sistemas.find(e => e.id == this.selectedSistema);

                    fetch(`/buques/{{ $buque->id }}/sistemas-buque/${this.selectedSistema}/mec`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ mec: mec, image: this.getDiagramImage(), observaciones: this.observacionesPorSistema[this.selectedSistema] || {} })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message === 'MEC actualizado correctamente') {
                                sistemaSeleccionado.pivot.mec = mec;
                                sistemaSeleccionado.pivot.image = this.getDiagramImage();
                                this.imagesPorSistema[this.selectedSistema] = this.getDiagramImage();
                                this.selectedMec = mec;
                                this.selectedImage = this.getDiagramImage();

                                let imagenElement = document.querySelector('.absolute-image img');
                                if (imagenElement) {
                                    imagenElement.src = this.getImageSrc(this.selectedImage);
                                    imagenElement.dataset.imageSrc = this.selectedImage;
                                }

                                Swal.fire('Actualizado', 'MEC actualizado correctamente', 'success');
                            } else {
                                Swal.fire('Error', 'No se pudo actualizar el MEC', 'error');
                            }
                        });
                },

                mostrarPopupObservaciones(pregunta) {
                    const _this = this;
                    const maxChars = 445;
                    Swal.fire({
                        title: `Observaciones <span id="char-count" style="font-size: 14px; color: #6b6b6b;">0/${maxChars}</span>`,
                        html: `
                                    <textarea id="observaciones-textarea" class="swal2-textarea" placeholder="Escribe tus observaciones aquí..." maxlength="${maxChars}">${this.observacionesPorSistema[this.selectedSistema]?.[pregunta] || ''}</textarea>
                                `,
                        showCancelButton: true,
                        confirmButtonText: 'Guardar',
                        cancelButtonText: 'Cancelar',
                        didOpen: () => {
                            const textarea = Swal.getPopup().querySelector('#observaciones-textarea');
                            const charCount = Swal.getPopup().querySelector('#char-count');
                            const updateCharCount = () => {
                                charCount.textContent = `${textarea.value.length}/${maxChars}`;
                            };
                            textarea.addEventListener('input', updateCharCount);
                            updateCharCount();
                        },
                        preConfirm: () => {
                            const observaciones = Swal.getPopup().querySelector('#observaciones-textarea').value;

                            if (!_this.observacionesPorSistema[_this.selectedSistema]) {
                                _this.observacionesPorSistema[_this.selectedSistema] = {};
                            }
                            _this.observacionesPorSistema[_this.selectedSistema][pregunta] = observaciones;

                            return fetch(`/buques/{{ $buque->id }}/sistemas-buque/${_this.selectedSistema}/save-observations`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    observaciones: _this.observacionesPorSistema[_this.selectedSistema]
                                })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        _this.actualizarObservacionesTabla();
                                        return true;
                                    } else {
                                        Swal.showValidationMessage('Error al guardar las observaciones');
                                        return false;
                                    }
                                })
                                .catch(() => {
                                    Swal.showValidationMessage('Error de red');
                                    return false;
                                });
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this[pregunta]();
                        }
                    });
                },

                actualizarObservacionesTabla() {
                    const observacionesDiv = document.getElementById('observaciones-tabla');
                    let observacionesHTML = '<table class="min-w-full divide-y divide-gray-200"><thead><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pregunta</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observación</th></tr></thead><tbody>';

                    if (this.observacionesPorSistema[this.selectedSistema]) {
                        for (const [pregunta, observacion] of Object.entries(this.observacionesPorSistema[this.selectedSistema])) {
                            const preguntaNumero = pregunta.replace('pregunta', '');
                            observacionesHTML += `<tr><td class="px-6 py-4 whitespace-nowrap">${preguntaNumero}</td><td class="px-6 py-4 whitespace-nowrap">${observacion}</td></tr>`;
                        }
                    } else {
                        observacionesHTML += '<tr><td colspan="2" class="px-6 py-4 text-center">No hay observaciones.</td></tr>';
                    }

                    observacionesHTML += '</tbody></table>';
                    observacionesDiv.innerHTML = observacionesHTML;
                },

                actualizarRutaRespuestas() {
                    const decisionPathDisplay = document.getElementById('decision-path-display');
                    decisionPathDisplay.textContent = this.decisionPath;
                },

                getDiagramImage() {
                    const diagramMap = {
                        '0': '0.png',
                        '100': '100.png',
                        '110': '110.png',
                        '1110': '1110.png',
                        '10100': '10100.png',
                        '10101': '10101.png',
                        '10111': '10111.png',
                        '101100': '101100.png',
                        '101101': '101101.png',
                        '111100': '111100.png',
                        '111101': '111101.png',
                        '111111': '111111.png',
                        '1111100': '1111100.png',
                        '1111101': '1111101.png'
                    };
                    return diagramMap[this.decisionPath] || '0.png';
                },

                // Continúa con las demás funciones de preguntas (pregunta3, pregunta4, etc.) y sus respectivas funciones de ayuda

                // Asegúrate de incluir todas las funciones sin omitir ninguna
            }
        }

        document.getElementById('viewPdfButton').addEventListener('click', function() {
            window.open(`{{ route('buques.viewPdf', ['buque' => $buque->id]) }}`, '_blank');
        });
    </script>

    <!-- Incluye los scripts necesarios -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        html, body {
            height: 100%;
            overflow: hidden;
        }
        .container {
            height: calc(100vh - 4rem);
        }

        @media (max-width: 640px) {
            .table-container {
                overflow-x: auto;
            }
        }
        .fade-in {
            opacity: 0;
            transition: opacity 0.5s ease-in;
        }
        .fade-in.show {
            opacity: 1;
        }

        .swal2-modal {
            font-family: 'Inter', sans-serif;
            margin-top: 50px;
            border-radius: 10px;
        }

        .swal2-modal .swal2-title {
            line-height: 1.2;
            font-size: 20px;
            margin-top: 70px;
            font-weight: bold;
            color: #464647;
        }

        .swal2-custom-buttons {
            position: absolute;
            top: 0;
            right: 10px;
            display: flex;
            gap: 10px;
            margin-top: 60px;
            margin-right: 20px;
        }

        .swal2-misiones-button, .swal2-help-button, .swal2-speak-button {
            background-color: transparent;
            color: #464647;
            border: 1.5px solid #3b3d40;
            border-radius: 15px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            margin-bottom: 50px;
            font-weight: bold;
        }

        .swal2-back-button {
            background-color: transparent;
            color: #464647;
            border: 1px solid #3b3d40;
            border-radius: 9999px;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            font-weight: bold;
            border: none;
        }

        .swal2-back-button:hover {
            color: #3458eb;
        }

        .swal2-help-button, .swal2-speak-button {
            padding: 10px 15px;
            border-radius: 15px;
        }

        .swal2-misiones-button:hover, .swal2-help-button:hover, .swal2-speak-button:hover {
            background-color: #6B7280;
            color: white;
        }

        .swal2-confirm, .swal2-cancel, .swal2-deny {
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 5px;
        }

        .img-container img {
            width: 100%;
            height: auto;
        }

        #expanded-image-container {
            display: none;
        }
        #expanded-image {
            max-width: 90%;
            max-height: 90%;
        }
        button.bg-blue-500:hover{
            background-color: #3b82f6;
        }
    </style>
</x-app-layout>
