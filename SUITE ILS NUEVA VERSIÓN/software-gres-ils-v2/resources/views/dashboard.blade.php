@section('title', 'Dashboard | Suite ILS')

<x-app-layout>
    <div class="bg-cover bg-center relative min-h-screen" x-data="{ search: '' }">
        
        <!-- Superposición para la opacidad -->
        <div class="absolute inset-0 bg-white opacity-85 z-0"></div>
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8 relative z-10 py-6">

            <div style="display: flex; justify-content: space-between; ">
                <div>
                    <h1 class="uppercase text-xl font-bold" style="color: #003366;">Proyectos Cotecmar</h1>
                    <p class="text-base text-gray-600">Selecciona el proyecto para entrar en la sección de módulos</p>
                </div>

                <!-- Buscador estilo imagen -->
                <div class="mb-6 max-w-md text-left">
                    <div class="flex">
                        <input type="text" x-model="search" placeholder="Buscar proyecto por nombre"
                            class="w-full px-4 py-2 border border-gray-300 rounded-l-md shadow-sm focus:ring-2 focus:ring-[#105dad] focus:outline-none">
                        <button class="px-4 rounded-r-md flex items-center justify-center" style="background-color: #003366">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.415l4.387 4.386a1 1 0 01-1.414 1.415l-4.387-4.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 py-5" x-sortable x-data="{ items: @json($buques) }">
                @foreach ($buques as $index => $buque)
                    <div x-data="{ show: false }"
                         x-init="setTimeout(() => show = true, {{ $index * 100 }})"
                         x-show="show && (search === '' || '{{ strtolower($buque->nombre) }}'.includes(search.toLowerCase()))"
                         x-transition:enter="transition-opacity duration-500 ease-in-out opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition-opacity duration-300 ease-in-out opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="bg-white shadow-md rounded-[4px] overflow-hidden font-inter relative h-[300px] group">
                        <a href="{{ route('buques.modulos', $buque->id) }}" class="block">
                            <div class="relative h-36 overflow-hidden">
                                <img src="{{ $buque->imagen ? Storage::url($buque->imagen) : asset('images/default.png') }}"
                                     alt="{{ $buque->nombre }}"
                                     class="object-cover w-full h-full transition-transform duration-300 ease-in-out group-hover:scale-110">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition duration-300 ease-in-out"></div>
                                @if ($buque->etapa)
                                    <div class="absolute top-2 right-2 z-10 bg-gray-800 text-white text-xs font-bold px-2 py-1 rounded uppercase">
                                        {{ $buque->etapa }}
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 flex flex-col justify-between h-[calc(100%-144px)]">
                                <div>
                                    <h3 class="text-s font-bold uppercase text-[#105dad]">{{ $buque->nombre }}</h3>
                                    <p class="text-sm text-gray-600 mt-3">{{ Str::limit($buque->descripcion, 100) }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endpush

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        .font-inter {
            font-family: 'Inter', sans-serif;
        }

        .bg-cover {
            background-image: url('/images/MAMONAL.webp'); /* Ruta de tu imagen */
            background-size: cover;
            background-position: center;
        }

        .min-h-screen {
            min-height: 100vh; /* Asegura que el contenedor cubra al menos toda la altura de la ventana */
        }
    </style>
</x-app-layout>
