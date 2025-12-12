<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRES - {{ $buque->nombre }} (Equipos)</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/js/gres-equipos-mec.js"></script>
    <script src="/js/gres-equipos-colab.js"></script>

<style>
  /* ========= Overlay de imagen ========= */
  .overlay{
    position:fixed; inset:0; width:100%; height:100%;
    background:rgba(0,0,0,.8);
    display:flex; align-items:center; justify-content:center;
    z-index:9999; visibility:hidden; opacity:0;
    transition:visibility .3s, opacity .3s;
  }
  .overlay.active{ visibility:visible; opacity:1; }
  .overlay img{
    max-width:90%; max-height:90%;
    border-radius:8px; background:#fff; padding:20px;
    box-shadow:0 4px 15px rgba(0,0,0,.5);
  }
  .overlay img:hover{ transform:scale(1.05); }

  /* ========= Modales MEC ========= */
  .mec-modal.hidden{ display:none; }
  .mec-modal{
    position:fixed; inset:0; z-index:9999;
    display:flex; align-items:center; justify-content:center; height:100%;
  }
  .mec-modal__overlay{
    position:absolute; inset:0; background:rgba(0,0,0,.5);
    backdrop-filter:blur(2px); z-index:0;
  }
  .mec-modal__card{
    position:relative; z-index:1; width:100%; max-width:640px;
    border-radius:12px; background:#fff;
    box-shadow:0 20px 50px rgba(0,0,0,.25);
    display:flex; flex-direction:column; overflow:hidden;
    animation:mec-pop .18s ease-out; margin:0 auto;
  }
  @keyframes mec-pop{ from{transform:translateY(12px);opacity:0} to{transform:translateY(0);opacity:1} }

  .mec-modal__header{
    display:flex; align-items:center; justify-content:space-between;
    gap:6px; padding:8px 10px; border-bottom:1px solid #eef2f6; background:#f9fafb;
  }
  .mec-title-wrap{ display:flex; flex-direction:column; gap:2px; text-align:center; flex:1; }
  .mec-title{ margin:0; font-size:.95rem; font-weight:800; color:#0f172a; text-transform:uppercase; }
  .mec-subtitle{ font-size:.75rem; color:#64748b; }
  .mec-header-actions{ display:flex; gap:4px; align-items:center; }

  .mec-chip{
    border:1px solid #e5e7eb; background:#f3f4f6; color:#111827;
    padding:4px 8px; border-radius:999px; font-weight:600; font-size:.75rem; cursor:pointer;
  }
  .mec-chip:hover{ background:#e5e7eb; }

  .mec-btn{ cursor:pointer; border:none; padding:6px 10px; border-radius:8px; font-weight:600; font-size:.85rem; }
  .mec-btn--ghost{ background:transparent; color:#1f2937; }
  .mec-btn--ghost:hover{ background:#f3f4f6; }
  .mec-btn--primary{ background:#003366; color:#fff; box-shadow:0 4px 10px rgba(37,99,235,.15); }
  .mec-btn--primary:hover{ filter:brightness(.95); }
  .mec-btn--danger{ background:#730C02; color:#fff; box-shadow:0 4px 10px rgba(239,68,68,.15); }
  .mec-btn--danger:hover{ filter:brightness(.95); }

  .mec-modal__body{ padding:10px; display:flex; flex-direction:column; gap:8px; }
  .mec-question{
    background:#003366; color:#fff; font-weight:700; text-transform:uppercase;
    border-radius:8px; padding:8px; text-align:center; line-height:1.3; font-size:.9rem;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
  }

  .mec-obs{ background:#f8fafc; border:1px solid #e5e7eb; border-radius:8px; padding:8px; }
  .mec-obs__label{ font-size:.8rem; font-weight:600; color:#334155; display:block; margin-bottom:4px; }
  .mec-obs__input{
    display:block; width:100%; height:90px; max-height:110px; resize:none;
    border:1px solid #cbd5e1; border-radius:8px; padding:8px 10px; font-size:.85rem; line-height:1.4; background:#fff; outline:none;
  }
  .mec-obs__input:focus{ border-color:#2563eb; box-shadow:0 0 0 2px rgba(37,99,235,.15); }
  .mec-obs__meta{ display:flex; justify-content:space-between; margin-top:4px; }
  .mec-progress,.mec-count{ font-size:.75rem; color:#64748b; }

  .mec-panel.hidden{ display:none; }
  .mec-panel__inner{ background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:8px; }
  .mec-panel__inner table{ width:100%; border-collapse:collapse; }
  .mec-panel__inner th,.mec-panel__inner td{ border:1px solid #e5e7eb; padding:6px; font-size:.8rem; text-align:left; }
  .mec-panel__inner thead{ background:#f5f5f5; }

  .mec-modal__footer{
    display:flex; justify-content:center; gap:8px; padding:8px; border-top:1px solid #eef2f6; background:#fafafa;
  }

  .mec-obs-toggle{ display:flex; align-items:center; gap:8px; justify-content:flex-end; margin-top:6px; color:#334155; font-size:.8rem; font-weight:600; }
  .mec-switch{ position:relative; display:inline-block; width:40px; height:22px; }
  .mec-switch input{ display:none; }
  .mec-slider{ position:absolute; cursor:pointer; inset:0; background:#e5e7eb; border-radius:999px; transition:.2s; }
  .mec-slider:before{
    content:""; position:absolute; height:18px; width:18px; left:2px; top:2px;
    background:#fff; border-radius:50%; transition:.2s; box-shadow:0 1px 3px rgba(0,0,0,.2);
  }
  .mec-switch input:checked + .mec-slider{ background:#2563eb; }
  .mec-switch input:checked + .mec-slider:before{ transform:translateX(18px); }

  .hidden{ display:none !important; }
  .mec-fade{ animation:mec-fade .35s ease; }
  @keyframes mec-fade{ from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }

  .mec-result__wrap{ text-align:center; padding:12px 10px; }
  .mec-result__badge{
    display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border-radius:999px;
    font-weight:800; color:#fff; margin:10px 0 6px;
  }
  .mec-result--1{ background:#16a34a; }
  .mec-result--2{ background:#2563eb; }
  .mec-result--3{ background:#d97706; }
  .mec-result--4{ background:#dc2626; }
  .mec-result__desc{ font-size:.85rem; color:#475569; line-height:1.45; }

  #mec-panel-content{ font-size:14px; }

  /* ========= Toolbar del panel izquierdo ========= */
  .panel-toolbar{
    display:flex; align-items:center; justify-content:space-between;
    gap:12px; padding:6px 0; flex-wrap:wrap;
  }
  .panel-toolbar__text{ margin:0; color:#475569; font-size:14px; line-height:1.35; }
  .panel-toolbar__actions{ display:flex; align-items:center; gap:8px; flex-wrap:wrap; }

  /* ========= Botones base ========= */
  .btn{
    display:inline-flex; align-items:center; gap:6px;
    border-radius:8px; padding:8px 12px; line-height:1;
    font-weight:600; font-size:13px; border:1px solid transparent; transition:.15s;
  }
  .btn-primary{ background:#3b82f6; color:#fff; }
  .btn-primary:hover{ filter:brightness(.95); }
  .btn-success{ background:#10b981; color:#fff; }
  .btn-success:hover{ filter:brightness(.95); }
  .btn-ghost{ background:#fff; border:1px dashed #cbd5e1; color:#0f172a; padding:6px 10px; }
  .btn-ghost:hover{ background:#f8fafc; border-style:solid; }
  .arrow-toggle{ width:36px; height:36px; padding:0; justify-content:center; }

  /* ========= Input con ícono (compartido panel / modales) =========
     (el ancho lo pones con utilidades: w-64, w-full, etc.) */
  .input-icon{ position:relative; display:inline-block; width:auto; }
  .input-icon i{
    position:absolute; left:10px; top:50%; transform:translateY(-50%);
    color:#94a3b8; font-size:14px; pointer-events:none;
  }
  .input-icon input{
    border:1px solid #e2e8f0; border-radius:8px; background:#fff;
    padding:.5rem .75rem .5rem 2rem; height:32px; outline:none; transition:.15s;
  }
  .input-icon input:focus{ border-color:#93c5fd; box-shadow:0 0 0 3px rgba(59,130,246,.15); }
  .input-icon .input-clear{
    position:absolute; right:8px; top:50%; transform:translateY(-50%);
    border:none; background:transparent; font-size:18px; line-height:1;
    color:#94a3b8; cursor:pointer; display:none;
  }
  .input-icon .input-clear:hover{ color:#64748b; }
  .input-icon .input-clear.show{ display:block; }

  /* ========= Scope SOLO para modales de colaboradores ========= */
  .colab-modal .swal2-title{
    text-align:left !important; font-size:1rem !important; font-weight:600 !important;
    color:rgb(55,65,81) !important; /* slate-700 */
  }
  .colab-modal .cm-wrap{ padding-top:4px; }
  .colab-modal .cm-grid{
    display:grid; grid-template-columns:1fr; gap:14px;
  }
  @media (min-width:768px){
    .colab-modal .cm-grid{ grid-template-columns:repeat(2,minmax(0,1fr)); column-gap:18px; row-gap:14px; }
  }
  .colab-modal .cm-field{ display:flex; flex-direction:column; }
  .colab-modal .cm-label{
    font-size:.75rem; font-weight:600; color:#475569; margin:0 0 6px;
  }
  .colab-modal .cm-input{
    height:42px; padding:10px 12px; border:1px solid #cbd5e1; border-radius:10px;
    font-size:14px; line-height:1.2; background:#fff; outline:none; width:100%; transition:.15s;
  }
  .colab-modal .cm-input::placeholder{ color:#94a3b8; }
  .colab-modal .cm-input:focus{
    border-color:#93c5fd; box-shadow:0 0 0 3px rgba(59,130,246,.15);
  }
</style>


</head>
<body class="bg-gray-100">
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <!-- Span GRES -->
            <span class="font-bold mt-0 text-center" style="color: rgb(18, 164, 73); font-size: 40px;">GRES</span>
            
            <!-- Span frase Grado de esencialidad con ancho limitado y texto ajustado -->
            <span class="text-gray-600 leading-tight" style="font-size: 14px; max-width: 120px; word-wrap: break-word; line-height: 1.3; padding-left: 4px">
                Grado de esencialidad
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

    <div class="container py-1 px-6" style="max-width: 100%;">
        <div x-data="{ open: false }" class="flex transition-all duration-300">
            <!-- Panel izquierdo: Lista de equipos -->
            <div
                :class="open ? 'w-1/2 mr-4' : 'w-full'"
                class="bg-white rounded shadow p-6 transition-all duration-300"
            >

                <div class="mb-4 panel-toolbar">
                    <p class="panel-toolbar__text">
                        Lista de equipos asignados al buque para metodología GRES.
                    </p>

                    <!-- Barra de búsqueda y botones -->
                    <div class="panel-toolbar__actions">
                        <div class="input-icon">
                        <i class="fas fa-search"></i>
                        <input
                            type="text"
                            id="search"
                            placeholder="Buscar por nombre"
                            class="w-64"
                        >
                        </div>

                        <button
                        id="export-equipos-pdf-btn"
                        class="btn btn-primary"
                        type="button"
                        >
                        <i class="fas fa-file-pdf"></i>
                        <span class="hidden sm:inline">Exportar PDF</span>
                        <span class="sm:hidden">PDF</span>
                        </button>

                        <button
                        id="manage-equipos-colab-btn"
                        class="btn btn-success"
                        title="Gestionar Colaboradores"
                        >
                        <i class="fas fa-user-plus"></i>
                        <span class="hidden sm:inline">Colab</span>
                        </button>

                        <button
                        @click="open = false"
                        x-show="open"
                        class="btn btn-ghost arrow-toggle"
                        title="Ocultar Detalles"
                        >
                        &rsaquo;
                        </button>
                    </div>
                </div>


                <!-- Tabla de equipos -->
                <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-20">Código</th>
                        <th scope="col" class="px-6 py-3">Nombre</th>
                        <th scope="col" class="px-6 py-3 w-28">MEC</th>
                        <th scope="col" class="px-6 py-3 w-20 text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody id="equipos-table-body">
                    @foreach($equipos as $equipo)
                        <tr class="bg-white border-b hover:bg-gray-50" id="equipo-row-{{ $equipo->id }}">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $equipo->codigo }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $equipo->nombre }}
                        </td>
                        <td id="mec-column-{{ $equipo->id }}" class="px-6 py-4">
                            {{ $equipo->mec ?? 'Sin Asignar' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button
                            @click="
                                open = true;
                                loadEquipoDetails({{ json_encode($equipo) }});
                            "
                            class="text-blue-500 hover:underline"
                            title="Ver Detalles"
                            >
                            <i class="fas fa-pencil-alt"></i>
                            </button>
                        </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>

            </div>

            <!-- Panel derecho: Información del equipo -->
            <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-10"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            class="bg-white rounded shadow p-6 w-1/2 transition-all duration-300"
            style="display: none;"
            >
            <!-- Header -->
            <div class="mb-6 border-b border-gray-200 pb-3">
                <h2 class="text-lg font-bold text-[#105dad]">Detalles del Equipo</h2>
                <p class="text-sm text-gray-500">Asignación de MEC y visualización del diagrama</p>
            </div>

            <!-- Info básica -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Código</label>
                <input
                    id="selected-equipo-code"
                    type="text"
                    disabled
                    class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 text-sm"
                >
                </div>
                <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Nombre Equipo</label>
                <input
                    id="selected-equipo-name"
                    type="text"
                    disabled
                    class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 text-sm"
                >
                </div>
            </div>

            <!-- MEC y Diagrama -->
            <div class="grid grid-cols-3 gap-6 mb-6">
                <!-- Columna izquierda MEC -->
                <div class="col-span-1">
                <label class="block text-xs font-semibold text-gray-600 mb-1">MEC</label>
                <input
                    id="mec-input"
                    type="text"
                    disabled
                    class="w-44 border border-gray-300 rounded px-3 py-2 bg-gray-100 text-sm"
                >
                <div class="mt-3 space-y-2">
                    <button
                    id="assign-mec-btn"
                    class="w-44 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded shadow-sm assign-mec-btn"
                    >
                    <i class="fas fa-tasks mr-1"></i> Asignar MEC
                    </button>
                </div>
                </div>

                <!-- Columna derecha Diagrama -->
                <div class="col-span-2">
                <h3 class="text-xs font-semibold text-gray-600 mb-2">Diagrama de Decisión</h3>
                <div
                    id="diagram-container"
                    class="border border-gray-200 rounded-lg flex items-center justify-center bg-gray-50"
                    style="width: 100%; height: auto; max-width: 600px;"
                >
                    <img
                    src="/images/diagramas/default.webp"
                    alt="Diagrama de decisión"
                    id="diagram-image"
                    class="max-w-full h-auto cursor-pointer"
                    >
                </div>
                </div>
            </div>

            <!-- Observaciones -->
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Observaciones</h3>
                <div class="relative overflow-x-auto border border-gray-200">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th class="px-6 py-3">Pregunta</th>
                        <th class="px-6 py-3">Observación</th>
                    </tr>
                    </thead>
                    <tbody id="observations-table-body">
                    <!-- Se llena dinámicamente -->
                    </tbody>
                </table>
                </div>
            </div>
            </div>

        </div>
    </div>

    <!-- Overlay para ampliar la imagen -->
    <div class="overlay" id="image-overlay">
        <img id="overlay-image" src="" alt="Diagrama ampliado">
    </div>

    <!-- Script principal de la lógica GRES -->
    <script>
        // Almacena el ID del equipo actualmente seleccionado
        window.selectedEquipoId = null;
        // Variable para saber si tenemos un MEC pendiente por guardar
        let pendingMecData = null;
        // Variable para controlar si ya se está guardando
        let isSaving = false;
        // ID del buque actual
        window.buqueId = {{ $buque->id }};

        /**
         * Carga los detalles de un equipo en el panel derecho
         */
        function loadEquipoDetails(equipo) {
            window.selectedEquipoId = equipo.id;
            window.selectedSistemaId = equipo.sistema_id; // Guardamos el sistema_id

            // Rellenar campos
            document.getElementById('selected-equipo-code').value = equipo.codigo;
            document.getElementById('selected-equipo-name').value = equipo.nombre;
            document.getElementById('mec-input').value = (equipo.mec ?? 'Sin Asignar');

            // Imagen de diagrama
            const diagramImage = document.getElementById('diagram-image');
            if (equipo.diagrama) {
                diagramImage.src = equipo.diagrama;
            } else {
                diagramImage.src = '/images/diagramas/default.webp';
            }
            diagramImage.style.display = 'block';
            diagramImage.style.cursor = 'pointer';

            // Tabla de observaciones
            const obsTableBody = document.getElementById('observations-table-body');
            obsTableBody.innerHTML = '';

            if (equipo.observaciones && Array.isArray(equipo.observaciones)) {
                equipo.observaciones.forEach(obs => {
                    const newRow = `
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                Pregunta ${obs.pregunta}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                ${obs.texto}
                            </td>
                        </tr>
                    `;
                    obsTableBody.innerHTML += newRow;
                });
            }

            // Reseteamos la variable "pendingMecData"
            pendingMecData = null;
            // Deshabilitamos el botón "Guardar MEC"
            const saveMecBtn = document.getElementById('save-mec-btn');
            if (saveMecBtn) {
                saveMecBtn.disabled = true;
            }
        }

        /**
         * Configura el overlay para ampliar la imagen de diagrama
         */
        function setupImageOverlay() {
            const overlay = document.getElementById('image-overlay');
            const overlayImage = document.getElementById('overlay-image');
            const diagramContainer = document.getElementById('diagram-container');

            diagramContainer.addEventListener('click', function(event) {
                const clickedImage = (event.target.tagName === 'IMG') ? event.target : null;
                if (clickedImage) {
                    event.stopPropagation();
                    overlayImage.src = clickedImage.src;
                    overlay.classList.add('active');
                }
            });

            overlay.addEventListener('click', function(event) {
                if (event.target === overlay) {
                    overlay.classList.remove('active');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            setupImageOverlay();

            // LÓGICA DE BÚSQUEDA
            const searchInput = document.getElementById('search');
            const tableBody = document.getElementById('equipos-table-body');

            if (searchInput && tableBody) {
                searchInput.addEventListener('input', () => {
                    const filter = searchInput.value.toLowerCase();
                    const rows = tableBody.querySelectorAll('tr');

                    rows.forEach(row => {
                        const nameCell = row.querySelector('td:nth-child(2)');
                        if (!nameCell) return;
                        const nameText = nameCell.textContent.toLowerCase();
                        if (nameText.includes(filter)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // Botón "ASIGNAR MEC"
            const assignMecBtn = document.getElementById('assign-mec-btn');
            if (assignMecBtn) {
                assignMecBtn.addEventListener('click', () => {
                    if (!window.selectedEquipoId) return;

                    const mecInput = document.getElementById('mec-input');
                    const currentMec = mecInput ? mecInput.value : null;

                    if (currentMec && currentMec !== 'MEC Sin Asignar') {
                        Swal.fire({
                            title: '¿Reasignar MEC?',
                            text: 'Este equipo ya tiene un MEC asignado. Si decides asignar un nuevo MEC, se eliminarán todas las observaciones previas y el diagrama actual. ¿Estás seguro?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, estoy seguro',
                            cancelButtonText: 'No, cancelar',
                            allowOutsideClick: false,
                            confirmButtonColor: '#003366' // 👈 color del botón Confirmar
                            }).then((result) => {
                            if (result.isConfirmed) {
                                clearEquipoObservations(window.selectedEquipoId).then(() => {
                                startMecQuestions();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Acción cancelada',
                                    text: 'El MEC actual no se ha modificado.',
                                    icon: 'info',
                                    confirmButtonText: 'Entendido',
                                    confirmButtonColor: '#003366'
                                });
                            }
                        });
                    } else {
                        startMecQuestions();
                    }
                });
            }

            // LÓGICA: BOTÓN "GUARDAR MEC"
            const saveMecBtn = document.getElementById('save-mec-btn');
            if (saveMecBtn) {
                saveMecBtn.addEventListener('click', () => {
                    if (!pendingMecData) return;
                    saveMecDataToDatabase(pendingMecData);
                });
            }

            const $resModal   = document.getElementById('mec-result-modal');
            const $resOverlay = $resModal.querySelector('.mec-modal__overlay');
            const $resCloseX  = document.getElementById('mec-result-close');
            const $resClose   = document.getElementById('mec-result-cancel');
            const $resSave    = document.getElementById('mec-result-save');

            // Cerrar modal de resultado
            function closeResultModal() { $resModal.classList.add('hidden'); }
            $resCloseX.onclick  = closeResultModal;
            $resClose.onclick   = closeResultModal;
            $resOverlay.onclick = (e) => { if (e.target.dataset.close === 'true') closeResultModal(); };

            // Guardar desde el modal final
            $resSave.onclick = () => {
            if (!pendingMecData) return; // por si acaso
            saveMecDataToDatabase(pendingMecData);
            closeResultModal(); // 👈 se cierra el modal inmediatamente después de guardar
            };

            // Exponemos función para abrirlo desde finalizeRoute()
            window.__openResultModal = function({ level, label, desc }) {
            const $badge     = document.getElementById('mec-result-badge');
            const $badgeText = document.getElementById('mec-result-badge-text');
            const $desc      = document.getElementById('mec-result-desc');

            // Reset clases y aplicamos la del nivel
            $badge.classList.remove('mec-result--1','mec-result--2','mec-result--3','mec-result--4');
            $badge.classList.add(`mec-result--${level}`);

            // Texto
            $badgeText.textContent = `Nivel ${level} · ${label}`;
            $desc.textContent = desc;

            // Abrir
            $resModal.classList.remove('hidden');
            };

        });

        /**
         * Elimina todas las observaciones de un equipo
         */
        function clearEquipoObservations(equipoId) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            return fetch(`/gres/observations/clear/${equipoId}`, {
                method: 'DELETE',
                headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
                },
            })
                .then(async (response) => {
                if (!response.ok) throw new Error('Error al eliminar las observaciones.');
                const obsTableBody = document.getElementById('observations-table-body');
                if (obsTableBody) obsTableBody.innerHTML = '';
                // 👇 devolvemos la promesa de SweetAlert para esperar a que el usuario cierre el diálogo
                return Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Observaciones eliminadas',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
                });
                })
                .catch((error) => {
                console.error('Error al eliminar observaciones:', error);
                // también devolvemos la promesa de este SweetAlert
                return Swal.fire('Error', 'No se pudieron eliminar las observaciones previas.', 'error');
                });
            }


        // Misiones del Buque
        window.buqueMisiones = @json($buque->misiones->map(function ($mision) {
            return [
                'nombre'      => $mision->nombre,
                'porcentaje'  => $mision->pivot->porcentaje,
                'descripcion' => $mision->pivot->descripcion
            ];
        }));

        /* ============================================================
         *  FUNCIONES PRINCIPALES PARA EL DIAGRAMA Y ASIGNACIÓN DE MEC
         * ============================================================ */

        /**
         * Inicia la secuencia de preguntas de MEC
         */
function startMecQuestions() {
  // ==========================
  // Estado
  // ==========================
  let chain = [];
  let currentQuestion = 1;
  let questionHistory = [1];

  // ==========================
  // DOM refs del modal
  // ==========================
  const $modal        = document.getElementById('mec-modal');
  const $overlay      = $modal.querySelector('.mec-modal__overlay');
  const $title        = document.getElementById('mec-title');
  const $subtitle     = document.getElementById('mec-subtitle');
  const $question     = document.getElementById('mec-question');
  const $obsWrap      = document.getElementById('mec-obs');      
  const $obsToggle    = document.getElementById('mec-obs-toggle'); 
  const $obsInput     = document.getElementById('mec-obs-input');
  const $count        = document.getElementById('mec-count');
  const $progress     = document.getElementById('mec-progress');
  const $panel        = document.getElementById('mec-panel');
  const $panelContent = document.getElementById('mec-panel-content');

  const $btnBack      = document.getElementById('mec-back');
  const $btnClose     = document.getElementById('mec-close');
  const $btnYes       = document.getElementById('mec-yes');
  const $btnNo        = document.getElementById('mec-no');
  const $btnMisiones  = document.getElementById('mec-misiones');
  const $btnHelp      = document.getElementById('mec-help');

  const MAX_CHARS = 92;

  // =======================
  // Toggle observación
  // =======================
  $obsToggle.addEventListener('change', () => {
    if ($obsToggle.checked) {
      $obsWrap.classList.remove('hidden');
      setTimeout(() => $obsInput.focus(), 0);
    } else {
      $obsWrap.classList.add('hidden');
    }
  });

  // ==========================
  // Utilidades Observaciones
  // ==========================
  function getExistingObservation(q) {
    const obsTableBody = document.getElementById('observations-table-body');
    if (!obsTableBody) return '';
    const rows = obsTableBody.querySelectorAll('tr');
    for (const row of rows) {
      const cells = row.querySelectorAll('td');
      if (cells.length >= 2) {
        const pregunta = cells[0].textContent.trim().replace('Pregunta ', '');
        if (String(pregunta) === String(q)) {
          return cells[1].textContent.trim();
        }
      }
    }
    return '';
  }

  function upsertObservationRow(q, text) {
    const obsTableBody = document.getElementById('observations-table-body');
    if (!obsTableBody) return;
    const rows = obsTableBody.querySelectorAll('tr');
    let updated = false;

    for (const row of rows) {
      const cells = row.querySelectorAll('td');
      if (cells.length >= 2) {
        const pregunta = cells[0].textContent.trim().replace('Pregunta ', '');
        if (String(pregunta) === String(q)) {
          cells[1].textContent = text;
          updated = true;
          break;
        }
      }
    }

    if (!updated) {
      const newRow = `
        <tr>
          <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">Pregunta ${q}</td>
          <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">${text}</td>
        </tr>
      `;
      obsTableBody.insertAdjacentHTML('beforeend', newRow);
    }
  }

  // ==========================
  // Apertura/Cierre
  // ==========================
  function openModal() {
    $modal.classList.remove('hidden');
    renderQuestion();
    $obsInput.focus();
    document.addEventListener('keydown', onKeydown);
  }
  function closeModal() {
    document.removeEventListener('keydown', onKeydown);
    $modal.classList.add('hidden');
    // Limpia panel
    $panel.classList.add('hidden');
    $panelContent.innerHTML = '';
  }

  // ==========================
  // Render de pregunta
  // ==========================
    function renderQuestion() {
    const { titleHtml, showAB } = getQuestionContent(currentQuestion);

    // Texto base
    $title.textContent = 'Pregunta MEC';
    $question.textContent = titleHtml.replace(/<\/?[^>]+(>|$)/g, '');
    const stepText = `Pregunta ${currentQuestion} de 7`;
    $subtitle.textContent = stepText;
    $progress.textContent = stepText;

    // Etiquetas de botones y back
    $btnYes.textContent = showAB ? 'A' : 'Sí';
    $btnNo.textContent  = showAB ? 'B' : 'No';
    $btnBack.style.visibility = currentQuestion > 1 ? 'visible' : 'hidden';

    // Observación existente
    const existing = getExistingObservation(currentQuestion);
    $obsInput.value = existing;
    $count.textContent = `${$obsInput.value.length}/${MAX_CHARS} caracteres`;

    // Switch de Observación: mostrar/ocultar según exista texto previo
    const hasObs = !!(existing && existing.trim().length > 0);
    $obsToggle.checked = hasObs;
    if (hasObs) $obsWrap.classList.remove('hidden');
    else        $obsWrap.classList.add('hidden');

    // --- Animación (fade) al cambiar de pregunta ---
    // Reiniciar animación en los elementos clave (pregunta y subtítulo/progreso)
    [$question, $subtitle, $progress].forEach(($el) => {
        if (!$el) return;
        $el.classList.remove('mec-fade');
        // Fuerza reflow para reiniciar la animación
        void $el.offsetWidth;
        $el.classList.add('mec-fade');
    });
    }


  // ==========================
  // Handlers
  // ==========================
  function onKeydown(ev) {
    // no interceptar Enter cuando el foco está en textarea
    if (ev.key === 'Enter' && document.activeElement === $obsInput) return;

    if (ev.key === 'Enter') { // Sí
      persistObservation();
      chain.push(1);
      proceed();
    } else if (ev.key === 'Escape') { // No
      persistObservation();
      chain.push(0);
      proceed();
    } else if (ev.key === 'ArrowLeft' && currentQuestion > 1) {
      // Back rápido
      persistObservation();
      if (chain.length > 0) chain.pop();
      questionHistory.pop();
      currentQuestion = questionHistory[questionHistory.length - 1];
      renderQuestion();
    }
  }

    function persistObservation() {
    if ($obsToggle.checked && $obsInput.value.trim().length > 0) {
        upsertObservationRow(currentQuestion, $obsInput.value.trim());
    }
    }

  // Observación con debounce
  let debounceTimer = null;
  $obsInput.addEventListener('input', () => {
    $count.textContent = `${$obsInput.value.length}/${MAX_CHARS} caracteres`;
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => persistObservation(), 180);
  });

  // Botones de acción
  $btnYes.onclick = () => { persistObservation(); chain.push(1); proceed(); };
  $btnNo.onclick  = () => { persistObservation(); chain.push(0); proceed(); };

  $btnBack.onclick = () => {
    if (currentQuestion <= 1) return;
    persistObservation();
    if (chain.length > 0) chain.pop();
    questionHistory.pop();
    currentQuestion = questionHistory[questionHistory.length - 1];
    renderQuestion();
  };

  $btnClose.onclick = () => closeModal();
  $overlay.onclick  = (e) => { if (e.target.dataset.close === 'true') closeModal(); };

  // Misiones / Ayuda dentro del panel plegable
  $btnMisiones.onclick = () => {
    persistObservation();
    showMisionesPanel();
  };
  $btnHelp.onclick = () => {
    persistObservation();
    showHelpPanel(currentQuestion);
  };

  function showMisionesPanel() {
    const misiones = window.buqueMisiones || [];
    if (misiones.length === 0) {
      $panelContent.innerHTML = `<div style="padding:8px; font-weight:600; color:#64748b;">No hay misiones asociadas a este buque.</div>`;
      $panel.classList.remove('hidden');
      return;
    }
    const rows = misiones.map(m => `
      <tr>
        <td>${m.nombre}</td>
        <td style="text-align:center;">${m.porcentaje}%</td>
        <td>${m.descripcion}</td>
      </tr>
    `).join('');
    $panelContent.innerHTML = `
      <div style="font-weight:800; margin-bottom:6px; color:#0f172a;">Misiones del Buque</div>
      <table>
        <thead>
          <tr>
            <th>Nombre</th><th>%</th><th>Descripción</th>
          </tr>
        </thead>
        <tbody>${rows}</tbody>
      </table>
    `;
    $panel.classList.remove('hidden');
  }

  function showHelpPanel(qNumber) {
    let helpText = '';
    switch (qNumber) {
      case 1: helpText = 'EVALÚE SI LA INDISPONIBILIDAD DEL EQUIPO AFECTA PARCIAL O TOTALMENTE LA FUNCIONALIDAD DE LA UNIDAD'; break;
      case 2: helpText = 'EVALÚE SI AL QUEDAR INOPERATIVO EL EQUIPO, SE REFLEJA UNA CONSECUENCIA NEGATIVA SOBRE EL PERSONAL, EL SISTEMA O EL MEDIO AMBIENTE.'; break;
      case 3: helpText = 'CONSIDERE QUE EXISTE REDUNDANCIA SI HAY EQUIPO EN PARALELO CAPAZ DE SUPLIR LA FUNCIÓN.'; break;
      case 4: helpText = 'SI EL EQUIPO INOPERATIVO CAUSA LIMITACIÓN EN ALGUNA MISIÓN, LA RESPUESTA ES SÍ.'; break;
      case 5: helpText = 'SE HABLA DE REDUNDANCIA PASIVA CUANDO SE TIENE UN RELEVO DISPONIBLE EN STANDBY.'; break;
      case 6: helpText = 'CONSIDERE SI EL EQUIPO DE RELEVO DA EL MISMO RENDIMIENTO DURANTE UN TIEMPO ADECUADO.'; break;
      case 7: helpText = 'PÉRDIDAS MENORES (A) o afectación de más de una misión (B).'; break;
      default: helpText = 'Ayuda no disponible.';
    }
    $panelContent.innerHTML = `
      <div style="font-weight:800; margin-bottom:6px; color:#0f172a;">Ayuda</div>
      <div style="line-height:1.45;">${helpText}</div>
    `;
    $panel.classList.remove('hidden');
  }

  // ==========================
  // Flujo
  // ==========================
  function proceed() {
    const lastAnswer = chain[chain.length - 1];
    switch (currentQuestion) {
      case 1:
        if (lastAnswer === 0) finalizeRoute();
        else { currentQuestion = 2; questionHistory.push(2); renderQuestion(); }
        break;
      case 2:
        if (lastAnswer === 0) { currentQuestion = 4; questionHistory.push(4); renderQuestion(); }
        else { currentQuestion = 3; questionHistory.push(3); renderQuestion(); }
        break;
      case 3:
        if (lastAnswer === 0) finalizeRoute();
        else { currentQuestion = 4; questionHistory.push(4); renderQuestion(); }
        break;
      case 4:
        if (lastAnswer === 0) finalizeRoute();
        else { currentQuestion = 5; questionHistory.push(5); renderQuestion(); }
        break;
      case 5:
        if (lastAnswer === 0) { currentQuestion = 7; questionHistory.push(7); renderQuestion(); }
        else { currentQuestion = 6; questionHistory.push(6); renderQuestion(); }
        break;
      case 6:
        if (lastAnswer === 0) { currentQuestion = 7; questionHistory.push(7); renderQuestion(); }
        else finalizeRoute();
        break;
      case 7:
        finalizeRoute();
        break;
    }
    // al cambiar de pregunta, cierra panel si estaba abierto
    $panel.classList.add('hidden');
    $panelContent.innerHTML = '';
  }

    // ==========================
    // Finalización y payload
    // ==========================
    function finalizeRoute() {
    const finalChain = chain.join('');
    let assignedMecNumber = null;

    if (checkMEC4Chain(chain))      assignedMecNumber = '4';
    else if (checkMEC2Chain(chain)) assignedMecNumber = '2';
    else if (checkMEC3Chain(chain)) assignedMecNumber = '3';
    else if (checkMEC1Chain(chain)) assignedMecNumber = '1';
    else {
        console.error('Ruta inválida:', finalChain);
        closeModal();
        return;
    }

    // Refleja MEC en UI
    assignMEC(window.selectedEquipoId, `MEC ${assignedMecNumber}`);

    // Diagrama
    placeDiagram(finalChain);

    // Observaciones desde la tabla
    const observationsToSave = gatherObservationsFromTable();

    // Payload pendiente
    pendingMecData = {
        equipoId: window.selectedEquipoId,
        sistemaId: window.selectedSistemaId,
        assignedMecNumber,
        chain,
        diagramPath: `/images/diagramas/${finalChain}.webp`,
        observations: observationsToSave
    };

    // Habilita botón Guardar
    const saveMecBtn = document.getElementById('save-mec-btn');
    if (saveMecBtn) saveMecBtn.disabled = false;

    // Cierra el modal de preguntas
    closeModal();

    // Mapa de significados
    const map = {
    '1': { label: 'Completamente operativo', desc: 'El equipo se considera completamente operativo según las respuestas dadas.' },
    '2': { label: 'Operación restringida',   desc: 'El equipo presenta limitaciones y su operación es restringida.' },
    '3': { label: 'Pérdida de misión',       desc: 'El equipo ocasiona pérdida de la misión en el contexto evaluado.' },
    '4': { label: 'Riesgo de seguridad',     desc: 'El equipo representa un riesgo de seguridad y debe priorizarse.' }
    };
    const info = map[assignedMecNumber];

    // Abrimos nuestro modal custom
    if (window.__openResultModal) {
    window.__openResultModal({
        level: assignedMecNumber,
        label: info.label,
        desc: info.desc
    });
    }

    }


  // ==========================
  // Reglas de cadenas MEC
  // ==========================
  function checkMEC4Chain(chain) {
    const mec4Chains = [[1,1,0]];
    return includesChain(mec4Chains, chain);
  }
  function checkMEC2Chain(chain) {
    const mec2Chains = [
      [1,1,1,1,0,1],
      [1,0,1,1,0,1],
      [1,0,1,0,1],
      [1,1,1,1,1,0,1]
    ];
    return includesChain(mec2Chains, chain);
  }
  function checkMEC3Chain(chain) {
    const mec3Chains = [
      [1,0,1,0,0],
      [1,0,1,1,0,0],
      [1,1,1,1,0,0],
      [1,1,1,1,1,0,0]
    ];
    return includesChain(mec3Chains, chain);
  }
  function checkMEC1Chain(chain) {
    const mec1Chains = [
      [0],
      [1,0,0],
      [1,0,1,1,1],
      [1,1,1,0],
      [1,1,1,1,1,1]
    ];
    return includesChain(mec1Chains, chain);
  }
  function includesChain(validChains, currentChain) {
    const str = JSON.stringify(currentChain);
    return validChains.some(vc => JSON.stringify(vc) === str);
  }

  // ==========================
  // Texto de preguntas
  // ==========================
  function getQuestionContent(qNumber) {
    let titleHtml = '';
    let showAB = false;
    switch (qNumber) {
      case 1: titleHtml = '¿SE PIERDE CAPACIDAD DE LA UNIDAD SI EL EQUIPO QUEDA INOPERATIVO?'; break;
      case 2: titleHtml = '¿REPRESENTA UN EFECTO ADVERSO SOBRE EL PERSONAL, SISTEMA O MEDIO AMBIENTE?'; break;
      case 3: titleHtml = '¿EXISTE REDUNDANCIA DENTRO DEL EQUIPO PARA MITIGAR EL EFECTO ADVERSO?'; break;
      case 4: titleHtml = '¿CAUSA ALGUNA LIMITACIÓN SOBRE ALGUNA MISIÓN?'; break;
      case 5: titleHtml = '¿EXISTEN REDUNDANCIAS DENTRO DEL EQUIPO?'; break;
      case 6: titleHtml = '¿MITIGA COMPLETAMENTE EL EFECTO DE LA LIMITACIÓN?'; break;
      case 7: titleHtml = '¿QUÉ PÉRDIDAS SERÍAN? (A) Menores o 1 misión - (B) Más de 1 misión'; showAB = true; break;
    }
    return { titleHtml, showAB };
  }

  // ==========================
  // Diagrama (reusa tu overlay de imagen)
  // ==========================
  function placeDiagram(chainString) {
    const diagramContainer = document.getElementById('diagram-container');
    if (!diagramContainer) return;
    diagramContainer.innerHTML = `
      <img src="/images/diagramas/${chainString}.webp"
           alt="Diagrama ${chainString}"
           style="max-width: 100%; height: auto; cursor: pointer;" />
    `;
    setupImageOverlay();
  }

  // ==========================
  // Observaciones (sin cambios)
  // ==========================
  function gatherObservationsFromTable() {
    const obsTableBody = document.getElementById('observations-table-body');
    const rows = obsTableBody.querySelectorAll('tr');
    let observationsArray = [];
    rows.forEach(row => {
      const cells = row.querySelectorAll('td');
      if (cells.length >= 2) {
        let pregunta = cells[0].textContent.trim();
        let texto = cells[1].textContent.trim();
        pregunta = pregunta.replace('Pregunta ', '');
        observationsArray.push({ pregunta: pregunta, texto: texto });
      }
    });
    return observationsArray;
  }

  // ==========================
  // Reflejar MEC en UI (sin cambios)
  // ==========================
  function assignMEC(equipoId, mec) {
    const mecColumn = document.getElementById(`mec-column-${equipoId}`);
    if (mecColumn) mecColumn.textContent = mec;
    const mecInput = document.getElementById('mec-input');
    if (mecInput) mecInput.value = mec;
  }

  // Init
  openModal();
}



        

       function saveMecDataToDatabase(mecData) {
            // Evita doble submit
            if (window.isSaving) return;
            window.isSaving = true;

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            Swal.fire({
                title: 'Guardando...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            // Payload
            const data = {
                buque_id: window.buqueId,                         // Debe ser el mismo {buque} de la ruta
                equipo_id: mecData.equipoId,
                sistema_id: mecData.sistemaId ?? null,
                mec: `MEC ${mecData.assignedMecNumber}`,
                diagrama: mecData.diagramPath ?? null,
                observaciones: mecData.observations ?? null
            };

            console.log('Enviando datos:', data);

            // URL directa en la misma app
            const url = `/buques/${window.buqueId}/gres-equipo`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin', // asegura envío de cookies de sesión
                body: JSON.stringify(data)
            })
            .then(async (response) => {
                if (!response.ok) {
                    let message = `Error ${response.status}`;
                    try {
                        const err = await response.json();
                        message = err.message || JSON.stringify(err);
                    } catch (_) {
                        if (response.status === 419) message = 'CSRF inválido o sesión expirada (419)';
                        else if (response.status === 404) message = 'Ruta no encontrada (404): verifica /buques/{buque}/gres-equipo';
                        else {
                            const text = await response.text();
                            if (text && text.includes('<html')) {
                                message = 'Respuesta HTML (¿redirección a login?). Revisa autenticación/middleware.';
                            }
                        }
                    }
                    throw new Error(message);
                }
                return response.json();
            })
            .then((result) => {
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Guardado exitoso!',
                        text: `Se ha guardado ${data.mec} en la base de datos`,
                        confirmButtonText: 'Entendido'
                    });

                    const saveMecBtn = document.getElementById('save-mec-btn');
                    if (saveMecBtn) saveMecBtn.disabled = true;

                    window.pendingMecData = null;
                } else {
                    throw new Error(result.message || 'Error al guardar los datos');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Ocurrió un error al guardar los datos',
                    confirmButtonText: 'Entendido'
                });
            })
            .finally(() => {
                window.isSaving = false;
            });
        }

    </script>
</x-app-layout>
<!-- =================== MEC MODAL (Custom) =================== -->
<div id="mec-modal" class="mec-modal hidden">
  <div class="mec-modal__overlay" data-close="true"></div>
  <div class="mec-modal__card" role="dialog" aria-modal="true" aria-labelledby="mec-title">
    <div class="mec-modal__header">
      <button id="mec-back" class="mec-btn mec-btn--ghost" title="Volver">&#x2190;</button>
      <div class="mec-title-wrap">
        <h3 id="mec-title" class="mec-title">Pregunta</h3>
        <div id="mec-subtitle" class="mec-subtitle">Pregunta 1 de 7</div>
      </div>
      <div class="mec-header-actions">
        <button id="mec-misiones" class="mec-chip" title="Misiones">Misiones</button>
        <button id="mec-help" class="mec-chip" title="Ayuda">?</button>
        <button id="mec-close" class="mec-btn mec-btn--ghost" title="Cerrar">&times;</button>
      </div>
    </div>

    <div class="mec-modal__body">
    <div id="mec-question" class="mec-question"></div>

    <!-- Switch para mostrar/ocultar observación -->
    <div class="mec-obs-toggle">
        <span>Agregar observación</span>
        <label class="mec-switch" title="Agregar observación">
        <input id="mec-obs-toggle" type="checkbox">
        <span class="mec-slider"></span>
        </label>
    </div>

    <!-- Observación (inicia oculta) -->
    <div id="mec-obs" class="mec-obs hidden">
        <label for="mec-obs-input" class="mec-obs__label">Observación (opcional)</label>
        <textarea id="mec-obs-input" class="mec-obs__input" maxlength="92" placeholder="Escribe tu comentario aquí..."></textarea>
        <div class="mec-obs__meta">
        <span id="mec-progress" class="mec-progress">Pregunta 1 de 7</span>
        <span id="mec-count" class="mec-count">0/92 caracteres</span>
        </div>
    </div>

    <!-- Panel plegable para Misiones / Ayuda -->
    <div id="mec-panel" class="mec-panel hidden">
        <div class="mec-panel__inner">
        <div id="mec-panel-content"></div>
        </div>
    </div>
    </div>

    <div class="mec-modal__footer">
      <button id="mec-yes" class="mec-btn mec-btn--primary">Sí</button>
      <button id="mec-no" class="mec-btn mec-btn--danger">No</button>
    </div>
  </div>
</div>
<!-- =================== /MEC MODAL =================== -->

<!-- =================== MEC RESULT MODAL (Custom) =================== -->
<div id="mec-result-modal" class="mec-modal hidden">
  <div class="mec-modal__overlay" data-close="true"></div>
  <div class="mec-modal__card" role="dialog" aria-modal="true" aria-labelledby="mec-result-title">
    <div class="mec-modal__header">
      <div class="mec-title-wrap">
        <h3 id="mec-result-title" class="mec-title">Resultado MEC</h3>
        <div id="mec-result-subtitle" class="mec-subtitle">Mantenimiento, Esencialidad y Criticidad</div>
      </div>
      <div class="mec-header-actions">
        <button id="mec-result-close" class="mec-btn mec-btn--ghost" title="Cerrar">&times;</button>
      </div>
    </div>

    <div class="mec-modal__body">
      <div class="mec-result__wrap">
        <div id="mec-result-badge" class="mec-result__badge mec-result--1">
          <span id="mec-result-badge-text">Nivel 1 · Completamente operativo</span>
        </div>
        <div id="mec-result-desc" class="mec-result__desc">
          El equipo se considera completamente operativo según las respuestas dadas.
        </div>
      </div>
    </div>

    <div class="mec-modal__footer">
      <button id="mec-result-save" class="mec-btn mec-btn--primary">Guardar resultado</button>
      <button id="mec-result-cancel" class="mec-btn mec-btn--ghost">Cerrar</button>
    </div>
  </div>
</div>
<!-- =================== /MEC RESULT MODAL =================== -->



</body>
</html>
