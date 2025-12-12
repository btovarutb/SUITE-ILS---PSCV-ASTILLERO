let isEditing = false;


document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('buscar-equipo');
    const equiposList = document.querySelectorAll('.list-group-item');

    searchInput.addEventListener('input', function () {
        const searchValue = searchInput.value.toLowerCase();

        equiposList.forEach(equipo => {
            const equipoName = equipo.textContent.toLowerCase();
            if (equipoName.includes(searchValue)) {
                equipo.style.display = ''; // Mostrar si coincide
            } else {
                equipo.style.display = 'none'; // Ocultar si no coincide
            }
        });
    });

     // Diccionario para almacenar la información
     const data = {
        FUA: {}, // Almacena los campos estáticos y dinámicos de FUA
        FR: {},  // Almacena los campos estáticos y dinámicos de FR
        resultado_FUA: "" // Aquí se guardará el resultado calculado de FUA
    };

    // Alternar modo de edición
    const editButton = document.getElementById('btn-editar');
    editButton.addEventListener('click', function () { toggler() });

    // Función para cargar datos en los campos (opcional si hay datos preexistentes)
    function loadData() {
        Object.entries(data.FUA).forEach(([key, value]) => {
            const field = document.querySelector(`#section1 [name="${key}"], #section1 [id="${key}"]`);
            if (field) {
                if (field.type === "number") {
                    field.value = value.porcentaje;
                } else {
                    field.value = value.descripcion;
                }
            }
        });

        Object.entries(data.FR).forEach(([key, value]) => {
            const field = document.querySelector(`#section2 [name="${key}"], #section2 [id="${key}"]`);
            if (field) {
                if (field.type === "number") {
                    field.value = value.porcentaje;
                } else {
                    field.value = value.descripcion;
                }
            }
        });
    }

    const buttons = document.querySelectorAll('.tab-button');
    const sections = document.querySelectorAll('.section');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            // Remover la clase "active" de todos los botones y secciones
            buttons.forEach(btn => btn.classList.remove('active'));
            sections.forEach(section => section.classList.remove('active'));

            // Activar el botón y la sección correspondiente
            button.classList.add('active');
            const target = document.getElementById(button.dataset.target);
            target.classList.add('active');
        });
    });

    loadData();

});


function toggler (){
    const saveButtonContainer = document.querySelector('.espacioGuardado');
    const inputs = document.querySelectorAll('#content input');
    const textareas = document.querySelectorAll('#content textarea');
    const editButton = document.getElementById('btn-editar');

    isEditing = !isEditing;

    inputs.forEach(input => input.readOnly = !isEditing);
    textareas.forEach(textarea => textarea.readOnly = !isEditing);

    // Cambiar icono del botón
    const icon = editButton.querySelector('i');
    icon.classList.toggle('bi-pencil', !isEditing);
    icon.classList.toggle('bi-x', isEditing);

    // Mostrar/Ocultar botón de guardar
    saveButtonContainer.classList.toggle('d-none', !isEditing);
    saveButtonContainer.classList.toggle('d-flex', isEditing);
} 

function cargarEquipo(equipoId) {
    selectedEquipoId = equipoId;

    const mensajePredeterminado = document.getElementById('mensaje-predeterminado');
    const detalleEquipoContent = document.querySelector('#detalle-equipo .card-body');

    mensajePredeterminado.classList.add('hide');
    detalleEquipoContent.classList.add('show');

    // Remover la clase active de cualquier botón previamente activo
    const botonesActivos = document.querySelectorAll('.list-group-item.active');
    botonesActivos.forEach(boton => boton.classList.remove('active'));

    // Obtener el botón seleccionado y agregarle la clase active
    const equipoButton = document.querySelector(`.list-group-item[data-id="${equipoId}"]`);
    if (equipoButton) {
        equipoButton.classList.add('active');
    } else {
        console.warn(`No se encontró el botón para el equipo con ID ${equipoId}`);
    }

    if (equipoButton) {
        console.log(equipoButton)
        try {
            // Obtener los datos FUA_FR del atributo data-fua-fr
            const fuaFrData = JSON.parse(equipoButton.getAttribute('data-fua-fr')) || {};

            // Cargar los datos en los campos
            cargarDatosFormulario(fuaFrData);

            configurarInputsYCalcular(fuaFrData);
        } catch (error) {
            console.error('Error al parsear JSON en data-fua-fr:', error);
        }
    } else {
        console.error(`Botón del equipo con ID ${equipoId} no encontrado.`);
    }
}

