document.addEventListener('DOMContentLoaded', function() {
    // Capturar el evento del botón "Realizar Cuestionario RCM"
    const btnCuestionario = document.getElementById('btn-realizar-cuestionario');
    btnCuestionario.addEventListener('click', function() {
        alert('Realizar Cuestionario RCM');
    });

    // Capturar el evento del botón "Siguiente" para pasar a la siguiente vista
    const btnSiguiente = document.getElementById('btn-siguiente');
    btnSiguiente.addEventListener('click', function() {
        window.location.href = 'registro-rcm-2'; // Cambiar a la segunda vista de RCM
    });

    // Capturar el evento submit del formulario de RCM
    const form = document.getElementById('rcm-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Evitar el comportamiento predeterminado del formulario

        // Capturar los datos del formulario
        const data = {
            sistema: document.getElementById('sistema').value,
            falla_funcional: document.getElementById('falla_funcional').value,
            item_componente: document.getElementById('item_componente').value,
            codigo_modo_falla: document.getElementById('codigo_modo_falla').value,
            consecutivo_modo_falla: document.getElementById('consecutivo_modo_falla').value,
            descripcion_modo_falla: document.getElementById('descripcion_modo_falla').value,
            causas: document.getElementById('causas').value,
            hidden_failures: document.getElementById('hidden_failures').value,
            safety: document.getElementById('safety').value,
            enviroment: document.getElementById('enviroment').value,
            operation: document.getElementById('operation').value,
            h1s1: document.getElementById('h1s1').value,
            h2s2: document.getElementById('h2s2').value,
            h3s3: document.getElementById('h3s3').value,
            h4s4: document.getElementById('h4s4').value,
            h5: document.getElementById('h5').value,
            tarea: document.getElementById('tarea').value,
            patron_de_falla: document.getElementById('patron_de_falla').value,  // Imagen Base64
            tarea_contemplada: document.getElementById('tarea_contemplada').value,
            fuente: document.getElementById('fuente').value
        };
        

        // Enviar los datos mediante fetch
        fetch('/api/rcm', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data) // Convertir a JSON
        })
        .then(response => response.json())
        .then(result => {
            console.log('RCM guardado:', result);
            alert('RCM agregado correctamente');
        })
        .catch(error => {
            console.error('Error al guardar RCM:', error);
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const rcmForm = document.getElementById('rcm-form');

    if (rcmForm) {
        rcmForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar el envío automático del formulario

            // Mostrar alerta de confirmación con SweetAlert2
            Swal.fire({
                title: '¿Deseas guardar los cambios del RCM?',
                text: "Verifica que todos los datos estén correctos antes de continuar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar el formulario si el usuario confirma
                    rcmForm.submit();
                }
            });
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const imagenInput = document.getElementById('imagen_patron');
    const hiddenInput = document.getElementById('patron_de_falla');

    imagenInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function() {
                hiddenInput.value = reader.result;  // Guardar imagen en Base64 en campo oculto
            };
        }
    });
});