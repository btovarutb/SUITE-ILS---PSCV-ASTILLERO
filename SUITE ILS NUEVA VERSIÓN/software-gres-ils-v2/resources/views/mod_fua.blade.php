<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUA - {{ $buque->nombre }}</title> <!-- Título de la ventana dinámico -->

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0.3s, opacity 0.3s;
        }

        .overlay.active {
            visibility: visible;
            opacity: 1;
        }

        .overlay img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            background: white;
            padding: 20px;
        }

        .overlay img:hover {
            transform: scale(1.05);
        }

        /* Contenedor principal */
        #desglose-container {
            display: flex;
            width: 100%;
            transition: all 0.5s ease;
        }

        /* Transiciones suaves */
        #grupos-container,
        #equipos-container {
            transition: all 0.5s ease;
            overflow-x: hidden;
        }

        /* Colores y tamaños de botones */
        button.group-btn,
        button.system-btn {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: start;
            width: 100%;
            padding: 10px 15px;
            margin-bottom: 5px;
            background-color: rgb(229, 231, 235);
            color: #003366;
            border-radius: 8px;
            border: none;
            transition: all 0.3s ease;
            text-align: left;
        }

        /* Botón al pasar el mouse */
        button.group-btn:hover,
        button.system-btn:hover {
            background-color: rgb(200, 202, 205);
        }

        /* Estilo cuando está seleccionado */
        button.selected-group,
        button.selected-system {
            background-color: #105dad !important;
            color: white;
        }

        /* Código del grupo/sistema */
        button .code {
            font-size: 18px;
            font-weight: 900;
        }

        /* Descripción del grupo/sistema */
        button .desc {
            font-size: 13px;
            text-align: left;
            flex-grow: 1;
            padding-left: 10px;
        }

        .titulo-col{
            font-size: 14px;
            height: 45px;
            text-align: center;
            color: #003366;
        }

        #grupos-container{
            width: 20%;
        }

        #equipos-container{
            width: 80%;
        }

        #filtro-sistemas{
            padding: 5.5px;
        }

        #filtro-sistemas-container{
            color: #003366;
        }

        .no-equipos-msg {
            text-align: center;
            font-size: 16px;
            color: #555;
            padding: 50px 0;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .ver-fua-btn {
            background-color: #9636ea;
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            transition: background-color 0.2s;
        }
        .ver-fua-btn:hover {
            background-color:rgb(121, 46, 187);
        }

        .tab-btn.active {
            background-color:rgb(121, 46, 187) !important;
            color: white !important;
            border-radius: 6px;
        }

        .tab-btn.active span {
            color: white !important;
        }


        #listaBotones button {
            border-radius: 6px;
            color: #323336;
            background-color: rgb(229, 231, 235);
        }

          /* Estilos para el tooltip */
        .tooltip-container {
            position: relative;
            display: inline-block;
        }

        .tooltip {
            visibility: hidden;
            width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .tooltip::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        }

        .tooltip-container:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }

         .help-button {
            background-color: #105dad;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .help-button:hover {
            background-color: #0d4b8c;
        }


    </style>
</head>
<body class="bg-gray-100">




