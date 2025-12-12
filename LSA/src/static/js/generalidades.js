document.addEventListener('DOMContentLoaded', () => {
    // Cambio en grupo_constructivo
    const grupoConstructivo = document.getElementById('grupo_constructivo');
    const subgrupoConstructivo = document.getElementById('subgrupo_constructivo');
    const sistema = document.getElementById('sistema');
    const subsistema = document.getElementById('subsistema');
    const equipo = document.getElementById('equipo');
    const tipoEquipo = document.getElementById('tipo_equipo');
    const addPersonalBtn = document.getElementById('add_personal');
    const deletePersonalBtn = document.getElementById('delete_personal');
    const responsable = document.getElementById('responsable');
    const codigoHidden = document.getElementById('codigo'); // <- hidden name="codigo"

    grupoConstructivo.addEventListener('change', () => {
        const grupoId = grupoConstructivo.value;
        if (grupoId) {
            fetch(`/api/subgrupos/${grupoId}`)
                .then(response => response.json())
                .then(data => {
                    subgrupoConstructivo.innerHTML = '<option value="">Seleccione Subgrupo Constructivo</option>';
                    data.forEach(subgrupo => {
                        subgrupoConstructivo.innerHTML += `<option value="${subgrupo.id}">${subgrupo.nombre}</option>`;
                    });
                })
                .catch(error => console.error('Error al obtener subgrupos:', error));
        } else {
            subgrupoConstructivo.innerHTML = '<option value="">Seleccione Subgrupo Constructivo</option>';
        }
        sistema.innerHTML = '<option value="">Seleccione Sistema</option>';
        equipo.innerHTML = '<option value="">Seleccione Equipo</option>';
        subsistema.innerHTML = '<option value="">Seleccione Subsistema</option>';
        if (codigoHidden) codigoHidden.value = '';
    });

    subgrupoConstructivo.addEventListener('change', () => {
        const subgrupoId = subgrupoConstructivo.value;

        // Reseteos iniciales
        sistema.innerHTML = '<option value="">Seleccione Sistema</option>';
        equipo.innerHTML = '<option value="">Seleccione Equipo</option>';
        subsistema.innerHTML = '<option value="">Seleccione Subsistema</option>';
        if (codigoHidden) codigoHidden.value = '';

        if (subgrupoId) {
            fetch(`/api/sistemas/${subgrupoId}`)
            .then(response => response.json())
            .then(data => {
                sistema.innerHTML = '<option value="">Seleccione Sistema</option>';
                data.forEach(sistemaItem => {
                    // "codigo - nombre" y guardamos el codigo en data-*
                    const opt = document.createElement('option');
                    opt.value = sistemaItem.id;
                    opt.textContent = `${sistemaItem.numeracion} - ${sistemaItem.nombre}`;
                    opt.dataset.codigo = sistemaItem.numeracion || '';
                    sistema.appendChild(opt);
                });
            })
            .catch(error => console.error('Error al obtener sistemas:', error));
        }
    });

    sistema.addEventListener('change', () => {
        const sistemaId = sistema.value;

        // Actualiza hidden 'codigo' con el data-codigo del option seleccionado
        const sel = sistema.options[sistema.selectedIndex];
        if (codigoHidden) codigoHidden.value = sel?.dataset?.codigo || '';

        // Cargar equipos
        if (sistemaId) {
            fetch(`/api/equipos/${sistemaId}`)
                .then(response => response.json())
                .then(data => {
                    equipo.innerHTML = '<option value="">Seleccione Equipo</option>';
                    data.forEach(equipoItem => {
                        equipo.innerHTML += `<option value="${equipoItem.id}">${equipoItem.numeracion} - ${equipoItem.nombre}</option>`;
                    });
                })
                .catch(error => console.error('Error al obtener equipos:', error));

            // Cargar subsistemas relacionados
            fetch(`/api/subsistemas/${sistemaId}`)
                .then(response => response.json())
                .then(data => {
                    subsistema.innerHTML = '<option value="">Seleccione Subsistema</option>';
                    data.forEach(sub => {
                        subsistema.innerHTML += `<option value="${sub.id}">${sub.numero_de_referencia} - ${sub.descripcion}</option>`;
                    });
                })
                .catch(error => console.error('Error al obtener subsistemas:', error));
        } else {
            equipo.innerHTML = '<option value="">Seleccione Equipo</option>';
            subsistema.innerHTML = '<option value="">Seleccione Subsistema</option>';
        }
    });

    // Cambio en tipo de equipo
    tipoEquipo.addEventListener('change', () => {
        const tipoEquipoId = tipoEquipo.value;
        if (tipoEquipoId) {
            fetch(`/api/equipos_por_tipo/${tipoEquipoId}`)
                .then(response => response.json())
                .then(data => {
                    equipo.innerHTML = '<option value="">Seleccione Equipo</option>';
                    data.forEach(equipoItem => {
                        equipo.innerHTML += `<option value="${equipoItem.id}">${equipoItem.nombre}</option>`;
                    });
                })
                .catch(error => console.error('Error al obtener equipos:', error));
        } else {
            equipo.innerHTML = '<option value="">Seleccione Equipo</option>';
        }
    });

    // Manejar agregar personal
    addPersonalBtn.addEventListener('click', () => {
        const nombreCompleto = prompt('Ingrese el nombre completo del nuevo personal:');
        if (nombreCompleto) {
            fetch('/api/crear_personal', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ 'nombre_completo': nombreCompleto })
            })
                .then(response => response.json())
                .then(data => {
                    responsable.innerHTML += `<option value="${data.id}">${data.nombre_completo}</option>`;
                    responsable.value = data.id;
                })
                .catch(error => alert('Error al crear personal: ' + error.message));
        }
    });

    // Manejar eliminar personal
    deletePersonalBtn.addEventListener('click', () => {
        const idPersonal = responsable.value;
        const nombrePersonal = responsable.options[responsable.selectedIndex].text;
        if (idPersonal) {
            if (confirm(`¿Está seguro que desea eliminar a ${nombrePersonal}?`)) {
                fetch('/api/eliminar_personal', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ 'id_personal': idPersonal })
                })
                    .then(response => response.json())
                    .then(() => {
                        responsable.querySelector(`option[value="${idPersonal}"]`).remove();
                        responsable.value = '';
                        alert('Personal eliminado');
                    })
                    .catch(error => alert('Error al eliminar personal: ' + error.message));
            }
        } else {
            alert('Por favor, seleccione un personal para eliminar');
        }
    });

    // Verificar si el nombre del equipo ya existe
    const nombreEquipoInput = document.getElementById('nombre_equipo');

    if (nombreEquipoInput) {
        nombreEquipoInput.addEventListener('blur', () => {
            const nombreEquipo = nombreEquipoInput.value.trim();

            if (nombreEquipo !== '') {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/LSA/check_nombre_equipo', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = () => {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.exists) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Nombre duplicado',
                                text: 'El nombre del equipo ya existe. Por favor, elija otro nombre.',
                                confirmButtonText: 'OK'
                            });
                            nombreEquipoInput.value = '';
                            nombreEquipoInput.focus();
                        }
                    } else {
                        console.error('Error en la solicitud AJAX');
                    }
                };

                xhr.send('nombre_equipo=' + encodeURIComponent(nombreEquipo));
            }
        });
    }

    const fechaInput = document.getElementById('fecha');
    const gresSistema = document.getElementById('gres_sistema');
    const fiabilidadEquipo = document.getElementById('fiabilidad_equipo');
    const criticidadEquipo = document.getElementById('criticidad_equipo');
    const marca = document.getElementById('marca');
    const modelo = document.getElementById('modelo');
    const pesoSeco = document.getElementById('peso_seco');
    const dimensiones = document.getElementById('dimensiones');
    const imagenEquipo = document.getElementById('imagen_equipo');
    const descripcionEquipo = document.getElementById('descripcion_equipo');
    const procedimientoArranque = document.getElementById('procedimiento_arranque');
    const procedimientoParada = document.getElementById('procedimiento_parada');
    const diagramaFlujo = document.getElementById('diagrama_flujo');
    const diagramaCajaNegra = document.getElementById('diagrama_caja_negra');
    const diagramaCajaTransparente = document.getElementById('diagrama_caja_transparente');
    const submitBtn = document.getElementById('submitBtn'); // Botón para enviar el formulario
    

    // Función de validación
    function validarFormulario() {
        if (!nombreEquipoInput.value.trim()) {
            mostrarAlerta('El nombre del equipo es obligatorio.');
            nombreEquipoInput.focus();
            return false;
        }

        if (!grupoConstructivo.value) {
            mostrarAlerta('Debe seleccionar un grupo constructivo.');
            grupoConstructivo.focus();
            return false;
        }

        if (!subgrupoConstructivo.value) {
            mostrarAlerta('Debe seleccionar un subgrupo constructivo.');
            subgrupoConstructivo.focus();
            return false;
        }

        if (!sistema.value) {
            mostrarAlerta('Debe seleccionar un sistema.');
            sistema.focus();
            return false;
        }
   /*
        if (!equipo.value) {
            mostrarAlerta('Debe seleccionar un equipo.');
            equipo.focus();
            return false;
        }

        if (!tipoEquipo.value) {
            mostrarAlerta('Debe seleccionar un tipo de equipo.');
            tipoEquipo.focus();
            return false;
        }

     

        if (!gresSistema.value.trim()) {
            mostrarAlerta('El campo GRES del sistema es obligatorio.');
            gresSistema.focus();
            return false;
        }

        if (!fiabilidadEquipo.value.trim()) {
            mostrarAlerta('El campo Fiabilidad del equipo es obligatorio.');
            fiabilidadEquipo.focus();
            return false;
        }

        if (!criticidadEquipo.value.trim()) {
            mostrarAlerta('El campo Criticidad del equipo es obligatorio.');
            criticidadEquipo.focus();
            return false;
        }

        if (!marca.value.trim()) {
            mostrarAlerta('El campo Marca es obligatorio.');
            marca.focus();
            return false;
        }

        if (!modelo.value.trim()) {
            mostrarAlerta('El campo Modelo es obligatorio.');
            modelo.focus();
            return false;
        }

        if (!pesoSeco.value || isNaN(pesoSeco.value)) {
            mostrarAlerta('El campo Peso seco debe ser un número válido.');
            pesoSeco.focus();
            return false;
        }

        if (!dimensiones.value.trim()) {
            mostrarAlerta('El campo Dimensiones es obligatorio.');
            dimensiones.focus();
            return false;
        }

        if (!descripcionEquipo.value.trim()) {
            mostrarAlerta('El campo Descripción del equipo es obligatorio.');
            descripcionEquipo.focus();
            return false;
        }

        if (!procedimientoArranque.value.trim()) {
            mostrarAlerta('El campo Procedimiento de arranque es obligatorio.');
            procedimientoArranque.focus();
            return false;
        }

        if (!procedimientoParada.value.trim()) {
            mostrarAlerta('El campo Procedimiento de parada es obligatorio.');
            procedimientoParada.focus();
            return false;
        }

        if (!validarImagen(imagenEquipo)) {
            mostrarAlerta('Debe cargar una imagen válida del equipo.');
            imagenEquipo.focus();
            return false;
        }

        if (!validarImagen(diagramaFlujo)) {
            mostrarAlerta('Debe cargar un diagrama de flujo válido.');
            diagramaFlujo.focus();
            return false;
        }

        if (!validarImagen(diagramaCajaNegra)) {
            mostrarAlerta('Debe cargar un diagrama de caja negra válido.');
            diagramaCajaNegra.focus();
            return false;
        }

        if (!validarImagen(diagramaCajaTransparente)) {
            mostrarAlerta('Debe cargar un diagrama de caja transparente válido.');
            diagramaCajaTransparente.focus();
            return false;
        }
        */

        // Si todo está lleno, devuelve verdadero
        return true;
    }

    // Función para validar los campos de imágenes
    function validarImagen(inputFile) {
        if (!inputFile.value) {
            return false; // Campo vacío
        }

        const file = inputFile.files[0];
        const allowedExtensions = ['image/jpeg', 'image/png', 'image/gif'];

        if (!allowedExtensions.includes(file.type)) {
            return false; // Tipo de archivo no permitido
        }

        return true;
    }
    // Mostrar alerta utilizando SweetAlert
    function mostrarAlerta(mensaje) {
        Swal.fire({
            icon: 'warning',
            title: 'Formulario incompleto',
            text: mensaje,
            confirmButtonText: 'OK'
        });
    }

    // Cargar automáticamente subsistemas si ya hay un sistema seleccionado
    if (sistema.value) {
        fetch(`/api/subsistemas/${sistema.value}`)
            .then(response => response.json())
            .then(data => {
                subsistema.innerHTML = '<option value="">Seleccione Subsistema</option>';
                data.forEach(sub => {
                    subsistema.innerHTML += `<option value="${sub.id}">${sub.descripcion}</option>`;
                });
            })
            .catch(error => console.error('Error al precargar subsistemas:', error));
    }

    // Manejar el envío del formulario
    submitBtn.addEventListener('click', (event) => {
        event.preventDefault(); // Evita el envío predeterminado del formulario
    
        if (!validarFormulario()) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, completa todos los campos requeridos.',
            });
            return; // Detiene la ejecución si la validación falla
        }
    
        // Si el formulario pasa la validación
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Formulario enviado con éxito.',
        }).then(() => {
            // Opcional: Puedes enviar el formulario aquí si todo está bien
            document.querySelector('form').submit(); // Envía el formulario
        });
    });
});
