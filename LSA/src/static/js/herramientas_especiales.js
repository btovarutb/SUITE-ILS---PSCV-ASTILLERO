document.addEventListener('DOMContentLoaded', function() {
    // Función para limpiar el formulario
    function limpiarFormulario(form) {
        form.reset(); // Limpiar todos los campos del formulario
    }

    function redirigirSegunURLAnterior(idEquipoInfo) {
        const urlAnterior = document.referrer; // URL previa

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

        if (urlAnterior.includes('/LSA/mostrar-herramientas-especiales-ext')) {
            window.location.href = `/LSA/mostrar-herramientas-especiales-ext?id_equipo_info=${idEquipoInfo}`;
        } else {
            window.location.href = `/LSA/mostrar-herramientas-especiales`;
        }
    }

    // Manejo del formulario de Análisis de Herramientas
    const formAnalisis = document.getElementById('analisis-herramientas-form');

    formAnalisis.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevenir comportamiento predeterminado del formulario

        const formData = new FormData(formAnalisis);

        fetch('/api/analisis-herramientas', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(error => {
                    throw new Error(error.error || 'Error desconocido del servidor');
                });
            }
            return response.json();
        })
        .then(result => {
            // Mostrar mensaje de éxito con SweetAlert
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: result.message, // Mensaje devuelto por el servidor
            }).then(() => {
                // Limpiar el formulario después de enviar la información
                limpiarFormulario(formAnalisis);
            });
        })
        .catch(error => {
            // Mostrar mensaje de error con SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al guardar análisis de herramientas. Inténtalo nuevamente.',
            });
            console.error('Error al guardar análisis de herramientas:', error);
        });
    });

    // Manejo del formulario de Herramientas Especiales
    const formEspeciales = document.getElementById('herramientas-especiales-form');

    formEspeciales.addEventListener('submit', function(e) {
        e.preventDefault(); // prevenir
    
        const formData = new FormData(formEspeciales);
    
        // 👇 AÑADIR ID EXPLÍCITAMENTE
        const idEquipoInput = document.querySelector('input[name="id_equipo_info"]');
        if (idEquipoInput) {
            formData.append('id_equipo_info', idEquipoInput.value);
        }
    
        fetch('/api/herramientas-especiales', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(error => {
                    throw new Error(error.error || 'Error desconocido del servidor');
                });
            }
            return response.json();
        })
        .then(result => {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: result.message,
            }).then(() => {
                limpiarFormulario(formEspeciales);
            });
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al guardar herramientas especiales. Inténtalo nuevamente.',
            });
            console.error('Error al guardar herramientas especiales:', error);
        });
    });
    
    
    const btnVisualizar = document.querySelector('.btn-visualizar-herramientas');
    if (btnVisualizar) {
        btnVisualizar.addEventListener('click', function(e) {
            e.preventDefault(); // Evitar comportamiento predeterminado
            const idEquipoInfo = document.querySelector('input[name="id_equipo_info"]').value;
            redirigirSegunURLAnterior(idEquipoInfo);
        });
    }
});
