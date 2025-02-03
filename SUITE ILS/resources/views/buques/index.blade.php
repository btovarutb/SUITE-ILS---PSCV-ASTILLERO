<x-app-layout>
    @section('title', 'Buques')
    <div class="container mx-auto px-1 py-8 sm:px-5">
        <div class="px-2 sm:px-4">
            <div class="flex flex-col sm:flex-row justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <h1 class="text-2xl font-bold mb-2 sm:mb-0" style="font-family: 'Inter', sans-serif;">Embarcaciones - </h1>
                    <span class="text-2xl font-bold mb-2 sm:mb-0" style="font-family: 'Inter', sans-serif;">{{ $currentDate }}</span>
                </div>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                    <form method="GET" action="{{ route('buques.index') }}" class="flex w-full sm:w-3/4">
                        <input type="text" name="search" id="search-input" placeholder="Nombre del proyecto" style="font-family: 'Inter', sans-serif;" class="form-input flex-grow px-4 py-2 border rounded-l" value="{{ request()->input('search') }}">
                        <button type="submit" style="font-family: 'Inter', sans-serif;" class="bg-green-400 text-white px-4 py-2 rounded-r">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <a href="{{ route('buques.create') }}" class="bg-green-400 text-white px-4 py-2 rounded flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i>Nuevo
                    </a>
                </div>
            </div>
            <div class="bg-white shadow-md rounded overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo de Buque
                            </th>
                            <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descripción
                            </th>
                            <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Autonomía de Horas
                            </th>
                            <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acción
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($buques as $buque)
                            <tr>
                                <td class="px-2 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $buque->nombre_proyecto }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $buque->tipo_buque }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 break-words">{{ Str::limit($buque->descripcion_proyecto, 50) }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $buque->autonomia_horas }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-4 whitespace-nowrap flex space-x-2">
                                    <a href="{{ route('buques.edit', $buque->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <button type="button" class="bg-red-600 text-white px-2 py-1 rounded delete-button" data-id="{{ $buque->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <form id="delete-form-{{ $buque->id }}" action="{{ route('buques.destroy', $buque->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    No se encontraron resultados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 flex justify-center">
                {{ $buques->links('vendor.pagination.default') }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');

            searchInput.addEventListener('input', function () {
                if (searchInput.value === '') {
                    window.location.href = "{{ route('buques.index') }}";
                }
            });

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
