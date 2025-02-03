<x-app-layout>
    @section('title', 'LSA')
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('buques.show', $buque->id) }}" class="text-blue-900 hover:text-blue-900 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                    </a>
                    <h1 class="text-2xl font-bold ml-2" style="font-family: 'Inter', sans-serif;">
                        Módulo LSA SISTEMAS: <span style="text-transform: uppercase; color: #1862B0;">{{ $buque->nombre_proyecto }}</span>
                    </h1>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-4 flex flex-col lg:flex-row gap-4 fade-in" x-data="lsaData()" x-init="initialize()">
        <div class="w-full flex flex-col">
            @if($sistemasBuques->isEmpty())
                <p>No hay sistemas asignados a este buque.</p>
            @else
                <div class="flex items-center justify-between mb-4">
                    <input
                        type="text"
                        placeholder="Buscar por código o nombre"
                        x-model="search"
                        class="px-4 py-2 border rounded-lg w-full lg:w-2/3"
                    />
                </div>

                <div class="table-container overflow-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Código
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    MEC
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sistemasBuques as $sistema)
                                <tr>
                                    <td class="px-6 py-4 text-left">{{ $sistema->codigo }}</td>
                                    <td class="px-6 py-4 text-left">{{ $sistema->nombre }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($sistema->pivot->mec)
                                            <span>{{ $sistema->pivot->mec }}</span>
                                        @else
                                            <span>No definido</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($sistema->pivot->mec)
                                        <button 
                                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none"
                                            @click="realizarLsa('{{ $sistema->id }}', '{{ $sistema->codigo }}', '{{ $sistema->nombre }}', '{{ $sistema->pivot->mec }}')">
                                            Realizar LSA
                                        </button>

                                        @else
                                            <a href="{{ route('buques.gres', $buque->id) }}" 
                                            class="text-blue-600 hover:text-blue-800 font-medium">
                                                Realizar GRES
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fadeInElements = document.querySelectorAll('.fade-in');
            fadeInElements.forEach(element => element.classList.add('show'));
        });

        function lsaData() {
            return {
                search: '',
                initialize() {
                    console.log('Componente LSA inicializado');
                },
                realizarLsa(id, codigo, nombre, mec) {
                    Swal.fire({
                        title: 'Realizar LSA',
                        text: `¿Desea iniciar el análisis LSA para el sistema ${nombre}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Datos de prueba que deseas enviar
                            const misiones = @json($misiones);
                            const datosPuertoBase =@json($datosPuertoBase)

                            // Preparar los datos para el POST
                            const payload = {
                                buqueId: {{ $buque->id }},
                                nombre_buque: "{{ $buque->nombre_proyecto }}",
                                sistemaId: id,
                                codigo: codigo,
                                nombre: nombre,
                                mec: mec,
                                misiones: misiones,
                                datosPuertoBase: datosPuertoBase
                            };

                            // Enviar la solicitud POST al contenedor Python
                            fetch('http://localhost:5000/LSA', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                credentials: 'include', // Esto asegura que las cookies se incluyan
                                body: JSON.stringify(payload),
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.redirect_url) {
                                    window.location.href = data.redirect_url; // Redirige al usuario si es necesario
                                } else {
                                    console.error('Error en la redirección:', data);
                                }
                            })
                            .catch(error => console.error('Error en la solicitud:', error));
                        }
                    });
                }
            };
        }
    </script>

    <style>
        .container {
            height: calc(100vh - 4rem);
        }

        .table-container {
            overflow-x: auto;
        }

        .fade-in {
            opacity: 0;
            transition: opacity 0.5s ease-in;
        }

        .fade-in.show {
            opacity: 1;
        }

        button.bg-blue-500:hover {
            background-color: #3b82f6;
        }

    </style>
</x-app-layout>
