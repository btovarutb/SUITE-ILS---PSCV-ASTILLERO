document.addEventListener('DOMContentLoaded', function () {
    const eliminarButton = document.getElementById('btn-eliminar-equipo');

    if (eliminarButton) {
        eliminarButton.addEventListener('click', function () {
            const equipoId = eliminarButton.getAttribute('data-equipo-id');
    
            // Obtener nombre del equipo y CJ (si existe)
            let rawNombre = document.getElementById("nombreEquipo")?.innerText || "Equipo desconocido";
            const nombreEquipo = rawNombre.replace("Nombre de equipo:", "").trim();
            const cjEquipo = document.querySelector("span[style*='font-weight: bold'][style*='font-size: 18px']")?.innerText || "";
    
            const tituloEquipo = cjEquipo ? `${nombreEquipo} (CJ: ${cjEquipo})` : nombreEquipo;
    
            // Confirmación con campo de texto
            Swal.fire({
                title: '¿Eliminar este equipo?',
                html: `<strong>${tituloEquipo}</strong><br><br>
                <p style="font-size: 16px;" class="m-0">Escribe el nombre del equipo para confirmar:</p>
                <input id="confirmacion-nombre" class="swal2-input" placeholder="${nombreEquipo}">`,
                icon: 'warning',
                iconColor: '#b02a37',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#003366',
                cancelButtonColor: '#b02a37',
                preConfirm: () => {
                    const inputNombre = document.getElementById('confirmacion-nombre').value.trim();
                    if (inputNombre !== nombreEquipo.trim()) {
                        Swal.showValidationMessage('El nombre no coincide. Escribe el nombre exacto del equipo.');
                    }
                    return inputNombre;
                }
            }).then((result) => {
                if (result.isConfirmed && result.value === nombreEquipo.trim()) {
                    fetch('/LSA/eliminar-equipo', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id_equipo_info: equipoId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            Swal.fire({
                                title: 'Eliminado',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#003366',
                            }).then(() => {
                                // Redirigir después de eliminar
                                window.location.href = '/desglose_sistema';
                            });
                        } else {
                            Swal.fire('Error', 'No se pudo eliminar el equipo', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error al eliminar equipo:', error);
                        Swal.fire('Error', 'Ocurrió un error al eliminar el equipo', 'error');
                    });
                }
            });
        });
    }
    

    const editarButtons = document.querySelectorAll('.btn[data-url]');

    if (editarButtons) {
        editarButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const url = new URL(this.getAttribute('data-url'), window.location.origin); // Obtiene la URL base
                const section = this.getAttribute('data-section'); // Obtiene la sección del atributo data-section

                if (section) {
                    url.searchParams.set('section', section); // Agrega el parámetro 'section' a la URL
                }

                // Confirmación con SweetAlert2 antes de redirigir
                Swal.fire({
                    title: '¿Deseas editar la información de este equipo?',
                    text: "Serás redirigido a la página de edición.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, editar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#003366',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirigir si el usuario confirma
                        window.location.href = url.toString();
                    }
                });
            });
        });
    }
});
