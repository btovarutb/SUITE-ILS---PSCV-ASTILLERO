document.addEventListener('DOMContentLoaded', function() {
    // Manejo del botón Editar
    const editButtons = document.querySelectorAll('.btn-editar');
    editButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir la redirección por defecto

            const repuestoId = this.getAttribute('data-id');
            const idEquipoInfo = this.getAttribute('data-id-equipo-info');

            // Confirmación con SweetAlert2 antes de editar
            Swal.fire({
                title: '¿Deseas editar este repuesto?',
                text: "Serás redirigido a la página de edición.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, editar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirigir a la página de edición incluyendo id_equipo_info en la URL
                    window.location.href = `/LSA/editar-repuesto/${repuestoId}?id_equipo_info=${idEquipoInfo}`;
                }
            });
        });
    });

    // Manejo del botón Eliminar
    const deleteButtons = document.querySelectorAll('.btn-eliminar');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir el envío del formulario

            const repuestoId = this.getAttribute('data-id');
            const idEquipoInfo = this.getAttribute('data-id-equipo-info');

            // Confirmación con SweetAlert2 antes de eliminar
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Petición de eliminación con Fetch API
                    fetch(`/api/repuesto/${repuestoId}?id_equipo_info=${idEquipoInfo}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.message) {
                            // Alerta de éxito con SweetAlert2
                            Swal.fire({
                                title: 'Eliminado',
                                text: result.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Remover la fila de la tabla
                                button.closest('tr').remove();
                            });
                        } else {
                            // Alerta de error con SweetAlert2
                            Swal.fire('Error', 'Error al eliminar repuesto', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error al eliminar repuesto:', error);
                        // Alerta de error en caso de excepción
                        Swal.fire('Error', 'Error al eliminar repuesto: ' + error.message, 'error');
                    });
                }
            });
        });
    });    
});