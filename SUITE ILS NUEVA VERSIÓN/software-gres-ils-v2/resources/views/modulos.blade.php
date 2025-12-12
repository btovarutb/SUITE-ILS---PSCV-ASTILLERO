<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Módulos | Suite ILS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 overflow-hidden">
<x-app-layout>
    <div class="flex flex-col md:flex-row h-auto md:h-[calc(100vh-64px)]">
        <!-- Panel izquierdo: Imagen y descripción -->
        <div class="w-full md:w-1/2 relative">
            @if ($buque->imagen)
                <img src="{{ Storage::url($buque->imagen) }}" alt="{{ $buque->nombre }}" class="w-full h-full object-cover">
            @else
                <img src="{{ asset('images/default.png') }}" alt="Imagen por defecto" class="w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-75"></div>
            <div class="absolute bottom-4 left-4 text-white" style="font-family: 'Inter', sans-serif;">
                <h1 class="text-2xl md:text-3xl font-bold uppercase truncate">{{ $buque->nombre }}</h1>
                <p class="text-sm md:text-md mt-2 break-words whitespace-normal">{{ $buque->descripcion }}</p>
            </div>
        </div>

        <!-- Panel derecho: Botones de módulos -->
        <div class="w-full md:w-1/2 flex items-center justify-center bg-gray-100">
            <!-- Contenedor principal de botones en grid 2x2 -->
            <div id="main-buttons" class="grid grid-cols-2 gap-6">
                <!-- Botón Gestión de la Configuración -->
                <button onclick="window.location.href='{{ Config::get('api.flask_url') }}/equipos_buque/{{ rawurlencode($buque->nombre) }}?buque_id={{ $buque->id }}'"
                        class="flex flex-col items-center justify-center bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-lg w-40 h-40 p-4">
                    <span class="text-gray-500 text-sm font-semibold text-center">Gestión de la Configuración</span>
                    <span class="font-bold mt-0 text-center text-gray-500" style=" font-size: 40px">SWBS</span>
                </button>

                <!-- Botón FUA -->
                <a href="{{ route('buques.mod_fua', $buque->id) }}"
                class="flex flex-col items-center justify-center bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-lg w-40 h-40 p-4">
                    <span class="text-gray-500 text-sm font-semibold text-center">Módulo</span>
                    <span class="font-bold mt-0 text-center" style="color: rgb(150 54 234); font-size: 40px">FUA</span>
                </a>

                <!-- Botón GRES -->
                <button onclick="showGresOptions()"
                        class="flex flex-col items-center justify-center bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-lg w-40 h-40 p-4">
                    <span class="text-gray-500 text-sm font-semibold text-center">Grado de Esencialidad</span>
                    <span class="font-bold mt-0 text-center" style="color: rgb(18 164 73); font-size: 40px">GRES</span>
                </button>

                <!-- Botón LSA → análisis_lsa en Flask -->
                <button
                onclick="window.location.href='{{ Config::get('api.flask_url') }}/analisis_lsa/{{ rawurlencode($buque->nombre) }}?buque_id={{ $buque->id }}&from=analisis_lsa'"
                class="flex flex-col items-center justify-center bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-lg w-40 h-40 p-4">
                <span class="text-gray-500 text-sm font-semibold text-center">Módulo</span>
                <span class="font-bold mt-0 text-center" style="color: rgb(33 69 169); font-size: 40px">LSA</span>
                </button>

            </div>

            <!-- Contenedor de opciones GRES (inicialmente oculto) -->
            <div id="gres-options" class="hidden flex-col items-center">
                <!-- Botón de retorno -->
                <button onclick="showMainButtons()"
                        class="mb-6 text-gray-600 hover:text-gray-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-8 w-8"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <!-- Contenedor de botones GRES -->
                <div class="grid grid-cols-2 gap-6">
                    <a href="{{ route('buques.mod_gres', $buque->id) }}"
                    class="flex flex-col items-center justify-center bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-lg w-40 h-40 p-4">
                        <span class="text-gray-500 text-sm font-semibold text-center">Sistemas</span>
                        <span class="text-green-500 text-3xl font-bold mt-2 text-center">GRES</span>
                    </a>

                    <a href="{{ route('buques.mod_gres_equipo', $buque->id) }}"
                    class="flex flex-col items-center justify-center bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-lg w-40 h-40 p-4">
                        <span class="text-gray-500 text-sm font-semibold text-center">Equipos</span>
                        <span class="text-green-500 text-3xl font-bold mt-2 text-center">GRES</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        html, body {
            height: 100%;
            margin: 0;
        }

        .bg-gradient-to-b {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.75) 100%);
        }

        .text-white {
            font-family: 'Inter', sans-serif;
        }

        .flex-col {
            font-family: 'Inter', sans-serif;
        }

        a {
            text-decoration: none;
        }

        a:hover .text-green-500 {
            color: #15803d;
        }

        .rounded-lg {
            border-radius: 12px;
        }

        /* Animaciones */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(10px);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out forwards;
        }

        .fade-out {
            animation: fadeOut 0.3s ease-in-out forwards;
        }

        #gres-options {
            opacity: 0;
        }

        #gres-options.active {
            display: flex !important;
            animation: fadeIn 0.3s ease-in-out forwards;
        }
    </style>

    <script>
        function showGresOptions() {
            const mainButtons = document.getElementById('main-buttons');
            const gresOptions = document.getElementById('gres-options');

            mainButtons.classList.add('fade-out');

            setTimeout(() => {
                mainButtons.style.display = 'none';
                gresOptions.classList.add('active');
            }, 300);
        }

        function showMainButtons() {
            const mainButtons = document.getElementById('main-buttons');
            const gresOptions = document.getElementById('gres-options');

            gresOptions.classList.remove('active');

            setTimeout(() => {
                gresOptions.style.display = 'none';
                mainButtons.style.display = 'flex';
                mainButtons.classList.remove('fade-out');
                mainButtons.classList.add('fade-in');
            }, 300);
        }

        // Manejar el botón de retroceso del navegador
        window.addEventListener('popstate', function() {
            showMainButtons();
        });
    </script>
</x-app-layout>
</body>
</html>
