document.addEventListener('DOMContentLoaded', function() {
    // Función para validar si los campos están vacíos
    function validarCampos() {
        let camposVacios = [];

        // Capturamos los campos del formulario que deben ser llenados
        const sistema = document.getElementById('sistema');
        const subsistema = document.getElementById('subsistema');
        const verbo = document.getElementById('verbo');
        const accion = document.getElementById('accion');
        const estandar_desempeño = document.getElementById('estandar_desempeño');

        // Comprobamos si los campos están vacíos
        if (!sistema.value.trim()) camposVacios.push('Sistema');
        if (!subsistema.value.trim()) camposVacios.push('Subsistema');
        if (!verbo.value.trim()) camposVacios.push('Verbo');
        if (!accion.value.trim()) camposVacios.push('Acción');
        if (!estandar_desempeño.value.trim()) camposVacios.push('Estándar de Desempeño');

        // Retorna el array de campos vacíos
        return camposVacios;
    }

    // Función para redirigir según la URL anterior
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

        if (urlAnterior.includes('/LSA/equipo/mostrar-analisis-funcional-ext')) {
            window.location.href = `/LSA/equipo//mostrar-analisis-funcional-ext?id_equipo_info=${idEquipoInfo}`;
        } else {
            window.location.href = `/LSA/equipo/mostrar-analisis-funcional`;
        }
    }

    // Capturar el evento submit del formulario de Análisis Funcional
    const form = document.getElementById('analisis-funcional-form');
    const id_equipo_info_element = document.getElementById('id_equipo_info');
    console.log('id_equipo_info_element:', id_equipo_info_element);



    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Evitar el comportamiento predeterminado del formulario

        // Validar campos antes de enviar
        const camposVacios = validarCampos();

        if (camposVacios.length > 0) {
            // Mostrar alerta si hay campos vacíos
            Swal.fire({
                icon: 'warning',
                title: 'Campos Vacíos',
                text: `Por favor, complete los siguientes campos: ${camposVacios.join(', ')}`,
                confirmButtonText: 'OK'
            });
            return; // No continuar con el envío si hay campos vacíos
        }

        // Capturar los datos del formulario
        const data = {
            sistema: document.getElementById('sistema').value,
            subsistema: document.getElementById('subsistema').value,
            verbo: document.getElementById('verbo').value,
            accion: document.getElementById('accion').value,
            estandar_desempeño: document.getElementById('estandar_desempeño').value,
            id_equipo_info: id_equipo_info_element.value,
            componentes: [] // Array para capturar los componentes
        };

        // Capturar los componentes dinámicos del formulario
        document.querySelectorAll('#componentes .row').forEach(function(item) {
            console.log(item);
            const nombre_componente = item.querySelector('p').textContent;
            const verbo = item.querySelector('input[name^="verbo_"]').value;
            const accion = item.querySelector('input[name^="accion_"]').value;
            const id_ = item.querySelector('input[name^="id_"]').value;
            data.componentes.push({
                nombre_componente,
                verbo,
                accion,
                id_
            });
        });


        console.log('Datos enviados:', data);

        // Enviar los datos mediante fetch
        fetch('/api/analisis-funcional', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data) // Convertir a JSON
        })
        .then(response => response.json())
        .then(result => {
            console.log('Análisis funcional guardado:', result);
            
            // Mostrar alerta de éxito con SweetAlert
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Análisis funcional agregado correctamente',
                confirmButtonText: 'OK'
            }).then(() => {
                // Redirigir a la página de mostrar análisis funcional después de cerrar la alerta
                redirigirSegunURLAnterior(id_equipo_info_element.value);
            });
        })
        .catch(error => {
            console.error('Error al guardar análisis funcional:', error);

            // Mostrar alerta de error con SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al guardar el análisis funcional. Inténtalo de nuevo.',
                confirmButtonText: 'OK'
            });
        });
    });
});
