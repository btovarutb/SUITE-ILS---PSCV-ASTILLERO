<x-app-layout>
    @section('title', 'Dashboard')
    <div class="relative min-h-screen">
        <!-- Imagen de fondo con desenfoque -->
        <div class="absolute inset-0 bg-cover bg-center opacity-15" style="background-image: url('https://www.cotecmar.com/sites/default/files/media/imagenes/2023-12/INSTALACIONES_1.png');">
        </div>

        <!-- Contenido principal -->
        <div class="relative z-10 container mx-auto px-20 py-8">
            <h1 class="text-2xl font-bold mb-6" style="color: #1862B0; font-family: 'Inter', sans-serif;">PROYECTOS MARÍTIMOS</h1>
            <div class="flex justify-between items-center mb-6">
                <!-- Barra de búsqueda -->
                <input
                    type="text"
                    id="search-input"
                    placeholder="Buscar proyectos..."
                    class="w-1/2 px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring focus:border-blue-300"
                />

                <!-- Botón para alternar vistas -->
                <button
                    id="toggle-view-button"
                    class="px-4 py-2 bg-gray-200 rounded shadow-md hover:bg-gray-300 transition flex items-center justify-center"
                >
                    <i id="toggle-icon" class="fas fa-list text-gray-500"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($buques as $index => $buque)
                    @php
                        // Estados y tags de ejemplo
                        $estados = ['Activo', 'En Construcción', 'En Puerto Base', 'En Servicio'];
                        $tags = ['Investigación', 'Control', 'Patrullero'];
                        $estado = $estados[$index % count($estados)];
                        $tag = $tags[$index % count($tags)];
                    @endphp

                    <a href="{{ route('buques.show', $buque->id) }}" class="buque-card bg-white shadow-md rounded overflow-hidden group flex flex-col h-full fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                        <img src="{{ $buque->image_url }}" alt="{{ $buque->nombre_proyecto }}" class="w-full h-32 object-cover transition duration-300 ease-in-out group-hover:brightness-75" draggable="false">
                        <div class="p-4 flex-grow flex flex-col">
                            <h2 class="text-xl font-bold mb-3" style="color: #1862B0; font-family: 'Inter', sans-serif;">{{ Str::limit(strtoupper($buque->nombre_proyecto), 50) }}</h2>
                            <p class="text-sm text-gray-600 flex-grow mb-4" style="font-family: 'Inter', sans-serif;">{{ Str::limit($buque->descripcion_proyecto, 100) }}</p>
                            <!-- Tags -->
                            <div class="flex flex-wrap gap-2">
                                <span class="text-xs bg-blue-100 text-blue-600 font-semibold px-2 py-1 rounded" style="font-family: 'Inter', sans-serif;">{{ $tag }}</span>
                            </div>
                        </div>
                        <!-- Estado -->
                        <div class="absolute top-2 right-2 bg-gray-800 text-white text-xs font-bold uppercase px-2 py-1 rounded">
                            {{ $estado }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.5s forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const toggleViewButton = document.getElementById('toggle-view-button');
            const projectContainer = document.querySelector('.grid');
            const projectCards = document.querySelectorAll('.buque-card');
            const toggleIcon = document.getElementById('toggle-icon');

            // Buscador en tiempo real
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    const query = searchInput.value.toLowerCase();
                    projectCards.forEach(card => {
                        const name = card.querySelector('h2').textContent.toLowerCase();
                        if (name.includes(query)) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }

            // Alternar vistas (Mosaico / Lista)
            if (toggleViewButton) {
                toggleViewButton.addEventListener('click', function () {
                    // Alternar entre grid y lista
                    if (projectContainer.classList.contains('grid')) {
                        projectContainer.classList.remove('grid', 'grid-cols-1', 'sm:grid-cols-2', 'md:grid-cols-3', 'lg:grid-cols-4');
                        projectContainer.classList.add('flex', 'flex-col', 'gap-4');
                        toggleIcon.classList.remove('fa-list');
                        toggleIcon.classList.add('fa-th');
                    } else {
                        projectContainer.classList.remove('flex', 'flex-col', 'gap-4');
                        projectContainer.classList.add('grid', 'grid-cols-1', 'sm:grid-cols-2', 'md:grid-cols-3', 'lg:grid-cols-4');
                        toggleIcon.classList.remove('fa-th');
                        toggleIcon.classList.add('fa-list');
                    }
                });
            }

            // SweetAlert para eliminar proyectos
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const buqueId = this.getAttribute('data-id');
                    Swal.fire({
                        title: '¿Estás seguro de borrar el proyecto?',
                        text: "No podrás revertir esta acción",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminalo',
                        cancelButtonText: 'No, cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${buqueId}`).submit();
                        }
                    });
                });
            });
        });
    </script>


</x-app-layout>
