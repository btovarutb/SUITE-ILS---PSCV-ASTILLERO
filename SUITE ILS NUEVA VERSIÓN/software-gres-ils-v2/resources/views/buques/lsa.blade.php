<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSA - {{ $buque->nombre }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <!-- Span LSA -->
            <span class="font-bold mt-0 text-center" style="color: rgb(33, 69, 169); font-size: 40px;">LSA</span>
            
            <!-- Span frase análisis de apoyo logístico con ancho limitado y texto ajustado -->
            <span class="text-gray-600 leading-tight" style="font-size: 14px; max-width: 140px; word-wrap: break-word; line-height: 1.3; padding-left: 4px">
                análisis de apoyo logístico
            </span>
            
            <!-- Span nombre de la embarcación -->
            <span
                style="
                    border-left: 2px solid #003366;
                    padding-left: 10px;
                    display: inline-block;
                "
            >
                <span
                    style="
                        color: #003366;
                        font-weight: 600;
                        font-size: 1.5rem;
                        display: inline-block;
                        cursor: pointer;
                        transition: transform 0.3s ease;
                    "
                    onmouseover="this.style.transform='translateY(-4px)'"
                    onmouseout="this.style.transform='translateY(0)'"
                    onclick="window.location.href='/{{ $buque->id }}/modulos'"
                >
                    {{ $buque->nombre }}
                </span>
            </span>

        </div>
    </x-slot>


    <div class="py-1" x-data="lsaData()">  <!-- ✅ Se inicializa Alpine.js -->
        <div class="container mx-auto px-4">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Listado de Sistemas</h3>

                <!-- Campo de búsqueda -->
                <div class="flex items-center justify-between mb-4">
                    <input
                        type="text"
                        placeholder="Buscar por código o nombre"
                        x-model="search"
                        class="px-4 py-2 border rounded-lg w-full lg:w-2/3"
                    />
                </div>

                @forelse ($sistemasBuques as $sistema)
                    <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-lg p-4 mb-3 shadow-sm hover:shadow-md transition">
                        <div>
                            <p class="text-gray-700 font-semibold text-lg">{{ $sistema->codigo }}</p>
                            <p class="text-gray-600 text-sm">{{ $sistema->nombre }}</p>
                            <p class="text-gray-500 text-sm">MEC: <strong>{{ $sistema->mec ?? 'No definido' }}</strong></p>
                        </div>

                        <!-- Acciones -->
                        <div class="flex space-x-2">
                            @if($sistema->mec)
                                <button 
                                    class="text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition" style="background-color: rgb(33, 69, 169)"
                                    @click="realizarLsa({{ $sistema->id }}, '{{ $sistema->codigo }}', '{{ $sistema->nombre }}', '{{ $sistema->mec }}')">
                                    Ver LSA
                                </button>
                            @else
                                <a 
                                    class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition">
                                    Realizar GRES (NO FUNCIONAL)
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No hay sistemas asociados a este buque.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        console.log("DOM Cargado");
    });

    function lsaData() {
    return {
        search: '',
        realizarLsa(id, codigo, nombre, mec) {
        Swal.fire({
            title: 'Ver LSA',
            text: `¿Desea redirigirse al análisis LSA para los equipos del sistema ${nombre}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No',
            confirmButtonColor: 'rgb(33, 69, 169)',
        }).then((result) => {
            if (!result.isConfirmed) return;

            const misiones        = @json($misiones);
            const datosPuertoBase = @json($datosPuertoBase);
            const payload = {
            buqueId: {{ $buque->id }},
            nombre_buque: "{{ $buque->nombre }}",
            sistemaId: id,
            codigo,
            nombre,
            mec,
            misiones,
            datosPuertoBase,
            origen: "realizarLsa"
            };

            fetch('{{ $flaskUrl }}/guardar_lsa', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            credentials: 'include',
            body: JSON.stringify(payload),
            })
            .then(r => {
            if (!r.ok) throw new Error('Error al guardar datos');
            return r.json();
            })
            .then(() => {
            // ✅ Redirige pasando TODO por query params (sin depender de cookie/sesión)
            const q = new URLSearchParams({
                buque_id:        String(payload.buqueId),
                sistema_id:      String(payload.sistemaId),
                nombre_buque:    payload.nombre_buque,
                codigo:          payload.codigo,
                nombre:          payload.nombre,
                mec:             payload.mec,
                origen:          payload.origen,
                misiones:        JSON.stringify(payload.misiones),
                datosPuertoBase: JSON.stringify(payload.datosPuertoBase),
            });
            window.location.assign('{{ $flaskUrl }}/desglose_sistema?' + q.toString());
            })
            .catch(err => {
            console.error('Error en la solicitud:', err);
            alert('Error al procesar la solicitud. Por favor, intente nuevamente.');
            });
        });
        }
    }
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
