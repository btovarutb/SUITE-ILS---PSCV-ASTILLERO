document.addEventListener('DOMContentLoaded', function () {
  const manageColaboradoresBtn = document.getElementById('manage-colaboradores-btn');
  if (manageColaboradoresBtn) {
    manageColaboradoresBtn.addEventListener('click', () => {
      openColaboradoresModal(window.buqueId);
    });
  }
});

/**
 * Abre el modal para gestionar colaboradores del buque.
 * @param {Number} buqueId - ID del buque actual
 */
function openColaboradoresModal(buqueId) {
  fetch(`/gres/colaboradores/${buqueId}`)
    .then(response => {
      if (!response.ok) {
        throw new Error('Error al cargar colaboradores');
      }
      return response.json();
    })
    .then(data => {
      const colaboradores = data.colaboradores || [];
      const modalContent = renderColaboradoresModalContent(colaboradores);
      Swal.fire({
        title: 'Gestionar Colaboradores',
        html: modalContent,
        width: '900px',
        showCancelButton: false,
        showConfirmButton: false,
        focusConfirm: false,
        backdrop: true,
        customClass: {
          popup: 'colab-modal' // ⚠️ para estilos scoped del título/campos
        },
        didOpen: () => {
          setupColaboradoresModalActions(buqueId);
        }
      });
    })
    .catch(error => {
      console.error('Error al cargar colaboradores:', error);
      Swal.fire('Error', 'No se pudo cargar la lista de colaboradores.', 'error');
    });
}

/**
 * Renderiza el contenido del modal con la tabla de colaboradores (estilo limpio tipo Tabler).
 * @param {Array} colaboradores
 * @returns {string}
 */
function renderColaboradoresModalContent(colaboradores) {
  const count = colaboradores.length;

  const rows = colaboradores.map(colab => `
    <tr class="bg-white border-b hover:bg-gray-50" data-row>
      <td class="px-6 py-3">${escapeHtml(colab.cargo ?? '')}</td>
      <td class="px-6 py-3">${escapeHtml(colab.nombre ?? '')}</td>
      <td class="px-6 py-3">${escapeHtml(colab.apellido ?? '')}</td>
      <td class="px-6 py-3">${escapeHtml(colab.entidad ?? '')}</td>
      <td class="px-6 py-3 text-center">
        <div class="inline-flex gap-2">
          <button class="edit-colab-btn inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200"
                  data-id="${colab.id}">
            <i class="fas fa-edit mr-1"></i> Editar
          </button>
          <button class="delete-colab-btn inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md bg-red-50 text-red-700 hover:bg-red-100 border border-red-200"
                  data-id="${colab.id}">
            <i class="fas fa-trash-alt mr-1"></i> Eliminar
          </button>
        </div>
      </td>
    </tr>
  `).join('');

  const emptyRow = `
    <tr data-empty-row>
      <td colspan="5" class="px-6 py-8 text-center text-gray-500">
        No hay colaboradores registrados. <span class="hidden sm:inline">Haz clic en “Añadir nuevo”.</span>
      </td>
    </tr>
  `;

  return `
    <div class="space-y-4">
      <!-- Toolbar -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="text-sm text-gray-600">
          Total: <span id="colab2-count" class="font-semibold text-gray-800">${count}</span>
        </div>
        <div class="flex items-center gap-2">
          <div class="input-icon">
            <i class="fas fa-search"></i>
            <input id="colab2-search" type="text" placeholder="Buscar por cargo, nombre, apellido o entidad" class="w-64">
            <button id="colab2-search-clear" class="input-clear" aria-label="Limpiar búsqueda">&times;</button>
          </div>
          <button id="add-colab-btn" class="btn btn-success">
            <i class="fas fa-user-plus"></i>
            <span class="hidden sm:inline">Añadir nuevo</span>
          </button>
        </div>
      </div>

      <!-- Tabla -->
      <div class="relative overflow-x-auto border border-gray-200 rounded-lg">
        <table class="w-full text-sm text-left text-gray-600">
          <thead class="text-xs uppercase bg-gray-200 text-gray-700">
            <tr>
              <th scope="col" class="px-6 py-3">Cargo</th>
              <th scope="col" class="px-6 py-3">Nombre</th>
              <th scope="col" class="px-6 py-3">Apellido</th>
              <th scope="col" class="px-6 py-3">Entidad</th>
              <th scope="col" class="px-6 py-3 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody id="colaboradores-table-body">
            ${rows || emptyRow}
          </tbody>
        </table>
      </div>
    </div>
  `;
}

/**
 * Configura los eventos del modal (añadir, editar, eliminar, buscar).
 * @param {Number} buqueId
 */
