document.addEventListener('DOMContentLoaded', function () {
    // Manejo del formulario de edición
    const form = document.getElementById('editar-repuesto-form');
    if (form) {
        const repuestoId = form.getAttribute('data-repuesto-id');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);

            // Confirmación con SweetAlert2 antes de actualizar
            Swal.fire({
                title: '¿Deseas guardar los cambios?',
                text: 'El repuesto será actualizado con la información ingresada.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/api/repuesto/' + repuestoId, {
                        method: 'POST', // Usamos POST para la actualización
                        body: formData,
                    })
                        .then((response) => response.json())
                        .then((result) => {
                            if (result.message) {
                                Swal.fire({
                                    title: 'Actualizado',
                                    text: result.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                }).then(() => {
                                    redirigirSegunURLAnterior();
                                });
                            } else {
                                Swal.fire('Error', 'Error al actualizar repuesto', 'error');
                            }
                        })
                        .catch((error) => {
                            console.error('Error al actualizar repuesto:', error);
                            Swal.fire('Error', 'Error al actualizar repuesto: ' + error.message, 'error');
                        });
                }
            });
        });
    }

    // Manejo del botón Editar
    const editButtons = document.querySelectorAll('.btn-editar');
    editButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            const repuestoId = this.getAttribute('data-id');
            const idEquipoInfo = this.getAttribute('data-id-equipo-info');

            // Confirmación con SweetAlert2 antes de editar
            Swal.fire({
                title: '¿Deseas editar este repuesto?',
                text: 'Serás redirigido a la página de edición.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, editar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/LSA/editar-repuesto/${repuestoId}?id_equipo_info=${idEquipoInfo}`;
                }
            });
        });
    });

    // Manejo del botón Eliminar
    const deleteButtons = document.querySelectorAll('.btn-eliminar');
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            const repuestoId = this.getAttribute('data-id');
            const idEquipoInfo = this.getAttribute('data-id-equipo-info');

            // Confirmación con SweetAlert2 antes de eliminar
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/repuesto/${repuestoId}?id_equipo_info=${idEquipoInfo}`, {
                        method: 'DELETE',
                    })
                        .then((response) => response.json())
                        .then((result) => {
                            if (result.message) {
                                Swal.fire({
                                    title: 'Eliminado',
                                    text: result.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                }).then(() => {
                                    button.closest('tr').remove();
                                });
                            } else {
                                Swal.fire('Error', 'Error al eliminar repuesto', 'error');
                            }
                        })
                        .catch((error) => {
                            console.error('Error al eliminar repuesto:', error);
                            Swal.fire('Error', 'Error al eliminar repuesto: ' + error.message, 'error');
                        });
                }
            });
        });
    });

    // Función redirigir según URL anterior
    function redirigirSegunURLAnterior() {
        const urlAnterior = document.referrer; // URL previa
        const idEquipoInfo = document.getElementById('id_equipo_info')?.value;

        if (!idEquipoInfo) {
            Swal.fire({
                title: 'Error',
                text: 'El ID del equipo no está disponible. Por favor, verifica.',
                icon: 'warning',
                confirmButtonText: 'OK',
            });
            window.location.href = '/LSA';
            return;
        }

        if (urlAnterior.includes('/LSA/mostrar-repuesto-ext')) {
            window.location.href = `/LSA/mostrar-repuesto-ext?id_equipo_info=${idEquipoInfo}`;
        } else {
            window.location.href = `/LSA/mostrar-repuesto`;
        }
    }
});