function cargarDatosFormulario(fuaFrData) {
    console.log("Iniciando carga de datos en el formulario...");

    // Resetear los campos de FUA (Sección 1)
    document.querySelectorAll('#section1 input, #section1 textarea').forEach(element => {
        element.readOnly = false;
        element.value = ""; // Limpiar el campo
        element.readOnly = true;
    });

    // Resetear los campos de FR (Sección 2)
    document.querySelectorAll('#section2 input, #section2 textarea').forEach(element => {
        element.readOnly = false;
        element.value = ""; // Limpiar el campo
        element.readOnly = true;
    });

    // Cargar datos de FUA (Sección 1)
    Object.entries(fuaFrData.FUA || {}).forEach(([key, value]) => {
        const porcentajeInput = document.getElementById(key);
        const descripcionTextarea = document.getElementById(`descripcion-${key}`);

        if (porcentajeInput) {
            porcentajeInput.readOnly = false;
            porcentajeInput.value = value.porcentaje || "";
            porcentajeInput.readOnly = true;
        } else {
            console.warn(`No se encontró el input de porcentaje para FUA clave: "${key}"`);
        }

        if (descripcionTextarea) {
            descripcionTextarea.readOnly = false;
            descripcionTextarea.value = value.descripcion || "";
            descripcionTextarea.readOnly = true;
        } else {
            console.warn(`No se encontró el textarea de descripción para FUA clave: "${key}"`);
        }
    });

    // Cargar datos de FR (Sección 2)
    Object.entries(fuaFrData.FR || {}).forEach(([key, value]) => {
        const porcentajeInput = document.getElementById(`fr-${key}`);
        const descripcionTextarea = document.getElementById(`descripcion-fr-${key}`);

        if (porcentajeInput) {
            porcentajeInput.readOnly = false;
            porcentajeInput.value = value.porcentaje || "";
            porcentajeInput.readOnly = true;
        } else {
            console.warn(`No se encontró el input de porcentaje para FR clave: "${key}"`);
        }

        if (descripcionTextarea) {
            descripcionTextarea.readOnly = false;
            descripcionTextarea.value = value.descripcion || "";
            descripcionTextarea.readOnly = true;
        } else {
            console.warn(`No se encontró el textarea de descripción para FR clave: "${key}"`);
        }
    });



    console.log("Carga de datos en el formulario completada.");
}


// Función para normalizar textos (remover tildes, convertir a minúsculas y reemplazar espacios por guiones bajos)
function normalizeKey(text) {
    return text
        .normalize("NFD") // Descomponer caracteres unicode (separar tildes)
        .replace(/[\u0300-\u036f]/g, "") // Eliminar diacríticos (tildes)
        .toLowerCase() // Convertir a minúsculas
        .replace(/\s+/g, "_") // Reemplazar espacios por guiones bajos
        .replace(/[^\w\-]/g, ""); // Eliminar caracteres no alfanuméricos
}

function guardarFuaFr() {
    if (!selectedEquipoId) {
        console.error('No se ha seleccionado ningún equipo.');
        return;
    }    

    toggler();

    console.log('Guardando datos para el equipo:', selectedEquipoId);

    // Diccionario de datos a guardar
    const data = {
        FUA: {}, // Almacena los campos estáticos y dinámicos de FUA
        FR: {},  // Almacena los campos estáticos y dinámicos de FR
    };

    // Procesar sección FUA
    document.querySelectorAll('#section1 .row').forEach(row => {
        const input = row.querySelector('input'); // Buscar el campo porcentaje
        const textarea = row.querySelector('textarea'); // Buscar el campo descripción
        const label = row.querySelector('label'); // Buscar el label común

        // Excluir explícitamente el campo Resultado Total FUA
        if (input && input.id === 'resultado-fua') return;

        if (!label) return;

        const key = normalizeKey(label.textContent); // Clave normalizada

        // Inicializar el subdiccionario si no existe
        if (!data.FUA[key]) {
            data.FUA[key] = { porcentaje: "", descripcion: "" };
        }

        // Asignar valores de porcentaje y descripción
        if (input) data.FUA[key].porcentaje = input.value || "";
        if (textarea) data.FUA[key].descripcion = textarea.value || "";
    });

    // Procesar sección FR
    document.querySelectorAll('#section2 .row').forEach(row => {
        const input = row.querySelector('input');
        const textarea = row.querySelector('textarea');
        const label = row.querySelector('label');

        if (!label) return;

        const key = normalizeKey(label.textContent);

        if (!data.FR[key]) {
            data.FR[key] = { porcentaje: "", descripcion: "" };
        }

        if (input) data.FR[key].porcentaje = input.value || "";
        if (textarea) data.FR[key].descripcion = textarea.value || "";
    });

    // Guardar el resultado del cálculo de FUA en su propia clave
    const resultadoFuaInput = document.getElementById('resultado-fua'); 
    let AOR = null;
    if (resultadoFuaInput && resultadoFuaInput.value.trim() !== '') {
        AOR = parseFloat(resultadoFuaInput.value);
    }

    const dataTosend = { data, AOR }
    console.log(dataTosend)

    // Llamar a la API para guardar los datos en la base de datos
    fetch(`/api/equipos/${selectedEquipoId}/fua_fr`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dataTosend)
    })
    .then(response => response.json())
    .then(result => {
        console.log(result.message || result.error);      
    })
    .catch(error => console.error('Error al guardar FUA_FR:', error));
}