function setupColaboradoresModalActions(buqueId) {
  const container  = Swal.getHtmlContainer();
  if (!container) return;

  const addColabBtn = container.querySelector('#add-colab-btn');
  const tableBody   = container.querySelector('#colaboradores-table-body');
  const searchInput = container.querySelector('#colab2-search');
  const clearBtn    = container.querySelector('#colab2-search-clear');
  const countEl     = container.querySelector('#colab2-count');

  // Añadir colaborador
  if (addColabBtn) {
    addColabBtn.addEventListener('click', () => openColaboradorForm(buqueId, null));
  }

  // Delegación para Editar/Eliminar (soporta refrescos del DOM)
  if (tableBody) {
    tableBody.addEventListener('click', (e) => {
      const editBtn = e.target.closest('.edit-colab-btn');
      const delBtn  = e.target.closest('.delete-colab-btn');
      if (editBtn) {
        const colabId = editBtn.getAttribute('data-id');
        openColaboradorForm(buqueId, colabId);
      } else if (delBtn) {
        const colabId = delBtn.getAttribute('data-id');
        deleteColaborador(colabId, buqueId);
      }
    });
  }

  // Buscar / filtrar
  function applyFilter() {
    const q = (searchInput?.value || '').trim().toLowerCase();
    let visibles = 0;

    if (!tableBody) return;

    // Oculta fila "vacía" previa si existe
    const prevEmpty = tableBody.querySelector('[data-empty-row]');
    if (prevEmpty) prevEmpty.remove();

    tableBody.querySelectorAll('tr[data-row]').forEach(tr => {
      const text = tr.textContent.toLowerCase();
      const match = text.includes(q);
      tr.style.display = match ? '' : 'none';
      if (match) visibles++;
    });

    if (visibles === 0) {
      tableBody.insertAdjacentHTML('beforeend', `
        <tr data-empty-row>
          <td colspan="5" class="px-6 py-8 text-center text-gray-500">
            No se encontraron resultados.
          </td>
        </tr>
      `);
    }

    if (countEl) countEl.textContent = visibles;
    if (clearBtn) clearBtn.classList.toggle('show', !!q);
  }

  if (searchInput) {
    searchInput.addEventListener('input', applyFilter);
  }
  if (clearBtn && searchInput) {
    clearBtn.addEventListener('click', () => {
      searchInput.value = '';
      applyFilter();
      searchInput.focus();
    });
  }
}

/**
 * Abre el formulario para crear o editar un colaborador.
 * @param {Number} buqueId
 * @param {Number|null} colabId
 */
function openColaboradorForm(buqueId, colabId) {
  const isEditing = colabId !== null;

  const fetchColab = isEditing
    ? fetch(`/gres/colaboradores/${buqueId}/${colabId}`).then(res => res.json())
    : Promise.resolve({});

  fetchColab.then(colab => {
    const { cargo = '', nombre = '', apellido = '', entidad = '' } = colab || {};

    Swal.fire({
      title: isEditing ? 'Editar Colaborador' : 'Añadir Nuevo Colaborador',
      width: 700,
      html: `
        <div class="cm-wrap">
          <div class="cm-grid">
            <div class="cm-field">
              <label class="cm-label">Cargo</label>
              <input type="text" id="colab-cargo" placeholder="Cargo" value="${escapeAttr(cargo)}" class="cm-input">
            </div>
            <div class="cm-field">
              <label class="cm-label">Nombre</label>
              <input type="text" id="colab-nombre" placeholder="Nombre" value="${escapeAttr(nombre)}" class="cm-input">
            </div>
            <div class="cm-field">
              <label class="cm-label">Apellido</label>
              <input type="text" id="colab-apellido" placeholder="Apellido" value="${escapeAttr(apellido)}" class="cm-input">
            </div>
            <div class="cm-field">
              <label class="cm-label">Entidad</label>
              <input type="text" id="colab-entidad" placeholder="Entidad" value="${escapeAttr(entidad)}" class="cm-input">
            </div>
          </div>
        </div>
      `,
      showCancelButton: true,
      cancelButtonText: 'Cancelar',
      confirmButtonText: isEditing ? 'Guardar Cambios' : 'Añadir Colaborador',
      confirmButtonColor: '#105dad',
      focusConfirm: false,
      customClass: {
        popup: 'colab-modal' // ⚠️ mismo scope visual que el modal de lista
      },
      preConfirm: () => {
        const cargoVal    = document.getElementById('colab-cargo').value.trim();
        const nombreVal   = document.getElementById('colab-nombre').value.trim();
        const apellidoVal = document.getElementById('colab-apellido').value.trim();
        const entidadVal  = document.getElementById('colab-entidad').value.trim();

        if (!cargoVal || !nombreVal || !apellidoVal || !entidadVal) {
          Swal.showValidationMessage('Completa todos los campos.');
          return false;
        }
        return { cargo: cargoVal, nombre: nombreVal, apellido: apellidoVal, entidad: entidadVal };
      },
      didOpen: () => {
        const first = document.getElementById('colab-cargo');
        if (first) first.focus();
      }
    }).then(result => {
      if (result.isConfirmed) {
        const endpoint = isEditing
          ? `/gres/colaboradores/${colabId}`   // Editar
          : `/gres/colaboradores`;             // Crear
        const method = isEditing ? 'PUT' : 'POST';

        fetch(endpoint, {
          method,
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          },
          body: JSON.stringify({ buque_id: buqueId, ...result.value })
        })
          .then(response => {
            if (!response.ok) {
              return response.json().then(err => {
                throw new Error(err.message || 'Error desconocido al guardar colaborador.');
              });
            }
            return response.json();
          })
          .then(() => {
            Swal.fire('Éxito', isEditing ? 'Colaborador actualizado correctamente.' : 'Colaborador añadido correctamente.', 'success');
            openColaboradoresModal(buqueId); // Recargar la lista
          })
          .catch(error => {
            console.error('Error al guardar colaborador:', error);
            Swal.fire('Error', 'No se pudo guardar el colaborador.', 'error');
          });
      }
    });
  });
}

