document.addEventListener('DOMContentLoaded', function() {
    // Manejo del botón Editar en la sección de análisis de herramientas
    const editButtonsAnalisis = document.querySelectorAll('.btn-editar-analisis');
    editButtonsAnalisis.forEach(function(button) {
        button.addEventListener('click', function() {
            // Confirmación de SweetAlert2 antes de editar
            const idAnalisis = button.getAttribute('data-id');
            const idEquipoInfo = button.getAttribute('data-equipo-info-id');
            Swal.fire({
                title: '¿Deseas editar esta herramienta?',
                text: "Serás redirigido a la página de edición.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, editar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/LSA/editar-analisis-herramienta/${idAnalisis}?id_equipo_info=${idEquipoInfo}`;
                }
            });
        });
    });

    // Manejo del botón Eliminar en la sección de análisis de herramientas
    const deleteButtonsAnalisis = document.querySelectorAll('.btn-eliminar-analisis');
    deleteButtonsAnalisis.forEach(function(button) {
        button.addEventListener('click', function() {
            const herramientaId = this.getAttribute('data-id');
            
            // Confirmación de SweetAlert2 antes de eliminar
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
                    fetch('/api/analisis-herramientas/' + herramientaId, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.message) {
                            Swal.fire('Eliminado', result.message, 'success');
                            this.closest('tr').remove();
                        } else {
                            Swal.fire('Error', 'Error al eliminar herramienta', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error al eliminar herramienta:', error);
                        Swal.fire('Error', 'Error al eliminar herramienta: ' + error.message, 'error');
                    });
                }
            });
        });
    });

    // Manejo del botón Editar en la sección de herramientas especiales
    const editButtonsEspecial = document.querySelectorAll('.btn-editar');
    editButtonsEspecial.forEach(function(button) {
        button.addEventListener('click', function() {
            const herramientaId = this.getAttribute('data-id');
            const idEquipoInfo = button.getAttribute('data-equipo-info-id');
            // Confirmación de SweetAlert2 antes de editar
            Swal.fire({
                title: '¿Deseas editar esta herramienta especial?',
                text: "Serás redirigido a la página de edición.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, editar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/LSA/editar-herramienta-especial/${herramientaId}?id_equipo_info=${idEquipoInfo}`;
                }
            });
        });
    });

    // Manejo del botón Eliminar en la sección de herramientas especiales
    const deleteButtonsEspecial = document.querySelectorAll('.btn-eliminar');
    deleteButtonsEspecial.forEach(function(button) {
        button.addEventListener('click', function() {
            const herramientaId = this.getAttribute('data-id');

            // Confirmación de SweetAlert2 antes de eliminar
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
                    fetch('/api/herramientas-especiales/' + herramientaId, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.message) {
                            Swal.fire('Eliminado', result.message, 'success');
                            this.closest('tr').remove();
                        } else {
                            Swal.fire('Error', 'Error al eliminar herramienta', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error al eliminar herramienta:', error);
                        Swal.fire('Error', 'Error al eliminar herramienta: ' + error.message, 'error');
                    });
                }
            });
        });
    });
});
