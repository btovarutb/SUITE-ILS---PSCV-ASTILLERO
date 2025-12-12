document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('editar-herramienta-form');
    const herramientaId = form.getAttribute('data-herramienta-id');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevenir comportamiento predeterminado del formulario

        // Confirmación con SweetAlert2 antes de actualizar
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se actualizará la información de la herramienta.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                // Crear FormData para enviar los datos del formulario
                const formData = new FormData(form);

                // Realizar la petición de actualización
                fetch('/api/herramientas-especiales/' + herramientaId, {
                    method: 'PUT',
                    body: formData,
                })
                    .then((response) => response.json())
                    .then((result) => {
                        if (result.message) {
                            // Alerta de éxito
                            Swal.fire({
                                title: 'Actualizado',
                                text: result.message,
                                icon: 'success',
                                confirmButtonText: 'OK',
                            }).then(() => {
                                // Llama a la función redirigirSegunURLAnterior
                                redirigirSegunURLAnterior();
                            });
                        } else {
                            // Alerta de error
                            Swal.fire({
                                title: 'Error',
                                text: 'Error al actualizar herramienta',
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        }
                    })
                    .catch((error) => {
                        console.error('Error al actualizar herramienta:', error);
                        // Alerta de error en caso de excepción
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al actualizar herramienta: ' + error.message,
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    });
            }
        });
    });

    function redirigirSegunURLAnterior() {
        const urlAnterior = document.referrer; // URL previa
        const idEquipoInfo = document.getElementById('id_equipo_info')?.value; // Obtener el valor del id_equipo_info

        // Verifica si el id_equipo_info es válido
        if (!idEquipoInfo) {
            console.error('El id_equipo_info no está definido o es inválido.');
            Swal.fire({
                title: 'Error',
                text: 'El ID del equipo no está disponible. Por favor, verifica.',
                icon: 'warning',
                confirmButtonText: 'OK',
            });
            // Redirige a una página predeterminada para manejar el caso
            window.location.href = '/LSA';
            return;
        }

        // Verifica si la URL anterior contiene la parte esperada
        if (urlAnterior.includes('/LSA/mostrar-herramientas-especiales-ext')) {
            // Redirige con el id dinámico
            window.location.href = `/LSA/mostrar-herramientas-especiales-ext?id_equipo_info=${idEquipoInfo}`;
        } else {
            // Redirige a una vista predeterminada
            window.location.href = `/LSA/mostrar-herramientas-especiales`;
        }
    }
});
