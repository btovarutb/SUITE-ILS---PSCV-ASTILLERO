<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GRES - {{ $buque->nombre }}</title>

  <meta name="csrf-token" content="{{ csrf_token() }}"/>

  {{-- Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/gres-mec.js'])

  {{-- Libs --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    transition:transform .25s ease;
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
  .mec-btn:disabled{ opacity:.6; cursor:not-allowed; }
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

  /* ========= Resultado MEC (badge del modal final) ========= */
  .mec-result__wrap{ text-align:center; padding:12px 10px; }
  .mec-result__badge{
    display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border-radius:999px;
    font-weight:800; color:#fff; margin:10px 0 6px;
  }
  .mec-result--1{ background:#16a34a; } /* Verde */
  .mec-result--2{ background:#2563eb; } /* Azul */
  .mec-result--3{ background:#d97706; } /* Ámbar */
  .mec-result--4{ background:#dc2626; } /* Rojo */
  .mec-result__desc{ font-size:.85rem; color:#475569; line-height:1.45; }

  /* ========= Toolbar compacta ========= */
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
  .btn:disabled{ opacity:.6; cursor:not-allowed; }
  .btn-primary{ background:#3b82f6; color:#fff; }
  .btn-primary:hover{ filter:brightness(.95); }
  .btn-success{ background:#10b981; color:#fff; }
  .btn-success:hover{ filter:brightness(.95); }
  .btn-ghost{ background:#fff; border:1px dashed #cbd5e1; color:#0f172a; padding:6px 10px; }
  .btn-ghost:hover{ background:#f8fafc; border-style:solid; }
  .arrow-toggle{ width:36px; height:36px; padding:0; justify-content:center; }

  /* ========= Input con ícono (compartido) ========= */
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
    color:rgb(55,65,81) !important;
  }
  .colab-modal .cm-wrap{ padding-top:4px; }
  .colab-modal .cm-grid{ display:grid; grid-template-columns:1fr; gap:14px; }
  @media (min-width:768px){
    .colab-modal .cm-grid{ grid-template-columns:repeat(2,minmax(0,1fr)); column-gap:18px; row-gap:14px; }
  }
  .colab-modal .cm-field{ display:flex; flex-direction:column; }
  .colab-modal .cm-label{ font-size:.75rem; font-weight:600; color:#475569; margin:0 0 6px; }
  .colab-modal .cm-input{
    height:42px; padding:10px 12px; border:1px solid #cbd5e1; border-radius:10px;
    font-size:14px; line-height:1.2; background:#fff; outline:none; width:100%; transition:.15s;
  }
  .colab-modal .cm-input::placeholder{ color:#94a3b8; }
  .colab-modal .cm-input:focus{ border-color:#93c5fd; box-shadow:0 0 0 3px rgba(59,130,246,.15); }
</style>

</head>

<body class="bg-gray-100">
<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center">
      <span class="font-bold mt-0 text-center" style="color: rgb(18, 164, 73); font-size: 40px;">GRES</span>
      <span class="text-gray-600 leading-tight" style="font-size: 14px; max-width: 120px; word-wrap: break-word; line-height: 1.3; padding-left: 4px">
        Grado de esencialidad
      </span>
      <span style="border-left: 2px solid #003366; padding-left: 10px; display: inline-block;">
        <span
          style="color:#003366; font-weight:600; font-size:1.5rem; display:inline-block; cursor:pointer; transition:transform .3s ease;"
          onmouseover="this.style.transform='translateY(-4px)'"
          onmouseout="this.style.transform='translateY(0)'"
          onclick="window.location.href='/{{ $buque->id }}/modulos'">
          {{ $buque->nombre }}
        </span>
      </span>
    </div>
  </x-slot>

  <div class="container py-1 px-6" style="max-width: 100%;">
    <div x-data="{ open: false }" class="flex transition-all duration-300">
      <!-- Panel izquierdo: Lista de sistemas -->
      <div :class="open ? 'w-1/2 mr-4' : 'w-full'" class="bg-white rounded shadow p-6 transition-all duration-300">
        <!-- Toolbar -->
        <div class="mb-4 panel-toolbar">
          <p class="panel-toolbar__text">Lista de sistemas asignados al buque para metodología GRES.</p>

          <div class="panel-toolbar__actions">
            <div class="input-icon">
              <i class="fas fa-search"></i>
              <input type="text" id="search" placeholder="Buscar por código" class="w-64">
              <button id="systems-search-clear" class="input-clear" aria-label="Limpiar búsqueda">&times;</button>
            </div>

            <button id="export-pdf-btn" class="btn btn-primary" type="button">
              <i class="fas fa-file-pdf"></i>
              <span class="hidden sm:inline">Exportar PDF</span>
              <span class="sm:hidden">PDF</span>
            </button>

            <button id="manage-colaboradores-btn" class="btn btn-success" title="Gestionar Colaboradores">
              <i class="fas fa-user-plus"></i>
              <span class="hidden sm:inline">Colab</span>
            </button>

            <button @click="open = false" x-show="open" class="btn btn-ghost arrow-toggle" title="Ocultar Detalles">
              &rsaquo;
            </button>
          </div>
        </div>

        <!-- Tabla de sistemas -->
        <div class="relative overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
              <tr>
                <th class="px-6 py-3 w-20">Código</th>
                <th class="px-6 py-3">Nombre</th>
                <th class="px-6 py-3 w-28">MEC</th>
                <th class="px-6 py-3 w-20 text-center">Acciones</th>
              </tr>
            </thead>
            <tbody id="systems-table-body">
              @foreach ($buque->sistemas as $sistema)
                <tr class="bg-white border-b hover:bg-gray-50" id="system-row-{{ $sistema->id }}">
                  <td class="px-6 py-3">{{ $sistema->codigo }}</td>
                  <td class="px-6 py-3">{{ $sistema->nombre }}</td>
                  <td id="mec-column-{{ $sistema->id }}" class="px-6 py-3">MEC {{ $sistema->mec ?? 'Sin Asignar' }}</td>
                  <td class="px-6 py-3 text-center">
                    <button
                      @click="
                        open = true;
                        loadSystemDetails({{ json_encode($sistema) }});
                      "
                      class="text-blue-500 hover:underline"
                      title="Ver Detalles">
                      <i class="fas fa-pencil-alt"></i>
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <!-- Panel derecho: Información del sistema -->
      <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-x-10"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        class="bg-white rounded shadow p-6 w-1/2 transition-all duration-300"
        style="display: none;">
        <div class="mb-4 border-b border-gray-200 pb-3">
          <h2 class="text-lg font-bold text-[#105dad]">Detalles del Sistema</h2>
          <p class="text-sm text-gray-500">Asignación de MEC y visualización del diagrama</p>
        </div>

        <!-- Grid datos básicos -->
        <div class="grid grid-cols-2 gap-4 mb-6">
          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Código</label>
            <input id="selected-system-code" type="text" disabled class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 text-sm">
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Nombre Sistema</label>
            <input id="selected-system-name" type="text" disabled class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 text-sm">
          </div>
        </div>

        <div class="grid grid-cols-3 gap-6 mb-6">
          <!-- Columna izquierda MEC -->
          <div class="col-span-1">
            <label class="block text-xs font-semibold text-gray-600 mb-1">MEC</label>
            <input id="mec-input" type="text" disabled class="w-44 border border-gray-300 rounded px-3 py-2 bg-gray-100 text-sm">
            <div class="mt-3 space-y-2">
              <button id="assign-mec-btn" class="w-44 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded shadow-sm assign-mec-btn">
                <i class="fas fa-tasks mr-1"></i> Asignar MEC
              </button>
            </div>
          </div>

          <!-- Columna derecha Diagrama -->
          <div class="col-span-2">
            <h3 class="text-xs font-semibold text-gray-600 mb-2">Diagrama de Decisión</h3>
            <div id="diagram-container" class="border border-gray-200 rounded-lg flex items-center justify-center bg-gray-50" style="width:100%; height:auto; max-width:600px;">
              <img src="/images/diagramas/default.webp" alt="Diagrama de decisión" id="diagram-image" class="max-w-full h-auto cursor-pointer">
            </div>
          </div>
        </div>

        <!-- Observaciones -->
        <div>
          <h3 class="text-sm font-semibold text-gray-700 mb-3">Observaciones</h3>
          <div class="relative overflow-x-auto border border-gray-200">
            <table class="w-full text-sm text-left text-gray-600">
              <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                  <th class="px-6 py-3">Pregunta</th>
                  <th class="px-6 py-3">Observación</th>
                </tr>
              </thead>
              <tbody id="observations-table-body">
                <!-- Dinámico -->
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
  // ====== Estado global ======
  window.selectedSystemId = null;
  let pendingMecData = null;
  window.buqueId = {{ $buque->id }};

  // ====== Cargar detalle del sistema ======
  function loadSystemDetails(system){
    window.selectedSystemId = system.id;
    document.getElementById('selected-system-code').value = system.codigo;
    document.getElementById('selected-system-name').value = system.nombre;
    document.getElementById('mec-input').value = 'MEC ' + (system.mec ?? 'Sin Asignar');

    const diagramImage = document.getElementById('diagram-image');
    diagramImage.src = system.diagrama ? system.diagrama : '/images/diagramas/default.webp';
    diagramImage.style.display = 'block';
    diagramImage.style.cursor  = 'pointer';

    const obsTableBody = document.getElementById('observations-table-body');
    obsTableBody.innerHTML = '';
    if (system.observaciones && Array.isArray(system.observaciones)) {
      system.observaciones.forEach(obs => {
        const newRow = `
          <tr>
            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">Pregunta ${obs.pregunta}</td>
            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">${obs.texto}</td>
          </tr>`;
        obsTableBody.insertAdjacentHTML('beforeend', newRow);
      });
    }

    pendingMecData = null;
    const saveMecBtn = document.getElementById('save-mec-btn');
    if (saveMecBtn) saveMecBtn.disabled = true;
  }

  // ====== Overlay imagen ======
  function setupImageOverlay(){
    const overlay = document.getElementById('image-overlay');
    const overlayImage = document.getElementById('overlay-image');
    const diagramContainer = document.getElementById('diagram-container');

    if (diagramContainer){
      diagramContainer.addEventListener('click', (event) => {
        const clickedImage = (event.target.tagName === 'IMG') ? event.target : null;
        if (clickedImage) {
          event.stopPropagation();
          overlayImage.src = clickedImage.src;
          overlay.classList.add('active');
        }
      });
    }

    if (overlay){
      overlay.addEventListener('click', (event) => {
        if (event.target === overlay) {
          overlay.classList.remove('active');
        }
      });
    }
  }

document.addEventListener('DOMContentLoaded', function () {
  // ===== Overlay imagen =====
  setupImageOverlay();

  // ===== Búsqueda por código + botón limpiar =====
  const searchInput = document.getElementById('search');
  const clearBtn    = document.getElementById('systems-search-clear');
  const tableBody   = document.getElementById('systems-table-body');

  function applyFilter(){
    const q = (searchInput?.value || '').trim().toLowerCase();
    const rows = tableBody?.querySelectorAll('tr') || [];
    rows.forEach(row => {
      const codeCell = row.querySelector('td:nth-child(1)');
      const text = (codeCell?.textContent || '').toLowerCase();
      const match = text.includes(q);
      row.style.display = match ? '' : 'none';
    });
    if (clearBtn) clearBtn.classList.toggle('show', !!q);
  }

  if (searchInput){
    searchInput.addEventListener('input', applyFilter);
  }
  if (clearBtn && searchInput){
    clearBtn.addEventListener('click', () => {
      searchInput.value = '';
      applyFilter();
      searchInput.focus();
    });
  }

  // ===== Botón ASIGNAR MEC =====
  const assignMecBtn = document.getElementById('assign-mec-btn');
  if (assignMecBtn){
    assignMecBtn.addEventListener('click', () => {
      if (!window.selectedSystemId) return;
      const mecInput = document.getElementById('mec-input');
      const currentMec = mecInput ? mecInput.value : null;

      if (currentMec && currentMec !== 'MEC Sin Asignar') {
        Swal.fire({
          title: '¿Reasignar MEC?',
          text: 'Este sistema ya tiene un MEC asignado. Si decides asignar un nuevo MEC, se eliminarán todas las observaciones previas y el diagrama actual. ¿Estás seguro?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Sí, estoy seguro',
          cancelButtonText: 'No, cancelar',
          allowOutsideClick: false
        }).then((result) => {
          if (result.isConfirmed) {
            clearSystemObservations(window.selectedSystemId).then(() => startMecQuestions());
          } else {
            Swal.fire('Acción cancelada', 'El MEC actual no se ha modificado.', 'info');
          }
        });
      } else {
        startMecQuestions(); // <<--- ahora abre el modal custom (sin Swal)
      }
    });
  }

  // ===== Guardar MEC =====
  const saveMecBtn = document.getElementById('save-mec-btn');
  if (saveMecBtn){
    saveMecBtn.addEventListener('click', () => {
      if (!pendingMecData) return;
      saveMecDataToDatabase(pendingMecData);
    });
  }

  // ====== MEC RESULT MODAL (setup) ======
  const $resModal   = document.getElementById('mec-result-modal');
  const $resOverlay = $resModal?.querySelector('.mec-modal__overlay');
  const $resCloseX  = document.getElementById('mec-result-close');
  const $resClose   = document.getElementById('mec-result-cancel');
  const $resSave    = document.getElementById('mec-result-save');

  function closeResultModal(){ $resModal.classList.add('hidden'); }
  if ($resCloseX)  $resCloseX.onclick  = closeResultModal;
  if ($resClose)   $resClose.onclick   = closeResultModal;
  if ($resOverlay) $resOverlay.onclick = (e) => { if (e.target.dataset.close === 'true') closeResultModal(); };
  if ($resSave)    $resSave.onclick    = () => {
    if (!pendingMecData) return;
    saveMecDataToDatabase(pendingMecData);
    closeResultModal();
  };

  // expositor para abrir el modal final desde startMecQuestions()
  window.__openResultModal = function({ level, label, desc }){
    const $badge     = document.getElementById('mec-result-badge');
    const $badgeText = document.getElementById('mec-result-badge-text');
    const $desc      = document.getElementById('mec-result-desc');

    $badge.classList.remove('mec-result--1','mec-result--2','mec-result--3','mec-result--4');
    $badge.classList.add(`mec-result--${level}`);

    $badgeText.textContent = `Nivel ${level} · ${label}`;
    $desc.textContent = desc;

    $resModal.classList.remove('hidden');
  };
});

  // ====== Limpiar observaciones en servidor ======
  function clearSystemObservations(systemId){
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    return fetch(`/gres/observations/clear/${systemId}`, {
      method:'DELETE',
      headers:{ 'X-CSRF-TOKEN':token, 'Content-Type':'application/json' }
    })
    .then((response) => {
      if (!response.ok) throw new Error('Error al eliminar las observaciones.');
      const obsTableBody = document.getElementById('observations-table-body');
      if (obsTableBody) obsTableBody.innerHTML = '';
      return Swal.fire({ toast:true, position:'top-end', icon:'success', title:'Observaciones eliminadas', showConfirmButton:false, timer:2000, timerProgressBar:true });
    })
    .catch((error) => {
      console.error('Error al eliminar observaciones:', error);
      return Swal.fire('Error', 'No se pudieron eliminar las observaciones previas.', 'error');
    });
  }

  // ====== Misiones del Buque para popup de ayuda ======
  window.buqueMisiones = @json($buque->misiones->map(function ($mision) {
    return [
      'nombre'      => $mision->nombre,
      'porcentaje'  => $mision->pivot->porcentaje,
      'descripcion' => $mision->pivot->descripcion
    ];
  }));


function startMecQuestions() {
  // ========================== Estado ==========================
  let chain = [];
  let currentQuestion = 1;
  let questionHistory = [1]; // para back

  // ========================== DOM refs ==========================
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

  // ========================== Helpers Obs ==========================
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
    for (const row of rows) {
      const cells = row.querySelectorAll('td');
      if (cells.length >= 2) {
        const pregunta = cells[0].textContent.trim().replace('Pregunta ', '');
        if (String(pregunta) === String(q)) {
          cells[1].textContent = text;
          return;
        }
      }
    }
    obsTableBody.insertAdjacentHTML('beforeend', `
      <tr>
        <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">Pregunta ${q}</td>
        <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">${text}</td>
      </tr>
    `);
  }

  // ========================== Toggle y conteo ==========================
  $obsToggle.onchange = () => {
    if ($obsToggle.checked) {
      $obsWrap.classList.remove('hidden');
      setTimeout(() => $obsInput.focus(), 0);
    } else {
      $obsWrap.classList.add('hidden');
    }
  };

  $obsInput.oninput = () => {
    $count.textContent = `${$obsInput.value.length}/${MAX_CHARS} caracteres`;
    // auto-guardar a la tabla con leve debounce natural
    if ($obsToggle.checked && $obsInput.value.trim().length > 0) {
      upsertObservationRow(currentQuestion, $obsInput.value.trim());
    }
  };

  // ========================== Apertura/cierre ==========================
  function onKeydown(ev) {
    if (ev.key === 'Enter' && document.activeElement === $obsInput) return;
    if (ev.key === 'Enter') { persistObservation(); chain.push(1); proceed(); }
    else if (ev.key === 'Escape') { persistObservation(); chain.push(0); proceed(); }
    else if (ev.key === 'ArrowLeft' && currentQuestion > 1) {
      persistObservation();
      if (chain.length > 0) chain.pop();
      questionHistory.pop();
      currentQuestion = questionHistory[questionHistory.length - 1];
      renderQuestion();
    }
  }

  function openModal() {
    $modal.classList.remove('hidden');
    renderQuestion();
    $obsInput.focus();
    document.addEventListener('keydown', onKeydown);
  }

  function closeModal() {
    document.removeEventListener('keydown', onKeydown);
    $modal.classList.add('hidden');
    $panel.classList.add('hidden');
    $panelContent.innerHTML = '';
  }

  $btnClose.onclick = () => closeModal();
  $overlay.onclick   = (e) => { if (e.target.dataset.close === 'true') closeModal(); };

  // ========================== Render pregunta ==========================
  function persistObservation() {
    if ($obsToggle.checked && $obsInput.value.trim().length > 0) {
      upsertObservationRow(currentQuestion, $obsInput.value.trim());
    }
  }

  function renderQuestion() {
    const { titleHtml, showAB } = getQuestionContent(currentQuestion);

    $title.textContent = 'Pregunta MEC';
    $question.textContent = titleHtml; // texto plano
    const stepText = `Pregunta ${currentQuestion} de 7`;
    $subtitle.textContent = stepText;
    $progress.textContent = stepText;

    $btnYes.textContent = showAB ? 'A' : 'Sí';
    $btnNo.textContent  = showAB ? 'B' : 'No';
    $btnBack.style.visibility = currentQuestion > 1 ? 'visible' : 'hidden';

    // Rellenar obs existente
    const existing = getExistingObservation(currentQuestion);
    $obsInput.value = existing;
    $count.textContent = `${$obsInput.value.length}/${MAX_CHARS} caracteres`;

    // Mostrar/ocultar bloque de obs según haya texto previo
    const hasObs = !!(existing && existing.trim().length > 0);
    $obsToggle.checked = hasObs;
    if (hasObs) $obsWrap.classList.remove('hidden'); else $obsWrap.classList.add('hidden');

    // animación ligera
    [$question, $subtitle, $progress].forEach(($el) => {
      if (!$el) return;
      $el.classList.remove('mec-fade');
      void $el.offsetWidth;
      $el.classList.add('mec-fade');
    });

    // Cerrar panel auxiliar si estaba abierto
    $panel.classList.add('hidden');
    $panelContent.innerHTML = '';
  }

  // ========================== Botones ==========================
  $btnBack.onclick = () => {
    if (currentQuestion <= 1) return;
    persistObservation();
    if (chain.length > 0) chain.pop();
    questionHistory.pop();
    currentQuestion = questionHistory[questionHistory.length - 1];
    renderQuestion();
  };

  $btnYes.onclick = () => { persistObservation(); chain.push(1); proceed(); };
  $btnNo.onclick  = () => { persistObservation(); chain.push(0); proceed(); };

  $btnMisiones.onclick = () => { persistObservation(); showMisionesPanel(); };
  $btnHelp.onclick     = () => { persistObservation(); showHelpPanel(currentQuestion); };

  // ========================== Paneles auxiliares ==========================
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
        <thead><tr><th>Nombre</th><th>%</th><th>Descripción</th></tr></thead>
        <tbody>${rows}</tbody>
      </table>
    `;
    $panel.classList.remove('hidden');
  }

  function showHelpPanel(qNumber) {
    let helpText = '';
    switch (qNumber) {
      case 1: helpText = 'EVALÚE SI LA INDISPONIBILIDAD DEL SISTEMA AFECTA PARCIAL O TOTALMENTE LA FUNCIONALIDAD DE LA UNIDAD.'; break;
      case 2: helpText = 'EVALÚE SI AL QUEDAR INOPERATIVO EL SISTEMA, SE REFLEJA UNA CONSECUENCIA NEGATIVA SOBRE EL PERSONAL, EL SISTEMA O EL MEDIO AMBIENTE.'; break;
      case 3: helpText = 'CONSIDERE QUE EXISTE REDUNDANCIA SI HAY SUB-SISTEMA EN PARALELO CAPAZ DE SUPLIR LA FUNCIÓN.'; break;
      case 4: helpText = 'SI EL SISTEMA INOPERATIVO CAUSA LIMITACIÓN EN ALGUNA MISIÓN, LA RESPUESTA ES SÍ.'; break;
      case 5: helpText = 'SE HABLA DE REDUNDANCIA PASIVA CUANDO SE TIENE UN RELEVO DISPONIBLE EN STANDBY.'; break;
      case 6: helpText = 'CONSIDERE SI EL SUB-SISTEMA DE RELEVO DA EL MISMO RENDIMIENTO DURANTE UN TIEMPO ADECUADO.'; break;
      case 7: helpText = 'PÉRDIDAS MENORES (A) o afectación de más de una misión (B).'; break;
      default: helpText = 'Ayuda no disponible.';
    }
    $panelContent.innerHTML = `
      <div style="font-weight:800; margin-bottom:6px; color:#0f172a;">Ayuda</div>
      <div style="line-height:1.45;">${helpText}</div>
    `;
    $panel.classList.remove('hidden');
  }

  // ========================== Flujo ==========================
  function proceed() {
    const last = chain[chain.length - 1];
    switch (currentQuestion) {
      case 1: if (last===0) finalizeRoute(); else { currentQuestion=2; questionHistory.push(2); renderQuestion(); } break;
      case 2: if (last===0) { currentQuestion=4; questionHistory.push(4); renderQuestion(); } else { currentQuestion=3; questionHistory.push(3); renderQuestion(); } break;
      case 3: if (last===0) finalizeRoute(); else { currentQuestion=4; questionHistory.push(4); renderQuestion(); } break;
      case 4: if (last===0) finalizeRoute(); else { currentQuestion=5; questionHistory.push(5); renderQuestion(); } break;
      case 5: if (last===0) { currentQuestion=7; questionHistory.push(7); renderQuestion(); } else { currentQuestion=6; questionHistory.push(6); renderQuestion(); } break;
      case 6: if (last===0) { currentQuestion=7; questionHistory.push(7); renderQuestion(); } else finalizeRoute(); break;
      case 7: finalizeRoute(); break;
    }
    // cerrar panel al cambiar
    $panel.classList.add('hidden'); $panelContent.innerHTML = '';
  }

  // ========================== Finalización ==========================
  function finalizeRoute() {
    const finalChain = chain.join('');
    let assignedMecNumber = null;

    if (checkMEC4Chain(chain))      assignedMecNumber = '4';
    else if (checkMEC2Chain(chain)) assignedMecNumber = '2';
    else if (checkMEC3Chain(chain)) assignedMecNumber = '3';
    else if (checkMEC1Chain(chain)) assignedMecNumber = '1';
    else { console.error('Ruta inválida:', finalChain); closeModal(); return; }

    // Refleja MEC en UI
    assignMEC(window.selectedSystemId, `MEC ${assignedMecNumber}`);

    // Diagrama
    placeDiagram(finalChain);

    // Observaciones desde la tabla
    const observationsToSave = gatherObservationsFromTable();

    // Payload pendiente
    pendingMecData = {
      systemId: window.selectedSystemId,
      assignedMecNumber,
      chain,
      diagramPath: `/images/diagramas/${finalChain}.webp`,
      observations: observationsToSave
    };

    // Habilita botón Guardar
    const saveMecBtn = document.getElementById('save-mec-btn');
    if (saveMecBtn) saveMecBtn.disabled = false;

    // cierra el modal de preguntas
    closeModal();

    // Mapa de significados
    const map = {
      '1': { label: 'Completamente operativo', desc: 'El sistema se considera completamente operativo según las respuestas dadas.' },
      '2': { label: 'Operación restringida',   desc: 'El sistema presenta limitaciones y su operación es restringida.' },
      '3': { label: 'Pérdida de misión',       desc: 'El sistema ocasiona pérdida de la misión en el contexto evaluado.' },
      '4': { label: 'Riesgo de seguridad',     desc: 'El sistema representa un riesgo de seguridad y debe priorizarse.' }
    };

    if (window.__openResultModal) {
      window.__openResultModal({ level: assignedMecNumber, label: map[assignedMecNumber].label, desc: map[assignedMecNumber].desc });
    }
  }

  // ========================== Reglas cadenas ==========================
  function checkMEC4Chain(c){ return includesChain([[1,1,0]], c); }
  function checkMEC2Chain(c){ return includesChain([[1,1,1,1,0,1],[1,0,1,1,0,1],[1,0,1,0,1],[1,1,1,1,1,0,1]], c); }
  function checkMEC3Chain(c){ return includesChain([[1,0,1,0,0],[1,0,1,1,0,0],[1,1,1,1,0,0],[1,1,1,1,1,0,0]], c); }
  function checkMEC1Chain(c){ return includesChain([[0],[1,0,0],[1,0,1,1,1],[1,1,1,0],[1,1,1,1,1,1]], c); }
  function includesChain(valid, cur){ const s = JSON.stringify(cur); return valid.some(v=> JSON.stringify(v)===s); }

  // ========================== Textos preguntas ==========================
  function getQuestionContent(n){
    let titleHtml='', showAB=false;
    switch(n){
      case 1: titleHtml='¿SE PIERDE CAPACIDAD DE LA UNIDAD SI EL SISTEMA QUEDA INOPERATIVO?'; break;
      case 2: titleHtml='¿REPRESENTA UN EFECTO ADVERSO SOBRE EL PERSONAL, SISTEMA O MEDIO AMBIENTE?'; break;
      case 3: titleHtml='¿EXISTE REDUNDANCIA DENTRO DEL SISTEMA PARA MITIGAR EL EFECTO ADVERSO?'; break;
      case 4: titleHtml='¿CAUSA ALGUNA LIMITACIÓN SOBRE ALGUNA MISIÓN?'; break;
      case 5: titleHtml='¿EXISTEN REDUNDANCIAS DENTRO DEL SISTEMA?'; break;
      case 6: titleHtml='¿MITIGA COMPLETAMENTE EL EFECTO DE LA LIMITACIÓN?'; break;
      case 7: titleHtml='¿QUÉ PÉRDIDAS SERÍAN? (A) Menores o 1 misión - (B) Más de 1 misión'; showAB=true; break;
    }
    return { titleHtml, showAB };
  }

  // ========================== Reusar helpers existentes ==========================
  function placeDiagram(chainString){
    const diagramContainer = document.getElementById('diagram-container');
    if (!diagramContainer) return;
    diagramContainer.innerHTML = `
      <img src="/images/diagramas/${chainString}.webp" alt="Diagrama ${chainString}" class="max-w-full h-auto cursor-pointer" />
    `;
    setupImageOverlay();
  }

  function gatherObservationsFromTable(){
    const obsTableBody = document.getElementById('observations-table-body');
    const rows = obsTableBody.querySelectorAll('tr');
    let arr = [];
    rows.forEach(row=>{
      const cells = row.querySelectorAll('td');
      if (cells.length>=2){
        let pregunta = cells[0].textContent.trim().replace('Pregunta ','');
        let texto = cells[1].textContent.trim();
        arr.push({ pregunta, texto });
      }
    });
    return arr;
  }

  function assignMEC(systemId, mec){
    const mecColumn = document.getElementById(`mec-column-${systemId}`);
    if (mecColumn) mecColumn.textContent = mec;
    const mecInput = document.getElementById('mec-input');
    if (mecInput) mecInput.value = mec;
  }

  // abrir modal
  openModal();
}

  // ====== Guardar en BD ======
  function saveMecDataToDatabase(mecData){
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    Swal.fire({ title:'Guardando...', allowOutsideClick:false, didOpen:()=> Swal.showLoading() });

    fetch('/gres/save', {
      method:'POST',
      headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN':token },
      body: JSON.stringify({
        buque_id: window.buqueId,
        sistema_id: mecData.systemId,
        mec: mecData.assignedMecNumber,
        diagrama: mecData.diagramPath,
        observaciones: mecData.observations
      })
    })
    .then(r=>r.json())
    .then(() => {
      Swal.fire({ icon:'success', title:'¡Guardado exitoso!', text:`Se ha guardado MEC ${mecData.assignedMecNumber} en la base de datos`, confirmButtonText:'Entendido' });
      const saveMecBtn = document.getElementById('save-mec-btn');
      if (saveMecBtn) saveMecBtn.disabled = true;
      pendingMecData = null;
    })
    .catch(err=>{
      console.error('Error:', err);
      Swal.fire({ icon:'error', title:'Error', text:'Hubo un problema al guardar el MEC' });
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
        <h3 id="mec-title" class="mec-title">Pregunta MEC</h3>
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

      <!-- Switch observación -->
      <div class="mec-obs-toggle">
        <span>Agregar observación</span>
        <label class="mec-switch" title="Agregar observación">
          <input id="mec-obs-toggle" type="checkbox">
          <span class="mec-slider"></span>
        </label>
      </div>

      <!-- Observación (oculta al inicio) -->
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
      <button id="mec-no"  class="mec-btn mec-btn--danger">No</button>
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
          El sistema se considera completamente operativo según las respuestas dadas.
        </div>
      </div>
    </div>

    <div class="mec-modal__footer">
      <button id="mec-result-save"   class="mec-btn mec-btn--primary">Guardar resultado</button>
      <button id="mec-result-cancel" class="mec-btn mec-btn--ghost">Cerrar</button>
    </div>
  </div>
</div>
<!-- =================== /MEC RESULT MODAL =================== -->

</body>
</html>
