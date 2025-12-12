document.addEventListener('DOMContentLoaded', function () {
  const manageEquiposColabBtn = document.getElementById('manage-equipos-colab-btn');

  if (manageEquiposColabBtn) {
    manageEquiposColabBtn.addEventListener('click', () => {
      openEquiposColabModal(window.buqueId);
    });
  }
});

/**
 * Abre el modal para gestionar colaboradores de equipos del buque.
 * @param {Number} buqueId - ID del buque actual
 */
function openEquiposColabModal(buqueId) {
  fetch(`/gres/equipos/colaboradores/${buqueId}`)
    .then(response => {
      if (!response.ok) {
        throw new Error('Error al cargar colaboradores');
      }
      return response.json();
    })
    .then(data => {
      const colaboradores = data.colaboradores || [];
      const modalContent = renderEquiposColabModalContent(colaboradores);

        Swal.fire({
            title: 'Gestionar Colaboradores de Equipos',
            html: modalContent,
            width: '900px',
            showCancelButton: false,
            showConfirmButton: false,
            focusConfirm: false,
            backdrop: true,
            customClass: {
                popup: 'colab-modal'   // 👈 scope CSS solo para estos modales
            },
            didOpen: () => {
                setupEquiposColabModalActions(buqueId);
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
 * @param {Array} colaboradores - Lista de colaboradores
 * @returns {string} - HTML del modal
 */
function renderEquiposColabModalContent(colaboradores) {
  const count = colaboradores.length;

  const rows = colaboradores.map(colab => `
    <tr class="bg-white border-b hover:bg-gray-50" data-row>
      <td class="px-6 py-3">${escapeHtml(colab.cargo ?? '')}</td>
      <td class="px-6 py-3">${escapeHtml(colab.nombre ?? '')}</td>
      <td class="px-6 py-3">${escapeHtml(colab.apellido ?? '')}</td>
      <td class="px-6 py-3">${escapeHtml(colab.entidad ?? '')}</td>
      <td class="px-6 py-3 text-center">
        <div class="inline-flex gap-2">
          <button class="edit-equipo-colab-btn inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200"
                  data-id="${colab.id}">
            <i class="fas fa-edit mr-1"></i> Editar
          </button>
          <button class="delete-equipo-colab-btn inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md bg-red-50 text-red-700 hover:bg-red-100 border border-red-200"
                  data-id="${colab.id}">
            <i class="fas fa-trash-alt mr-1"></i> Eliminar
          </button>
        </div>
      </td>
    </tr>
  `).join('');

  const emptyRow = `
    <tr>
      <td colspan="5" class="px-6 py-8 text-center text-gray-500">
        No hay colaboradores registrados. <span class="hidden sm:inline">Haz clic en “Añadir nuevo”.</span>
      </td>
    </tr>
  `;

  return `
    <div class="space-y-4">
      <!-- Toolbar -->
      <div class="flex items-center justify-between gap-2 flex-wrap">
        <div class="text-sm text-gray-600">
          Total: <span id="colab-count" class="font-semibold text-gray-800">${count}</span>
        </div>
        <div class="flex items-center gap-2">
          <div class="input-icon" style="width: 390px; max-width: 100%;">
            <i class="fas fa-search"></i>
            <input
                id="colab-search"
                type="text"
                placeholder="Buscar por cargo, nombre, apellido o entidad"
                class="w-full"
            >
            <button id="colab-clear" type="button" class="input-clear" aria-label="Limpiar búsqueda">&times;</button>
          </div>

          <button id="add-equipo-colab-btn"
                  class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold px-3 py-2 rounded">
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
          <tbody id="equipos-colab-table-body">
            ${rows || emptyRow}
          </tbody>
        </table>
      </div>
    </div>
  `;
}

/**
 * Configura los eventos del modal (añadir, editar, eliminar, buscar).
 * @param {Number} buqueId - ID del buque actual
 */
function setupEquiposColabModalActions(buqueId) {
  const container = Swal.getHtmlContainer();
  if (!container) return;

  const addColabBtn = container.querySelector('#add-equipo-colab-btn');
  const tableBody   = container.querySelector('#equipos-colab-table-body');
  const searchInput = container.querySelector('#colab-search');
  const countEl     = container.querySelector('#colab-count');

  // Añadir colaborador
  if (addColabBtn) {
    addColabBtn.addEventListener('click', () => openEquipoColabForm(buqueId, null));
  }

  // Editar colaborador
  if (tableBody) {
    tableBody.querySelectorAll('.edit-equipo-colab-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const colabId = btn.getAttribute('data-id');
        openEquipoColabForm(buqueId, colabId);
      });
    });

    // Eliminar colaborador
    tableBody.querySelectorAll('.delete-equipo-colab-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const colabId = btn.getAttribute('data-id');
        deleteEquipoColab(colabId, buqueId);
      });
    });
  }

  // Búsqueda en vivo
  if (searchInput && tableBody) {
    searchInput.addEventListener('input', () => {
      const q = searchInput.value.trim().toLowerCase();
      let visibles = 0;
      tableBody.querySelectorAll('tr[data-row], tr').forEach(tr => {
        // si es fila de "vacío", la ocultamos al escribir
        if (!tr.hasAttribute('data-row')) {
          tr.style.display = q ? 'none' : '';
          return;
        }
        const text = tr.textContent.toLowerCase();
        const match = text.includes(q);
        tr.style.display = match ? '' : 'none';
        if (match) visibles++;
      });

      // Si no hay visibles, mostramos fila vacía
      const hasVisible = visibles > 0;
      let emptyRow = tableBody.querySelector('[data-empty-row]');
      if (!hasVisible) {
        if (!emptyRow) {
          tableBody.insertAdjacentHTML('beforeend', `
            <tr data-empty-row>
              <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                No se encontraron resultados.
              </td>
            </tr>
          `);
        }
      } else if (emptyRow) {
        emptyRow.remove();
      }

      if (countEl) countEl.textContent = visibles;
    });
  }
}

