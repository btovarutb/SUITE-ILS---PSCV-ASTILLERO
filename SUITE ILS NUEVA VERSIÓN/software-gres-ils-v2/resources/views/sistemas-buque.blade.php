<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistemas {{ $buque->nombre }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .header-container span {
            font-size: 20px;
            border-left: 3px solid #003366;
            padding-left: 10px;
            margin-left: 20px;
            text-transform: uppercase;
        }
    </style>
</head>
<body class="bg-gray-100">
<x-app-layout>
    <x-slot name="header">
        <div class="header-container flex items-center space-x-4 bg-gray-100 rounded">
            <a href="{{ route('buques.index') }}" class="flex items-center text-azulCotecmar font-medium hover:underline">
                <img src="{{ asset('images/chevron-left.svg') }}" alt="Volver" class="w-5 h-5 mr-1">
                Volver
            </a>

            <span class="text-azulCotecmar font-bold text-lg">
                Sistemas {{ $buque->nombre }}
            </span>
        </div>
    </x-slot>


    <div style="margin: 1rem;" x-data="lsaData()"> <!-- Inicializamos Alpine.js -->
        <div class="container mx-auto px-4">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold text-azulCotecmar mb-4">Listado de Sistemas</h3>
                
                @forelse ($sistemas as $sistema)
                    <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-lg p-4 mb-3 shadow-sm hover:shadow-md transition">
                        <div>
                            <p class="text-azulCotecmar font-semibold text-lg">{{ $sistema->codigo }}</p>
                            <p class="text-azulCotecmar text-sm">{{ $sistema->nombre }}</p>
                        </div>

                        <button 
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition"
                            @click="verEquipos({{ $sistema->id }}, '{{ $sistema->codigo }}', '{{ $sistema->nombre }}', '{{ $sistema->mec ?? 'No definido' }}')">
                            Ver Equipos
                        </button>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No hay sistemas asociados a este buque.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

<script>
   function lsaData() {
    return {
        search: '',
        initialize() {
            console.log('Componente LSA inicializado');
        },

        verEquipos(id, codigo, nombre, mec) {
            console.log("Redirigiendo directamente a /desglose_sistema con params");

            const misiones = @json($misiones);
            const datosPuertoBase = @json($datosPuertoBase);

            // Encodear como JSON y luego URI para pasar por query string
            const params = new URLSearchParams({
                buque_id: {{ $buque->id }},
                nombre_buque: "{{ $buque->nombre }}",
                sistema_id: id,
                codigo: codigo,
                nombre: nombre,
                mec: mec,
                origen: "sistemas",
                misiones: JSON.stringify(misiones),
                datosPuertoBase: JSON.stringify(datosPuertoBase)
            });

            window.location.href = `{{ $flaskUrl }}/desglose_sistema?${params.toString()}`;
        }
    };
}

</script>

<style>
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
    button.bg-blue-500:hover {
        background-color: #3b82f6;
    }
</style>

</body>
</html>
