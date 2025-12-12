<x-app-layout>
    @section('title', $buque->nombre_proyecto)
    <div class="flex flex-col md:flex-row h-auto md:h-[calc(100vh-64px)]">
        <div class="w-full md:w-1/2 relative">
            @if ($buque->image_path)
                <img src="{{ Storage::url($buque->image_path) }}" alt="{{ $buque->nombre_proyecto }}" class="w-full h-full object-cover">
            @else
                <img src="{{ asset('storage/default/image.png') }}" alt="Default Image" class="w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-75"></div>
            <div class="absolute inset-x-4 bottom-4 text-left text-white" style="font-family: 'Inter', sans-serif;">
                <h1 class="text-2xl md:text-3xl font-bold uppercase truncate">{{ $buque->nombre_proyecto }}</h1>
                <p class="text-sm md:text-md mt-2 break-words whitespace-normal">
                    {{ $buque->descripcion_proyecto }}
                </p>
            </div>
        </div>
        <div class="w-full md:w-1/2 flex items-center justify-center bg-gray-100">
            <div x-data="{ showSubButtons: false }" class="w-full px-4">
                <template x-if="!showSubButtons">
                    <div class="flex flex-wrap justify-center items-center">
                        <!-- Fila superior con 3 botones -->
                        <div class="w-full flex justify-center">
                            <!-- Botón GRES con redireccionamiento -->
                            <a @click.prevent="showSubButtons = true" href="#" class="btn btn-delay-1 module-button">
                                <span class="module-text">Grado de Esencialidad</span>
                                <span class="module-code text-green-600 text-stroke-green-600">GRES</span>
                            </a>
                            <!-- Botón FUA con redireccionamiento -->
                            <a href="{{ route('buques.fua', $buque->id) }}" class="btn btn-delay-2 module-button">
                                <span class="module-text">Factor de Utilización Anual</span>
                                <span class="module-code text-blue-800 text-stroke-blue-600">FUA</span>
                            </a>
                            <!-- Botón LSA sin redireccionamiento -->
                            <a href="{{ route('acceder.lsa', ['buqueId' => $buque->id]) }}" class="btn btn-delay-3 module-button">
                                <span class="module-text">Módulo</span>
                                <span class="module-code text-red-600 text-stroke-red-600">LSA</span>
                            </a>
                        </div>
                        <!-- Fila inferior con 2 botones centrados -->
                        <div class="w-full flex justify-center mt-4">
                            <!-- Botón RAM sin redireccionamiento -->
                            <a href="#" class="btn btn-delay-4 module-button">
                                <span class="module-text">Módulo</span>
                                <span class="module-code text-purple-600 text-stroke-purple-600">RAM</span>
                            </a>
                            <!-- Botón LCC sin redireccionamiento -->
                            <a href="#" class="btn btn-delay-5 module-button">
                                <span class="module-text">Módulo</span>
                                <span class="module-code text-orange-600 text-stroke-orange-600">LCC</span>
                            </a>
                        </div>
                    </div>
                </template>
                <template x-if="showSubButtons">
                    <div class="flex flex-col space-y-4 items-center">
                        <!-- Botón para regresar -->
                        <a @click.prevent="showSubButtons = false" href="#" class="btn btn-delay-1 bg-gray-500 text-white w-12 h-12 rounded-full text-xl font-bold hover:bg-gray-700 flex items-center justify-center">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <div class="flex flex-wrap justify-center items-center">
                            <!-- Botón GRES Sistema con redireccionamiento -->
                            <a href="{{ route('buques.gres', $buque->id) }}" class="btn btn-delay-2 module-button">
                                <span class="module-subtext">GRES:</span>
                                <span class="module-subcode text-blue-600">Sistema</span>
                            </a>
                            <!-- Botón GRES Equipos con redireccionamiento -->
                            <a href="{{ route('buques.mod_gres_sistema', $buque->id) }}" class="btn btn-delay-3 module-button">
                                <span class="module-subtext">GRES:</span>
                                <span class="module-subcode text-green-600">Equipos</span>
                            </a>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #app {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn {
            animation: fadeIn 0.5s ease-in-out both;
            margin: 10px;
        }

        .btn-delay-1 {
            animation-delay: 0.1s;
        }

        .btn-delay-2 {
            animation-delay: 0.2s;
        }

        .btn-delay-3 {
            animation-delay: 0.3s;
        }

        .btn-delay-4 {
            animation-delay: 0.4s;
        }

        .btn-delay-5 {
            animation-delay: 0.5s;
        }

        .text-stroke-2 {
            -webkit-text-stroke-width: 2px;
            text-stroke-width: 2px;
        }

        .text-stroke-blue-600 {
            -webkit-text-stroke-color: #1E40AF;
            text-stroke-color: #1E40AF;
        }

        .text-stroke-green-600 {
            -webkit-text-stroke-color: #16A34A;
            text-stroke-color: #16A34A;
        }

        .text-stroke-red-600 {
            -webkit-text-stroke-color: #DC2626;
            text-stroke-color: #DC2626;
        }

        .text-stroke-purple-600 {
            -webkit-text-stroke-color: #7C3AED;
            text-stroke-color: #7C3AED;
        }

        .text-stroke-orange-600 {
            -webkit-text-stroke-color: #EA580C;
            text-stroke-color: #EA580C;
        }

        /* Estilos para los botones */
        .module-button {
            background-color: white;
            border: 1px solid #E5E7EB;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            width: 150px;
            height: 150px;
            margin: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            padding: 0.5rem;
            transition: transform 0.2s;
        }

        .module-button:hover {
            transform: scale(1.05);
        }

        .module-text {
            font-size: 1rem;
            font-weight: 600;
            color: #4B5563;
            text-align: center;
            line-height: 1.25rem;
        }

        .module-code {
            font-size: 2.5rem;
            font-weight: 800;
            margin-top: 0.5rem;
            -webkit-text-stroke-width: 1px;
            text-stroke-width: 1px;
        }

        .module-subtext {
            font-size: 1.25rem;
            font-weight: 700;
            color: #4B5563;
            text-align: center;
            line-height: 1.5rem;
        }

        .module-subcode {
            font-size: 1.5rem;
            font-weight: 900;
            margin-top: 0.25rem;
        }

        /* Disposición en pirámide invertida en pantallas grandes */
        @media (min-width: 768px) {
            /* Mantener el tamaño de los botones */
            .module-button {
                width: 150px;
                height: 150px;
            }

            /* Fila superior de 3 botones */
            .flex-wrap > .w-full:nth-child(1) {
                display: flex;
                justify-content: center;
            }

            /* Fila inferior de 2 botones centrados */
            .flex-wrap > .w-full:nth-child(2) {
                display: flex;
                justify-content: center;
            }

            /* Centrar los botones */
            .flex-wrap > .w-full a {
                margin: 0 20px;
            }
        }

        /* Disposición en columna en pantallas pequeñas */
        @media (max-width: 767px) {
            .flex-wrap {
                flex-direction: column;
            }

            .flex-wrap > .w-full {
                width: 100%;
                display: flex;
                justify-content: center;
            }

            .flex-wrap > .w-full a {
                margin: 10px 0;
            }
        }
    </style>
</x-app-layout>
