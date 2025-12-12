<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $buque->id ? 'Editar Buque' : 'Crear Buque' }}</title>


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        #selectedMissionCards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            transition: all 0.3s ease; /* Transición suave para todos los cambios */
        }
        .mission-card {
            background: white;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            display: flex;
            flex-direction: column;
            height: 100%;
            opacity: 1; /* Comenzar invisible */
            transition: opacity 0.3s ease, transform 0.3s ease;
            --tw-border-opacity: 1;
            border-color: rgb(209 213 219 / var(--tw-border-opacity, 1));
            border-width: 1px;

        }
        .mission-card.active {
            opacity: 1;
            transform: translateY(0);
        }
        .mission-card .input-group {
            display: flex;
            flex-direction: column;
            flex-grow: 1; /* Allow input groups to grow equally */
        }
        .mission-card .input-group label {
            display: block;
            font-size: 0.75rem;
            color: #4a5568;
            margin-bottom: 0.25rem;
        }

        .btn-guardar:hover {
            background-color: #003366;
        }

        .btn-guardar {
            background-color: #0c377f;
        }

        .header-container {
            display: flex;
            align-items: center;
            color: #003366;
            font-weight: 600;
            font-size: 1rem;
        }

        .header-container span{
            font-size: 20px;
            border-left: 3px solid #003366;
            padding-left: 10px;
            margin-left: 20px;
        }

        .header-container a{
            font-size: 18px;
        }

        .header-back {
            display: flex;
            align-items: center;
            color: #003366;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .header-back:hover {
            text-decoration: underline;
        }

        .header-divider {
            border-left: 2px solid #003366;
            height: 20px;
        }

        .header-title {
            font-weight: bold;
            font-size: 1.1rem;
            text-transform: uppercase;
            color: #003366;
            letter-spacing: 0.5px;
        }
            
        .transition-width { transition: width 0.5s ease; }

        .fade-visible {
            opacity: 1;
            pointer-events: auto;
            transition: opacity 0.5s ease 0.5s; /* después del cambio de ancho */
        }

        .fade-hidden {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
        }

        .col-100 { width: 100%; }
        .col-40 { width: 40%; }
        .col-60 { width: 60%; }

        /* Scrollbar estilizado solo para navegadores que lo soportan */
        .col-60::-webkit-scrollbar {
            width: 6px;
        }
        .col-60::-webkit-scrollbar-track {
            background: #f0f0f0;
        }
        .col-60::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 3px;
        }

        #filtrosAvanzados{
            width: 500px;
            gap: 10px;
        }

        #filtrosAvanzados select, #buscarEquipo{
            border-radius: 4px;
            border-color: rgb(209 213 219 / var(--tw-border-opacity, 1));
            color: #6C7280;
            font-size: 14px;
            height: 35px;
            padding: 5px;
        }

        #BtnFiltros, #BtnConfigAvan{
            font-size: 14px; 
            padding-top: 7px;
            padding-bottom: 7px;
            background-color: #74767D
        }

        #filtrosAvanzados .cerrar{
            position: absolute;
            bottom: 10px;
        }

        .input-bajo {
            border: none;
            border-bottom: 2px solid #3B82F6; /* azul tipo tailwind azul-500 */
            background-color: transparent;
            outline: none;
            font-size: 0.875rem !important; /* text-sm */
            width: 100%;
            text-align: center;
            line-height: 1.25rem !important;
            border-color: #d1d5db !important;
            height: 30px;
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }

        .input-bajo:focus {
            --tw-ring-shadow: unset !important;
        }

        .textarea-pendiente {
            background-color: #fff5f5 !important; /* rojo claro */
            border: 1px solid #730C02 !important; /* rojo fuerte */
            color: #000;
        }

        .textarea-pendiente:focus {
            --tw-ring-color: none;
        }


        .textarea-pendiente::placeholder {
            color: #730C02 !important;
        }

        .spinner {
            position: relative;
            width: 150px;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .spinner:before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            border: 5px solid rgba(0, 0, 0, 0.1);
            border-top: 5px solid #728694;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        .spinner img {
            width: 70%;
            height: 70%;
            object-fit: contain;
            opacity: 0.4;
            animation: sail 2s ease-in-out infinite;
            margin-top: 15px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes sail {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        #codigoConfirmacion{
            font-size: 14px;
        }

        div:where(.swal2-container).swal2-center>.swal2-popup {
            width: 65%;
        }

        .grid-cols-4 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 1rem; /* igual a Tailwind gap-4 */
            align-items: center;
        }

        .help-button {
            background-color: #e2e8f0;
            color: #1f2937;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: bold;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            user-select: none;
        }

        .tooltip-container {
            position: relative;
            display: inline-block;
        }

        .tooltip {
            visibility: hidden;
            width: 220px;
            background-color: #333;
            color: #fff;
            text-align: left;
            border-radius: 4px;
            padding: 8px;
            position: absolute;
            z-index: 10;
            bottom: 125%;
            right: 0;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip::after {
            content: "";
            position: absolute;
            top: 100%;
            right: 10px;
            border-width: 5px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        }

        .tooltip-container:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }
        
        /* Para inputs dentro de #puerto-base */
        #puerto-base input[type="number"] {
            padding: 4px 8px !important;
            border: none;
            outline: none;
            font-size: 0.875rem; /* equivalente a text-sm */
            color: #1f2937;       /* equivalente a text-gray-800 */
            text-align: center;
            width: 130px;
            margin-bottom: 4px;   /* reemplaza mb-1 */
            border-bottom: 1px solid #e5e7eb;
        }

        #puerto-base .label-xs {
            font-size: 0.75rem;
            color: #6b7280; /* text-gray-500 */
            display: block;
            margin-bottom: 0.25rem;
        }

        #puerto-base .percentage-label {
            font-size: 0.75rem;
            color: #9ca3af; /* text-gray-400 */
            text-align: right;
            margin-top: 0.25rem;
        }

        #puerto-base .card-field {
            border: 1px solid #e5e7eb; /* border-gray-200 */
            border-radius: 0.375rem;
            background-color: #fff;
            padding: 0.75rem;
            position: relative;
        }

        #puerto-base .card-field.bg-light {
            background-color: #f9fafb; /* bg-gray-50 */
        }

        #selectedMissionCards input, #missionsTableBody input{
            padding: 5px 10px;

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
                {{ $buque->id ? 'EDITAR BUQUE' : 'CREAR BUQUE' }}
            </span>
        </div>
    </x-slot>


    <div class="bg-white rounded-lg" style="margin: 1rem; margin-left: 1.5rem; margin-right: 1.5rem; box-shadow: 0 1px 10px rgba(123, 115, 235, 0.473);">
        <div class="container py-4 px-6">
            <!-- Pestañas de navegación -->
            <div class="flex flex-wrap gap-4 mb-6">
                <button onclick="showTab('datos-basicos')" id="tab-datos-basicos"
                    class="bg-azulCotecmar text-white px-4 py-2 rounded shadow hover:bg-grisHover focus:outline-none">
                    Contexto Operacional
                </button>

                @if ($buque->id)
                    <button onclick="showTab('misiones')" id="tab-misiones"
                        class="bg-grisClaro text-gray-700 px-4 py-2 rounded shadow hover:bg-grisHover focus:outline-none">
                        Misiones
                    </button>

                    <button onclick="showTab('configuracion-buque')" id="tab-configuracion-buque"
                        class="bg-grisClaro text-gray-700 px-4 py-2 rounded shadow hover:bg-grisHover focus:outline-none">
                        Configuración del buque
                    </button>
                @endif
            </div>
            
            <!-- Datos Básicos -->
            <div id="datos-basicos" class="tab-content">
                <form action="{{ $buque->id ? route('buques.update', $buque->id) : route('buques.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($buque->id)
                        @method('PUT')
                    @endif

                    <div class="md:flex md:gap-6">
                        <!-- Columna Izquierda (60%) -->
                        <div class="md:w-3/5 space-y-4">

                            <!-- Fila 1: Nombre del Buque -->
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Buque:</label>
                                <input type="text" id="nombre" name="nombre" value="{{ $buque->nombre }}" required
                                    class="w-full border-gray-300 rounded text-sm py-1 px-2">
                            </div>

                            <!-- Fila 2: Tipo de Buque, Número del Casco -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de Buque:</label>
                                    <input type="text" id="tipo" name="tipo" value="{{ $buque->tipo }}" required
                                        class="w-full border-gray-300 rounded text-sm py-1 px-2">
                                </div>

                                <div>
                                    <label for="numero_casco_cotecmar" class="block text-sm font-medium text-gray-700">Número del Casco Cotecmar:</label>
                                    <input type="text" id="numero_casco_cotecmar" name="numero_casco_cotecmar" value="{{ $buque->numero_casco_cotecmar }}" required
                                        class="w-full border-gray-300 rounded text-sm py-1 px-2">
                                </div>
                                <div>
                                    <label for="numero_casco_armada" class="block text-sm font-medium text-gray-700">Número del Casco Armada:</label>
                                    <input type="text" id="numero_casco_armada" name="numero_casco_armada" value="{{ $buque->numero_casco_armada }}" required
                                        class="w-full border-gray-300 rounded text-sm py-1 px-2">
                                </div>
                            </div>

                            <!-- Fila 3: Etapa de Vida, Autonomía (horas), Autonomía (millas náuticas) -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="etapa" class="block text-sm font-medium text-gray-700">Fase Ciclo de Vida:</label>
                                    <select id="etapa" name="etapa" class="w-full border-gray-300 rounded text-sm py-1 px-2">
                                        <option value="Fase de Diseño" {{ $buque->etapa === 'Fase de Diseño' ? 'selected' : '' }}>Fase de Diseño</option>
                                        <option value="Fase de Construcción" {{ $buque->etapa === 'Fase de Construcción' ? 'selected' : '' }}>Fase de Construcción</option>
                                        <option value="Fase de Operación" {{ $buque->etapa === 'Fase de Operación' ? 'selected' : '' }}>Fase de Operación</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="autonomia_horas" class="block text-sm font-medium text-gray-700">Autonomía (horas):</label>
                                    <input type="number" id="autonomia_horas" name="autonomia_horas" value="{{ $buque->autonomia_horas }}" required
                                        class="w-full border-gray-300 rounded text-sm py-1 px-2">
                                </div>

                                <div>
                                    <label for="autonomia_millas_nauticas" class="block text-sm font-medium text-gray-700">Autonomía (millas náuticas):</label>
                                    <input type="number" step="0.01" min="0" id="autonomia_millas_nauticas" name="autonomia_millas_nauticas"
                                        value="{{ $buque->autonomia_millas_nauticas }}"
                                        class="w-full border-gray-300 rounded text-sm py-1 px-2">
                                </div>
                            </div>

                            <!-- Fila 4: Vida Diseño, Horas Navegación -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="vida_diseno_anios" class="block text-sm font-medium text-gray-700">Tiempo de Vida de Diseño (años):</label>
                                    <input type="number" id="vida_diseno_anios" name="vida_diseno_anios" value="{{ $buque->vida_diseno_anios }}" required
                                        class="w-full border-gray-300 rounded text-sm py-1 px-2">
                                </div>

                                <div>
                                    <label for="horas_navegacion_anio" class="block text-sm font-medium text-gray-700">Horas de Navegación (año):</label>
                                    <input type="number" id="horas_navegacion_anio" name="horas_navegacion_anio" value="{{ $buque->horas_navegacion_anio }}" required
                                        class="w-full border-gray-300 rounded text-sm py-1 px-2">
                                </div>
                            </div>

                            <!-- Fila 5: Peso, Unidad de peso y Tamaño/Dimensión -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="peso_buque" class="block text-sm font-medium text-gray-700">Peso del buque:</label>
                                    <input type="number" step="0.001" min="0" id="peso_buque" name="peso_buque"
                                        value="{{ old('peso_buque', $buque->peso_buque) }}"
                                        class="w-full border-gray-300 rounded text-sm py-1 px-2">
                                </div>

                                <div>
                                    <label for="unidad_peso" class="block text-sm font-medium text-gray-700">Unidad de peso:</label>
                                    <input type="text" id="unidad_peso" name="unidad_peso"
                                        value="{{ old('unidad_peso', $buque->unidad_peso) }}"
                                        class="w-full border-gray-300 rounded text-sm py-1 px-2">
                                </div>

                                <div>
                                    <label for="tamano_dimension_buque" class="block text-sm font-medium text-gray-700">Tamaño/Dimensión del buque:</label>
                                    <input type="text" id="tamano_dimension_buque" name="tamano_dimension_buque"
                                        value="{{ old('tamano_dimension_buque', $buque->tamano_dimension_buque) }}"
                                        class="w-full border-gray-300 rounded text-sm py-1 px-2">
                                </div>
                            </div>

                        </div>

                        <!-- Columna Derecha (40%) -->
                        <div class="md:w-2/5 space-y-3 mt-6 md:mt-0">
                            <!-- Imagen -->
                            <div x-data="imagenBuque()" class="relative w-full">
                                <label class="block text-sm font-medium text-gray-700">Imagen:</label>

                                <div class="relative">
                                    <!-- Imagen actual o por defecto -->
                                    <img
                                        :src="preview || '{{ $buque->imagen ? Storage::url($buque->imagen) : asset('images/default_image.png') }}'"
                                        alt="Imagen del Buque"
                                        class="w-full max-w-full object-contain rounded border border-gray-300"
                                        style="max-height: fit-content;"
                                    >

                                    <!-- Botón sobre la imagen para subir -->
                                    <label for="imagen" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white text-sm font-semibold rounded cursor-pointer hover:bg-opacity-70 transition">
                                        @if ($buque->id)
                                            Actualizar Foto
                                        @else
                                            Añadir
                                        @endif
                                    </label>

                                    <!-- Botón para eliminar imagen -->
                                    <button type="button"
                                            @click="removeImage"
                                            class="absolute top-2 right-2 bg-white rounded-full shadow text-gray-700 hover:text-red-600 px-2 py-1 text-xs font-bold z-10">
                                        ✕
                                    </button>
                                </div>

                                <!-- Input oculto -->
                                <input type="file" id="imagen" name="imagen" @change="previewImage" class="hidden">

                                <!-- Campo oculto para notificar al backend si se debe eliminar la imagen -->
                                <input type="hidden" name="remove_imagen" x-model="removeImagen">
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mt-3">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción de la Embarcación:</label>
                        <textarea id="descripcion" name="descripcion" class="w-full border-gray-300 rounded text-sm py-1 px-2" rows="4">{{ $buque->descripcion }}</textarea>
                    </div>

                    <!-- DERECHA: DATOS REQUERIDOS PARA SAP -->
                    <div class="border-t border-gray-200 mt-6 pt-4 space-y-8">

                        @php
                            $ds     = $buque->datos_sap ?? [];
                            $dsLog  = $ds['logistico'] ?? [];
                            $dsHist = $ds['historico'] ?? [];
                        @endphp

                        <!-- ===================== DATO_TECNIC_BUQUE ===================== -->
                        <div class="bg-white border rounded-xl p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-gray-800 tracking-wide">DATOS REQUERIDOS PARA SAP (Datos Técnicos del Buque)</h3>
                            <p class="text-xs text-gray-500 mt-1 mb-4">
                                Para cada campo marca <strong>Pendiente</strong> (deshabilita el input) o ingresa el valor.
                            </p>

                            @php
                            $tecnicoFields = [
                                // key, label, type, step, min, value (desde modelo)
                                ['eslora','Eslora (m)','number','0.01',null,$buque->eslora],
                                ['manga','Manga (m)','number','0.01',null,$buque->manga],
                                ['puntal','Puntal (m)','number','0.01',null,$buque->puntal],
                                ['calado_metros','Calado en Metros (m)','number','0.01',null,$buque->calado_metros],
                                ['altura_mastil','Altura Mástil (m)','number','0.01',null,$buque->altura_mastil],
                                ['altura_maxima_buque','Altura Máxima del Buque (m)','number','0.01',null,$buque->altura_maxima_buque],
                                ['tipo_material_construccion','Tipo de Material Construcción','text',null,null,$buque->tipo_material_construccion],
                                ['sigla_internacional_unidad','Sigla Internacional Unidad','text',null,null,$buque->sigla_internacional_unidad],
                                ['plano_numero','Plano Número','text',null,null,$buque->plano_numero],
                                ['desp_cond_1_peso_rosca','Cond 1 - Peso en Rosca (t)','number','0.001','0',$buque->desp_cond_1_peso_rosca],
                                ['desp_cond_2_10_consumibles','Cond 2 - 10% Consumibles (t)','number','0.001','0',$buque->desp_cond_2_10_consumibles],
                                ['desp_cond_3_minima_operacional','Cond 3 - Mínima Operacional (t)','number','0.001','0',$buque->desp_cond_3_minima_operacional],
                                ['desp_cond_4_50_consumibles','Cond 4 - 50% Consumibles (t)','number','0.001','0',$buque->desp_cond_4_50_consumibles],
                                ['desp_cond_5_optima_operacional','Cond 5 - Óptima Operacional (t)','number','0.001','0',$buque->desp_cond_5_optima_operacional],
                                ['desp_cond_6_zarpe_plena_carga','Cond 6 - Zarpe Plena Carga (t)','number','0.001','0',$buque->desp_cond_6_zarpe_plena_carga],
                            ];
                            @endphp

                            <div class="grid grid-cols-1 sm:grid-cols-3 xl:grid-cols-3 gap-4">
                                @foreach ($tecnicoFields as [$key,$label,$type,$step,$min,$val])
                                    <div
                                        class="rounded-lg border bg-gray-50/60 py-1 px-2 h-fit"
                                        x-data="{ val:'{{ old("datos_sap_tecnico.$key.valor", $val) }}', pend:@json(old("datos_sap_tecnico.$key.pendiente", false)) }"
                                    >
                                        <label class="block text-xs font-medium text-gray-700 mb-1">{{ $label }}</label>
                                        <div class="flex items-center gap-2">
                                            <!-- Checkbox primero -->
                                            <label class="inline-flex items-center text-[11px] bg-amber-50 border border-amber-300 rounded px-2 py-1 text-xs">
                                                <input type="checkbox" class="mr-2 accent-amber-600"
                                                    x-model="pend" name="datos_sap_tecnico[{{ $key }}][pendiente]" value="1">
                                                Pendiente
                                            </label>

                                            <!-- Input al lado -->
                                            @if ($type === 'text')
                                                <input type="text"
                                                    class="flex-1 border-gray-300 rounded-md text-xs py-1.5 px-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                    :class="pend ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : ''"
                                                    :disabled="pend"
                                                    x-model="val" name="datos_sap_tecnico[{{ $key }}][valor]" @input="pend=false">
                                            @else
                                                <input type="number" @if($step) step="{{ $step }}" @endif @if($min) min="{{ $min }}" @endif
                                                    class="flex-1 border-gray-300 rounded-md text-xs py-1.5 px-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                    :class="pend ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : ''"
                                                    :disabled="pend"
                                                    x-model="val" name="datos_sap_tecnico[{{ $key }}][valor]" @input="pend=false">
                                            @endif
                                        </div>
                                        <input type="hidden" :value="pend ? 'PENDIENTE' : val" name="datos_sap_tecnico[{{ $key }}][valor_final]">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- ===================== DATO_LOGIST_BUQUE ===================== -->
                        <div class="bg-white border rounded-xl p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-gray-800 tracking-wide">DATOS REQUERIDOS PARA SAP (Datos Logísticos del Buque)</h3>
                            <p class="text-xs text-gray-500 mt-1 mb-4">
                                Puedes marcar <strong>No aplica</strong> o <strong>Pendiente</strong> (ambos deshabilitan) o escribir el valor.
                            </p>

                            @php
                            $logFields = [
                                ['cap_agua_gal','Capacidad de Agua (gal)'],
                                ['cap_mdo_gal','Capacidad de M.D.O (gal)'],
                                ['cap_gasolina_gal','Capacidad de Gasolina (gal)'],
                                ['cap_kerosene_gal','Capacidad de Kerosene (gal)'],
                                ['cap_jet_a1_gal','Capacidad de JET-A1 (gal)'],
                                ['cap_lubricante_gal','Capacidad Lubricante (gal)'],
                                ['cap_viveres_congelados_kg','Cap. Víveres Congelados (kg)'],
                                ['cap_viveres_secos_kg','Cap. Víveres Secos (kg)'],
                                ['cap_viveres_conserva_kg','Cap. Víveres Conserva (kg)'],
                                ['cap_produccion_agua','Capacidad Producción de Agua'],
                                ['consumo_kw_h_navegando','Consumo kW·h (Navegando)'],
                                ['consumo_kw_h_muelle','Consumo kW·h (Muelle)'],
                                ['consumo_comb_hora_vel_economica','Consumo Comb/h a Vel. Económica'],
                                ['consumo_comb_hora_vel_maxima','Consumo Comb/h a Vel. Máxima'],
                                ['consumo_comb_milla_vel_economica','Consumo Comb/milla a Vel. Económica'],
                                ['consumo_comb_milla_vel_maxima','Consumo Comb/milla a Vel. Máxima'],
                                ['tipo_grua_bordo','Tipo de Grúa a bordo'],
                                ['cap_grua_ext_100_ton','Cap. Grúa extendida 100% (ton)'],
                                ['cap_grua_ext_0_ton','Cap. Grúa extendida 0% (ton)'],
                            ];
                            @endphp

                            <div class="grid grid-cols-3 gap-4">
                                @foreach ($logFields as [$key,$label])
                                    @php
                                        $saved = $dsLog[$label] ?? null;
                                        $savedVal  = ($saved !== 'PENDIENTE' && $saved !== 'N/A') ? $saved : '';
                                        $savedNa   = ($saved === 'N/A');
                                        $savedPend = ($saved === 'PENDIENTE');
                                    @endphp

                                    <div
                                        class="rounded-lg border bg-gray-50/60 py-1 px-2 h-fit"
                                        x-data="{
                                            val:  '{{ old("datos_sap_logistico.$key.valor", $savedVal) }}',
                                            na:   @json(old("datos_sap_logistico.$key.no_aplica", $savedNa)),
                                            pend: @json(old("datos_sap_logistico.$key.pendiente", $savedPend))
                                        }"
                                    >
                                        <label class="block text-xs font-medium text-gray-700 mb-1">{{ $label }}</label>
                                        <div class="flex items-center gap-2">
                                            <!-- Checkboxes primero -->
                                            <label class="inline-flex items-center text-[11px] bg-gray-50 border border-gray-300 rounded px-2 py-1 text-xs">
                                                <input type="checkbox" class="mr-2 accent-gray-600"
                                                    x-model="na" @change="if(na){pend=false}"
                                                    name="datos_sap_logistico[{{ $key }}][no_aplica]" value="1">
                                                No aplica
                                            </label>
                                            <label class="inline-flex items-center text-[11px] bg-amber-50 border border-amber-300 rounded px-2 py-1 text-xs">
                                                <input type="checkbox" class="mr-2 accent-amber-600"
                                                    x-model="pend" @change="if(pend){na=false}"
                                                    name="datos_sap_logistico[{{ $key }}][pendiente]" value="1">
                                                Pendiente
                                            </label>

                                            <!-- Input más angosto -->
                                            <input type="text"
                                                class="w-40 border-gray-300 rounded-md text-xs py-1.5 px-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                :class="(na||pend) ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : ''"
                                                :disabled="na || pend"
                                                x-model="val" name="datos_sap_logistico[{{ $key }}][valor]"
                                                @input="na=false; pend=false">
                                        </div>
                                        <input type="hidden" :value="na ? 'N/A' : (pend ? 'PENDIENTE' : val)" name="datos_sap_logistico[{{ $key }}][valor_final]">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- ===================== DATO_HISTOR_BUQUE ===================== -->
                        <div class="bg-white border rounded-xl p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-gray-800 tracking-wide">DATOS REQUERIDOS PARA SAP (Datos Históricos del Buque)</h3>
                            <p class="text-xs text-gray-500 mt-1 mb-4">
                                Puedes marcar <strong>No aplica</strong> o <strong>Pendiente</strong> (ambos deshabilitan) o escribir el valor.
                            </p>

                            @php
                            $histRows = [
                                ['numero_resolucion_alta','Número de Resolución de Alta','text'],
                                ['fecha_resolucion_alta','Fecha Resolución Alta','date'],
                                ['fecha_resolucion_baja','Fecha Resolución Baja','date'],
                                ['fecha_resolucion_traslado','Fecha Resolución Traslado','date'],
                                ['fecha_estimada_reemplazo','Fecha Estimada de Reemplazo','date'],
                                ['ultima_bajada_dique','Última Bajada de Dique','date'],
                                ['ultima_subida_dique','Última Subida de Dique','date'],
                                ['proxima_subida_dique','Próxima Subida a Dique','date'],
                                ['ciclo_vida_estimado_anios','Ciclo de Vida Estimado (años)','number'],
                                ['valor_adquisicion','Valor de Adquisición','number'],
                                ['fuerza','Fuerza','text'],
                                ['brigada_flotilla_comando','Brigada / Flotilla / Comando','text'],
                            ];
                            @endphp

                            <div class="grid grid-cols-1 sm:grid-cols-3 xl:grid-cols-3 gap-4">
                                @foreach ($histRows as [$key,$label,$type])
                                    @php
                                        $saved = $dsHist[$label] ?? null;
                                        $savedVal  = ($saved !== 'PENDIENTE' && $saved !== 'N/A') ? $saved : '';
                                        $savedNa   = ($saved === 'N/A');
                                        $savedPend = ($saved === 'PENDIENTE');
                                    @endphp

                                    <div
                                        class="rounded-lg border bg-gray-50/60 py-1 px-2 h-fit"
                                        x-data="{
                                            val:  '{{ old("datos_sap_historico.$key.valor", $savedVal) }}',
                                            na:   @json(old("datos_sap_historico.$key.no_aplica", $savedNa)),
                                            pend: @json(old("datos_sap_historico.$key.pendiente", $savedPend))
                                        }"
                                    >
                                        <label class="block text-xs font-medium text-gray-700 mb-1">{{ $label }}</label>
                                        <div class="flex items-center gap-2">
                                            <!-- Checkboxes primero -->
                                            <label class="inline-flex items-center text-[11px] bg-gray-50 border border-gray-300 rounded px-2 py-1 text-xs">
                                                <input type="checkbox" class="mr-2 accent-gray-600"
                                                    x-model="na" @change="if(na){pend=false}"
                                                    name="datos_sap_historico[{{ $key }}][no_aplica]" value="1">
                                                No aplica
                                            </label>
                                            <label class="inline-flex items-center text-[11px] bg-amber-50 border border-amber-300 rounded px-2 py-1 text-xs">
                                                <input type="checkbox" class="mr-2 accent-amber-600"
                                                    x-model="pend" @change="if(pend){na=false}"
                                                    name="datos_sap_historico[{{ $key }}][pendiente]" value="1">
                                                Pendiente
                                            </label>

                                            <!-- Input al lado -->
                                            @if ($type === 'text')
                                                <input type="text"
                                                    class="w-40 flex-1 border-gray-300 rounded-md text-xs py-1.5 px-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                    :class="(na||pend) ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : ''"
                                                    :disabled="na || pend"
                                                    x-model="val" name="datos_sap_historico[{{ $key }}][valor]"
                                                    @input="na=false; pend=false">
                                            @elseif ($type === 'number')
                                                <input type="number" step="0.01"
                                                    class="w-40 flex-1 border-gray-300 rounded-md text-xs py-1.5 px-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                    :class="(na||pend) ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : ''"
                                                    :disabled="na || pend"
                                                    x-model="val" name="datos_sap_historico[{{ $key }}][valor]"
                                                    @input="na=false; pend=false">
                                            @else
                                                <input type="date"
                                                    class="w-40 flex-1 border-gray-300 rounded-md text-xs py-1.5 px-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                    :class="(na||pend) ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : ''"
                                                    :disabled="na || pend"
                                                    x-model="val" name="datos_sap_historico[{{ $key }}][valor]"
                                                    @input="na=false; pend=false">
                                            @endif
                                        </div>
                                        <input type="hidden" :value="na ? 'N/A' : (pend ? 'PENDIENTE' : val)" name="datos_sap_historico[{{ $key }}][valor_final]">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>



                    <!-- DATOS PARA EL PLAN DE USO Y MANTENIMIENTO UUP -->
                    <div class="border-t border-gray-200 mt-6 pt-4">
                        <h3 class="text-sm font-semibold text-gray-800 tracking-wide">DATOS PARA EL PLAN DE USO Y MANTENIMIENTO UUP</h3>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="pt-0">
                                <!-- 1. Misión de la organización -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Misión de la Organización:</label>
                                    <p class="text-xs text-gray-500 italic mb-1">
                                        Defina la misión de la organización donde se utilizará el activo. Puede incluir el enfoque institucional y el marco normativo bajo el cual opera.
                                    </p>
                                    <textarea name="mision_organizacion" rows="3"
                                            class="w-full border-gray-300 rounded text-sm py-1 px-2">{{ old('mision_organizacion', $buque->mision_organizacion) }}</textarea>
                                </div>

                                <!-- 2. Operaciones continuas vs intermitentes -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Operaciones continuas vs intermitentes:</label>
                                    <p class="text-xs text-gray-500 italic mb-1">
                                        Indique si el activo opera de manera continua o en periodos específicos. Mencione también las principales tareas operativas, diferenciando entre misiones principales y secundarias.
                                    </p>
                                    <textarea name="operaciones_tipo" rows="4"
                                            class="w-full border-gray-300 rounded text-sm py-1 px-2">{{ old('operaciones_tipo', $buque->operaciones_tipo) }}</textarea>
                                </div>

                                <!-- 3. Estándares de calidad operacional -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Estándares de calidad operacional:</label>
                                    <p class="text-xs text-gray-500 italic mb-1">
                                        Especifique las expectativas de servicio al país. Incluya conceptos como preparación, efectividad táctica u operativa, y cumplimiento de misiones.
                                    </p>
                                    <textarea name="estandares_calidad" rows="4"
                                            class="w-full border-gray-300 rounded text-sm py-1 px-2">{{ old('estandares_calidad', $buque->estandares_calidad) }}</textarea>
                                </div>

                                <!-- 4. Estándares ambientales -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Estándares ambientales:</label>
                                    <p class="text-xs text-gray-500 italic mb-1">
                                        Identifique qué normativas ambientales aplican al activo: MARPOL, normas regionales, nacionales o propias de la organización. Indique también sus anexos si corresponde.
                                    </p>
                                    <textarea name="estandares_ambientales" rows="5"
                                            class="w-full border-gray-300 rounded text-sm py-1 px-2">{{ old('estandares_ambientales', $buque->estandares_ambientales) }}</textarea>
                                </div>

                                <!-- 5. Estándares de seguridad -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Estándares de seguridad:</label>
                                    <p class="text-xs text-gray-500 italic mb-1">
                                        Mencione las políticas, normas o guías técnicas aplicadas para prevenir lesiones o fatalidades. Incluya riesgos mecánicos, eléctricos, estructurales, tecnológicos, etc.
                                    </p>
                                    <textarea name="estandares_seguridad" rows="6"
                                            class="w-full border-gray-300 rounded text-sm py-1 px-2">{{ old('estandares_seguridad', $buque->estandares_seguridad) }}</textarea>
                                </div>

                                <!-- 6. Lugar de operaciones -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Lugar de operaciones:</label>
                                    <p class="text-xs text-gray-500 italic mb-1">
                                        Describa el entorno operativo: mar adentro/costa adentro, tropical, ártico, salinidad, temperaturas extremas, humedad, condiciones del mar, acceso a suministros, etc.
                                    </p>
                                    <textarea name="lugar_operaciones" rows="6"
                                            class="w-full border-gray-300 rounded text-sm py-1 px-2">{{ old('lugar_operaciones', $buque->lugar_operaciones) }}</textarea>
                                </div>
                            </div>

                            <div class="pt-0">
                                <div class="mt-0 space-y-4">
                                    <!-- 7. Intensidad de operaciones -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Intensidad de operaciones:</label>
                                        <p class="text-xs text-gray-500 italic mb-1">
                                            Indique el número de horas de operación anuales, distribución por velocidad, condiciones de carga, autonomía, alcance y si las políticas de falla son para tiempos de guerra o paz.
                                        </p>
                                        <textarea name="intensidad_operaciones" rows="5"
                                                class="w-full border-gray-300 rounded text-sm py-1 px-2">{{ old('intensidad_operaciones', $buque->intensidad_operaciones) }}</textarea>
                                    </div>

                                    <!-- 8. Redundancia -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Redundancia:</label>
                                        <p class="text-xs text-gray-500 italic mb-1">
                                            Indique si el sistema tiene redundancia activa o pasiva, y cómo se configura en cada modo de operación (ej. propulsores 1/2, generadores, backup de comunicaciones).
                                        </p>
                                        <textarea name="redundancia" rows="4"
                                                class="w-full border-gray-300 rounded text-sm py-1 px-2">{{ old('redundancia', $buque->redundancia) }}</textarea>
                                    </div>

                                    <!-- 9. Tareas durante la operación -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tareas durante la operación:</label>
                                        <p class="text-xs text-gray-500 italic mb-1">
                                            Describa si se pueden ejecutar tareas de mantenimiento sin detener el sistema. Indique si son tareas de operador o técnico, y si están ligadas a niveles de mantenimiento I o II.
                                        </p>
                                        <textarea name="tareas_operacion" rows="6"
                                                class="w-full border-gray-300 rounded text-sm py-1 px-2">{{ old('tareas_operacion', $buque->tareas_operacion) }}</textarea>
                                    </div>

                                    <!-- 10. Repuestos -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Repuestos:</label>
                                        <p class="text-xs text-gray-500 italic mb-1">
                                            Mencione si existen repuestos en stock o almacén. Especifique si son consumibles, piezas críticas, o si se requiere logística especial para su adquisición.
                                        </p>
                                        <textarea name="repuestos" rows="3"
                                                class="w-full border-gray-300 rounded text-sm py-1 px-2">{{ old('repuestos', $buque->repuestos) }}</textarea>
                                    </div>

                                    <!-- 11. Demanda operacional para repuestos -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Demanda operacional para repuestos:</label>
                                        <p class="text-xs text-gray-500 italic mb-1">
                                            Indique si la demanda varía según los tipos de operación, alcance, autonomía o condiciones de carga. Esto puede impactar políticas de mantenimiento o fallas.
                                        </p>
                                        <textarea name="demanda_repuestos" rows="3"
                                                class="w-full border-gray-300 rounded text-sm py-1 px-2">{{ old('demanda_repuestos', $buque->demanda_repuestos) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end" style="position: sticky; bottom: 10px;">
                        <button type="submit" class="flex items-center gap-2 text-white px-4 py-2 rounded shadow btn-guardar text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-floppy2" viewBox="0 0 16 16">
                                <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v3.5A1.5 1.5 0 0 1 11.5 6h-7A1.5 1.5 0 0 1 3 4.5V1H1.5a.5.5 0 0 0-.5.5m9.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
                            </svg>
                            Guardar Contexto Operacional
                        </button>
                    </div>
                </form>
            </div>




            <!-- Misiones -->
            @if ($buque->id)
            <div id="misiones" class="tab-content hidden">
                <form id="formularioCombinado" action="{{ route('buques.misionesYciclo.store', $buque->id) }}" method="POST">
                    @csrf

                    <!-- Dropdown de Selección de Misiones -->
                    <div class="mb-6 border rounded shadow" x-data="{ mostrarMisiones: false }">
                        <button type="button"
                            @click="mostrarMisiones = !mostrarMisiones"
                            class="w-full flex items-center justify-between px-4 py-3 font-semibold text-blue-800">
                            <span class="text-azulCotecmar">Selección de Misiones del Buque</span>

                            <template x-if="mostrarMisiones">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#003366" class="bi bi-chevron-up" viewBox="0 0 16 16"> 
                                    <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
                                </svg>
                            </template>
                            <template x-if="!mostrarMisiones">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#003366" class="bi bi-chevron-down" viewBox="0 0 16 16"> 
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </template>
                        </button>

                        <div x-show="mostrarMisiones" x-transition class="px-4 py-4">
                            <div class="flex mb-6">
                                <!-- Misiones Disponibles -->
                                <div class="w-1/2 bg-white p-4 rounded border border-gray-300">
                                    <h3 class="text-l font-bold text-gray-800 mb-4">Misiones Disponibles</h3>
                                    <ul id="availableMissions" class="space-y-2">
                                        @foreach ($misiones as $mision)
                                            @if (!$misionesSeleccionadas->contains($mision->id))
                                                <li data-id="{{ $mision->id }}">
                                                    <label class="flex items-center space-x-2">
                                                        <input type="checkbox" class="mission-checkbox" value="{{ $mision->id }}">
                                                        <span class="text-sm">{{ $mision->nombre }}</span>
                                                    </label>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Botones para mover misiones -->
                                <div class="flex flex-col justify-center items-center px-4">
                                    <button type="button" id="moveRight"
                                        class="bg-azulCotecmar text-white px-4 py-2 mb-2 rounded shadow hover:bg-blue-600 focus:outline-none">
                                        &gt;
                                    </button>
                                    <button type="button" id="moveLeft"
                                        class="bg-azulCotecmar text-white px-4 py-2 rounded shadow hover:bg-blue-600 focus:outline-none">
                                        &lt;
                                    </button>
                                </div>

                                <!-- Misiones Seleccionadas -->
                                <div class="w-1/2 bg-white p-4 rounded border border-gray-300">
                                    <h3 class="text-l font-bold text-gray-800 mb-4">Misiones Seleccionadas</h3>
                                    <ul id="selectedMissions" class="space-y-2">
                                        @foreach ($misionesSeleccionadas as $mision)
                                            <li data-id="{{ $mision->id }}">
                                                <label class="flex items-center space-x-2">
                                                    <input type="checkbox" name="misiones[{{ $mision->id }}][porcentaje]" value="0" checked>
                                                    <span class="text-sm">{{ $mision->nombre }}</span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Dropdown: Perfil de Navegación -->
                    <div class="mb-6 border rounded shadow" x-data="{ mostrarPerfil: true }">
                        <button type="button"
                            @click="mostrarPerfil = !mostrarPerfil"
                            class="w-full flex items-center justify-between px-4 py-3 font-semibold text-blue-800">
                            <span class="text-azulCotecmar">Perfil de Navegación</span>

                            <template x-if="mostrarPerfil">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#003366" class="bi bi-chevron-up" viewBox="0 0 16 16"> 
                                    <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
                                </svg>
                            </template>
                            <template x-if="!mostrarPerfil">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#003366" class="bi bi-chevron-down" viewBox="0 0 16 16"> 
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </template>
                        </button>

                        <div x-show="mostrarPerfil" x-transition class="px-4 py-4">

                            <!-- Tabla de Porcentaje y Descripción -->
                     <div class="mb-6 mt-1">

    <!-- Encabezado -->
    <div class="flex items-center justify-center mb-2">
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="px-4 text-lg font-semibold text-azulCotecmar">Fuera de puerto</span>
        <div class="flex-grow border-t border-gray-300"></div>
    </div>

    <!-- Fila: Puerto Extranjero -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center mb-4">
        <div class="flex items-center gap-2">
            <label for="puerto_extranjero" class="text-sm font-medium text-gray-700 whitespace-nowrap">
                Puerto Extranjero:
            </label>
            <input type="number"
                name="puerto_extranjero"
                id="puerto_extranjero"
                value="{{ old('puerto_extranjero', $datosPuertoBase->puerto_extranjero ?? '') }}"
                class="border-gray-300 rounded text-sm px-2 py-1 w-24 text-center"
                oninput="actualizarPorcentajePuertoExtranjero()">



            <span class="text-sm text-gray-500">horas</span>
            <span class="text-sm text-gray-500 ml-2">(<span id="porcentaje_puerto_extranjero">0</span>%)</span>
        </div>

       
    </div>

    <!-- Subtítulo -->
    <div class="text-l font-semibold text-gray-700 mb-4">
        Perfil de Misión
        <span class="text-sm text-gray-600 font-medium">
            (Horas de navegación: {{ $buque->horas_navegacion_anio ?? 0 }})
        </span>
    </div>

    

    <!-- Tabla de Misiones -->
    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead class="bg-gray-200">
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Misión</th>
                <th style="width: 120px;" class="border border-gray-300 px-2 py-2 text-center text-sm font-semibold text-gray-700">Porcentaje %</th>
                <th style="width: 100px;" class="border border-gray-300 px-2 py-2 text-center text-sm font-semibold text-gray-700">Horas</th>
                <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Descripción</th>
            </tr>
        </thead>
        <tbody id="missionsTableBody">
            @foreach ($misionesSeleccionadas as $mision)
                <tr>
                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $mision->nombre }}</td>
                    <td class="border border-gray-300 px-2 py-2 text-center text-sm text-gray-700">
                        <input type="number"
                            name="misiones[{{ $mision->id }}][porcentaje]"
                            value="{{ $mision->pivot->porcentaje }}"
                            min="0"
                            max="100"
                            class="percentage-input w-full border-gray-300 rounded text-sm"
                            oninput="validatePercentage(this); actualizarHoras(this, '{{ $mision->id }}')">
                    </td>
                    <td class="border border-gray-300 px-2 py-2 text-center text-sm text-gray-700">
                        <span id="horas_mision_{{ $mision->id }}">0</span>
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                        <textarea name="misiones[{{ $mision->id }}][descripcion]"
                                  class="w-full border-gray-300 rounded" style="height: 56px">{{ $mision->pivot->descripcion }}</textarea>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="bg-gray-100">
            <tr>
                <td class="border border-gray-300 px-4 py-2 text-sm font-bold text-gray-700">Total:</td>
                <td class="border border-gray-300 px-2 py-2 text-center text-sm font-bold text-gray-700">
                    <span id="totalPercentage">0</span>%
                </td>
                <td class="border border-gray-300 px-2 py-2"></td>
                <td class="border border-gray-300 px-4 py-2"></td>
            </tr>
        </tfoot>
    </table>

    <!-- Mensaje de error -->
    <div id="percentageError" class="mt-2 text-red-500 text-sm hidden">
        La suma de los porcentajes debe ser exactamente <strong>100%</strong> para poder guardar.
    </div>
