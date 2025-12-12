<x-app-layout>
    @section('title', 'FUA')
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('buques.show', $buque->id) }}" class="text-blue-900 hover:text-blue-900 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                    </a>
                    <h1 class="text-2xl font-bold ml-2" style="font-family: 'Inter', sans-serif;">
                        Módulo FUA: <span style="text-transform: uppercase; color: #1862B0;">{{ $buque->nombre_proyecto }}</span>
                    </h1>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div x-data="{ tab: 'perfil_navegacion' }" class="bg-white shadow rounded-lg p-6 flex">
            <!-- Navegación de pestañas -->
            <nav class="w-1/4 pr-4 border-r border-gray-200">
                <ul class="space-y-4">
                    <li>
                        <button type="button" @click="tab = 'perfil_navegacion'" :class="{'bg-blue-700 text-white': tab === 'perfil_navegacion', 'bg-gray-200 text-gray-700': tab !== 'perfil_navegacion'}" class="transition-colors duration-300 w-full text-left px-4 py-2 rounded flex items-center">
                            Perfil de Navegación Sugerido
                        </button>
                    </li>
                    <li>
                        <button type="button" @click="tab = 'ciclo_operacional'" :class="{'bg-blue-700 text-white': tab === 'ciclo_operacional', 'bg-gray-200 text-gray-700': tab !== 'ciclo_operacional'}" class="transition-colors duration-300 w-full text-left px-4 py-2 rounded flex items-center">
                            Ciclo Operacional (Primer Año)
                        </button>
                    </li>
                    <li>
                        <button type="button" @click="tab = 'perfil_mision'" :class="{'bg-blue-700 text-white': tab === 'perfil_mision', 'bg-gray-200 text-gray-700': tab !== 'perfil_mision'}" class="transition-colors duration-300 w-full text-left px-4 py-2 rounded flex items-center">
                            Perfil de Misión Operativa Tipo (Primer Año)
                        </button>
                    </li>
                    <li>
                        <button type="button" @click="tab = 'perfil_sistema'" :class="{'bg-blue-700 text-white': tab === 'perfil_sistema', 'bg-gray-200 text-gray-700': tab !== 'perfil_sistema'}" class="transition-colors duration-300 w-full text-left px-4 py-2 rounded flex items-center">
                            Perfil de Uso del Sistema de Propulsión
                        </button>
                    </li>
                    <li>
                        <button type="button" @click="tab = 'disponibilidad_bote'" :class="{'bg-blue-700 text-white': tab === 'disponibilidad_bote', 'bg-gray-200 text-gray-700': tab !== 'disponibilidad_bote'}" class="transition-colors duration-300 w-full text-left px-4 py-2 rounded flex items-center">
                            Disponibilidad del Bote (6 años)
                        </button>
                    </li>
                    <li>
                        <div class="text-center bg-gray-200 border border-gray-300 rounded-lg p-4">
                            <button type="button" disabled class="w-full text-gray-500 font-bold cursor-not-allowed">
                                Cronograma de Ciclo de Uso y Mantenimiento
                            </button>
                            <span class="block text-gray-500 mt-1 text-sm">En Desarrollo</span>
                        </div>
                    </li>
                    <li>
                        <div class="text-center bg-gray-200 border border-gray-300 rounded-lg p-4">
                            <button type="button" disabled class="w-full text-gray-500 font-bold cursor-not-allowed">
                                Cálculo de AOR para Equipos
                            </button>
                            <span class="block text-gray-500 mt-1 text-sm">En Desarrollo</span>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- Contenido de cada pestaña -->
            <div class="w-3/4 pl-4">
                <div x-show="tab === 'perfil_navegacion'">
                    <h2 class="text-2xl font-bold mb-4 text-blue-900">Perfil de Navegación Sugerido</h2>
                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 bg-blue-100 text-left">Operación</th>
                            <th class="border border-gray-300 px-4 py-2 bg-blue-100 text-left">% Tiempo</th>
                            <th class="border border-gray-300 px-4 py-2 bg-blue-100 text-left">Velocidad (Nudos)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($buque->buqueMisiones as $mision)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $mision->mision }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $mision->porcentaje }}%</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $mision->velocidad }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="border border-gray-300 px-4 py-2 text-center">No hay misiones registradas</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>


                <div x-show="tab === 'ciclo_operacional'">
                    <h2 class="text-2xl font-bold mb-4 text-blue-900">Ciclo Operacional (Primer Año)</h2>

                    @php
                        // Datos base
                        $totalDias = 365;
                        $totalHorasAnio = 8760.00; // Horas en un año fijo
                        $horasNavegacion = $buque->horas_navegacion_anual ?? 0;

                        // Fuera de Puerto/Navegación
                        // Convertir horasNavegacion a días (ceil hacia arriba)
                        $diasNavegacion = ceil($horasNavegacion / 24);
                        // Calcular % respecto a 365 días
                        $porcentajeNavegacion = $diasNavegacion > 0 ? round(($diasNavegacion / $totalDias) * 100, 2) : 0;

                        // Misiones Seleccionadas (Nuevas reglas)
                        // Ahora el porcentaje que teníamos en buque_misiones se aplica a horasNavegacionAnual.
                        // Horas = ceil((porcentaje/100)*horasNavegacion)
                        // Días = round(Horas/24)
                        // % = (Horas / 8760)*100

                        $misionesCalculadas = $buque->buqueMisiones->map(function($mision) use ($horasNavegacion, $totalDias, $totalHorasAnio) {
                            $p = $mision->porcentaje;
                            $horasMision = ceil(($p / 100) * $horasNavegacion);
                            $diasMision = round($horasMision / 24);
                            $porcentajeMision = $horasMision > 0 ? round(($horasMision / $totalHorasAnio) * 100, 2) : 0;
                            return [
                                'mision' => $mision->mision,
                                'dias' => $diasMision,
                                'horas' => $horasMision,
                                'porcentaje' => $porcentajeMision
                            ];
                        });

                        // Tabla Tipo, Días, Horas, %
                        // Valores desde buque_fua: disponible_misiones_1, disponibilidad_mantenimiento_1, roh_1
                        $disponibleMisionesHoras = optional($buque->fua)->disponible_misiones_1;
                        $mantMantenimientoHoras = optional($buque->fua)->disponibilidad_mantenimiento_1;
                        $revPeriodicaHoras = optional($buque->fua)->roh_1;

                        // Función para convertir horas a días y porcentaje (respecto a 365 días)
                        function convertirHoras($horas, $totalDias) {
                            if (is_null($horas)) {
                                return ['dias' => 'Null', 'horas' => 'Null', 'porcentaje' => 'Null'];
                            }
                            $diasFloat = $horas / 24;
                            $dias = round($diasFloat); // al entero más cercano
                            $porcentaje = ($dias > 0) ? round(($dias / $totalDias) * 100, 2) . '%' : '0%';
                            return ['dias' => $dias, 'horas' => $horas, 'porcentaje' => $porcentaje];
                        }

                        $dispMisiones = convertirHoras($disponibleMisionesHoras, $totalDias);
                        $dispManto = convertirHoras($mantMantenimientoHoras, $totalDias);
                        $revPeriodica = convertirHoras($revPeriodicaHoras, $totalDias);

                        // Puerto Base = suma de las 3 filas anteriores (días, horas, %)
                        // Si alguno es 'Null', lo tratamos como 0.
                        function parseValue($val) {
                            return ($val === 'Null' || $val === null) ? 0 : $val;
                        }
                        function parsePercentage($val) {
                            if ($val === 'Null') return 0;
                            return floatval(rtrim($val, '%'));
                        }

                        $sumDiasPuertoBase = parseValue($dispMisiones['dias']) + parseValue($dispManto['dias']) + parseValue($revPeriodica['dias']);
                        $sumHorasPuertoBase = parseValue($dispMisiones['horas']) + parseValue($dispManto['horas']) + parseValue($revPeriodica['horas']);
                        $sumPorcentajePuertoBase = parsePercentage($dispMisiones['porcentaje']) + parsePercentage($dispManto['porcentaje']) + parsePercentage($revPeriodica['porcentaje']);

                        // Si no hay datos (todos null), ponemos Null en vez de 0
                        if ($dispMisiones['dias'] === 'Null' && $dispManto['dias'] === 'Null' && $revPeriodica['dias'] === 'Null') {
                            $sumDiasPuertoBase = 'Null';
                            $sumHorasPuertoBase = 'Null';
                            $sumPorcentajePuertoBase = 'Null';
                        } else {
                            // Convertir porcentaje a string con % si no es Null
                            $sumPorcentajePuertoBase = ($sumPorcentajePuertoBase === 0 && $sumDiasPuertoBase === 0) ? 'Null' : $sumPorcentajePuertoBase . '%';
                        }
                    @endphp

                        <!-- Días Totales por Año -->
                    <div class="flex items-start justify-between mb-6">
                        <h3 class="text-xl font-semibold text-blue-700 mr-4">Días totales por Año</h3>
                        <table class="w-1/2 border-collapse border border-gray-200">
                            <thead>
                            <tr class="bg-blue-100">
                                <th class="border border-gray-300 px-4 py-2 font-semibold text-left">Días</th>
                                <th class="border border-gray-300 px-4 py-2 font-semibold text-right">Horas</th>
                                <th class="border border-gray-300 px-4 py-2 font-semibold text-right">%</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="border px-4 py-2 text-left">{{ $totalDias }}</td>
                                <td class="border px-4 py-2 text-right">8760.00</td>
                                <td class="border px-4 py-2 text-right">100%</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Fuera de Puerto / Navegación -->
                    <div class="flex items-start justify-between mb-6">
                        <h3 class="text-xl font-semibold text-blue-700 mr-4">Fuera de Puerto / Navegación</h3>
                        <table class="w-1/2 border-collapse border border-gray-200">
                            <thead>
                            <tr class="bg-blue-100">
                                <th class="border border-gray-300 px-4 py-2 font-semibold text-left">Días</th>
                                <th class="border border-gray-300 px-4 py-2 font-semibold text-right">Horas</th>
                                <th class="border border-gray-300 px-4 py-2 font-semibold text-right">%</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="border px-4 py-2 text-left">{{ $diasNavegacion }}</td>
                                <td class="border px-4 py-2 text-right">{{ ceil($horasNavegacion) }}</td>
                                <td class="border px-4 py-2 text-right">{{ $porcentajeNavegacion }}%</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Misiones Seleccionadas -->
                    <table class="w-full border-collapse mb-6">
                        <thead>
                        <tr class="bg-blue-100">
                            <th class="border px-4 py-2 font-semibold text-left">Misión</th>
                            <th class="border px-4 py-2 font-semibold text-right">Días</th>
                            <th class="border px-4 py-2 font-semibold text-right">Horas</th>
                            <th class="border px-4 py-2 font-semibold text-right">%</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($misionesCalculadas as $m)
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="border px-4 py-2">{{ $m['mision'] }}</td>
                                <td class="border px-4 py-2 text-right">{{ $m['dias'] }}</td>
                                <td class="border px-4 py-2 text-right">{{ $m['horas'] }}</td>
                                <td class="border px-4 py-2 text-right">{{ $m['porcentaje'] }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="border px-4 py-2 text-center">No hay misiones registradas</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- Puerto Base -->
                    @php
                        $diasPuertoBase = ($sumDiasPuertoBase === 'Null') ? 'Null' : $sumDiasPuertoBase;
                        $horasPuertoBase = ($sumHorasPuertoBase === 'Null') ? 'Null' : $sumHorasPuertoBase;
                        $porcPuertoBase = ($sumPorcentajePuertoBase === 'Null') ? 'Null' : $sumPorcentajePuertoBase;
                    @endphp

                    <div class="flex items-start justify-between mb-6">
                        <h3 class="text-xl font-semibold text-blue-700 mr-4">Puerto Base</h3>
                        <table class="w-1/2 border-collapse border border-gray-200">
                            <thead>
                            <tr class="bg-blue-100">
                                <th class="border border-gray-300 px-4 py-2 font-semibold text-left">Días</th>
                                <th class="border border-gray-300 px-4 py-2 font-semibold text-right">Horas</th>
                                <th class="border border-gray-300 px-4 py-2 font-semibold text-right">%</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="border px-4 py-2 text-left">{{ $diasPuertoBase }}</td>
                                <td class="border px-4 py-2 text-right">{{ $horasPuertoBase }}</td>
                                <td class="border px-4 py-2 text-right">{{ $porcPuertoBase }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabla Tipo, Días, Horas % -->
                    <table class="w-full border-collapse">
                        <thead>
                        <tr class="bg-blue-100">
                            <th class="border px-4 py-2 font-semibold text-left">Tipo</th>
                            <th class="border px-4 py-2 font-semibold text-right">Días</th>
                            <th class="border px-4 py-2 font-semibold text-right">Horas</th>
                            <th class="border px-4 py-2 font-semibold text-right">%</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="hover:bg-gray-100 transition-colors">
                            <td class="border px-4 py-2">Disponible para Misiones</td>
                            <td class="border px-4 py-2 text-right">{{ $dispMisiones['dias'] }}</td>
                            <td class="border px-4 py-2 text-right">{{ $dispMisiones['horas'] }}</td>
                            <td class="border px-4 py-2 text-right">{{ $dispMisiones['porcentaje'] }}</td>
                        </tr>
                        <tr class="hover:bg-gray-100 transition-colors">
                            <td class="border px-4 py-2">Disponibilidad de Mantenimiento</td>
                            <td class="border px-4 py-2 text-right">{{ $dispManto['dias'] }}</td>
                            <td class="border px-4 py-2 text-right">{{ $dispManto['horas'] }}</td>
                            <td class="border px-4 py-2 text-right">{{ $dispManto['porcentaje'] }}</td>
                        </tr>
                        <tr class="hover:bg-gray-100 transition-colors">
                            <td class="border px-4 py-2">Revisión Periódica</td>
                            <td class="border px-4 py-2 text-right">{{ $revPeriodica['dias'] }}</td>
                            <td class="border px-4 py-2 text-right">{{ $revPeriodica['horas'] }}</td>
                            <td class="border px-4 py-2 text-right">{{ $revPeriodica['porcentaje'] }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div x-show="tab === 'perfil_mision'">
                    <h2 class="text-2xl font-bold mb-4 text-blue-900">Perfil de Misión Operativa Tipo (Primer Año)</h2>
                    <div class="mb-4 text-right">
                        <button type="button" onclick="copyToClipboard()" class="bg-blue-500 text-white px-4 py-2 rounded">
                            Copiar como Tabla
                        </button>
                    </div>
                    <!-- Tabla completa -->
                    <table id="tabla-perfil-mision" class="min-w-full">
                        <!-- Ciclo de vida -->
                        <thead>
                        <tr>
                            <th colspan="2" class="text-left text-xl text-blue-900 py-2">Ciclo de Vida</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="py-2 px-4">Vida de Diseño</td>
                            <td class="py-2 px-4">
                                <input type="text" value="{{ $buque->tablaFua->vida_diseño ?? 'Calculando...' }}" readonly
                                       class="w-full p-2 border rounded-lg bg-gray-100">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Horas al Año</td>
                            <td class="py-2 px-4">
                                <input type="text" value="{{ $buque->tablaFua->horas_ano ?? 'Calculando...' }}" readonly
                                       class="w-full p-2 border rounded-lg bg-gray-100">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Horas de Mantenimiento al Año</td>
                            <td class="py-2 px-4">
                                <input type="text" value="{{ $buque->tablaFua->horas_mant_año ?? 'Calculando...' }}" readonly
                                       class="w-full p-2 border rounded-lg bg-gray-100">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Horas Disponibles al Año</td>
                            <td class="py-2 px-4">
                                <input type="text" value="{{ $buque->tablaFua->horas_disp_año ?? 'Calculando...' }}" readonly
                                       class="w-full p-2 border rounded-lg bg-gray-100">
                            </td>
                        </tr>
                        </tbody>
                        <!-- Operaciones -->
                        <thead>
                        <tr>
                            <th colspan="2" class="text-left text-xl text-blue-900 py-2">Operaciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="py-2 px-4">Máxima Misiones por Año</td>
                            <td class="py-2 px-4">
                                <input type="text" value="{{ $buque->tablaFua->max_mis_año ?? 'Calculando...' }}" readonly
                                       class="w-full p-2 border rounded-lg bg-gray-100">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Misiones acuerdo Plan de Uso y Mantenimiento</td>
                            <td class="py-2 px-4">
                                <input type="text" value="{{ $buque->tablaFua->mis_plan_mant ?? 'Calculando...' }}" readonly
                                       class="w-full p-2 border rounded-lg bg-gray-100">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Días de Operación por Año</td>
                            <td class="py-2 px-4">
                                <input type="text" value="{{ $buque->tablaFua->dias_op_año ?? 'Calculando...' }}" readonly
                                       class="w-full p-2 border rounded-lg bg-gray-100">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Días por Misión</td>
                            <td class="py-2 px-4">
                                <input type="text" value="{{ $buque->tablaFua->dias_mision ?? 'Calculando...' }}" readonly
                                       class="w-full p-2 border rounded-lg bg-gray-100">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Días de Navegación por Misión</td>
                            <td class="py-2 px-4">
                                <input type="text" value="{{ $buque->tablaFua->dias_nav_mision ?? 'Calculando...' }}" readonly
                                       class="w-full p-2 border rounded-lg bg-gray-100">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Horas Operacionales por Misión</td>
                            <td class="py-2 px-4">
                                <input type="text" value="{{ $buque->tablaFua->horas_op_mision ?? 'Calculando...' }}" readonly
                                       class="w-full p-2 border rounded-lg bg-gray-100">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Horas Operacionales por Año</td>
                            <td class="py-2 px-4">
                                <input type="text" value="{{ $buque->tablaFua->horas_op_año ?? 'Calculando...' }}" readonly
                                       class="w-full p-2 border rounded-lg bg-gray-100">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Horas de Navegación por Misión</td>
                            <td class="py-2 px-4">
                                <input type="text" value="{{ $buque->tablaFua->horas_nav_mision ?? 'Calculando...' }}" readonly
                                       class="w-full p-2 border rounded-lg bg-gray-100">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <script>
                    function copyToClipboard() {
                        // Obtener la tabla
                        const table = document.getElementById('tabla-perfil-mision');
                        let clipboardText = '';

                        // Recorrer las filas de la tabla
                        table.querySelectorAll('tr').forEach((row) => {
                            const columns = row.querySelectorAll('td');
                            if (columns.length > 0) {
                                // Combinar columnas en formato separado por tabulaciones
                                const rowText = Array.from(columns)
                                    .map((col) => col.innerText || col.querySelector('input')?.value || '')
                                    .join('\t');
                                clipboardText += rowText + '\n'; // Agregar nueva línea
                            }
                        });

                        // Copiar el texto al portapapeles
                        navigator.clipboard.writeText(clipboardText)
                            .then(() => {
                                alert('Datos copiados al portapapeles');
                            })
                            .catch(() => {
                                alert('Hubo un error al copiar los datos.');
                            });
                    }
                </script>

                <div x-show="tab === 'perfil_sistema'">
                    <h2 class="text-2xl font-bold mb-4 text-blue-900">Perfil de Uso del Sistema de Propulsión</h2>
                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 bg-blue-100 text-left">Operación</th>
                            <th class="border border-gray-300 px-4 py-2 bg-blue-100 text-left">Velocidad (Nudos)</th>
                            <th class="border border-gray-300 px-4 py-2 bg-blue-100 text-left">Número de Motores</th>
                            <th class="border border-gray-300 px-4 py-2 bg-blue-100 text-left">Energía/Potencia</th>
                            <th class="border border-gray-300 px-4 py-2 bg-blue-100 text-left">Descripción</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($buque->buqueMisiones as $mision)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $mision->mision }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $mision->velocidad }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $mision->num_motores }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $mision->potencia }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $mision->descripcion }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border border-gray-300 px-4 py-2 text-center">No hay misiones registradas</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>


                <div x-show="tab === 'disponibilidad_bote'">
                    <h2 class="text-2xl font-bold mb-4 text-blue-900">Disponibilidad del bote en un período de 6 años</h2>
                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead class="bg-blue-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 font-semibold text-left w-64">Estado de Disponibilidad</th>
                            <th class="border border-gray-300 px-4 py-2 font-semibold text-right">Año 1</th>
                            <th class="border border-gray-300 px-4 py-2 font-semibold text-right">Año 2</th>
                            <th class="border border-gray-300 px-4 py-2 font-semibold text-right">Año 3</th>
                            <th class="border border-gray-300 px-4 py-2 font-semibold text-right">Año 4</th>
                            <th class="border border-gray-300 px-4 py-2 font-semibold text-right">Año 5</th>
                            <th class="border border-gray-300 px-4 py-2 font-semibold text-right">Año 6</th>
                            <th class="border border-gray-300 px-4 py-2 font-semibold text-right">Promedio</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="hover:bg-gray-100 transition-colors">
                            <td class="border px-4 py-2 w-64">Buque Fuera de puerto (Horas a la Mar)</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                        </tr>
                        <tr class="hover:bg-gray-100 transition-colors">
                            <td class="border px-4 py-2 w-64">Buque Disponible (Horas en puerto - Listo para Zarpe)</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                        </tr>
                        <tr class="hover:bg-gray-100 transition-colors">
                            <td class="border px-4 py-2 w-64">Buque No Disponible (Horas de Mantenimiento + Horas de Revisión Periódicas)</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                        </tr>
                        <tr class="hover:bg-gray-100 transition-colors">
                            <td class="border px-4 py-2 w-64">Despliegue medio (horas) x año (disponibilidad operativa)</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                            <td class="border px-4 py-2 text-right">Null</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div x-show="tab === 'cronograma_ciclo'">
                    <h2 class="text-2xl font-bold mb-4 text-blue-900">Cronograma de Ciclo de Uso y Mantenimiento</h2>
                    <p>Hola Mundo</p>
                </div>

                <div x-show="tab === 'calculo_aor'">
                    <h2 class="text-2xl font-bold mb-4 text-blue-900">Cálculo de AOR para Equipos</h2>
                    <p>Hola Mundo</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        html, body {
            height: 100%;
            overflow-x: hidden;
        }
        .container {
            min-height: calc(100vh - 8.5rem);
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</x-app-layout>