/**
 * Elimina un colaborador y recarga la lista.
 * @param {Number} colabId
 * @param {Number} buqueId
 */
function deleteColaborador(colabId, buqueId) {
  Swal.fire({
    title: '¿Eliminar Colaborador?',
    text: 'Esta acción no se puede deshacer.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#dc2626',
    cancelButtonColor: '#6b7280',
    customClass: { popup: 'colab-modal' }
  }).then(result => {
    if (result.isConfirmed) {
      fetch(`/gres/colaboradores/${colabId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
      })
        .then(response => {
          if (!response.ok) throw new Error('Error al eliminar el colaborador');
          openColaboradoresModal(buqueId); // Recargar la lista
        })
        .catch(() => {
          Swal.fire('Error', 'No se pudo eliminar el colaborador.', 'error');
        });
    }
  });
}

/* ======================= Utilidades para evitar XSS ======================= */
function escapeHtml(str) {
  return String(str ?? '').replace(/[&<>"']/g, s => (
    { '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;' }[s]
  ));
}
function escapeAttr(str) {
  return String(str ?? '').replace(/"/g, '&quot;');
}

/* ======================= Export GRES a PDF (se mantiene) ======================= */
document.addEventListener('DOMContentLoaded', function () {
  const exportPdfBtn = document.getElementById('export-pdf-btn');
  if (exportPdfBtn) {
    exportPdfBtn.addEventListener('click', () => {
      exportGresPdf(window.buqueId);
    });
  }
});

function exportGresPdf(buqueId) {
  const loadingMessages = [
    "Acoplando Sistemas",
    "Insertando diagramas correspondientes",
    "Insertando MEC por Sistemas",
    "Añadiendo Observaciones escritas por el usuario"
  ];

  let currentMessageIndex = 0;
  let messageInterval;

  const swalContent = document.createElement('div');
  swalContent.innerHTML = `
    <div class="loading-container">
      <div id="loading-message"
           style="opacity:0; transition:opacity .5s, transform .5s; transform:translateX(-20px); margin-top:10px;">
      </div>
    </div>
  `;

  function updateLoadingMessage() {
    const messageElement = document.getElementById('loading-message');
    if (!messageElement) return;
    messageElement.style.opacity = '0';
    messageElement.style.transform = 'translateX(20px)';
    setTimeout(() => {
      messageElement.textContent = loadingMessages[currentMessageIndex];
      messageElement.style.transform = 'translateX(-20px)';
      messageElement.offsetHeight; // reflow
      messageElement.style.opacity = '1';
      messageElement.style.transform = 'translateX(0)';
      currentMessageIndex = (currentMessageIndex + 1) % loadingMessages.length;
    }, 500);
  }

  Swal.fire({
    title: 'Generando PDF',
    html: swalContent,
    didOpen: () => {
      Swal.showLoading();
      updateLoadingMessage();
      messageInterval = setInterval(updateLoadingMessage, 10000);
    },
    willClose: () => clearInterval(messageInterval),
    allowOutsideClick: false
  });

  fetch(`/gres/colaboradores/${buqueId}`)
    .then(res => {
      if (!res.ok) {
        throw new Error(`Error al obtener colaboradores: ${res.status}`);
      }
      return res.json();
    })
    .then(colaboradoresData => {
      const formData = new FormData();
      formData.append('colaboradores', JSON.stringify(colaboradoresData.colaboradores));
      formData.append('buque_id', buqueId);
      return fetch('/gres/export-pdf', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
      });
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Error al generar el PDF');
      }
      return response.blob();
    })
    .then(blob => {
      Swal.close();
      const pdfUrl = URL.createObjectURL(blob);
      window.open(pdfUrl, '_blank');
    })
    .catch(error => {
      console.error('Error:', error);
      Swal.fire({ icon: 'error', title: 'Error', text: error.message });
    });
}