</div>



                            <!-- Cards de Velocidad, Motores, Potencia y RPM -->
                            <div class="mt-6">
                                <h4 class="text-l font-semibold text-gray-700 mb-4">Perfil de uso de sistema de propulsión</h4>
                                <div id="selectedMissionCards" class="grid grid-cols-2 gap-4">
                                    @foreach ($misionesSeleccionadas as $mision)
                                        <div class="mission-card" id="mission-card-{{ $mision->id }}">
                                            <h4 class="text-base text-sm font-semibold mb-2">{{ $mision->nombre }}</h4>
                                            <div style="display: flex; gap: 8px;">
                                                <!-- Velocidad -->
                                                <div class="input-group" style="width: 33%;">
                                                    <label style="font-size: 12px;">Rango de velocidad (nudos)</label>
                                                    <input type="text"
                                                        name="misiones[{{ $mision->id }}][velocidad]"
                                                        value="{{ $mision->pivot->velocidad }}"
                                                        style="width: 100%; border: 1px solid #D1D5DB; border-radius: 4px; font-size: 14px; padding: 4px;">
                                                </div>

                                                <!-- Número de motores -->
                                                <div class="input-group" style="width: 27%;">
                                                    <label style="font-size: 12px;">Número de motores</label>
                                                    <input type="number"
                                                        name="misiones[{{ $mision->id }}][num_motores]"
                                                        value="{{ $mision->pivot->num_motores }}"
                                                        style="width: 100%; border: 1px solid #D1D5DB; border-radius: 4px; font-size: 14px; padding: 4px;">
                                                </div>

                                                <!-- Potencia -->
                                                <div class="input-group" style="width: 27%;">
                                                    <label style="font-size: 12px;">Potencia/Energía (%)</label>
                                                    <input type="number"
                                                        name="misiones[{{ $mision->id }}][potencia]"
                                                        value="{{ $mision->pivot->potencia }}"
                                                        min="0"
                                                        max="100"
                                                        style="width: 100%; border: 1px solid #D1D5DB; border-radius: 4px; font-size: 14px; padding: 4px;">
                                                </div>

                                                <!-- RPM -->
                                                <div class="input-group" style="width: 13%;">
                                                    <label style="font-size: 12px;">RPM</label>
                                                    <input type="number"
                                                        name="misiones[{{ $mision->id }}][rpm]"
                                                        value="{{ $mision->pivot->rpm ?? '' }}"
                                                        min="0"
                                                        style="width: 100%; border: 1px solid #D1D5DB; border-radius: 4px; font-size: 14px; padding: 4px; text-align: center;">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            
                            <div id="puerto-base">
                                <div class="flex items-center justify-center mt-10 mb-6">
                                    <div class="flex-grow border-t border-gray-300"></div>
                                    <span class="px-4 text-lg font-semibold text-azulCotecmar">Puerto Base</span>
                                    <div class="text-sm text-gray-600 font-medium mr-4 whitespace-nowrap">
                                        {{ 8760 - ($buque->horas_navegacion_anio ?? 0) }} horas
                                    </div>
                                    <div class="flex-grow border-t border-gray-300"></div>
                                </div>


                                <input type="hidden" id="horas_navegacion" value="{{ $buque->horas_navegacion_anio }}">
                                <div class="grid grid-cols-3 gap-6">
                                    @foreach ([1, 3, 5] as $año)
                                    <div class="bg-white border border-gray-300 rounded-lg shadow-sm p-4 space-y-6">
                                        <h3 class="text-center font-bold text-azulCotecmar text-base">
                                            {{ $año === 1 ? '1er Año' : ($año === 3 ? '3er Año' : '5to Año') }}
                                        </h3>

                                        {{-- 🔹 Disponible para Misiones --}}
                                        <div class="relative border border-gray-200 rounded-md p-2 bg-gray-50" style="margin-top: 10px;">
                                            <label class="text-xs text-gray-500 block mb-1">Disponible para Misiones (horas)</label>
                                            <div class="flex gap-2 justify-center">
                                                <div class="text-center text-blue-600 font-semibold text-sm" id="disponible_misiones_{{ $año }}_calc" style="width: 130px;">
                                                    {{ $datosPuertoBase->{'disponible_misiones_'.$año} ?? '0' }}
                                                </div>
                                                <div class="text-xs text-center text-gray-500 mt-1" id="porcentaje_disp_{{ $año }}">0%</div>

                                                <div class="absolute top-2 right-2 tooltip-container">
                                                    <div class="help-button">i</div>
                                                    <div class="tooltip">
                                                        Cálculo: 8760 - (Mantenimiento + ROH + Navegación)
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- 🔹 Disponibilidad de Mantenimiento --}}
                                        <div class="relative border border-gray-200 rounded-md p-2 bg-white" style="margin-top: 10px;">
                                            <label class="text-xs text-gray-500 block mb-1">Disponibilidad de Mantenimiento (horas)</label>
                                            <div class="flex gap-2 justify-center">
                                                <input type="number"
                                                id="disponibilidad_mantenimiento_{{ $año }}"
                                                name="disponibilidad_mantenimiento_{{ $año }}"
                                                class="w-full text-sm text-gray-800 outline-none border-none text-center"
                                                placeholder="Horas"
                                                min="0"
                                                value="{{ old("disponibilidad_mantenimiento_$año", $datosPuertoBase->{'disponibilidad_mantenimiento_'.$año} ?? '') }}"
                                                oninput="calcularPorcentaje(this, 'porcentaje_dm_{{ $año }}'); actualizarDisponible('{{ $año }}')">

                                                <input type="hidden"
                                                    id="mant_basico_{{ $año }}"
                                                    name="mant_basico_{{ $año }}"
                                                    value="{{ old("mant_basico_$año", $datosPuertoBase->{'mant_basico_'.$año} ?? '') }}">

                                                <div id="porcentaje_dm_{{ $año }}" class="text-xs text-right text-gray-400 mt-1">0%</div>

                                                <div class="absolute top-2 right-2 tooltip-container">
                                                    <div class="help-button">i</div>
                                                    <div class="tooltip">
                                                        Estimación de horas asignadas al mantenimiento para este año.
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        {{-- 🔹 ROH --}}
                                        <div class="relative border border-gray-200 rounded-md p-2 bg-white" style="margin-top: 10px;">
                                            <label class="text-xs text-gray-500 block mb-1">Revisión Periódica (ROH) (horas) </label>
                                                <div class="flex gap-2 flex gap-2 justify-center">
                                                    <input type="number"
                                                    id="roh_{{ $año }}"
                                                    name="roh_{{ $año }}"
                                                    class="w-full text-sm text-gray-800 outline-none border-none text-center"
                                                    placeholder="Horas"
                                                    min="0"
                                                    value="{{ old("roh_$año", $datosPuertoBase->{'roh_'.$año} ?? '') }}"
                                                    oninput="calcularPorcentaje(this, 'porcentaje_roh_{{ $año }}'); actualizarDisponible('{{ $año }}')">
                                                <div id="porcentaje_roh_{{ $año }}" class="text-xs text-right text-gray-400 mt-1">0%</div>

                                                <div class="absolute top-2 right-2 tooltip-container">
                                                    <div class="help-button">i</div>
                                                    <div class="tooltip">
                                                        Horas requeridas para revisiones técnicas periódicas.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div> <!-- Fin de x-show="mostrarPerfil" -->
                    </div> <!-- Fin del dropdown de Perfil de Navegación -->
                    
                    <!-- Botón único de guardar -->
                    <div class="mt-6 flex justify-end" style="position: sticky; bottom: 10px;">
                        <button type="button" id="guardarMisiones"
                                class="flex items-center gap-2 text-white px-4 py-2 rounded shadow btn-guardar text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-floppy2" viewBox="0 0 16 16">
                                    <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v3.5A1.5 1.5 0 0 1 11.5 6h-7A1.5 1.5 0 0 1 3 4.5V1H1.5a.5.5 0 0 0-.5.5m9.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
                                </svg>
                                Guardar Misiones
                        </button>
                        <span id="percentageError" class="text-red-500 text-sm hidden">
                            El total de porcentajes no puede superar el 100%
                        </span>
                    </div>
                </form>
            
            </div>
            @endif

            <!-- Configuración del Buque -->
            @if ($buque->id)
            <div id="configuracion-buque" class="tab-content hidden">

                <div x-data="{ mostrarSistemas: false, mostrarEquipos: false }">

                    <!-- Área 1: Selección de Sistemas -->
                    <div class="mb-6 border rounded shadow" x-data="selectorSistemas()" x-init="init()">
                        <button type="button"
                            @click="mostrarSistemas = !mostrarSistemas"
                            class="w-full flex items-center justify-between px-4 py-3 font-semibold text-blue-800">
                            <span class="text-azulCotecmar"> Selección de Sistemas del Buque</span>

                            <template x-if="mostrarSistemas">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#003366" class="bi bi-chevron-up" viewBox="0 0 16 16"> 
                                    <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
                                </svg>
                            </template>
                            <template x-if="!mostrarSistemas">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#003366" class="bi bi-chevron-down" viewBox="0 0 16 16"> 
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </template>
                        </button>


                        <div x-show="mostrarSistemas" x-transition class="px-4 py-4">
                            <form id="form-sistemas" data-action="{{ route('buques.sistemas.store', $buque->id) }}">
                                @csrf

                                <!-- Contenedor de columnas -->
                                <div class="flex flex-wrap" x-data="selectorSistemas()" x-init="init()" x-ref="contenedor">
                                    <!-- Columna Izquierda: Grupos -->
                                    <div x-ref="grupos" 
                                        :class="['transition-width', grupoSeleccionado || bloquearExpansión ? 'col-40' : 'col-100']"
                                        class="space-y-2"
                                        style="height: fit-content;">
                                        @foreach ($grupos as $grupo)
                                        <button type="button"
                                            @click="seleccionarGrupo({{ $grupo->id }})"
                                            class="w-full text-left px-4 py-2 rounded border hover:bg-blue-100 transition font-medium"
                                            :class="grupoSeleccionado === {{ $grupo->id }} 
                                                ? 'bg-blue-200 text-blue-900' 
                                                : 'bg-white text-gray-600'">
                                            {{ $grupo->codigo }} - {{ $grupo->nombre }}
                                        </button>


                                        @endforeach
                                    </div>

                                    <!-- Columna Derecha: Sistemas -->
                                    <div x-ref="sistemas"
                                        :class="['transition-width', grupoSeleccionado ? 'col-60 fade-visible' : 'col-60 fade-hidden']"
                                        style="padding-left: 20px; overflow-y: auto; scroll-behavior: smooth;">
                                        
                                        @foreach ($grupos as $grupo)
                                            <div x-show="grupoSeleccionado === {{ $grupo->id }}" class="space-y-2">
                                                @foreach ($grupo->sistemas as $sistema)
                                                    <div class="flex items-center space-x-2">
                                                        <input type="checkbox"
                                                            id="sistema-{{ $sistema->id }}"
                                                            name="sistemas[]"
                                                            value="{{ $sistema->id }}"
                                                            {{ $buque->sistemas->contains($sistema->id) ? 'checked' : '' }}
                                                            class="form-checkbox border-gray-300 rounded"
                                                            @change="actualizarEquipos()">
                                                        <label for="sistema-{{ $sistema->id }}" class="text-sm text-gray-600">
                                                            {{ $sistema->codigo }} - {{ $sistema->nombre }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <button type="submit"
                                        class="flex items-center gap-2 text-white px-4 py-2 rounded shadow text-sm"
                                        style="background-color: #003366;"
                                        onmouseover="this.style.backgroundColor='#002244';"
                                        onmouseout="this.style.backgroundColor='#003366';">
                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy2" viewBox="0 0 16 16">
                                            <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v3.5A1.5 1.5 0 0 1 11.5 6h-7A1.5 1.5 0 0 1 3 4.5V1H1.5a.5.5 0 0 0-.5.5m9.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
                                        </svg>

                                        Guardar sistemas
                                    </button>
                                </div>
                            </form>
                        </div>

                        <script>
                            window.sistemasSeleccionadosLaravel = @json(
                                $buque->sistemas->map(function($s) {
                                    return [
                                        'codigo' => (string) $s->codigo,   // asegúrate que sea string
                                        'id_sistema_ils' => $s->id,
                                        'nombre' => $s->nombre
                                    ];
                                })
                            );
                        </script>

                    </div>


                    @if ($buque->sistemas->count() > 0)
                        <div class="border rounded shadow" x-data="equiposBuque({{ $buque->id }})" x-init="init()">
                            <!-- Botón desplegable -->
                            <button type="button"
                                @click="mostrarEquipos = !mostrarEquipos"
                                class="w-full flex items-center justify-between px-4 py-3 font-semibold text-blue-800">
                                <span class="text-azulCotecmar">Gestión de Equipos</span>
                                <template x-if="mostrarEquipos">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#003366" class="bi bi-chevron-up" viewBox="0 0 16 16"> 
                                        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
                                    </svg>
                                </template>
                                <template x-if="!mostrarEquipos">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#003366" class="bi bi-chevron-down" viewBox="0 0 16 16"> 
                                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                    </svg>
                                </template>
                            </button>

                            <!-- Contenido -->
                            <div x-show="mostrarEquipos" x-transition class="px-4 py-4">

                                <!-- Campo de búsqueda + botón de Filtros + botón Configuración avanzada -->
                                <div class="flex items-center justify-between gap-2 relative mb-4">
                                    <div class="flex gap-2">
                                        <!-- 🔍 Campo de búsqueda -->
                                        <input id="buscarEquipo" type="text" x-model="filtros.nombre" @input="filtrarEquipos()" class="form-input" placeholder="Buscar por Nombre" />

                                        <!-- 🎛 Botón Filtros -->
                                        <div class="relative">
                                            <button @click="mostrarFiltrosAvanzados = !mostrarFiltrosAvanzados"
                                                class="flex items-center gap-1 px-3 py-2 bg-azulCotecmar text-white rounded-md shadow hover:bg-blue-800 transition"
                                                id="BtnFiltros" aria-label="Mostrar filtros">
                                                Filtros
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-funnel" viewBox="0 0 16 16">
                                                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                                                </svg>
                                            </button>

                                            <!-- Dropdown de filtros avanzados -->
                                            <div x-show="mostrarFiltrosAvanzados" @click.outside="mostrarFiltrosAvanzados = false"
                                                class="absolute z-50 bg-white border rounded-md shadow-lg mt-2 p-4 w-80 space-y-4 text-sm left-0 flex"
                                                id="filtrosAvanzados">

                                                <!-- Filtros de jerarquía -->
                                                <div style="width: 60%">
                                                    <div>
                                                        <label class="block text-gray-600 mb-1 font-medium">Grupo</label>
                                                        <select x-model="filtros.grupo" @change="filtrarEquipos()" class="form-select w-full">
                                                            <option value="">Todos los grupos</option>
                                                            <template x-for="item in grupos" :key="item.id">
                                                                <option :value="item.id" x-text="item.descripcion"></option>
                                                            </template>
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label class="block text-gray-600 mb-1 font-medium">Subgrupo</label>
                                                        <select x-model="filtros.subgrupo" @change="filtrarEquipos()" class="form-select w-full">
                                                            <option value="">Todos los subgrupos</option>
                                                            <template x-for="item in subgrupos" :key="item.id">
                                                                <option :value="item.id" x-text="item.descripcion"></option>
                                                            </template>
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label class="block text-gray-600 mb-1 font-medium">Sistema</label>
                                                        <select x-model="filtros.sistema" @change="filtrarEquipos()" class="form-select w-full">
                                                            <option value="">Todos los sistemas</option>
                                                            <template x-for="item in sistemas" :key="item.id">
                                                                <option :value="item.id" x-text="item.descripcion"></option>
                                                            </template>
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label class="block text-gray-600 mb-1 font-medium">Subsistema</label>
                                                        <select x-model="filtros.subsistema" @change="filtrarEquipos()" class="form-select w-full">
                                                            <option value="">Todos los subsistemas</option>
                                                            <template x-for="item in subsistemas" :key="item.id">
                                                                <option :value="item.id" x-text="item.descripcion"></option>
                                                            </template>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- 🧩 Selector de columnas visibles -->
                                                <div>
                                                    <label class="block text-gray-600 mb-1 font-medium">Mostrar columnas</label>
                                                    <div class="space-y-1">
                                                        <template x-for="col in columnasDisponibles" :key="col.campo">
                                                            <label class="flex items-center space-x-2">
                                                                <input type="checkbox" x-model="col.visible">
                                                                <span x-text="col.label"></span>
                                                            </label>
                                                        </template>
                                                    </div>
                                                </div>

                                                <!-- Botón cerrar -->
                                                <div class="flex justify-end pt-2">
                                                    <button @click="mostrarFiltrosAvanzados = false" class="text-sm text-gray-600 hover:text-red-500 cerrar">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    

                                    <!-- ⚙️ Botón de configuración avanzada -->
                                    <button
                                        class="flex items-center gap-2 px-3 py-2 bg-azulCotecmar text-white rounded-md shadow hover:bg-blue-800 transition"
                                        onclick="window.location.href='{{ Config::get('api.flask_url') }}/equipos_buque/{{ rawurlencode($buque->nombre) }}?buque_id={{ $buque->id }}&from=editar_buque'"
                                        aria-label="Configuración avanzada" id="BtnConfigAvan">
                                        <!-- SVG ICONO -->
                                        Configuración avanzada
                                    </button>

                                </div>

                                <!-- Cards equipo -->
                                <div x-show="equiposFiltrados.length > 0">

                                    <!-- Header -->
                                    <div class="flex justify-between px-4 py-2 border-b bg-gray-100 font-semibold text-gray-700 text-sm">

                                        <!-- Nombre -->
                                        <div :style="`width: ${obtenerWidthColumna('nombre')}`">
                                            Nombre
                                        </div>

                                        <!-- Marca -->
                                        <div :style="`width: ${obtenerWidthColumna('marca')}`">
                                            Marca
                                        </div>

                                        <!-- Modelo -->
                                        <div :style="`width: ${obtenerWidthColumna('modelo')}`">
                                            Modelo
                                        </div>

                                        <!-- Descripción -->
                                        <div
                                            x-show="columnasDisponibles.find(c => c.campo === 'descripcion')?.visible"
                                            x-transition
                                            :style="columnasDisponibles.find(c => c.campo === 'descripcion')?.visible ? `width: ${obtenerWidthColumna('descripcion')}` : 'width: 0%; display: none;'"
                                            class="text-center"
                                        >
                                            Descripción
                                        </div>

                                        <!-- Dimensiones -->
                                        <div
                                            x-show="columnasDisponibles.find(c => c.campo === 'dimensiones')?.visible"
                                            x-transition
                                            :style="columnasDisponibles.find(c => c.campo === 'dimensiones')?.visible ? `width: ${obtenerWidthColumna('dimensiones')}` : 'width: 0%; display: none;'"
                                            class="text-center"
                                        >
                                            Dimensiones
                                        </div>

                                        <!-- Peso seco -->
                                        <div
                                            x-show="columnasDisponibles.find(c => c.campo === 'peso_seco')?.visible"
                                            x-transition
                                            :style="columnasDisponibles.find(c => c.campo === 'peso_seco')?.visible ? `width: ${obtenerWidthColumna('peso_seco')}` : 'width: 0%; display: none;'"
                                            class="text-center"
                                        >
                                            Peso seco
                                        </div>

                                        <!-- Imagen -->
                                        <div
                                            x-show="columnasDisponibles.find(c => c.campo === 'imagen')?.visible"
                                            x-transition
                                            :style="columnasDisponibles.find(c => c.campo === 'imagen')?.visible ? `width: ${obtenerWidthColumna('imagen')}` : 'width: 0%; display: none;'"
                                            class="text-center"
                                        >
                                            Imagen
                                        </div>

                                        <!-- Cantidad -->
                                        <div :style="`width: ${obtenerWidthColumna('cantidad')}`" class="text-center">
                                            Cantidad
                                        </div>

                                        <!-- Botón Relacionar (sin título, pero reservado el espacio) -->
                                        <div :style="`width: ${obtenerWidthColumna('relacion')}`" class="text-center"></div>

                                        <!-- Acciones -->
                                        <div :style="`width: ${obtenerWidthColumna('acciones')}`" class="text-center"></div>

                                    </div>


                                    <!-- Botón para añadir nuevo equipo -->
                                    <div class="bg-white border border-dashed border-gray-400 text-center py-1 rounded cursor-pointer hover:bg-gray-50"
                                        @click="crearEquipoVacio()" x-show="!modoEdicion" style="margin-top: 0.5rem">
                                        <span class="text-grisCotecmar font-semibold text-sm">+ Añadir nuevo equipo</span>
                                    </div>

                                    <!-- Equipos -->
                                    <template x-for="(equipo, index) in equiposFiltrados" :key="equipo.id_equipo">
                                        <div>
                                            
                                            <!-- Fila principal -->
                                            <div class="flex justify-between px-4 py-2 border-b items-center bg-white text-sm">

                                                <!-- Nombre -->
                                                <div :style="`width: ${obtenerWidthColumna('nombre')}`" class="flex items-center gap-2 text-sm" style="font-weight: 500; color: #1f2937;">

                                                    <!-- Botón chevron (expandir/replegar copias relacionadas) -->
                                                    <template x-if="equipo.copiasRelacionadas && equipo.copiasRelacionadas.length > 0">
                                                        <button @click="equipo.expandido = !equipo.expandido"
                                                                class="text-gray-500 hover:text-gray-700"
                                                                title="Mostrar/Ocultar copias">
                                                            <template x-if="equipo.expandido">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-chevron-up">
                                                                    <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
                                                                </svg>
                                                            </template>
                                                            <template x-if="!equipo.expandido">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-chevron-down">
                                                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                                                </svg>
                                                            </template>
                                                        </button>
                                                    </template>

                                                    <!-- Campo editable o texto plano -->
                                                    <template x-if="modoEdicion && equipoEnEdicion === index">
                                                        <input type="text" x-model="equipo.nombre_equipo" class="input-bajo">
                                                    </template>
                                                    <template x-if="!(modoEdicion && equipoEnEdicion === index)">
                                                        <span x-text="equipo.nombre_equipo"></span>
                                                    </template>

                                                </div>


                                                <!-- Marca -->
                                                <div :style="`width: ${obtenerWidthColumna('marca')}`" style="color: #4b5563;">
                                                    <template x-if="modoEdicion && equipoEnEdicion === index">
                                                        <input type="text" x-model="equipo.marca" class="input-bajo">
                                                    </template>
                                                    <template x-if="!(modoEdicion && equipoEnEdicion === index)">
                                                        <span x-text="equipo.marca"></span>
                                                    </template>
                                                </div>

                                                <!-- Modelo -->
                                                <div :style="`width: ${obtenerWidthColumna('modelo')}`" style="color: #4b5563;">
                                                    <template x-if="modoEdicion && equipoEnEdicion === index">
                                                        <input type="text" x-model="equipo.modelo" class="input-bajo">
                                                    </template>
                                                    <template x-if="!(modoEdicion && equipoEnEdicion === index)">
                                                        <span x-text="equipo.modelo"></span>
                                                    </template>
                                                </div>

                                                <!-- Descripción -->
                                                <div
                                                    x-show="columnasDisponibles.find(c => c.campo === 'descripcion')?.visible"
                                                    x-transition
                                                    :style="columnasDisponibles.find(c => c.campo === 'descripcion')?.visible ? `width: ${obtenerWidthColumna('descripcion')}` : 'width: 0%; display: none;'"
                                                    class="text-center">
                                                    <span @click="abrirModalDescripcion(equipo.descripcion, modoEdicion && equipoEnEdicion === index, index)"
                                                        class="text-azulCotecmar hover:underline cursor-pointer">
                                                        <span x-text="equipo.descripcion.slice(0, 10) + '...'"></span>
                                                    </span>

                                                </div>

                                                <!-- Dimensiones -->
                                                <div
                                                    x-show="columnasDisponibles.find(c => c.campo === 'dimensiones')?.visible"
                                                    x-transition
                                                    :style="columnasDisponibles.find(c => c.campo === 'dimensiones')?.visible ? `width: ${obtenerWidthColumna('dimensiones')}` : 'width: 0%; display: none;'"
                                                    class="text-center">
                                                    <div>
                                                        <input type="text"
                                                            x-show="modoEdicion && equipoEnEdicion === index"
                                                            x-model="equipo.dimensiones"
                                                            class="input-bajo">
                                                        <span x-show="!(modoEdicion && equipoEnEdicion === index)"
                                                            x-text="equipo.dimensiones || '-'"
                                                            class="text-sm text-gray-700"></span>
                                                    </div>
                                                </div>

                                                <!-- Peso seco -->
                                                <div
                                                    x-show="columnasDisponibles.find(c => c.campo === 'peso_seco')?.visible"
                                                    x-transition
                                                    :style="columnasDisponibles.find(c => c.campo === 'peso_seco')?.visible ? `width: ${obtenerWidthColumna('peso_seco')}` : 'width: 0%; display: none;'"
                                                    class="text-center">
                                                    <div>
                                                        <input type="text"
                                                            x-show="modoEdicion && equipoEnEdicion === index"
                                                            x-model="equipo.peso_seco"
                                                            class="input-bajo">
                                                        <span x-show="!(modoEdicion && equipoEnEdicion === index)"
                                                            x-text="equipo.peso_seco || '-'"
                                                            class="text-sm text-gray-700"></span>
                                                    </div>
                                                </div>

                                                <!-- Imagen -->
                                                <div
                                                    x-show="columnasDisponibles.find(c => c.campo === 'imagen')?.visible"
                                                    x-transition
                                                    :style="columnasDisponibles.find(c => c.campo === 'imagen')?.visible ? `width: ${obtenerWidthColumna('imagen')}` : 'width: 0%; display: none;'"
                                                    class="text-center">
                                                    <span @click="abrirModalImagen(equipo.imagen, index)"
                                                        class="text-azulCotecmar hover:underline cursor-pointer">
                                                        Ver imagen
                                                    </span>

                                                </div>

                                                <!-- Cantidad total -->
                                                <div :style="`width: ${obtenerWidthColumna('cantidad')}`" class="text-center" style="font-weight: 600; color: black;" x-text="equipo.totalCantidad || 0"></div>

                                                <!-- Botón Relacionar -->
                                                <div :style="`width: ${obtenerWidthColumna('relacion')}`" class="text-center">
                                                    <template x-if="modoEdicion && equipoEnEdicion === index">
                                                        <button @click="abrirModalRelacionar(index)" class="bg-azulCotecmar hover:bg-blue-200 text-white px-2 py-1 rounded text-xs font-medium">
                                                            Asignar Sistemas
                                                        </button>
                                                    </template>
                                                </div>

                                               <!-- Acciones -->
                                                <div :style="`width: ${obtenerWidthColumna('acciones')}`" class="flex justify-center gap-2">
                                                    <template x-if="modoEdicion && equipoEnEdicion === index">
                                                        <div class="flex gap-2">
                                                            <!-- Botón Guardar: solo si hay copias -->
                                                            <template x-if="equipo.copiasRelacionadas && equipo.copiasRelacionadas.length > 0">
                                                                <button @click="confirmarGuardado()" class="bg-azulCotecmar hover:bg-green-700 rounded" title="Guardar" style="padding: 4px">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-floppy2">
                                                                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v3.5A1.5 1.5 0 0 1 11.5 6h-7A1.5 1.5 0 0 1 3 4.5V1H1.5a.5.5 0 0 0-.5.5m9.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
                                                                    </svg>
                                                                </button>
                                                            </template>

                                                            <!-- Botón Cancelar: siempre visible en edición -->
                                                            <button @click="cancelarEdicion()" class="bg-red-500 hover:bg-red-600 rounded" title="Cancelar" style="padding: 4px">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-x">
                                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </template>


                                                    <template x-if="!modoEdicion">
                                                        <div class="flex gap-1">
                                                            <!-- Editar -->
                                                            <button @click="iniciarEdicion(index)" class="bg-azulCotecmar hover:bg-blue-700 rounded" title="Editar" style="padding: 4px">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-pencil-square">
                                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                                </svg>
                                                            </button>
                                                            <!-- Eliminar -->
                                                            <button @click="eliminarEquipo(equipo)" class="hover:bg-red-700 rounded" title="Eliminar" style="padding: 4px; background-color: #730C02">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-trash">
                                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>

                                            <!-- Contenedor colapsable de copias -->
                                            <template x-if="equipo.copiasRelacionadas && equipo.copiasRelacionadas.length > 0 && equipo.expandido">
                                                <div class="px-4 py-2 text-xs space-y-2">
                                                    <template x-for="(copia, idx) in equipo.copiasRelacionadas" :key="`${copia.id_sistema}-${copia.id_subsistema}-${index}-${idx}`">
                                                        <div class="flex justify-between items-start rounded bg-white p-0 border-b" style="margin-left: 10px; margin-top: 0.5rem; padding-bottom: 0.5rem; ">

                                                            <div style="width: 50%;">
                                                                <div class="text-xs text-gray-500 uppercase mb-1">Sistema relacionado</div>
                                                                <div class="text-sm">
                                                                    <span class="text-azulCotecmar font-semibold" x-text="copia.sistema_codigo.split(' - ')[0]"></span>
                                                                    <span class="text-gray-700" x-text="` - ${copia.sistema_codigo.split(' - ').slice(1).join(' - ')}`"></span>
                                                                </div>
                                                            </div>

                                                            <div style="width: 40%;">
                                                                <label class="text-xs text-gray-500 uppercase mb-1 block">Subsistema</label>
                                                                <div class="text-sm">
                                                                    <span class="text-azulCotecmar font-semibold" x-text="copia.subsistema_codigo.split(' - ')[0]"></span>
                                                                    <span class="text-gray-700" x-text="` - ${copia.subsistema_codigo.split(' - ').slice(1).join(' - ')}`"></span>
                                                                </div>
                                                            </div>

                                                            <!-- Cantidad -->
                                                            <div class="flex-1 flex flex-col" style="width: 10%; align-items: center">
                                                                <label class="text-xs text-gray-500 uppercase mb-1">Cantidad</label>
                                                                <input type="number"
                                                                    min="0"
                                                                    class="input-bajo"
                                                                    :value="copia.cantidad"
                                                                    @input="validarCantidadCopia($event, copia, equipo)"
                                                                    :readonly="!modoEdicion"
                                                                >
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                </div>

                                <!-- Modal Imagen -->
                                <div x-show="modalImagen.mostrar" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" @click.self="cerrarModales()">
                                    <div class="bg-white rounded shadow-lg p-4 max-w-lg w-3/4">
                                        <h2 class="text-lg font-semibold text-azulCotecmar mb-2">Vista previa de imagen</h2>

                                        <!-- Vista previa -->
                                        <template x-if="modalImagen.url">
                                            <img :src="modalImagen.url" alt="Imagen equipo"
                                                style="max-height: 70vh; width: auto; max-width: 100%; object-fit: contain; display: block; margin: 0 auto;"
                                                class="rounded border mb-4" />
                                        </template>

                                        <template x-if="modoEdicion && modalImagen.index === equipoEnEdicion">
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Subir nueva imagen:</label>
                                                <input type="file" @change="cargarImagen($event)" accept="image/*"
                                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-1 file:px-2 file:border file:border-gray-300 file:rounded file:text-sm file:font-semibold file:bg-azulCotecmar file:text-white hover:file:bg-blue-600" />
                                            </div>
                                        </template>

                                        <div class="text-right">
                                            <button @click="cerrarModales()" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Cerrar</button>
                                        </div>
                                    </div>
                                </div>


                                <!-- Modal Descripción -->
                                <div x-show="modalDescripcion.mostrar" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" @click.self="cerrarModales()">
                                    <div class="bg-white rounded shadow-lg p-4 max-w-lg w-3/4">
                                        <h2 class="text-lg font-semibold text-azulCotecmar mb-2">Descripción del equipo</h2>
                                        <textarea
                                            x-model="modalDescripcion.contenido"
                                            :readonly="!(modoEdicion && modalDescripcion.index === equipoEnEdicion)"
                                            :class="!(modoEdicion && modalDescripcion.index === equipoEnEdicion) ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white text-gray-900'"
                                            class="w-full h-40 border rounded p-2 resize-none focus:outline-none focus:ring"
                                            placeholder="Descripción del equipo..."
                                            @input="actualizarDescripcionEquipo()">
                                        </textarea>



                                        <div class="mt-4 text-right">
                                            <button @click="cerrarModales()" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Cerrar</button>
                                        </div>
                                    </div>
                                </div>

                                
                                <!-- Modal Relacionar Sistemas y Subsistemas -->
                                <div x-show="mostrarModalRelacionar"
                                    class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
                                    @click.self="cerrarModalRelacionar()">

                                    <div class="bg-white rounded shadow-lg p-4" style="margin: 1rem; width: 100%;">
                                        <h2 class="text-lg font-semibold text-azulCotecmar mb-4">Asignar Sistemas y Subsistemas</h2>

                                        <div class="flex gap-4 max-h-96 overflow-y-auto">
                                            <!-- Columna 1: Grupos -->
                                            <div class="border-r pr-4 flex-shrink-0" style="width: 22%">
                                                <h3 class="text-sm font-medium text-gray-600 mb-2">Grupos</h3>
                                                <template
                                                    x-for="grupo in Array.from(
                                                        new Set(window.sistemasSeleccionadosLaravel.map(s => s.codigo.toString().substring(0, 1) + '00'))
                                                    )"
                                                    :key="grupo"
                                                >
                                                    <button 
                                                        class="block text-left px-3 py-2 mb-2 rounded border text-sm font-medium w-full"
                                                        :class="grupoSeleccionadoModal === grupo ? 'bg-azulCotecmar text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                                        @click="grupoSeleccionadoModal = grupo; sistemaSeleccionadoModal = null"
                                                    >
                                                        <span x-text="nombreGrupo(grupo)"></span>
                                                    </button>
                                                </template>
                                            </div>

                                            <!-- Columna 2: Sistemas -->
                                            <div class="border-r pr-4" style="width: 33%">
                                                <h3 class="text-sm font-medium text-gray-600 mb-2">Sistemas</h3>

                                                <template x-if="!grupoSeleccionadoModal">
                                                    <div class="text-gray-500 italic text-sm">Seleccione un grupo</div>
                                                </template>

                                                <template
                                                    x-for="s in window.sistemasSeleccionadosLaravel.filter(s => s.codigo.toString().startsWith(grupoSeleccionadoModal?.substring(0, 1)))"
                                                    :key="s.id_sistema_ils">
                                                    <button 
                                                        class="block w-full text-left px-3 py-2 mb-2 rounded border text-sm font-medium"
                                                        :class="sistemaSeleccionadoModal === s.codigo ? 'bg-azulCotecmar text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                                        @click="sistemaSeleccionadoModal = s.codigo"
                                                        x-text="`${s.codigo} - ${s.nombre}`">
                                                    </button>
                                                </template>
                                            </div>

                                            <!-- Columna 3: Subsistemas -->
                                            <div style="width: 45%">
                                                <h3 class="text-sm font-medium text-gray-600 mb-2">Subsistemas</h3>

                                                <template x-if="!sistemaSeleccionadoModal">
                                                    <div class="text-gray-500 italic text-sm">Seleccione un sistema</div>
                                                </template>

                                                <template 
                                                    x-for="sub in subsistemasDisponibles.filter(ss => ss.ref_sistema == sistemaSeleccionadoModal)" 
                                                    :key="`${sub.sistema_id}_${sub.id_subsistema}`">

                                                    <label class="flex items-center space-x-2 mb-1 text-sm"
                                                        :title="tieneEquipos(sub) ? 'No se puede deseleccionar: tiene equipos cargados' : ''">
                                                        <input type="checkbox"
                                                            :value="`${sub.sistema_id}|${sub.id_subsistema}`"
                                                            x-model="subsistemasSeleccionados"
                                                            class="form-checkbox border-gray-300 rounded"
                                                            :disabled="tieneEquipos(sub)">
                                                        <span x-text="`${sub.numero_de_referencia} - ${sub.nombre_subsistema}`"></span>
                                                    </label>

                                                </template>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex justify-end gap-2">
                                            <button @click="cerrarModalRelacionar()" class="bg-gray-300 text-gray-800 px-4 py-1 rounded hover:bg-gray-400">Cancelar</button>
                                            <button @click="agregarCopiasRelacionadas()" class="bg-azulCotecmar text-white px-4 py-1 rounded hover:bg-blue-800">Asignar</button>
                                        </div>
                                    </div>
                                </div>


                                <div x-show="equiposFiltrados.length === 0" class="text-sm text-gray-500">
                                    No hay equipos registrados para este buque.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
        
        <div id="spinner-container" class="fixed inset-0 z-50 flex items-center justify-center hidden" style="background-color: rgba(255, 255, 255, 0.85);">
            <div class="spinner">
                <img src="/images/LogoProyect.webp" alt="Logo Cotecmar" />
            </div>
        </div>

    </div>