<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <!-- Span FUA -->
            <span class="font-bold mt-0 text-center" style="color: rgb(150, 54, 234); font-size: 40px;">FUA</span>
            
            <!-- Span frase Factor de utilización anual con ancho limitado y texto ajustado -->
            <span class="text-gray-600 leading-tight" style="font-size: 14px; max-width: 120px; word-wrap: break-word; line-height: 1.3; padding-left: 4px; margin-right: 10px;">
                Factor de utilización anual
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


    <div class="container mx-auto py-1 px-6">
        <div class="flex space-x-4">
            <!-- Panel izquierdo: Lista de botones -->
            <div id="listaBotones" class="bg-white rounded shadow p-2" style="width: 20%">
                <ul class="space-y-2">
                    <li>
                        <button
                            id="btn-perfil-navegacion"
                            class="tab-btn w-full text-left px-4 py-2 "
                            onclick="showTab('perfil-navegacion', this)">
                            Perfil de Navegación Sugerido
                        </button>
                    </li>
                    <li>
                        <button
                            id="btn-ciclo-operacional"
                            class="tab-btn w-full text-left px-4 py-2 "
                            onclick="showTab('ciclo-operacional', this)">
                            Ciclo Operacional<br><span class="text-sm text-gray-600">(Primer Año)</span>
                        </button>
                    </li>
                    <li>
                        <button
                            id="btn-perfil-mision"
                            class="tab-btn w-full text-left px-4 py-2 "
                            onclick="showTab('perfil-mision', this)">
                            Perfil de Misión Operativa Tipo<br><span class="text-sm text-gray-600">(Primer Año)</span>
                        </button>
                    </li>
                    <li>
                        <button
                            id="btn-perfil-uso-propulsion"
                            class="tab-btn w-full text-left px-4 py-2 "
                            onclick="showTab('perfil-uso-propulsion', this)">
                            Perfil de Uso del Sistema de Propulsión
                        </button>
                    </li>
                    <li>
                        <button
                            id="btn-disponibilidad-bote"
                            class="tab-btn w-full text-left px-4 py-2 "
                            onclick="showTab('disponibilidad-bote', this)">
                            Disponibilidad del Bote<br><span class="text-sm text-gray-600">(6 años)</span>
                        </button>
                    </li>
                    <li>
                        <button
                            id="btn-cronograma-uso"
                            class="tab-btn w-full text-left px-4 py-2 "
                            onclick="showTab('cronograma-uso', this)">
                            Cronograma de Ciclo de uso y Mantenimiento
                        </button>
                    </li>
                    <li>
                        <button 
                            id="btn-calculo-aor"
                            class="tab-btn w-full text-left px-4 py-2 "
                            onclick="showTab('calculo-aor', this)">
                            Cálculo de AOR para Equipos
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Panel derecho: Contenido dinámico -->
            <div class="bg-white rounded shadow p-4 relative" style="width: 80%">
                <!-- Tab: Perfil de Navegación Sugerido -->
                <div id="perfil-navegacion" class="tab-content hidden opacity-0 transition-opacity duration-500">
                    <h2 class="text-xl font-bold mb-2">Perfil de Navegación Sugerido</h2>

                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-blue-100">
                                <th class="border px-4 py-2 font-semibold text-left">Operación</th>
                                <th class="border px-4 py-2 font-semibold text-left">% Tiempo</th>
                                <th class="border px-4 py-2 font-semibold text-left">Velocidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($buque->misiones as $mision)
                                <tr>
                                    <!-- Nombre de la misión (columna 'nombre' en tu tabla misiones) -->
                                    <td class="border px-4 py-2">{{ $mision->nombre }}</td>

                                    <!-- Porcentaje en la tabla pivote buque_misiones -->
                                    <td class="border px-4 py-2">{{ $mision->pivot->porcentaje }}%</td>

                                    <!-- Velocidad en null (por ahora) -->
                                    <td class="border px-4 py-2">{{ $mision->pivot->velocidad }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="border px-4 py-2 text-center">No hay misiones registradas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Tab: Ciclo Operacional (Primer Año) -->
                <div id="ciclo-operacional" class="tab-content hidden opacity-0 transition-opacity duration-500">
                    <h2 class="text-xl font-bold mb-2 text-[#105dad]">Ciclo Operacional (Primer Año)</h2>

                    @php
                        // Datos base
                        $totalDias = 365;
                        $totalHorasAnio = 8760.00; // Horas en un año fijo
                        $horasNavegacion = $buque->horas_navegacion_anio ?? 0;

                        // Fuera de Puerto/Navegación
                        $diasNavegacion = ceil($horasNavegacion / 24);
                        $porcentajeNavegacion = $diasNavegacion > 0 ? round(($diasNavegacion / $totalDias) * 100, 2) : 0;

                        // Misiones Seleccionadas
                        $misionesCalculadas = $buque->misiones->map(function($mision) use ($horasNavegacion, $totalDias, $totalHorasAnio) {
                            $p = $mision->pivot->porcentaje;

                            // No usamos ceil aquí
                            $horasMision = ($p / 100) * $horasNavegacion;

                            // Días redondeados normalmente
                            $diasMision = round($horasMision / 24);

                            // Porcentaje respecto a total del año
                            $porcentajeMision = $horasMision > 0 ? round(($horasMision / $totalHorasAnio) * 100, 2) : 0;

                            return [
                                'mision' => $mision->nombre,
                                'dias' => $diasMision,
                                'horas' => round($horasMision, 2), // Opcional: puedes mostrar horas redondeadas a 2 decimales
                                'porcentaje' => $porcentajeMision
                            ];
                        });


                        // Datos del puerto base desde buque_fua
                        $disponibleMisionesHoras = optional($datosPuertoBase)->disponible_misiones_1;
                        $mantMantenimientoHoras = optional($datosPuertoBase)->disponibilidad_mantenimiento_1;
                        $revPeriodicaHoras = optional($datosPuertoBase)->roh_1;


                        // Función para convertir horas a días y porcentaje
                        function convertirHoras($horas, $totalDias) {
                            if (is_null($horas)) {
                                return ['dias' => 'Null', 'horas' => 'Null', 'porcentaje' => 'Null'];
                            }
                            $diasFloat = $horas / 24;
                            $dias = round($diasFloat);
                            $porcentaje = ($dias > 0) ? round(($dias / $totalDias) * 100, 2) . '%' : '0%';
                            return ['dias' => $dias, 'horas' => $horas, 'porcentaje' => $porcentaje];
                        }

                        // Convertir las horas a días y porcentajes
                        $dispMisiones = convertirHoras($disponibleMisionesHoras, $totalDias);
                        $dispManto = convertirHoras($mantMantenimientoHoras, $totalDias);
                        $revPeriodica = convertirHoras($revPeriodicaHoras, $totalDias);

                        // Cálculo de Puerto Base
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

                        if ($dispMisiones['dias'] === 'Null' && $dispManto['dias'] === 'Null' && $revPeriodica['dias'] === 'Null') {
                            $sumDiasPuertoBase = 'Null';
                            $sumHorasPuertoBase = 'Null';
                            $sumPorcentajePuertoBase = 'Null';
                        } else {
                            $sumPorcentajePuertoBase = ($sumPorcentajePuertoBase === 0 && $sumDiasPuertoBase === 0) ? 'Null' : $sumPorcentajePuertoBase . '%';
                        }
                    @endphp

                    <!-- Días Totales por Año -->
                    <div class="flex items-start justify-between mb-6">
                        <h3 class="text-xl font-semibold text-[#105dad] mr-4">Días totales por Año</h3>
                        <table class="w-1/2 border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-blue-100">
                                    <th class="border border-gray-300 px-4 py-2 font-semibold text-left text-[#105dad]">Días</th>
                                    <th class="border border-gray-300 px-4 py-2 font-semibold text-right text-[#105dad]">Horas</th>
                                    <th class="border border-gray-300 px-4 py-2 font-semibold text-right text-[#105dad]">%</th>
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
                        <h3 class="text-xl font-semibold text-[#105dad] mr-4">Fuera de Puerto / Navegación</h3>
                        <table class="w-1/2 border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-blue-100">
                                    <th class="border border-gray-300 px-4 py-2 font-semibold text-left text-[#105dad]">Días</th>
                                    <th class="border border-gray-300 px-4 py-2 font-semibold text-right text-[#105dad]">Horas</th>
                                    <th class="border border-gray-300 px-4 py-2 font-semibold text-right text-[#105dad]">%</th>
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

                    <h2>{{ $horasNavegacion }}</h2>

                    <!-- Misiones Seleccionadas -->
                    <table class="w-full border-collapse mb-6">
                        <thead>
                            <tr class="bg-blue-100">
                                <th class="border px-4 py-2 font-semibold text-left text-[#105dad]">Misión</th>
                                <th class="border px-4 py-2 font-semibold text-right text-[#105dad]">Días</th>
                                <th class="border px-4 py-2 font-semibold text-right text-[#105dad]">Horas</th>
                                <th class="border px-4 py-2 font-semibold text-right text-[#105dad]">%</th>
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
                    <div class="flex items-start justify-between mb-6">
                        <h3 class="text-xl font-semibold text-[#105dad] mr-4">Puerto Base</h3>
                        <table class="w-1/2 border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-blue-100">
                                    <th class="border border-gray-300 px-4 py-2 font-semibold text-left text-[#105dad]">Días</th>
                                    <th class="border border-gray-300 px-4 py-2 font-semibold text-right text-[#105dad]">Horas</th>
                                    <th class="border border-gray-300 px-4 py-2 font-semibold text-right text-[#105dad]">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-gray-100 transition-colors">
                                    <td class="border px-4 py-2 text-left">{{ round((8760 - $buque->horas_navegacion_anio)/24,0) }}</td>
                                    <td class="border px-4 py-2 text-right">{{  8760 - $buque->horas_navegacion_anio }}</td>
                                    <td class="border px-4 py-2 text-right">{{ round(((8760 - $buque->horas_navegacion_anio) * 100)/8760,2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabla Tipo, Días, Horas % -->
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-blue-100">
                                <th class="border px-4 py-2 font-semibold text-left text-[#105dad]">Tipo</th>
                                <th class="border px-4 py-2 font-semibold text-right text-[#105dad]">Días</th>
                                <th class="border px-4 py-2 font-semibold text-right text-[#105dad]">Horas</th>
                                <th class="border px-4 py-2 font-semibold text-right text-[#105dad]">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="border px-4 py-2">Disponible para Misiones</td>
                                <td class="border px-4 py-2 text-right">{{ round($disponibleMisionesHoras / 24) }}</td>
                                <td class="border px-4 py-2 text-right">{{ $disponibleMisionesHoras }}</td>
                                <td class="border px-4 py-2 text-right">{{ round(($disponibleMisionesHoras / 8760) * 100, 2) }}%</td>
                            </tr>
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="border px-4 py-2">Disponibilidad de Mantenimiento</td>
                                <td class="border px-4 py-2 text-right">{{ round($mantMantenimientoHoras / 24) }}</td>
                                <td class="border px-4 py-2 text-right">{{ $mantMantenimientoHoras }}</td>
                                <td class="border px-4 py-2 text-right">{{ round(($mantMantenimientoHoras / 8760) * 100, 2) }}%</td>
                            </tr>
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="border px-4 py-2">Revisión Periódica</td>
                                <td class="border px-4 py-2 text-right">{{ round($revPeriodicaHoras / 24) }}</td>
                                <td class="border px-4 py-2 text-right">{{ $revPeriodicaHoras }}</td>
                                <td class="border px-4 py-2 text-right">{{ round(($revPeriodicaHoras / 8760) * 100, 2) }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Tab: Perfil de Misión Operativa Tipo (Primer Año) -->
                <div id="perfil-mision" class="tab-content hidden opacity-0 transition-opacity duration-500">
                    <h2 class="text-xl font-bold mb-2 text-[#105dad]">Perfil de Misión Operativa Tipo (Primer Año)</h2>

                    <!-- Tabla con la información relacionada a las horas y otros datos -->
                    <table class="table-auto w-full border-collapse mt-4">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2 text-[#105dad]">Descripción</th>
                                <th class="border px-4 py-2 text-[#105dad]">Información</th>
                                <th class="border px-4 py-2">
                                    <button onclick="copiarTablaCompleta()" style="background-color: #105dad; color: white; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.875rem; border: 1px solid #105dad;">
                                        Copiar Formato
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Ciclo de Vida -->
                            <tr>
                                <td class="border px-4 py-2 font-bold" colspan="3">Ciclo de Vida</td>
                            </tr>

                            <!-- Vida de Diseño -->
                            <tr>
                                <td class="border px-4 py-2">Vida de Diseño (Años)</td>
                                <td class="border px-4 py-2">
                                    <input type="text" id="vida_diseno_anios" class="border px-4 py-2 w-full" value="{{ $buque->vida_diseno_anios }}" disabled>
                                </td>
                                <td class="border px-4 py-2"></td>
                            </tr>
                             <!-- Horas al Año -->
                            <tr>
                                <td class="border px-4 py-2">Horas al Año</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center">
                                        <input type="text" id="horas_anio" class="border px-4 py-2 w-full" value="{{ $perfilMisionOperativa['horas_anio'] }}" disabled>
                                        <div class="tooltip-container ml-2">
                                            <div class="help-button">?</div>
                                            <div class="tooltip">Valor fijo: 8760 horas en un año</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border px-4 py-2"></td>
                            </tr>

                             <!-- Horas de Mantenimiento al Año -->
                            <tr>
                                <td class="border px-4 py-2">Horas de Mantenimiento al Año</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center">
                                        <input type="text" id="horas_mantenimiento_anio" class="border px-4 py-2 w-full" value="{{ $perfilMisionOperativa['horas_mantenimiento_anio'] }}" disabled>
                                        <div class="tooltip-container ml-2">
                                            <div class="help-button">?</div>
                                            <div class="tooltip">Horas de mantenimiento en el primer año según el plan de mantenimiento</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border px-4 py-2"></td>
                            </tr>

                            <!-- Horas Disponibles al Año -->
                            <tr>
                                <td class="border px-4 py-2">Horas Disponibles al Año</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center">
                                        <input type="text" id="horas_disponibles_anio" class="border px-4 py-2 w-full" value="{{ $perfilMisionOperativa['horas_disponibles_anio'] }}" disabled>
                                        <div class="tooltip-container ml-2">
                                            <div class="help-button">?</div>
                                            <div class="tooltip">
                                                <div>Horas disponibles para misiones en el primer año</div>
                                                <div style="border-top: 1px solid white; margin: 5px 0;">más las horas de navegación anuales</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border px-4 py-2"></td>
                            </tr>

                            <!-- Operaciones -->
                            <tr>
                                <td class="border px-4 py-2 font-bold" colspan="3">Operaciones</td>
                            </tr>

                            <!-- Máxima Misiones por Año -->
                            <tr>
                                <td class="border px-4 py-2">Máxima Misiones por Año</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center">
                                        <input type="text" id="max_misiones_anio" class="border px-4 py-2 w-full" value="{{ $perfilMisionOperativa['max_misiones_anio'] }}" disabled>
                                        <div class="tooltip-container ml-2">
                                            <div class="help-button">?</div>
                                            <div class="tooltip">
                                                <div>Horas disponibles al año</div>
                                                <div style="border-top: 1px solid white; margin: 5px 0;">Autonomía del buque en horas</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border px-4 py-2"></td>
                            </tr>

                            <!-- Misiones acuerdo Plan de Uso y Mantenimiento -->
                            <tr>
                                <td class="border px-4 py-2">Misiones acuerdo Plan de Uso y Mantenimiento</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center">
                                        <input type="text" id="misiones_plan_uso" class="border px-4 py-2 w-full" value="{{ $perfilMisionOperativa['misiones_plan_uso'] }}" disabled>
                                        <div class="tooltip-container ml-2">
                                            <div class="help-button">?</div>
                                            <div class="tooltip">
                                                <div>Horas de navegación anuales</div>
                                                <div style="border-top: 1px solid white; margin: 5px 0;">Autonomía del buque en horas</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border px-4 py-2"></td>
                            </tr>

                            <!-- Días de Operación por Año -->
                            <tr>
                                <td class="border px-4 py-2">Días de Operación por Año</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center">
                                        <input type="text" id="dias_operacion_anio" class="border px-4 py-2 w-full" value="{{ $perfilMisionOperativa['dias_operacion_anio'] }}" disabled>
                                        <div class="tooltip-container ml-2">
                                            <div class="help-button">?</div>
                                            <div class="tooltip">
                                                <div>Horas de navegación anuales</div>
                                                <div style="border-top: 1px solid white; margin: 5px 0;">24 horas</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border px-4 py-2"></td>
                            </tr>

                            <!-- Días por Misión -->
                            <tr>
                                <td class="border px-4 py-2">Días por Misión</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center">
                                        <input type="text" id="dias_por_mision" class="border px-4 py-2 w-full" value="{{ $perfilMisionOperativa['dias_por_mision'] }}" disabled>
                                        <div class="tooltip-container ml-2">
                                            <div class="help-button">?</div>
                                            <div class="tooltip">
                                                <div>Autonomía del buque en horas</div>
                                                <div style="border-top: 1px solid white; margin: 5px 0;">24 horas</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border px-4 py-2"></td>
                            </tr>

                            <!-- Días de Navegación por Misión -->
                            <tr>
                                <td class="border px-4 py-2">Días de Navegación por Misión</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center">
                                        <input type="text" id="dias_navegacion_mision" class="border px-4 py-2 w-full" value="{{ $perfilMisionOperativa['dias_navegacion_mision'] }}" disabled>
                                        <div class="tooltip-container ml-2">
                                            <div class="help-button">?</div>
                                            <div class="tooltip">Días por misión menos un día de margen</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border px-4 py-2"></td>
                            </tr>

                            <!-- Horas Operacionales por Misión -->
                            <tr>
                                <td class="border px-4 py-2">Horas Operacionales por Misión</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center">
                                        <input type="text" id="horas_operacionales_mision" class="border px-4 py-2 w-full" value="{{ $perfilMisionOperativa['horas_operacionales_mision'] }}" disabled>
                                        <div class="tooltip-container ml-2">
                                            <div class="help-button">?</div>
                                            <div class="tooltip">Igual a la autonomía total del buque en horas</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border px-4 py-2"></td>
                            </tr>

                            <!-- Horas Operacionales por Año -->
                            <tr>
                                <td class="border px-4 py-2">Horas Operacionales por Año</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center">
                                        <input type="text" id="horas_operacionales_anio" class="border px-4 py-2 w-full" value="{{ $perfilMisionOperativa['horas_operacionales_anio'] }}" disabled>
                                        <div class="tooltip-container ml-2">
                                            <div class="help-button">?</div>
                                            <div class="tooltip">Igual a las horas de navegación anuales del buque</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border px-4 py-2"></td>
                            </tr>

                            <!-- Horas de Navegación por Misión -->
                            <tr>
                                <td class="border px-4 py-2">Horas de Navegación por Misión</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center">
                                        <input type="text" id="horas_navegacion_mision" class="border px-4 py-2 w-full" value="{{ $perfilMisionOperativa['horas_navegacion_mision'] }}" disabled>
                                        <div class="tooltip-container ml-2">
                                            <div class="help-button">?</div>
                                            <div class="tooltip">Autonomía del buque en horas menos 24 horas de margen</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border px-4 py-2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

               <!-- Tab: Perfil de Uso del Sistema de Propulsión -->
               <div id="perfil-uso-propulsion" class="tab-content hidden opacity-0 transition-opacity duration-500">
                    <h2 class="text-xl font-bold mb-2">Perfil de Uso del Sistema de Propulsión</h2>
                    <table class="table-auto w-full border-collapse mt-4">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Misión</th>
                                <th class="border px-4 py-2">Velocidad (nudos)</th>
                                <th class="border px-4 py-2">Número de Motores</th>
                                <th class="border px-4 py-2">Potencia</th>
                                <th class="border px-4 py-2">Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($misiones as $mision)
                                <tr>
                                    <td class="border px-4 py-2">{{ $mision->mision }}</td>
                                    <td class="border px-4 py-2">{{ $mision->velocidad ?? 'N/A' }}</td>
                                    <td class="border px-4 py-2">{{ $mision->num_motores ?? 'N/A' }}</td>
                                    <td class="border px-4 py-2">{{ $mision->potencia ?? 'N/A' }}</td>
                                    <td class="border px-4 py-2">{{ $mision->descripcion ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Vista: Disponibilidad del Bote (6 años) -->
                <div id="disponibilidad-bote" class="tab-content hidden opacity-0 transition-opacity duration-500">
                    <h2 class="text-xl font-bold mb-2">Disponibilidad del Bote (6 años)</h2>

                    <table class="table-auto w-full border-collapse mt-4">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Misión</th>
                                <th class="border px-4 py-2">Año 1</th>
                                <th class="border px-4 py-2">Año 2</th>
                                <th class="border px-4 py-2">Año 3</th>
                                <th class="border px-4 py-2">Año 4</th>
                                <th class="border px-4 py-2">Año 5</th>
                                <th class="border px-4 py-2">Año 6</th>
                                <th class="border px-4 py-2">Promedio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($misiones as $mision)
                                <tr>
                                    <td class="border px-4 py-2">{{ $mision->mision }}</td>
                                    <td class="border px-4 py-2">N/A</td>
                                    <td class="border px-4 py-2">N/A</td>
                                    <td class="border px-4 py-2">N/A</td>
                                    <td class="border px-4 py-2">N/A</td>
                                    <td class="border px-4 py-2">N/A</td>
                                    <td class="border px-4 py-2">N/A</td>
                                    <td class="border px-4 py-2">N/A</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Tab: Cronograma de Ciclo de Uso y Mantenimiento -->
                <div id="cronograma-uso" class="tab-content hidden opacity-0 transition-opacity duration-500">
                    <h2 class="text-xl font-bold mb-2">Cronograma de Ciclo de Uso y Mantenimiento</h2>
                    <p>Hola mundo</p>
                </div>

                <!-- Tab: Cálculo de AOR para Equipos -->
                <div id="calculo-aor" class="tab-content hidden opacity-0 transition-opacity duration-500">
                    <h2 class="text-xl font-bold mb-2" style="text-align: center; border-bottom: 1px solid #d1d5db; padding-bottom: 5px; color: #0e3265;">AOR para Equipos del buque</h2>
                    <div id="desglose-container" class="grid grid-cols-3 gap-4 mt-0">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
    window.sistemasGlobal = @json($sistemas);
    document.addEventListener("DOMContentLoaded", function () {
        const buqueId = {{ $buque->id }};
        const nombre_buque = {!! json_encode($buque->nombre) !!};
        const equiposDataUrl = `{{ $flaskUrl }}/equipos/${buqueId}`;
        const sistemasDataUrl = `/api/sistemas`;
        let equiposGlobal = [];
        let sistemasGlobal = [];

        inicializarVista();

        Promise.all([
            fetch(equiposDataUrl).then(res => res.json()),
            fetch(sistemasDataUrl).then(res => res.json())
        ]).then(([equiposData, sistemasData]) => {
            equiposGlobal = equiposData;
            sistemasGlobal = sistemasData;
        });

        function inicializarVista() {
            const container = document.getElementById("desglose-container");
            container.innerHTML = `
                <div id="grupos-container" class="p-2">
                    <h3 class="font-bold titulo-col">Grupos Constructivos</h3>
                    <div id="grupos-list" class="space-y-2"></div>
                </div>
                <div id="equipos-container" class="p-2">
                    <h3 class="font-bold titulo-col">Equipos</h3>
                    <div id="equipos-content">
                        <div class="no-equipos-msg">Seleccione un grupo constructivo.</div>
                    </div>
                </div>`;

            const grupos = [
                { id: 1, codigo: '100', nombre: 'Cascos y Estructuras' },
                { id: 2, codigo: '200', nombre: 'Maquinaria y Propulsión' },
                { id: 3, codigo: '300', nombre: 'Planta Eléctrica' },
                { id: 4, codigo: '400', nombre: 'Comando y Vigilancia' },
                { id: 5, codigo: '500', nombre: 'Sistemas Auxiliares' },
                { id: 6, codigo: '600', nombre: 'Acabados y Amoblamiento' },
                { id: 7, codigo: '700', nombre: 'Armamento' }
            ];

            const gruposList = document.getElementById("grupos-list");
            grupos.forEach(grupo => {
                gruposList.innerHTML += `
                    <button onclick="seleccionarGrupo(${grupo.id}, event)" class="group-btn">
                        <span class="code">${grupo.codigo}</span>
                        <span class="desc">${grupo.nombre}</span>
                    </button>`;
            });
        }

        window.seleccionarGrupo = function (grupoId, event) {
            const clickedButton = event.currentTarget;
            document.querySelectorAll("#grupos-list button").forEach(btn => btn.classList.remove("selected-group"));
            clickedButton.classList.add("selected-group");

            const sistemasDelGrupo = sistemasGlobal.filter(s => s.grupo_constructivo_id == grupoId);
            const sistemasIds = sistemasDelGrupo.map(s => s.id);
            const equiposDelGrupo = equiposGlobal.filter(eq => sistemasIds.includes(eq.id_sistema_ils));

            const equiposContent = document.getElementById("equipos-content");

            if (equiposDelGrupo.length === 0) {
                equiposContent.innerHTML = `<div class="no-equipos-msg">No se encontraron equipos en el grupo seleccionado.</div>`;
            } else {
                equiposContent.innerHTML = `
                    <div id="filtro-sistemas-container" class="mb-4">
                        <label class="block text-sm mb-1">Filtrar por sistema:</label>
                        <select id="filtro-sistemas" class="w-full border rounded p-2">
                            <option value="">Todos los sistemas</option>
                            ${sistemasDelGrupo.map(sis => `<option value="${sis.id}">${sis.codigo} - ${sis.nombre}</option>`).join('')}
                        </select>
                    </div>
                    <table class="w-full" style="color: #003366; font-size: 14px">
                        <thead><tr>
                            <th>Equipo</th>
                            <th>AOR (h)</th>
                            <th>AOR (%)</th>
                            <th>Acciones</th>
                        </tr></thead>
                        <tbody id="equipos-list"></tbody>
                    </table>
                `;

                document.getElementById("filtro-sistemas").onchange = (e) => {
                    filtrarEquipos(equiposDelGrupo, e.target.value);
                };

                renderizarEquipos(equiposDelGrupo);
            }
        };

        function filtrarEquipos(equiposDelGrupo, sistemaId) {
            let filtrados = sistemaId ? equiposDelGrupo.filter(eq => eq.id_sistema_ils == sistemaId) : equiposDelGrupo;

            if (filtrados.length === 0) {
                document.getElementById("equipos-list").innerHTML = `
                    <tr><td colspan="4" class="no-equipos-msg">No hay equipos para el sistema seleccionado.</td></tr>`;
            } else {
                renderizarEquipos(filtrados);
            }
        }

        function renderizarEquipos(equipos) {
            const equiposList = document.getElementById("equipos-list");
            equiposList.innerHTML = equipos.map(e => `
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-2 px-4">${e.nombre_equipo}</td>
                    <td class="py-2 px-4 text-center">${e.AOR ?? 'No establecido'}</td>
                    <td class="py-2 px-4 text-center">${e.AOR ? ((e.AOR / 8760) * 100).toFixed(2) : 'No establecido'}%</td>
                    <td class="py-2 px-4 text-center">
                        <button class="ver-fua-btn" onclick="verFuaLocalhost(${e.id}, ${buqueId}, '${nombre_buque}')">Ver FUA</button>
                    </td>
                </tr>
            `).join('');
        }

        window.verFuaLocalhost = function (equipoId, buqueId, nombreBuque) {
            const payload = {
                equipoId: equipoId,
                buqueId: buqueId,
                nombreBuque: nombreBuque,
                sistemas: window.sistemasGlobal
            };

            fetch('{{ $flaskUrl }}/FUA-POST', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                credentials: 'include',
                body: JSON.stringify(payload),
            })
            .then(response => response.json())
            .then(data => {
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else {
                    console.error('Error en la redirección:', data);
                }
            })
            .catch(err => console.error('Fetch error:', err));
        };
    }); // Fin del DOMContentLoaded

    // Script para manejar tabs
    function showTab(tabId, button) {
        // Ocultar todo el contenido
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
            content.classList.remove('opacity-100');
            content.classList.add('opacity-0');
        });

        // Mostrar la tab seleccionada
        const tabToShow = document.getElementById(tabId);
        if (tabToShow) {
            tabToShow.classList.remove('hidden');
            setTimeout(() => {
                tabToShow.classList.add('opacity-100');
            }, 50);
        }

        // Resetear estilos de todos los botones y spans internos
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.classList.add('bg-gray-300', 'text-gray-500');
            btn.querySelectorAll('span')?.forEach(span => {
                span.style.color = 'rgb(107, 114, 128)'; // text-gray-500
            });
        });

        // Aplicar estilo activo al botón clicado y su span interno
        if (button) {
            button.classList.add('active');
            button.classList.remove('bg-gray-300', 'text-gray-500');
            button.querySelectorAll('span')?.forEach(span => {
                span.style.color = 'white';
            });
        }
    }

     function copiarTablaCompleta() {
            const filas = document.querySelectorAll('#perfil-mision tbody tr');
            let textoACopiar = '';
            
            filas.forEach(fila => {
                const descripcion = fila.querySelector('td:first-child')?.textContent.trim();
                const input = fila.querySelector('input');
                
                if (descripcion && input && !descripcion.includes('Ciclo de Vida') && !descripcion.includes('Operaciones')) {
                    textoACopiar += `${descripcion}\t${input.value}\n`;
                }
            });
            
            navigator.clipboard.writeText(textoACopiar).then(() => {
                const button = document.querySelector('#perfil-mision button');
                const originalText = button.textContent;
                button.textContent = '¡Copiado!';
                button.classList.remove('bg-[#105dad]');
                button.classList.add('bg-green-500');
                
                setTimeout(() => {
                    button.textContent = originalText;
                    button.classList.remove('bg-green-500');
                    button.classList.add('bg-[#105dad]');
                }, 2000);
            }).catch(err => {
                console.error('Error al copiar: ', err);
            });
        }
</script>


</x-app-layout>