/**
 * Abre el formulario para crear o editar un colaborador de equipos.
 * @param {Number} buqueId - ID del buque actual
 * @param {Number|null} colabId - ID del colaborador (null si es nuevo)
 */
function openEquipoColabForm(buqueId, colabId) {
  const isEditing = colabId !== null;

  const fetchColab = isEditing
    ? fetch(`/gres/equipos/colaboradores/${buqueId}/${colabId}`).then(res => res.json())
    : Promise.resolve({});

  fetchColab.then(colab => {
    const { cargo = '', nombre = '', apellido = '', entidad = '' } = colab || {};

    Swal.fire({
        title: isEditing ? 'Editar Colaborador' : 'Añadir Nuevo Colaborador',
        width: 980,                              // 👈 Más ancho
        html: `
            <div class="cm-wrap">
            <div class="cm-grid">
                <div class="cm-field">
                <label for="colab-cargo" class="cm-label">Cargo</label>
                <input type="text" id="colab-cargo" placeholder="Cargo" value="${escapeAttr(cargo)}" class="cm-input" autocomplete="off">
                </div>

                <div class="cm-field">
                <label for="colab-nombre" class="cm-label">Nombre</label>
                <input type="text" id="colab-nombre" placeholder="Nombre" value="${escapeAttr(nombre)}" class="cm-input" autocomplete="off">
                </div>

                <div class="cm-field">
                <label for="colab-apellido" class="cm-label">Apellido</label>
                <input type="text" id="colab-apellido" placeholder="Apellido" value="${escapeAttr(apellido)}" class="cm-input" autocomplete="off">
                </div>

                <div class="cm-field">
                <label for="colab-entidad" class="cm-label">Entidad</label>
                <input type="text" id="colab-entidad" placeholder="Entidad" value="${escapeAttr(entidad)}" class="cm-input" autocomplete="off">
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
            popup: 'colab-modal'   // 👈 scope para los estilos de este modal
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

            // Enviar con Enter desde cualquier input
            const inputs = Swal.getHtmlContainer().querySelectorAll('.cm-input');
            inputs.forEach(inp => {
            inp.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') Swal.clickConfirm();
            });
            });
        }
    });
  });
}

/**
 * Elimina un colaborador de equipos y recarga la lista.
 * @param {Number} colabId - ID del colaborador
 * @param {Number} buqueId - ID del buque actual
 */
function deleteEquipoColab(colabId, buqueId) {
  Swal.fire({
    title: '¿Eliminar Colaborador?',
    text: 'Esta acción no se puede deshacer.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#dc2626',
    cancelButtonColor: '#6b7280'
  }).then(result => {
    if (result.isConfirmed) {
      fetch(`/gres/equipos/colaboradores/${colabId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
      })
        .then(response => {
          if (!response.ok) throw new Error('Error al eliminar el colaborador');
          openEquiposColabModal(buqueId); // Recargar la lista
        })
        .catch(() => {
          Swal.fire('Error', 'No se pudo eliminar el colaborador.', 'error');
        });
    }
  });
}

/* ===== Utilidades pequeñas para evitar XSS en HTML embebido ===== */
function escapeHtml(str) {
  return String(str ?? '').replace(/[&<>"']/g, s => (
    { '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;' }[s]
  ));
}
function escapeAttr(str) {
  // Atributo HTML (value="")
  return String(str ?? '').replace(/"/g, '&quot;');
}