<script>
    const availableMissions = document.getElementById('availableMissions');
    const selectedMissions = document.getElementById('selectedMissions');
    const missionsTableBody = document.getElementById('missionsTableBody');
    const moveRight = document.getElementById('moveRight');
    const moveLeft = document.getElementById('moveLeft');
    const formularioCombinado = document.getElementById('formularioCombinado');
    const horasNavegacion = {{ (int)($buque->horas_navegacion_anio ?? 0) }};
    const modoEdicion = {{ $buque->id ? 'true' : 'false' }};
    const missionDataCache = {};

    // Función para validar porcentajes
    function validatePercentage(input) {
        const inputs = document.querySelectorAll('.percentage-input');
        let total = 0;

        inputs.forEach(i => {
            const val = parseFloat(i.value);
            if (!isNaN(val)) {
                total += val;
            }
        });

        const totalElement = document.getElementById('totalPercentage');
        const submitButton = document.getElementById('guardarMisiones');
        const errorMessage = document.getElementById('percentageError');

        totalElement.textContent = total.toFixed(1);

        if (total === 100) {
            totalElement.classList.remove('text-red-500', 'font-bold');
            totalElement.classList.add('text-green-600');
            if (submitButton) submitButton.disabled = false;
            if (errorMessage) errorMessage.classList.add('hidden');
        } else {
            totalElement.classList.add('text-red-500', 'font-bold');
            totalElement.classList.remove('text-green-600');
            if (submitButton) submitButton.disabled = true;
            if (errorMessage) errorMessage.classList.remove('hidden');
        }
    }

    // Función para calcular el total de porcentajes
    function calculateTotal() {
        const inputs = document.querySelectorAll('.percentage-input');
        let total = 0;

        inputs.forEach(input => {
            total += parseFloat(input.value || 0);
        });

        const totalElement = document.getElementById('totalPercentage');
        const submitButton = document.getElementById('guardarMisiones');
        const errorMessage = document.getElementById('percentageError');

        if (totalElement) {
            totalElement.textContent = total.toFixed(1);
        }

        if (submitButton && errorMessage) {
            if (total > 100) {
                submitButton.disabled = true;
                errorMessage.classList.remove('hidden');
            } else {
                submitButton.disabled = false;
                errorMessage.classList.add('hidden');
            }
        }
    }

    // Función para actualizar la tabla de misiones seleccionadas
    function updateMissionsTable() {
        if (!missionsTableBody) return;
        missionsTableBody.innerHTML = '';

        document.querySelectorAll('#selectedMissions li').forEach((li) => {
            const id = li.dataset.id;
            const name = li.querySelector('span').textContent;

            const data = missionDataCache[id] || {};

            missionsTableBody.innerHTML += `
                <tr>
                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">${name}</td>
                    <td class="border border-gray-300 px-2 py-2 text-sm text-gray-700">
                        <input type="number"
                            name="misiones[${id}][porcentaje]"
                            class="percentage-input w-full border-gray-300 rounded"
                            value="${data.porcentaje || ''}"
                            min="0" max="100"
                            oninput="validatePercentage(this)">
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                        <textarea name="misiones[${id}][descripcion]"
                                class="w-full border-gray-300 rounded"
                                placeholder="Ej: Interdicción marítima, búsqueda...">${data.descripcion || ''}</textarea>
                    </td>
                </tr>
            `;
        });

        calculateTotal();
    }
    
    // Función para crear una card de misión
    function createMissionCard(id, name) {
        const card = document.createElement('div');
        card.className = 'mission-card flex flex-col';
        card.id = `mission-card-${id}`;
        card.innerHTML = `
            <h4 class="text-base font-semibold mb-2">${name}</h4>
            <div class="flex space-x-2 flex-grow">
                <div class="input-group flex-1">
                    <label class="text-xs">Rango de velocidad</label>
                    <input type="text"
                           name="misiones[${id}][velocidad]"
                           value="${missionDataCache[id]?.velocidad || ''}"
                           class="w-full border-gray-300 rounded text-sm">
                </div>
                <div class="input-group flex-1">
                    <label class="text-xs">Número de motores</label>
                    <input type="number"
                           name="misiones[${id}][num_motores]"
                           value="${missionDataCache[id]?.num_motores || ''}"
                           class="w-full border-gray-300 rounded text-sm">
                </div>
                <div class="input-group flex-1">
                    <label class="text-xs">Potencia/Energía (%)</label>
                    <input type="number"
                           name="misiones[${id}][potencia]"
                           value="${missionDataCache[id]?.potencia || ''}"
                           min="0"
                           max="100"
                           class="w-full border-gray-300 rounded text-sm">
                </div>
            </div>
        `;
        return card;
    }

    
    function updateMissionCards() { // Función para actualizar las cards de parámetros técnicos
        const container = document.getElementById('selectedMissionCards');
        if (!container) return;

        container.innerHTML = '';
        container.className = 'grid grid-cols-2 gap-4';

        document.querySelectorAll('#selectedMissions li').forEach((li, index) => {
            const id = li.dataset.id;
            const name = li.querySelector('span').textContent;
            const data = missionDataCache[id] || {};

            const card = document.createElement('div');
            card.className = 'mission-card';
            card.id = `mission-card-${id}`;
            card.innerHTML = `
                <h4 class="text-base font-semibold mb-2">${name}</h4>
                <div class="flex space-x-2">
                    <div class="input-group flex-1">
                        <label class="text-xs">Rango de velocidad</label>
                        <input type="text"
                            name="misiones[${id}][velocidad]"
                            value="${data.velocidad || ''}"
                            class="w-full border-gray-300 rounded text-sm">
                    </div>
                    <div class="input-group flex-1">
                        <label class="text-xs">N° Motores</label>
                        <input type="number"
                            name="misiones[${id}][num_motores]"
                            value="${data.num_motores || ''}"
                            class="w-full border-gray-300 rounded text-sm">
                    </div>
                    <div class="input-group flex-1">
                        <label class="text-xs">Potencia (%)</label>
                        <input type="number"
                            name="misiones[${id}][potencia]"
                            value="${data.potencia || ''}"
                            class="w-full border-gray-300 rounded text-sm"
                            min="0" max="100">
                    </div>
                </div>
            `;

            container.appendChild(card);

            setTimeout(() => {
                card.classList.add('active');
            }, index * 100);
        });
    }

    // Función para cachear todos los datos del formulario
    function cacheAllFormData() {
        // Cachear datos de la tabla de porcentajes y descripciones
        document.querySelectorAll('#missionsTableBody tr').forEach(tr => {
            const inputPorcentaje = tr.querySelector('input[type="number"]');
            if (!inputPorcentaje) return;

            const id = inputPorcentaje.name.match(/\d+/)[0];

            if (!missionDataCache[id]) {
                missionDataCache[id] = {};
            }

            missionDataCache[id].porcentaje = inputPorcentaje.value;
            missionDataCache[id].descripcion = tr.querySelector('textarea').value;
        });

        // Cachear datos de las cards
        document.querySelectorAll('#selectedMissionCards .mission-card').forEach(card => {
            const id = card.id.replace('mission-card-', '');

            if (!missionDataCache[id]) {
                missionDataCache[id] = {};
            }

            const inputs = card.querySelectorAll('input');
            if (inputs[0]) missionDataCache[id].velocidad = inputs[0].value;
            if (inputs[1]) missionDataCache[id].num_motores = inputs[1].value;
            if (inputs[2]) missionDataCache[id].potencia = inputs[2].value;
        });
    }

    // Añadir eventos a los botones
    if (moveRight) {
        moveRight.addEventListener('click', () => {
            // Cachear datos antes de modificar
            cacheAllFormData();

            document.querySelectorAll('#availableMissions .mission-checkbox:checked').forEach(checkbox => {
                const li = checkbox.closest('li');
                selectedMissions.appendChild(li); // Mover la misión seleccionada a la lista
                checkbox.checked = false; // Desmarcar el checkbox
            });
            updateMissionsTable(); // Actualizar la tabla de misiones
            updateMissionCards(); // Actualizar las cards de las misiones
        });
    }

    // Mover misiones de vuelta a la lista de disponibles
    if (moveLeft) {
        moveLeft.addEventListener('click', () => {
            // Cachear datos antes de modificar
            cacheAllFormData();

            document.querySelectorAll('#selectedMissions .mission-checkbox:checked').forEach(checkbox => {
                const li = checkbox.closest('li');
                const id = li.dataset.id;

                // Añadir animación de desvanecimiento antes de eliminar la card
                const card = document.getElementById(`mission-card-${id}`);
                if (card) {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.remove();
                    }, 300);
                }

                availableMissions.appendChild(li); // Mover la misión a la lista de disponibles
                checkbox.checked = false; // Desmarcar el checkbox
            });
            updateMissionsTable(); // Actualizar la tabla de misiones
        });
    }

    // Modificar la función showTab para cachear los datos del formulario
    function showTab(tabId) {
        cacheAllFormData();

        // Ocultar todas las pestañas
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
        document.getElementById(tabId).classList.remove('hidden');

        // Resetear estilos de botones de tabs
        document.querySelectorAll('button[id^="tab-"]').forEach(button => {
            button.classList.remove('bg-azulCotecmar', 'text-white');
            button.classList.add('bg-grisClaro', 'text-gray-700', 'hover:bg-grisHover');
        });

        const activeBtn = document.getElementById(`tab-${tabId}`);
        if (activeBtn) {
            activeBtn.classList.remove('bg-grisClaro', 'text-gray-700', 'hover:bg-grisHover');
            activeBtn.classList.add('bg-azulCotecmar', 'text-white');
        }
    }

    if (formularioCombinado) {
        formularioCombinado.addEventListener('submit', function(e) {
            const total = parseFloat(document.getElementById('totalPercentage').textContent);
            if (total !== 100) {
                e.preventDefault();
                document.getElementById('percentageError').classList.remove('hidden');
                return false;
            }
            return true;
        });
    }

    function imagenBuque() {
        return {
            preview: null,
            removeImagen: false,

            previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    this.removeImagen = false;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },

            removeImage() {
                this.preview = '{{ asset('images/default_image.png') }}';
                this.removeImagen = true;
                document.getElementById('imagen').value = '';
            }
        };
    }

    function selectorSistemas() {
        return {
            grupoSeleccionado: null,
            bloquearExpansión: false,

            init() {
                this.$nextTick(() => this.resize());
                window.addEventListener('resize', () => this.resize());
            },

            seleccionarGrupo(id) {
                // Al primer clic válido, bloqueamos expansión futura
                if (!this.bloquearExpansión) {
                    this.bloquearExpansión = true;
                }

                // Alternar selección solo si expansión aún no está bloqueada
                if (this.grupoSeleccionado === id && !this.bloquearExpansión) {
                    this.grupoSeleccionado = null;
                } else {
                    this.grupoSeleccionado = id;
                }

                this.$nextTick(() => this.resize());
            },

            resize() {
                const grupos = this.$refs.grupos;
                const sistemas = this.$refs.sistemas;

                if (grupos && sistemas) {
                    sistemas.style.maxHeight = grupos.offsetHeight + 'px';
                }
            },

            actualizarEquipos() {
                // lógica extra si quieres usarla
            }
        }
    }

    function equiposBuque(buqueId) {
        return {
            mostrarEquipos: false,
            mostrarFiltrosAvanzados: false,
            mostrarOpcionesColumnas: false,
            modoEdicion: false,
            equipoEnEdicion: null,

            grupoSeleccionadoModal: null,
            sistemaSeleccionadoModal: null,
            subsistemasSeleccionados: [],

            nombreGrupo(grupo) {
                const nombres = {
                    '100': 'Estructura del Casco',
                    '200': 'Planta Propulsora',
                    '300': 'Planta Eléctrica',
                    '400': 'Mando y Exploración',
                    '500': 'Sistemas Auxiliares',
                    '600': 'Habitabilidad y Equipamiento General',
                    '700': 'Armas',
                    '800': 'Integración/Ingeniería'
                };
                return `${grupo} - ${nombres[grupo] || 'SIN NOMBRE'}`;
            },


            equipos: [],
            equiposFiltrados: [],
            grupos: [],
            subgrupos: [],
            sistemas: [],
            subsistemas: [],
            sistemaSeleccionadoModal: null,
            subsistemasSeleccionados: [], // formateado como `${id_sistema}|${id_subsistema}`
            sistemaSeleccionadoILS: null,

            filtros: {
                grupo: '',
                subgrupo: '',
                sistema: '',
                subsistema: '',
                nombre: ''
            },

            columnasDisponibles: [
                { campo: 'descripcion', label: 'Descripción', visible: false },
                { campo: 'dimensiones', label: 'Dimensiones', visible: false },
                { campo: 'peso_seco', label: 'Peso seco', visible: false },
                { campo: 'imagen', label: 'Imagen', visible: false }
            ],

            toggleColumna(campo) {
                const col = this.columnasDisponibles.find(c => c.campo === campo);
                if (col) col.visible = !col.visible;
            },

            init() {
                this.cargarEquiposConNiveles();
            },

            cargarEquiposConNiveles() {
                return fetch(`{{ Config::get('api.flask_url') }}/api/equipos-con-niveles/${buqueId}`)
                    .then(res => res.json())
                    .then(data => {
                        const equiposAgrupados = {};

                        data.forEach((e, i) => {
                            const clave = `${e.nombre_equipo}|${e.modelo}`;
                            // Dentro del loop de `data.forEach` en `cargarEquiposConNiveles`
                            if (!equiposAgrupados[clave]) {
                                equiposAgrupados[clave] = {
                                    id_equipo: e.equipo_id || `temp-${Date.now()}-${i}`,
                                    nombre_equipo: e.nombre_equipo,
                                    marca: e.marca,
                                    modelo: e.modelo,
                                    descripcion: e.descripcion,
                                    dimensiones: e.dimensiones,
                                    peso_seco: e.peso_seco,
                                    imagen: e.imagen,
                                    copiasRelacionadas: [],
                                    totalCantidad: 0,
                                    expandido: false,
                                    nuevo: false,

                                    // ✅ Añadir jerarquía base
                                    id_grupo: e.id_grupo,
                                    id_subgrupo: e.id_subgrupo,
                                    id_sistema: e.id_sistema,
                                    id_subsistema: e.id_subsistema,
                                };
                            }


                            const cantidad = Number(e.cantidad || 0);
                            if (cantidad <= 0) return;

                            const claveCopia = `${e.id_sistema}|${e.id_subsistema}`;
                            let copiaExistente = equiposAgrupados[clave].copiasRelacionadas.find(c =>
                                `${c.id_sistema}|${c.id_subsistema}` === claveCopia
                            );

                            if (copiaExistente) {
                                copiaExistente.cantidad += 1;
                                copiaExistente.originalCantidad += 1;
                                copiaExistente.ids_equipos.push(e.equipo_id);
                            } else {
                                equiposAgrupados[clave].copiasRelacionadas.push({
                                    id_sistema: e.id_sistema,
                                    sistema_codigo: `${e.ref_sistema} - ${e.nombre_sistema}`,
                                    ref_sistema: e.ref_sistema,
                                    id_subsistema: e.id_subsistema,
                                    subsistema_codigo: `${e.ref_subsistema} - ${e.nombre_subsistema}`,
                                    cantidad: 1,
                                    originalCantidad: 1,
                                    ids_equipos: [e.equipo_id],
                                    original_marca: e.marca,
                                    original_modelo: e.modelo,
                                    original_descripcion: e.descripcion,
                                    original_dimensiones: e.dimensiones,
                                    original_peso_seco: e.peso_seco,
                                    original_imagen: e.imagen,
                                    nombre_equipo_grupo: clave
                                });
                            }

                            // Actualiza cantidad total por equipo
                            equiposAgrupados[clave].totalCantidad = equiposAgrupados[clave].copiasRelacionadas.reduce(
                                (sum, c) => sum + Number(c.cantidad || 0), 0
                            );

                            equiposAgrupados[clave].expandido = false;
                        });

                        this.equipos = Object.values(equiposAgrupados);
                        this.grupos = this.obtenerUnicos(data, 'id_grupo', 'nombre_grupo', 'ref_grupo');
                        this.subgrupos = this.obtenerUnicos(data, 'id_subgrupo', 'nombre_subgrupo', 'ref_subgrupo');
                        this.sistemas = this.obtenerUnicos(data, 'id_sistema', 'nombre_sistema', 'ref_sistema');
                        this.subsistemas = this.obtenerUnicos(data, 'id_subsistema', 'nombre_subsistema', 'ref_subsistema');

                        const codigosSeleccionados = (window.sistemasSeleccionadosLaravel || []).map(s => s.codigo);
                        this.cargarSubsistemasPorSistemas(codigosSeleccionados);

                        this.filtrarEquipos();
                    })
                    .catch(error => {
                        console.error('❌ Error cargando equipos:', error);
                    });
            },

            obtenerUnicos(data, idKey, labelKey, codigoKey) {
                const mapa = {};
                data.forEach(e => {
                    if (!mapa[e[idKey]]) {
                        mapa[e[idKey]] = {
                            id: e[idKey],
                            descripcion: `${e[codigoKey]} - ${e[labelKey]}`
                        };
                    }
                });
                return Object.values(mapa);
            },

            filtrarEquipos() {
                const { grupo, subgrupo, sistema, subsistema, nombre } = this.filtros;
                const nuevosFiltrados = this.equipos.filter(e => {
                    return (!grupo || e.id_grupo == grupo) &&
                        (!subgrupo || e.id_subgrupo == subgrupo) &&
                        (!sistema || e.id_sistema == sistema) &&
                        (!subsistema || e.id_subsistema == subsistema) &&
                        (!nombre || e.nombre_equipo.toLowerCase().includes(nombre.toLowerCase()));
                });

                // ✅ Ordenar: primero los nuevos, luego el resto
                nuevosFiltrados.sort((a, b) => {
                    if (a.nuevo && !b.nuevo) return -1;
                    if (!a.nuevo && b.nuevo) return 1;
                    return 0;
                });

                this.equiposFiltrados = [...nuevosFiltrados];
            },

            iniciarEdicion(index) {
                this.modoEdicion = true;
                this.equipoEnEdicion = index;

                // Cierra todos primero
                this.equiposFiltrados.forEach(e => e.expandido = false);

                // Abre solo el que estás editando
                this.equiposFiltrados[index].expandido = true;
            },

            cancelarEdicion() {
                const equipoCancelado = this.equiposFiltrados[this.equipoEnEdicion];

                if (equipoCancelado && equipoCancelado.nuevo) {
                    // Eliminar el equipo nuevo que fue cancelado
                    this.equipos = this.equipos.filter(e => e.id_equipo !== equipoCancelado.id_equipo);
                }

                this.modoEdicion = false;
                this.equipoEnEdicion = null;

                // Cierra todas las pestañas de copias
                this.equiposFiltrados.forEach(e => e.expandido = false);

                // Refrescar la lista filtrada
                this.filtrarEquipos();
            },

            guardarCambios() {
                const equipo = this.equiposFiltrados[this.equipoEnEdicion];
                if (!equipo) return;

                const actualizaciones = [];
                const inserciones = [];

                // 1️⃣ Detectamos el grupo original al que pertenecía el equipo
                const nombreGrupoOriginal = equipo.copiasRelacionadas[0]?.nombre_equipo_grupo;

                // 2️⃣ Buscamos todas las copias existentes que pertenecían a ese grupo
                const todasLasCopiasOriginales = this.equipos.flatMap(e => e.copiasRelacionadas || []).filter(c =>
                    c.nombre_equipo_grupo === nombreGrupoOriginal && c.id_equipo
                );

                // 3️⃣ Si se editó la información base, actualizamos todas las copias
                if (this.equipoFueEditado(equipo)) {
                    todasLasCopiasOriginales.forEach(copia => {
                        actualizaciones.push({
                            id_equipo_info: copia.id_equipo,
                            nombre_equipo: equipo.nombre_equipo,
                            marca: equipo.marca,
                            modelo: equipo.modelo,
                            descripcion: equipo.descripcion,
                            dimensiones: equipo.dimensiones,
                            peso_seco: equipo.peso_seco,
                            imagen: equipo.imagen,
                            id_buque: this.idBuque || buqueId,
                            id_sistema: copia.id_sistema,
                            id_subsistema: copia.id_subsistema,
                            id_sistema_ils: null,
                            cj: null
                        });
                    });
                }

                // 4️⃣ Insertamos nuevas copias si aumentó la cantidad
                equipo.copiasRelacionadas.forEach(copia => {
                    const original = copia.originalCantidad ?? 0;
                    const cantidadActual = Number(copia.cantidad || 0);

                    const sistemaRelacionado = window.sistemasSeleccionadosLaravel.find(
                        s => s.codigo == copia.ref_sistema
                    );

                    for (let i = 0; i < cantidadActual; i++) {
                        const equipoObj = {
                            nombre_equipo: equipo.nombre_equipo,
                            marca: equipo.marca,
                            modelo: equipo.modelo,
                            descripcion: equipo.descripcion,
                            dimensiones: equipo.dimensiones,
                            peso_seco: equipo.peso_seco,
                            imagen: equipo.imagen,
                            id_buque: this.idBuque || buqueId,
                            id_sistema: copia.id_sistema,
                            id_subsistema: copia.id_subsistema,
                            id_sistema_ils: sistemaRelacionado ? sistemaRelacionado.id_sistema_ils : null,
                            cj: null
                        };

                        // 🛠️ Usa ids_equipos si existe como lista, o id_equipo único
                        const id_equipo_info = Array.isArray(copia.ids_equipos)
                            ? copia.ids_equipos[i]
                            : (i === 0 ? copia.id_equipo : null);

                        if (i < original && id_equipo_info) {
                            equipoObj.id_equipo_info = id_equipo_info;
                            actualizaciones.push(equipoObj);
                        } else {
                            inserciones.push(equipoObj);
                        }
                    }
                });

                console.log("📤 Equipos a ACTUALIZAR:", actualizaciones.length, actualizaciones);
                console.log("📥 Equipos a CREAR:", inserciones.length, inserciones);

                const total = [...actualizaciones, ...inserciones];

                if (total.length > 0) {
                    enviarEquiposAlServidor(total).then(() => {
                        equipo.copiasRelacionadas.forEach(c => {
                            c.originalCantidad = c.cantidad;
                            c.original_marca = equipo.marca;
                            c.original_modelo = equipo.modelo;
                            c.original_descripcion = equipo.descripcion;
                            c.original_dimensiones = equipo.dimensiones;
                            c.original_peso_seco = equipo.peso_seco;
                            c.original_imagen = equipo.imagen;
                        });

                        this.cancelarEdicion();

                        Swal.fire({
                            icon: 'success',
                            title: 'Cambios guardados correctamente',
                            timer: 1600,
                            showConfirmButton: false
                        });
                    });
                } else {
                    this.cancelarEdicion();
                    Swal.fire({
                        icon: 'info',
                        title: 'No hay cambios por guardar',
                        timer: 1400,
                        showConfirmButton: false
                    });
                }
            },

            modalImagen: {
                mostrar: false,
                url: '',
            },
            
            modalDescripcion: {
                mostrar: false,
                contenido: '',
                editable: false,
            },

            abrirModalImagen(imagenBase64, index) {
                this.modalImagen.url = 'data:image/jpeg;base64,' + imagenBase64;
                this.modalImagen.index = index;
                this.modalImagen.mostrar = true;
            },


            abrirModalDescripcion(contenido, editable, index) {
                this.modalDescripcion.contenido = contenido;
                this.modalDescripcion.index = index;
                this.modalDescripcion.mostrar = true;
            },

            cerrarModales() {
                this.modalImagen.mostrar = false;
                this.modalDescripcion.mostrar = false;
            },

            // Estado para modal de relación de sistemas
            mostrarModalRelacionar: false,
            equipoRelacionando: null,
            sistemasDisponibles: [], // ← sistemas seleccionados del buque
            sistemasSeleccionados: [], // Cada elemento: { id: sistema.id, subsistemas: [1, 2] }
            subsistemasFiltrados: [],
            subsistemasDisponibles: [],

            cargarSubsistemasPorSistemas(codigos) {
                if (!Array.isArray(codigos) || codigos.length === 0) {
                    this.subsistemasDisponibles = [];
                    return;
                }

                // Lista temporal para almacenar todos los subsistemas
                const resultados = [];

                // Promesas para cada código
                const promesas = codigos.map(codigo =>
                    fetch('{{ Config::get('api.flask_url') }}/api/subsistemas-por-codigo', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ codigo })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (Array.isArray(data)) {
                            resultados.push(...data);
                        }
                    })
                    .catch(error => {
                        console.error(`❌ Error al obtener subsistemas para el código ${codigo}:`, error);
                    })
                );

                // Esperar todas las promesas y luego asignar
                Promise.all(promesas).then(() => {
                    this.subsistemasDisponibles = resultados;
                    //console.log('✅ Subsistemas combinados:', resultados);
                });
            },

            filtrarSubsistemas() {
                this.subsistemasFiltrados = this.subsistemasDisponibles.filter(sub =>
                    this.sistemasSeleccionados.includes(sub.sistema_id)
                );
            },

            abrirModalRelacionar(equipoIndex) {
                this.equipoRelacionando = equipoIndex;
                this.mostrarModalRelacionar = true;

                const equipo = this.equiposFiltrados[equipoIndex];

                // Obtener subsistemas relacionados ya existentes
                this.subsistemasSeleccionados = equipo.copiasRelacionadas?.map(c => `${c.id_sistema}|${c.id_subsistema}`) || [];

                // Seleccionamos el primer sistema disponible para mostrar subsistemas
                this.sistemaSeleccionadoModal = this.sistemas.length > 0 ? this.sistemas[0].id : null;
            },

            cerrarModalRelacionar() {
                this.mostrarModalRelacionar = false;
                this.equipoRelacionando = null;
                this.sistemasSeleccionados = [];
            },

            agregarCopiasRelacionadas() {
                if (this.equipoRelacionando === null) return;

                const equipoFiltrado = this.equiposFiltrados[this.equipoRelacionando];
                const equipoOriginal = this.equipos.find(e => e.nombre_equipo === equipoFiltrado.nombre_equipo && e.modelo === equipoFiltrado.modelo);

                if (!equipoOriginal) return;

                // Transformamos seleccionados en objetos { id_sistema, id_subsistema }
                const nuevasSelecciones = this.subsistemasSeleccionados.map(val => {
                    const [id_sistema, id_subsistema] = val.split('|').map(Number);
                    return { id_sistema, id_subsistema };
                });

                // Mantener solo copias que todavía están seleccionadas
                equipoOriginal.copiasRelacionadas = (equipoOriginal.copiasRelacionadas || []).filter(copia =>
                    nuevasSelecciones.some(sel => sel.id_sistema === copia.id_sistema && sel.id_subsistema === copia.id_subsistema)
                );

                // Agregar las nuevas que aún no existen
                nuevasSelecciones.forEach(({ id_sistema, id_subsistema }) => {
                    const yaExiste = equipoOriginal.copiasRelacionadas.some(copia =>
                        copia.id_sistema === id_sistema && copia.id_subsistema === id_subsistema
                    );

                    if (!yaExiste) {
                        const sistema = this.sistemas.find(s => s.id === id_sistema);
                        const subsistema = this.subsistemasDisponibles.find(ss => ss.id_subsistema === id_subsistema);

                        equipoOriginal.copiasRelacionadas.push({
                            id_sistema,
                            sistema_codigo: sistema 
                                ? `${sistema.descripcion.split(' - ')[0]} - ${sistema.descripcion.split(' - ').slice(1).join(' - ')}`
                                : `${subsistema?.ref_sistema ?? '???'} - ${subsistema?.nombre_sistema ?? 'Sin nombre de sistema'}`,
                            ref_sistema: subsistema?.ref_sistema || null,
                            id_subsistema,
                            subsistema_codigo: `${subsistema.numero_de_referencia} - ${subsistema.nombre_subsistema}`,
                            cantidad: 0
                        });

                    }
                });

                equipoOriginal.expandido = true;
                this.actualizarCantidadPadre(equipoOriginal);
                this.cerrarModalRelacionar();
                this.filtrarEquipos();

                console.log("✅ Copias sincronizadas correctamente:", equipoOriginal.copiasRelacionadas);
            },

            actualizarCantidadPadre(equipo) {
                equipo.totalCantidad = equipo.copiasRelacionadas.reduce((sum, copia) => sum + Number(copia.cantidad || 0), 0);
            },

            crearEquipoVacio() {
                const nuevoEquipo = {
                    id_equipo: `nuevo-${Date.now()}`,
                    nombre_equipo: '',
                    marca: '',
                    modelo: '',
                    descripcion: '',
                    dimensiones: '',
                    peso_seco: '',
                    imagen: '',
                    copiasRelacionadas: [],
                    totalCantidad: 0,
                    nuevo: true
                };

                this.equipos.unshift(nuevoEquipo);
                this.filtrarEquipos();

                // Encontrar el índice del nuevo en el array filtrado
                const index = this.equiposFiltrados.findIndex(e => e.id_equipo === nuevoEquipo.id_equipo);

                this.equipoEnEdicion = index;
                this.modoEdicion = true;
            },
            
            obtenerWidthColumna(campo) {
                const visibles = this.columnasDisponibles.filter(c => c.visible).map(c => c.campo);
                const totalColumnas = 6 + visibles.length;

                const configWidths = {
                    6: {
                        nombre: "24%", marca: "22%", modelo: "20%",
                        cantidad: "10%", relacion: "12%", acciones: "8%",
                        dinamicas: {}
                    },
                    7: {
                        nombre: "22%", marca: "20%", modelo: "18%",
                        cantidad: "8%", relacion: "12%", acciones: "6%",
                        dinamicas: { 1: "10%" }
                    },
                    8: {
                        nombre: "18%", marca: "16%", modelo: "14%",
                        cantidad: "6%", relacion: "12%", acciones: "6%",
                        dinamicas: { 1: "12%", 2: "12%" }
                    },
                    9: {
                        nombre: "16%", marca: "14%", modelo: "12%",
                        cantidad: "5%", relacion: "7%", acciones: "6%",
                        dinamicas: { 1: "12%", 2: "12%", 3: "12%" }
                    },
                    10: {
                        nombre: "14%", marca: "12%", modelo: "10%",
                        cantidad: "5%", relacion: "7%", acciones: "6%",
                        dinamicas: { 1: "10.5%", 2: "10.5%", 3: "10.5%", 4: "10.5%" }
                    }
                };

                const conf = configWidths[totalColumnas];
                const index = visibles.indexOf(campo);

                if (["nombre", "marca", "modelo", "cantidad", "relacion", "acciones"].includes(campo)) {
                    return conf[campo];
                }

                return conf.dinamicas[index + 1] || "0%";
            },

            prepararEquiposParaGuardar(equipo) {
                const equiposPreparados = [];

                if (!equipo || !equipo.copiasRelacionadas || equipo.copiasRelacionadas.length === 0) {
                    return equiposPreparados;
                }

                equipo.copiasRelacionadas.forEach(copia => {
                    const cantidad = Number(copia.cantidad || 0);
                    if (cantidad <= 0) return;

                    const sistemaRelacionado = window.sistemasSeleccionadosLaravel.find(
                        s => s.codigo == copia.ref_sistema
                    );

                    for (let i = 0; i < cantidad; i++) {
                        const equipoObj = {
                            nombre_equipo: equipo.nombre_equipo,
                            marca: equipo.marca,
                            modelo: equipo.modelo,
                            descripcion: equipo.descripcion,
                            dimensiones: equipo.dimensiones,
                            peso_seco: equipo.peso_seco,
                            imagen: equipo.imagen,
                            id_buque: this.idBuque || buqueId,
                            id_sistema: copia.id_sistema,
                            id_subsistema: copia.id_subsistema,
                            id_sistema_ils: sistemaRelacionado ? sistemaRelacionado.id_sistema_ils : null,
                            cj: null
                        };

                        // ⚠️ Si no es nuevo, agregar el ID para que se actualice
                        if (!equipo.nuevo && equipo.id_equipo) {
                            equipoObj.id_equipo_info = equipo.id_equipo;
                        }

                        console.log("🧪 Equipo evaluado:", equipo.nombre_equipo, "¿nuevo?", equipo.nuevo, "id:", equipo.id_equipo);

                        equiposPreparados.push(equipoObj);
                    }

                });

                console.log("📦 Equipos listos para guardar:", equiposPreparados);
                return equiposPreparados;
            },

            tieneEquipos(sub) {
                if (this.equipoRelacionando === null) return false;

                const equipo = this.equiposFiltrados[this.equipoRelacionando];
                if (!equipo) return false;

                const copia = equipo.copiasRelacionadas?.find(c =>
                    c.id_sistema === sub.sistema_id && c.id_subsistema === sub.id_subsistema
                );

                // SOLO bloquear si ya hay un original guardado (originalCantidad > 0)
                return copia && (copia.originalCantidad ?? 0) > 0;
            },

            confirmarGuardado() {
                const equipo = this.equiposFiltrados[this.equipoEnEdicion];
                if (!equipo) return;

                // Validaciones de campos obligatorios
                let errores = [];
                if (!equipo.nombre_equipo.trim()) errores.push("nombre del equipo");
                if (!equipo.marca.trim()) errores.push("marca del equipo");
                if (!equipo.modelo.trim()) errores.push("modelo del equipo");

                const totalCantidad = equipo.copiasRelacionadas?.reduce((sum, c) => sum + Number(c.cantidad || 0), 0) || 0;

                // Mostrar alerta si hay errores
                if (errores.length > 0 || totalCantidad === 0) {
                    let htmlMensaje = '';
                    if (errores.length > 0) {
                        htmlMensaje += `Debe completar: <b>${errores.join(', ')}</b>.`;
                    }
                    if (totalCantidad === 0) {
                        htmlMensaje += `<br><br><b>La cantidad de equipos por subsistema debe ser mayor a 0.</b>`;
                    }

                    Swal.fire({
                        icon: 'warning',
                        title: 'Faltan datos obligatorios',
                        html: htmlMensaje,
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#003366'
                    });
                    return;
                }

                const equipoEditando = equipo;
                const esNuevo = equipoEditando && equipoEditando.nuevo;
                const textoSwal = esNuevo
                    ? "Se creará un nuevo equipo con sus respectivas copias."
                    : "Se actualizarán los datos y se añadirán nuevas copias si corresponde.";

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: textoSwal,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, guardar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    if (esNuevo) {
                        const equipos = this.prepararEquiposParaGuardar(equipo);
                        console.log("🆕 Enviando nuevo equipo desde confirmarGuardado:", equipos);

                        enviarEquiposAlServidor(equipos).then(() => {
                            this.cargarEquiposConNiveles().then(() => {
                                const clave = `${equipo.nombre_equipo}|${equipo.modelo}`;
                                const nuevo = this.equipos.find(e => `${e.nombre_equipo}|${e.modelo}` === clave);

                                if (nuevo) {
                                    nuevo.copiasRelacionadas.forEach(c => {
                                        c.originalCantidad = c.cantidad;
                                        c.original_marca = nuevo.marca;
                                        c.original_descripcion = nuevo.descripcion;
                                        c.original_dimensiones = nuevo.dimensiones;
                                        c.original_peso_seco = nuevo.peso_seco;
                                        c.original_imagen = nuevo.imagen;
                                    });

                                    this.actualizarCantidadPadre(nuevo);
                                    this.equipos = [nuevo, ...this.equipos.filter(e => e !== nuevo)];
                                    this.filtrarEquipos();

                                    this.modoEdicion = false;
                                    this.equipoEnEdicion = null;
                                    this.equiposFiltrados.forEach((e, i) => e.expandido = false);
                                }

                                Swal.fire({
                                    title: 'Equipo guardado correctamente',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            });
                        });

                    } else {
                        this.guardarCambios();
                    }
                });
            },


            cargarImagen(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.modalImagen.url = e.target.result;

                    // Actualizar también en el equipo en edición
                    const equipo = this.equiposFiltrados[this.equipoEnEdicion];
                    if (equipo) {
                        equipo.imagen = e.target.result.split(',')[1]; // solo el base64
                    }
                };
                reader.readAsDataURL(file);
            },

            actualizarDescripcionEquipo() {
                if (!(this.modoEdicion && this.modalDescripcion.index === this.equipoEnEdicion)) return;

                const equipo = this.equiposFiltrados[this.equipoEnEdicion];
                if (equipo) {
                    equipo.descripcion = this.modalDescripcion.contenido;
                }
            },

            validarCantidadCopia(event, copia, equipo) {
                const valorRaw = event.target.value;
                const nuevoValor = Number(valorRaw);

                // Si el valor es vacío, NaN o menor a 0, no hacer nada aún
                if (!valorRaw || isNaN(nuevoValor) || nuevoValor < 0) return;

                // Solo restringir si hay una cantidad original guardada
                if (typeof copia.originalCantidad !== 'undefined' && nuevoValor < copia.originalCantidad) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cantidad inferior a la existente',
                        text: 'Para eliminar equipos, diríjase a ajustes avanzados de equipos.',
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#003366'
                    });

                    // Restaurar visualmente el valor anterior
                    event.target.value = copia.cantidad;
                    return;
                }

                // Si no está bloqueado, actualizar la cantidad
                copia.cantidad = nuevoValor;
                this.actualizarCantidadPadre(equipo);
            },

            actualizarEquipoBaseYCopias(equipo) {
                const sistemaRelacionado = window.sistemasSeleccionadosLaravel.find(s => s.codigo == equipo.ref_sistema);

                fetch('{{ Config::get('api.flask_url') }}/api/actualizar-equipos-basicos', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        nombre_equipo: equipo.nombre_equipo,
                        modelo: equipo.modelo,
                        id_buque: this.idBuque || buqueId,
                        marca: equipo.marca,
                        descripcion: equipo.descripcion,
                        dimensiones: equipo.dimensiones,
                        peso_seco: equipo.peso_seco,
                        imagen: equipo.imagen
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log("✅ Datos básicos actualizados:", data);
                })
                .catch(error => {
                    console.error("❌ Error actualizando datos básicos:", error);
                });
            },

            equipoFueEditado(equipo) {
                if (!equipo || !equipo.copiasRelacionadas || equipo.copiasRelacionadas.length === 0) return false;

                const copia = equipo.copiasRelacionadas[0]; // Tomamos la primera copia como referencia

                return (
                    equipo.marca !== copia.original_marca ||
                    equipo.modelo !== copia.original_modelo ||
                    equipo.descripcion !== copia.original_descripcion ||
                    equipo.dimensiones !== copia.original_dimensiones ||
                    equipo.peso_seco !== copia.original_peso_seco ||
                    equipo.imagen !== copia.original_imagen
                );
            },


           eliminarEquipo(equipo) {
                const nombre = equipo.nombre_equipo;

                const codigosSubsistemas = equipo.copiasRelacionadas.map(c => c.subsistema_codigo.split(" - ")[0].trim());
                const listaCopias = equipo.copiasRelacionadas.map(c => `• ${c.subsistema_codigo}`).join('\n');
                const codigosTexto = codigosSubsistemas.join(', ');

                Swal.fire({
                    title: `¿Eliminar "${nombre}"?`,
                    icon: 'warning',
                    html: `
                        <p style="font-size: 16px; padding-bottom: 10px;">Al eliminar este equipo se eliminarán también las siguientes copias y todos sus análisis relacionados:</p>
                        <pre style="margin-bottom: 25px; text-align: left; background-color: #f5f5f5; padding: 8px; border-radius: 4px; font-size: 16px;">${listaCopias}</pre>
                        <p style="margin-top: 10px; font-size: 16px;">Escriba los códigos para confirmar: <b>${codigosTexto}</b></p>
                        <input id="codigoConfirmacion" class="swal2-input" placeholder="Ej: ${codigosTexto}">
                    `,
                    preConfirm: () => {
                        const valorIngresado = Swal.getPopup().querySelector('#codigoConfirmacion').value.trim();
                        const codigosIngresados = valorIngresado.split(',').map(c => c.trim());
                        const todosCoinciden = codigosSubsistemas.every(c => codigosIngresados.includes(c));
                        if (!todosCoinciden) {
                            Swal.showValidationMessage('Debe ingresar todos los códigos correctamente separados por coma.');
                        }
                        return todosCoinciden;
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#730C02',
                    cancelButtonColor: '#003366',
                    iconColor: '#730C02',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    fetch('{{ Config::get('api.flask_url') }}/api/eliminar-equipos', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            nombre_equipo: equipo.nombre_equipo,
                            modelo: equipo.modelo,
                            id_buque: this.idBuque || buqueId
                        })
                    })
                    .then(res => res.json())
                    .then(resp => {
                        console.log("✅ Eliminado:", resp);
                        Swal.fire({
                            title: "Equipo eliminado correctamente",
                            icon: "success",
                            timer: 1600,
                            showConfirmButton: false
                        });
                        this.cargarEquiposConNiveles(); // Recargar lista
                    })
                    .catch(err => {
                        console.error("❌ Error al eliminar:", err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo eliminar el equipo. Intenta de nuevo.',
                        });
                    });
                });
            }
        }
    }

    function enviarEquiposAlServidor(equipos) {
        const lotes = dividirEnLotes(equipos, 5);

        const promesas = lotes.map(lote =>
            fetch("{{ Config::get('api.flask_url') }}/api/guardar-equipos", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(lote)
            })
            .then(res => res.json())
            .then(resp => {
                console.log("✅ Respuesta del servidor:", resp);
            })
            .catch(err => {
                console.error("❌ Error enviando lote de equipos:", err);
            })
        );

        return Promise.all(promesas); // 🔁 esto es crucial
    }

    function dividirEnLotes(array, tamano) {
        const lotes = [];
        for (let i = 0; i < array.length; i += tamano) {
            lotes.push(array.slice(i, i + tamano));
        }
        return lotes;
    }

    // 🔧 FUNCIONES UTILITARIAS

    // 🧮 Calcula el porcentaje basado en 8760 y actualiza el elemento de salida
    function calcularPorcentaje(inputElement, outputId) {
        const total = 8760;
        const valor = parseFloat(inputElement.value || 0);
        const porcentaje = !isNaN(valor) && valor >= 0 ? ((valor / total) * 100).toFixed(2) : 0;
        document.getElementById(outputId).innerText = `${porcentaje}%`;
    }

    // 🧠 Calcula el porcentaje a partir del contenido de un elemento
    function calcularPorcentajeDeElemento(valorId, outputId) {
        const total = 8760;
        const valor = parseFloat(document.getElementById(valorId)?.innerText || 0);
        const porcentaje = !isNaN(valor) && valor >= 0 ? ((valor / total) * 100).toFixed(2) : 0;
        document.getElementById(outputId).innerText = `${porcentaje}%`;
    }

    // 🔄 Actualiza el porcentaje para las 3 columnas de "Disponible para Misiones"
    function actualizarPorcentajesMisiones() {
        calcularPorcentajeDeElemento('disponible_misiones_1_calc', 'porcentaje_disp_1');
        calcularPorcentajeDeElemento('disponible_misiones_3_calc', 'porcentaje_disp_3');
        calcularPorcentajeDeElemento('disponible_misiones_5_calc', 'porcentaje_disp_5');
    }

    // 👁️ Observa cambios en los valores de horas disponibles para actualizar porcentajes automáticamente
    function observarCambiosDeHorasDisponible() {
        const ids = ['disponible_misiones_1_calc', 'disponible_misiones_3_calc', 'disponible_misiones_5_calc'];
        ids.forEach(id => {
            const target = document.getElementById(id);
            if (target) {
                const observer = new MutationObserver(() => {
                    actualizarPorcentajesMisiones();
                });
                observer.observe(target, { childList: true, subtree: true });
            }
        });
    }
    // ✅ Marca campos vacíos como pendientes y lanza alerta
    function validarCamposPendientes() {
        const camposPendientes = [
            'mision_organizacion',
            'operaciones_tipo',
            'estandares_calidad',
            'estandares_ambientales',
            'estandares_seguridad',
            'lugar_operaciones',
            'intensidad_operaciones',
            'redundancia',
            'tareas_operacion',
            'repuestos',
            'demanda_repuestos'
        ];

        let tieneCamposVacios = false;

        camposPendientes.forEach(id => {
            const campo = document.querySelector(`[name="${id}"]`);
            if (campo) {
                const marcarPendiente = () => {
                    campo.classList.add('textarea-pendiente');
                    campo.placeholder = 'Pendiente ...';
                };

                const quitarPendiente = () => {
                    campo.classList.remove('textarea-pendiente');
                };

                if (campo.value.trim() === '') {
                    marcarPendiente();
                    tieneCamposVacios = true;
                }

                campo.addEventListener('input', function () {
                    if (campo.value.trim() === '') {
                        marcarPendiente();
                    } else {
                        quitarPendiente();
                    }
                });
            }
        });

        if (tieneCamposVacios) {
            Swal.fire({
                icon: 'warning',
                title: 'Información incompleta',
                text: 'Hay campos pendientes por diligenciar en el Contexto Operacional del buque.',
                confirmButtonText: 'Revisar',
                confirmButtonColor: '#003366',
            });
        }
    }

    // 📤 Envía el formulario de sistemas por fetch con spinner y feedback
    function configurarFormularioSistemas() {
        const form = document.getElementById('form-sistemas');
        const spinner = document.getElementById('spinner-container');
        if (!form) return;

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            const url = form.getAttribute('data-action');
            const formData = new FormData(form);

            try {
                if (spinner) spinner.classList.remove('hidden');

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const result = await response.json();
                if (spinner) spinner.classList.add('hidden');

                if (result.success && result.sistemas_actualizados) {
                    window.sistemasSeleccionadosLaravel = result.sistemas_actualizados;

                    Swal.fire({
                        icon: 'success',
                        title: 'Sistemas guardados',
                        text: result.message || 'Los sistemas han sido sincronizados correctamente.',
                        confirmButtonColor: '#003366'
                    });
                } else {
                    throw new Error(result.message || 'Error al guardar los sistemas.');
                }

            } catch (error) {
                console.error('Error al guardar sistemas:', error);
                if (spinner) spinner.classList.add('hidden');
                Swal.fire({
                    icon: 'error',
                    title: 'Error al guardar',
                    text: 'No se pudieron guardar los sistemas. Revisa la consola para más detalles.',
                    confirmButtonColor: '#d33'
                });
            }
        });
    }

    // ⛽ Calcula las horas equivalentes para una misión dada según el porcentaje ingresado
    function actualizarHoras(input, idMision) {
        const horasNavegacion = {{ (int)($buque->horas_navegacion_anio ?? 0) }};
        const porcentaje = parseFloat(input.value || 0);
        const horas = Math.round((porcentaje / 100) * horasNavegacion);
        const span = document.getElementById(`horas_mision_${idMision}`);
        if (span) {
            span.innerText = isNaN(horas) ? '0' : horas;
        }
    }

    // 🔁 Inicializa las horas de todas las misiones al cargar
    function inicializarHorasMisiones() {
        document.querySelectorAll('.percentage-input').forEach(input => {
            const idMatch = input.name.match(/\[(\d+)\]/);
            if (idMatch) {
                const idMision = idMatch[1];
                actualizarHoras(input, idMision);
            }
        });
    }

    // ⚓ Cálculo de porcentaje del tiempo en Puerto Extranjero
    function actualizarPorcentajePuertoExtranjero() {
        const input = document.getElementById('puerto_extranjero');
        const span = document.getElementById('porcentaje_puerto_extranjero');
        const total = 8760;
        const valor = parseFloat(input?.value || 0);
        const porcentaje = !isNaN(valor) && valor >= 0 ? ((valor / total) * 100).toFixed(2) : 0;
        if (span) {
            span.innerText = porcentaje;
        }
    }
    
    document.addEventListener('DOMContentLoaded', function () {
        // === Variables Año 1 ===
        const dispManto1 = document.getElementById('disponibilidad_mantenimiento_1');
        const mantBasico1 = document.getElementById('mant_basico_1');
        const roh1 = document.getElementById('roh_1');
        const horasNav = document.getElementById('horas_navegacion');
        const dispMisCalc = document.getElementById('disponible_misiones_1_calc');

        // Valor guardado en la base de datos
        let valorEnBD = parseFloat("{{ $datosPuertoBase->disponible_misiones_1 ?? 0 }}");

        function recalcularDisponibleMisiones() {
            const dispMant = parseFloat(dispManto1.value || 0);
            const roh = parseFloat(roh1.value || 0);
            const hn = parseFloat(horasNav.value || 0);

            if (mantBasico1) mantBasico1.value = dispMant;

            const disponible = 8760 - (dispMant + roh + hn);
            dispMisCalc.textContent = disponible;
        }

        if (dispManto1) dispManto1.addEventListener('input', recalcularDisponibleMisiones);
        if (roh1) roh1.addEventListener('input', recalcularDisponibleMisiones);
        if (horasNav) horasNav.addEventListener('input', recalcularDisponibleMisiones);

        // === Variables Año 3 ===
        const dispManto3 = document.getElementById('disponibilidad_mantenimiento_3');
        const mantBasico3 = document.getElementById('mant_basico_3');
        const roh3 = document.getElementById('roh_3');
        const dispMisCalc3 = document.getElementById('disponible_misiones_3_calc');

        function recalcularDisponibleMisiones3() {
            const dispMant = parseFloat(dispManto3.value || 0);
            const roh = parseFloat(roh3.value || 0);
            const hn = parseFloat(horasNav.value || 0);

            if (mantBasico3) mantBasico3.value = dispMant;

            const disponible = 8760 - (dispMant + roh + hn);
            dispMisCalc3.textContent = disponible;
        }

        if (dispManto3) dispManto3.addEventListener('input', recalcularDisponibleMisiones3);
        if (roh3) roh3.addEventListener('input', recalcularDisponibleMisiones3);

        // === Variables Año 5 ===
        const dispManto5 = document.getElementById('disponibilidad_mantenimiento_5');
        const mantBasico5 = document.getElementById('mant_basico_5');
        const roh5 = document.getElementById('roh_5');
        const dispMisCalc5 = document.getElementById('disponible_misiones_5_calc');

        function recalcularDisponibleMisiones5() {
            const dispMant = parseFloat(dispManto5.value || 0);
            const roh = parseFloat(roh5.value || 0);
            const hn = parseFloat(horasNav.value || 0);

            if (mantBasico5) mantBasico5.value = dispMant;

            const disponible = 8760 - (dispMant + roh + hn);
            dispMisCalc5.textContent = disponible;
        }

        if (dispManto5) dispManto5.addEventListener('input', recalcularDisponibleMisiones5);
        if (roh5) roh5.addEventListener('input', recalcularDisponibleMisiones5);

        // Inicialización con valores desde la BD
        function initializeDisplay() {
            if (dispManto1.value === '' && roh1.value === '' && horasNav.value === '') {
                dispMisCalc.textContent = valorEnBD;
            } else {
                recalcularDisponibleMisiones();
                recalcularDisponibleMisiones3();
                recalcularDisponibleMisiones5();
            }
        }

        initializeDisplay();

            // === Guardado del Formulario Combinado ===
        const form = document.getElementById('formularioCombinado');
        const btnGuardar = document.getElementById('guardarMisiones');
        const spinner = document.getElementById('spinner-container'); // Asegúrate que existe en el HTML

        if (btnGuardar && form) {
            btnGuardar.addEventListener('click', async function () {
                const formData = new FormData(form);

                try {
                    if (spinner) spinner.classList.remove('hidden');
                    btnGuardar.disabled = true;

                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (spinner) spinner.classList.add('hidden');
                    btnGuardar.disabled = false;

                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Guardado!',
                            text: result.message,
                            confirmButtonColor: '#3085d6'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: result.message || 'Error al guardar las misiones.',
                            confirmButtonColor: '#e3342f'
                        });
                    }

                } catch (error) {
                    console.error('Error AJAX:', error);
                    if (spinner) spinner.classList.add('hidden');
                    btnGuardar.disabled = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error inesperado',
                        text: 'No se pudo completar la operación.',
                        confirmButtonColor: '#e3342f'
                    });
                }
            });
        }
        // === Lógica para mover misiones entre listas ===
        const moveRightBtn = document.getElementById('moveRight');
        const moveLeftBtn = document.getElementById('moveLeft');
        const availableList = document.getElementById('availableMissions');
        const selectedList = document.getElementById('selectedMissions');

        if (moveRightBtn && moveLeftBtn && availableList && selectedList) {
            moveRightBtn.addEventListener('click', function (e) {
                e.preventDefault();
                availableList.querySelectorAll('input[type="checkbox"]:checked').forEach(input => {
                    const misionId = input.value;
                    const li = input.closest('li');

                    // Crear inputs con name para que se envíen al backend
                    li.innerHTML = `
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="mission-checkbox" name="misiones[${misionId}][porcentaje]" value="0" checked>
                            <span>Misión ${misionId}</span>
                        </label>
                    `;
                    selectedList.appendChild(li);
                });
                updateMissionsTable();
                updateMissionCards();
            });

            moveLeftBtn.addEventListener('click', function (e) {
                e.preventDefault();
                selectedList.querySelectorAll('input[type="checkbox"]:checked').forEach(input => {
                    const li = input.closest('li');
                    const misionId = input.name.match(/\[(\d+)\]/)[1];

                    // Eliminar la card técnica si existe
                    const card = document.getElementById(`mission-card-${misionId}`);
                    if (card) card.remove();

                    li.innerHTML = `
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="mission-checkbox" value="${misionId}">
                            <span>Misión ${misionId}</span>
                        </label>
                    `;
                    availableList.appendChild(li);
                });
                updateMissionsTable();
                updateMissionCards();
            });
        }
        

        if (modoEdicion) {
            validarCamposPendientes();
        }

        // Inicializa porcentajes de mantenimiento y ROH para años 1, 3 y 5
        ['1', '3', '5'].forEach(año => {
            calcularPorcentaje(document.getElementById(`disponibilidad_mantenimiento_${año}`), `porcentaje_dm_${año}`);
            calcularPorcentaje(document.getElementById(`roh_${año}`), `porcentaje_roh_${año}`);
        });

        actualizarPorcentajesMisiones();
        observarCambiosDeHorasDisponible();
        configurarFormularioSistemas();
        actualizarPorcentajePuertoExtranjero();
        inicializarHorasMisiones();
    });

    

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</x-app-layout>


</body>
</html>
