<!-- resources/views/buques/show.blade.php -->

<x-app-layout>
    @section('title', $buque->nombre_proyecto)
    <div class="container mx-auto px-4 py-8 sm:px-20">
        <div class="px-2 sm:px-4">
            <div class="flex items-center mb-4">
                <button onclick="window.location='{{ url('/dashboard') }}'" class="text-blue-500 hover:text-blue-700 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> 
                    <span class="text-xl" style="font-family: 'Inter', sans-serif;">{{ __('Regresar') }}</span>
                </button>
                <h1 class="text-2xl font-bold ml-4" style="font-family: 'Inter', sans-serif;">{{ $buque->nombre_proyecto }}</h1>
            </div>
            <div>
                <p style="font-family: 'Inter', sans-serif;">{{ $buque->descripcion_proyecto }}</p>
                <!-- Aquí puedes agregar los módulos que mencionaste -->
            </div>
        </div>
    </div>
</x-app-layout>
