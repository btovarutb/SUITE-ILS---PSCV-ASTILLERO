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
    // Cargar colaboradores desde el servidor
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
                width: '800px',
                showCancelButton: false,
                showConfirmButton: false,
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
 * Renderiza el contenido del modal con la tabla de colaboradores.
 * @param {Array} colaboradores - Lista de colaboradores
 * @returns {string} - HTML del modal
 */
function renderEquiposColabModalContent(colaboradores) {
    const rows = colaboradores.map(colab => `
        <tr>
            <td class="border px-4 py-2">${colab.cargo}</td>
            <td class="border px-4 py-2">${colab.nombre}</td>
            <td class="border px-4 py-2">${colab.apellido}</td>
            <td class="border px-4 py-2">${colab.entidad}</td>
            <td class="border px-4 py-2 text-center">
                <button class="edit-equipo-colab-btn bg-blue-500 text-white px-3 py-1 rounded" data-id="${colab.id}">Editar</button>
                <button class="delete-equipo-colab-btn bg-red-500 text-white px-3 py-1 rounded" data-id="${colab.id}">Eliminar</button>
            </td>
        </tr>
    `).join('');

    return `
        <div>
            <button id="add-equipo-colab-btn" class="bg-green-500 text-white px-4 py-2 rounded mb-4">Añadir Nuevo Colaborador</button>
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2">Cargo</th>
                        <th class="border px-4 py-2">Nombre</th>
                        <th class="border px-4 py-2">Apellido</th>
                        <th class="border px-4 py-2">Entidad</th>
                        <th class="border px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="equipos-colab-table-body">
                    ${rows}
                </tbody>
            </table>
        </div>
    `;
}

/**
 * Configura los eventos de los botones del modal.
 * @param {Number} buqueId - ID del buque actual
 */
function setupEquiposColabModalActions(buqueId) {
    const addColabBtn = document.getElementById('add-equipo-colab-btn');
    const tableBody = document.getElementById('equipos-colab-table-body');

    // Añadir colaborador
    if (addColabBtn) {
        addColabBtn.addEventListener('click', () => {
            openEquipoColabForm(buqueId, null);
        });
    }

    // Editar colaborador
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

/**
 * Abre el formulario para crear o editar un colaborador de equipos.
 * @param {Number} buqueId - ID del buque actual
 * @param {Number|null} colabId - ID del colaborador (null si es nuevo)
 */
function openEquipoColabForm(buqueId, colabId) {
    const isEditing = colabId !== null;

    // Obtener datos del colaborador si es edición
    const fetchColab = isEditing
        ? fetch(`/gres/equipos/colaboradores/${buqueId}/${colabId}`).then(res => res.json())
        : Promise.resolve({});

    fetchColab.then(colab => {
        const { cargo = '', nombre = '', apellido = '', entidad = '' } = colab;

        Swal.fire({
            title: isEditing ? 'Editar Colaborador' : 'Añadir Nuevo Colaborador',
            html: `
                <div class="space-y-4">
                    <input type="text" id="colab-cargo" placeholder="Cargo" value="${cargo}" class="swal2-input">
                    <input type="text" id="colab-nombre" placeholder="Nombre" value="${nombre}" class="swal2-input">
                    <input type="text" id="colab-apellido" placeholder="Apellido" value="${apellido}" class="swal2-input">
                    <input type="text" id="colab-entidad" placeholder="Entidad" value="${entidad}" class="swal2-input">
                </div>
            `,
            confirmButtonText: isEditing ? 'Guardar Cambios' : 'Añadir Colaborador',
            preConfirm: () => {
                return {
                    cargo: document.getElementById('colab-cargo').value,
                    nombre: document.getElementById('colab-nombre').value,
                    apellido: document.getElementById('colab-apellido').value,
                    entidad: document.getElementById('colab-entidad').value
                };
            }
        }).then(result => {
            if (result.isConfirmed) {
                const endpoint = isEditing
                    ? `/gres/equipos/colaboradores/${colabId}` // Editar colaborador
                    : `/gres/equipos/colaboradores`;           // Crear colaborador

                const method = isEditing ? 'PUT' : 'POST';

                fetch(endpoint, {
                    method: method,
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
                    .then(data => {
                        Swal.fire('Éxito', isEditing ? 'Colaborador actualizado correctamente.' : 'Colaborador añadido correctamente.', 'success');
                        openEquiposColabModal(buqueId); // Recargar la lista
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
        cancelButtonText: 'Cancelar'
    }).then(result => {
        if (result.isConfirmed) {
            fetch(`/gres/equipos/colaboradores/${colabId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al eliminar el colaborador');
                    }
                    openEquiposColabModal(buqueId); // Recargar la lista
                })
                .catch(() => {
                    Swal.fire('Error', 'No se pudo eliminar el colaborador.', 'error');
                });
        }
    });
} 