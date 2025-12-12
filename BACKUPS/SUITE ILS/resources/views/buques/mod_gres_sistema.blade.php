<x-app-layout>
    @section('title', 'GRES Sistemas')
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
    <div class="container mx-auto flex" x-data="gresSystemData({{ $buque->id }})" x-init="initialize()">
        <div class="w-1/2 pr-4 h-full flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center space-x-4 w-full">
                    <input
                        type="text"
                        placeholder="Buscar por Sistema"
                        x-model="search"
                        class="px-4 py-2 border rounded-lg mt-2 ml-4 flex-grow"
                        style="flex-grow: 0.8;"
                    />
                    <div class="flex space-between mt-2 gap-3 ml-2">
                        <button @click="copyData" class="bg-blue-500 text-white px-4 py-2 rounded">Copiar</button>
                        <button id="viewPdfButton" class="bg-blue-500 text-white px-4 py-2 rounded mr-4"><i class="fa-solid fa-file-export"></i></button>
                    </div>
                </div>
            </div>

            <div class="flex-grow overflow-auto rounded-lg" id="scrollable-table">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sistema</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MEC</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template x-for="sistema in filteredSistemas" :key="sistema.id">
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap" x-text="sistema.id"></td>
                                <td class="px-6 py-4 break-words" x-text="sistema.nombre"></td>
                                <td class="px-6 py-4 whitespace-nowrap" x-text="sistema.mec || 'Sin asignar'"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button @click="selectSistema(sistema)" class="text-blue-600 hover:text-blue-900">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="w-1/2 pl-4">
            <div x-show="selectedSistema" class="p-4 bg-white h-full flex flex-col">
                <div class="flex items-center mb-4">
                    <div class="flex flex-col mr-4">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Sistema</span>
                        <span class="px-4 py-2 border rounded bg-gray-100" x-text="selectedSistema?.id"></span>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nombre Sistema</span>
                        <span class="px-4 py-2 border rounded bg-gray-100" x-text="selectedSistema?.nombre"></span>
                    </div>
                </div>

                <div class="flex items-start mb-4">
                    <div class="flex flex-col mr-4" style="min-width: 150px;">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">MEC</span>
                        <span class="px-4 py-2 border rounded bg-gray-100 mb-2" x-text="selectedSistema?.mec || 'MEC sin asignar'"></span>
                        <button @click="asignarMec" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Asignar MEC</button>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Diagrama de decisión</span>
                        <span class="px-4 py-2 border rounded bg-gray-100 flex justify-center items-center" style="min-width: 200px; min-height: 100px;">
                            <img :src="selectedSistema?.image ? getImageSrc(selectedSistema.image) : '/storage/images/ImageNullGres.png'" alt="Diagrama" class="w-full h-auto cursor-pointer" @click="expandImage">
                        </span>
                    </div>
                </div>

                <div class="flex flex-col mb-4" style="height: calc(100vh - 20rem);">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Observaciones</span>
                    <div id="observaciones-tabla" class="border rounded px-2 py-1 w-full h-24 overflow-auto mb-6"></div>
                    <div id="decision-path-display" class="border rounded px-2 py-1 w-full bg-gray-100 h-10 flex items-center justify-center"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="expanded-image-container" class="hidden fixed inset-0 bg-black bg-opacity-95 flex justify-center items-center z-50">
        <button id="close-expanded-image" class="absolute top-4 right-4 text-white text-3xl">&times;</button>
        <img id="expanded-image" src="" alt="Diagrama" class="max-w-full max-h-full">
    </div>

    <script>
        function gresSystemData() {
            return {
                isImageExpanded: false,
                expandedImageSrc: '',
                search: '',
                sistemas: [
                    { id: '100', nombre: 'Casco y Estructuras', mec: '', image: null },
                    { id: '200', nombre: 'Máquinaria y Propulsión', mec: '', image: null },
                    { id: '300', nombre: 'Planta Eléctrica', mec: '', image: null },
                    { id: '400', nombre: 'Comando y Vigilancia', mec: '', image: null },
                    { id: '500', nombre: 'Sistemas Auxiliares', mec: '', image: null },
                    { id: '600', nombre: 'Acabados y Amoblamiento', mec: '', image: null },
                    { id: '700', nombre: 'Armamento', mec: '', image: null }
                ],
                selectedSistema: null,
                decisionPath: '',
                observacionesPorSistema: {},



                get filteredSistemas() {
                    return this.sistemas.filter(sistema =>
                        sistema.id.toLowerCase().includes(this.search.toLowerCase()) ||
                        sistema.nombre.toLowerCase().includes(this.search.toLowerCase())
                    );
                },

                initialize() {
                    this.buqueId = {{ $buque->id }};
                    this.sistemas.forEach(sistema => {
                        // Parsear las observaciones si existen
                        if (sistema.pivot && sistema.pivot.observaciones) {
                            this.observacionesPorSistema[sistema.id] = JSON.parse(sistema.pivot.observaciones);
                        }
                        // Asignar mec e image desde el pivot
                        sistema.mec = sistema.pivot ? sistema.pivot.mec : '';
                        sistema.image = sistema.pivot ? sistema.pivot.image : null;
                    });
                },

                selectSistema(sistema) {
                    this.selectedSistema = sistema;
                    this.actualizarObservacionesTabla();
                    this.decisionPath = '';
                },

                asignarMec() {
                    this.decisionPath = '';
                    this.pregunta1();
                },

                pregunta1() {
                    Swal.fire({
                        title: '¿SE PIERDE LA CAPACIDAD DE LA UNIDAD SI EL SUB-SISTEMA QUEDA INOPERATIVO?',
                        html: `
                            <div style="position: absolute; top: 20px; right: 45px;">
                                <button id="misiones" class="swal2-confirm swal2-styled" style="background-color: #F9F9F9; color: #464647; font-size: 16px; font-family: 'Inter', sans-serif; padding: 5px 10px; border: 1px solid black; border-radius: 10px;">Misiones</button>
                                <button id="ayuda" class="swal2-cancel swal2-styled" style="background-color: white; color: #464647; font-size: 27px; padding: 5px 10px;"><i class="fa fa-question-circle" aria-hidden="true"></i></button>
                            </div>
                            <p>DESCRIBA LA CAPACIDAD PERDIDA</p>
                            <button id="atras" class="swal2-styled" style="color: #464647; font-size: 16px; padding: 5px 10px; position: absolute; top: 20px; left: 20px;"><i class="fa-solid fa-arrow-left"></i></button>
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
                        alert('Misiones clicked');
                    });

                    document.getElementById('ayuda').addEventListener('click', () => {
                        this.popupAyudaPregunta1();
                    });

                    document.getElementById('atras').addEventListener('click', () => {
                        this.retroceder();
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
                        alert('Misiones clicked');
                    });

                    document.getElementById('ayuda').addEventListener('click', () => {
                        this.popupAyudaPregunta2();
                    });

                    document.getElementById('atras').addEventListener('click', () => {
                        this.retroceder();
                    });
                },

                pregunta3() {
                    Swal.fire({
                        title: '¿EXISTEN REDUNDANCIAS DENTRO DEL SISTEMA PARA MITIGAR EL EFECTO ADVERSO PROVOCADO?',
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
                        alert('Misiones clicked');
                    });

                    document.getElementById('ayuda').addEventListener('click', () => {
                        this.popupAyudaPregunta3();
                    });

                    document.getElementById('atras').addEventListener('click', () => {
                        this.retroceder();
                    });
                },

                pregunta4() {
                    Swal.fire({
                        title: '¿LA CADENA DE SUCESOS CAUSA ALGUNA DEGRADACIÓN SOBRE ALGUNA DE LAS MISIONES?',
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
                        alert('Misiones clicked');
                    });

                    document.getElementById('ayuda').addEventListener('click', () => {
                        this.popupAyudaPregunta4();
                    });

                    document.getElementById('atras').addEventListener('click', () => {
                        this.retroceder();
                    });
                },

                pregunta5() {
                    Swal.fire({
                        title: '¿EXISTEN REDUNDANCIAS DENTRO DEL SUBSISTEMA?',
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
                        alert('Misiones clicked');
                    });

                    document.getElementById('ayuda').addEventListener('click', () => {
                        this.popupAyudaPregunta5();
                    });

                    document.getElementById('atras').addEventListener('click', () => {
                        this.retroceder();
                    });
                },

                pregunta6() {
                    Swal.fire({
                        title: '¿MITIGA COMPLETAMENTE EL EFECTO DE LA DEGRADACIÓN?',
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
                        alert('Misiones clicked');
                    });

                    document.getElementById('ayuda').addEventListener('click', () => {
                        this.popupAyudaPregunta6();
                    });

                    document.getElementById('atras').addEventListener('click', () => {
                        this.retroceder();
                    });
                },

                pregunta7() {
                    Swal.fire({
                        title: '¿DE QUÉ TAMAÑO SERÍAN LAS PÉRDIDAS?',
                        html: `
                            <div style="position: absolute; top: 20px; right: 45px;">
                                <button id="misiones" class="swal2-confirm swal2-styled" style="background-color: #F9F9F9; color: black; font-size: 16px; font-family: 'Inter', sans-serif; padding: 5px 10px; border: 1px solid black; border-radius: 10px;">Misiones</button>
                                <button id="ayuda" class="swal2-cancel swal2-styled" style="background-color: white; color: #464647; font-size: 27px; padding: 5px 10px;"><i class="fa fa-question-circle" aria-hidden="true"></i></button>
                            </div>
                            <button id="atras" class="swal2-styled" style="color: black; font-size: 16px; padding: 5px 10px; position: absolute; top: 20px; left: 20px;"><i class="fa-solid fa-arrow-left"></i></button>
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
                        alert('Misiones clicked');
                    });

                    document.getElementById('ayuda').addEventListener('click', () => {
                        this.popupAyudaPregunta7();
                    });

                    document.getElementById('atras').addEventListener('click', () => {
                        this.retroceder();
                    });
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

                updateMec(mec, image) {
                    const sistemaSeleccionado = this.selectedSistema;

                    fetch(`/buques/${this.buqueId}/sistemas/${sistemaSeleccionado.id}/mec`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            mec: mec,
                            image: image,
                            observaciones: this.observacionesPorSistema[sistemaSeleccionado.id] || {}
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message === 'MEC de sistema actualizado correctamente') {
                                sistemaSeleccionado.mec = mec;
                                sistemaSeleccionado.image = image;
                                this.selectedSistema = { ...sistemaSeleccionado };

                                // Actualizar el sistema en la lista de sistemas
                                const index = this.sistemas.findIndex(s => s.id === sistemaSeleccionado.id);
                                if (index !== -1) {
                                    this.sistemas[index] = { ...this.sistemas[index], mec: mec, image: image };
                                }

                                Swal.fire('Actualizado', 'MEC de sistema actualizado correctamente', 'success');
                            } else {
                                Swal.fire('Error', 'No se pudo actualizar el MEC del sistema', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Ocurrió un error al actualizar el MEC', 'error');
                        });
                },

                mostrarPopupObservaciones(pregunta) {
                    const _this = this;
                    Swal.fire({
                        title: 'Observaciones',
                        html: `<textarea id="observaciones-textarea" class="swal2-textarea" placeholder="Escribe tus observaciones aquí...">${this.observacionesPorSistema[this.selectedSistema.id] && this.observacionesPorSistema[this.selectedSistema.id][pregunta] ? this.observacionesPorSistema[this.selectedSistema.id][pregunta] : ''}</textarea>`,
                        showCancelButton: true,
                        confirmButtonText: 'Guardar',
                        cancelButtonText: 'Cancelar',
                        preConfirm: () => {
                            const observaciones = Swal.getPopup().querySelector('#observaciones-textarea').value;
                            if (!_this.observacionesPorSistema[_this.selectedSistema.id]) {
                                _this.observacionesPorSistema[_this.selectedSistema.id] = {};
                            }
                            _this.observacionesPorSistema[_this.selectedSistema.id][pregunta] = observaciones;

                            // Guardar observaciones en el servidor
                            fetch(`/buques/{{ $buque->id }}/sistemas/${_this.selectedSistema.id}/save-observations`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({ observaciones: _this.observacionesPorSistema[_this.selectedSistema.id] })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Guardado', 'Tus observaciones han sido guardadas.', 'success').then(() => {
                                        _this.actualizarObservacionesTabla();
                                        _this[pregunta]();
                                    });
                                } else {
                                    Swal.fire('Error', 'No se pudo guardar las observaciones', 'error');
                                }
                            });
                        }
                    }).then((result) => {
                        if (result.isDismissed) {
                            _this[pregunta]();
                        }
                    });
                },

                getImageSrc(image) {
                    if (!image) {
                        return '/storage/images/ImageNullGres.png';
                    }
                    return `/storage/diagramas_sistemas/${image}`;
                },

                actualizarObservacionesTabla() {
                    const observacionesDiv = document.getElementById('observaciones-tabla');
                    let observacionesHTML = '<table class="min-w-full divide-y divide-gray-200"><thead><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pregunta</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observación</th></tr></thead><tbody>';

                    if (this.observacionesPorSistema[this.selectedSistema.id]) {
                        for (const [pregunta, observacion] of Object.entries(this.observacionesPorSistema[this.selectedSistema.id])) {
                            const preguntaNumero = pregunta.replace('pregunta', '');
                            observacionesHTML += `<tr><td class="px-6 py-4 whitespace-nowrap">${preguntaNumero}</td><td class="px-6 py-4 whitespace-nowrap">${observacion}</td></tr>`;
                        }
                    }

                    observacionesHTML += '</tbody></table>';
                    observacionesDiv.innerHTML = observacionesHTML;
                },

                actualizarRutaRespuestas() {
                    const decisionPathDisplay = document.getElementById('decision-path-display');
                    decisionPathDisplay.textContent = this.decisionPath;
                },

                expandImage(event) {
                    this.expandedImageSrc = event.target.src;
                    this.isImageExpanded = true;
                },
                copyData() {
                    console.log('Copiar datos clicked');
                    // Implementar lógica para copiar datos
                },

                popupAyudaPregunta1() {
                    Swal.fire({
                        title: '¿SE PIERDE LA CAPACIDAD DE LA UNIDAD SI EL SUB-SISTEMA QUEDA INOPERATIVO?',
                        html: `
                            <p class="mb-6">Evalúe si la falla del sub-sistema afecta parcial o totalmente la funcionalidad de la unidad.</p>
                            <button id="volverPregunta1" class="swal2-styled" style="color: #464647; font-size: 16px; padding: 5px 10px; position: absolute; top: 20px; left: 20px;"><i class="fa-solid fa-arrow-left"></i></button>
                        `,
                        showConfirmButton: false,
                    });

                    document.getElementById('volverPregunta1').addEventListener('click', () => {
                        this.pregunta1();
                    });
                },

                popupAyudaPregunta2() {
                    Swal.fire({
                        title: '¿REPRESENTA UN EFECTO ADVERSO SOBRE EL PERSONAL, EL SISTEMA O EL MEDIO AMBIENTE?',
                        html: `
                            <p class="mb-6">Evalúe si al quedar inoperativo el sub-sistema, es decir, no cumplir su función, se refleja una consecuencia negativa sobre el personal, el sistema o el medio ambiente.</p>
                            <button id="volverPregunta2" class="swal2-styled" style="color: #464647; font-size: 16px; padding: 5px 10px; position: absolute; top: 20px; left: 20px;"><i class="fa-solid fa-arrow-left"></i></button>
                        `,
                        showConfirmButton: false,
                    });

                    document.getElementById('volverPregunta2').addEventListener('click', () => {
                        this.pregunta2();
                    });
                },

                popupAyudaPregunta3() {
                    Swal.fire({
                        title: '¿EXISTEN REDUNDANCIAS DENTRO DEL SISTEMA PARA MITIGAR EL EFECTO ADVERSO PROVOCADO?',
                        html: `
                            <p class="mb-6">Considere que la respuesta es afirmativa si dentro del sistema existe un sub-sistema en paralelo que cumpla con la misma función y pueda suplir la funcionalidad del sub-sistema inoperativo.</p>
                            <button id="volverPregunta3" class="swal2-styled" style="color: #464647; font-size: 16px; padding: 5px 10px; position: absolute; top: 20px; left: 20px;"><i class="fa-solid fa-arrow-left"></i></button>
                        `,
                        showConfirmButton: false,
                    });

                    document.getElementById('volverPregunta3').addEventListener('click', () => {
                        this.pregunta3();
                    });
                },

                popupAyudaPregunta4() {
                    Swal.fire({
                        title: '¿LA CADENA DE SUCESOS CAUSA ALGUNA DEGRADACIÓN SOBRE ALGUNA DE LAS MISIONES?',
                        html: `
                            <p class="mb-6">Evalúe si la inoperatividad del sub-sistema afecta negativamente el cumplimiento de alguna de las misiones de la unidad.</p>
                            <button id="volverPregunta4" class="swal2-styled" style="color: #464647; font-size: 16px; padding: 5px 10px; position: absolute; top: 20px; left: 20px;"><i class="fa-solid fa-arrow-left"></i></button>
                        `,
                        showConfirmButton: false,
                    });

                    document.getElementById('volverPregunta4').addEventListener('click', () => {
                        this.pregunta4();
                    });
                },

                popupAyudaPregunta5() {
                    Swal.fire({
                        title: '¿EXISTEN REDUNDANCIAS DENTRO DEL SUBSISTEMA?',
                        html: `
                            <p class="mb-6">Entiéndase como subsistema la línea de trabajo del sub-sistema. Se habla de redundancia pasiva cuando se tiene un relevo disponible en stand-by para el sub-sistema.</p>
                            <button id="volverPregunta5" class="swal2-styled" style="color: #464647; font-size: 16px; padding: 5px 10px; position: absolute; top: 20px; left: 20px;"><i class="fa-solid fa-arrow-left"></i></button>
                        `,
                        showConfirmButton: false,
                    });

                    document.getElementById('volverPregunta5').addEventListener('click', () => {
                        this.pregunta5();
                    });
                },

                popupAyudaPregunta6() {
                    Swal.fire({
                        title: '¿MITIGA COMPLETAMENTE EL EFECTO DE LA DEGRADACIÓN?',
                        html: `
                            <p class="mb-6">Considere si el sub-sistema de relevo es capaz de dar el mismo rendimiento dentro del sistema durante un tiempo adecuado.</p>
                            <button id="volverPregunta6" class="swal2-styled" style="color: #464647; font-size: 16px; padding: 5px 10px; position: absolute; top: 20px; left: 20px;"><i class="fa-solid fa-arrow-left"></i></button>
                        `,
                        showConfirmButton: false,
                    });

                    document.getElementById('volverPregunta6').addEventListener('click', () => {
                        this.pregunta6();
                    });
                },

                popupAyudaPregunta7() {
                    Swal.fire({
                        title: '¿DE QUÉ TAMAÑO SERÍAN LAS PÉRDIDAS?',
                        html: `
                            <p class="mb-6">Se consideran pérdidas menores cuando la unidad es capaz de realizar las misiones sin ningún inconveniente aún teniendo el sub-sistema inoperativo. Pérdidas mayores implican que más de una misión se ve afectada significativamente.</p>
                            <button id="volverPregunta7" class="swal2-styled" style="color: #464647; font-size: 16px; padding: 5px 10px; position: absolute; top: 20px; left: 20px;"><i class="fa-solid fa-arrow-left"></i></button>
                        `,
                        showConfirmButton: false,
                    });

                    document.getElementById('volverPregunta7').addEventListener('click', () => {
                        this.pregunta7();
                    });
                }
            }
        }

        document.getElementById('viewPdfButton').addEventListener('click', function() {
            console.log('Ver PDF clicked');
            // Implementar lógica para ver PDF
        });

        document.getElementById('close-expanded-image').addEventListener('click', function() {
            document.getElementById('expanded-image-container').classList.add('hidden');
        });
    </script>

<style>
    html, body {
        height: 100%;
        overflow: hidden;
    }
    .container {
        height: calc(100vh - 4rem);
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
