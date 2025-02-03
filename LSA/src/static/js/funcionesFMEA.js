
editar = document.getElementById('codigo_modo_falla').getAttribute('data-editar');

console.log(editar)
if (editar == 'True') {
    window.onload = event => {
        console.log("Hola, mundo")
        // console.log(event.target)
        actualizarDetallesFalla()

        actualizarValoresConOnChange('Severidad')
        actualizarValoresConOnChange('Riesgo')
        actualizarCalculos()
    }
} else {
    window.onload = event => {
        // En modo registro, sí llamamos a actualizarNombreFalla()
        actualizarNombreFalla();
        actualizarDetallesFalla();
        actualizarValoresConOnChange('Severidad');
        actualizarValoresConOnChange('Riesgo');
        actualizarCalculos();
    }
}

function cargarComponentes() {
    const subsistemaId = document.getElementById('subsistema').value;
    
    fetch(`/api/componentes/${subsistemaId}`)
        .then(response => response.json())
        .then(data => {
            const itemComponenteSelect = document.getElementById('item_componente');
            itemComponenteSelect.innerHTML = '<option value="" disabled selected>---- Selecciona el componente ----</option>';
            
            data.componentes.forEach(componente => {
                const option = document.createElement('option');
                option.value = componente.id;
                option.textContent = componente.nombre;
                itemComponenteSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error al cargar componentes:', error));
}

function obtenerRiesgo(frecuencia, consecuencia) {
    // Definición de la matriz de riesgo textual
    const matrizTexto = {
        rango10: { minima: "SEMI-CRITICO", menor: "SEMI-CRITICO", moderada: "CRITICO", mayor: "MUY CRITICO", maxima: "MUY CRITICO" },
        rango8: { minima: "NO CRITICO", menor: "SEMI-CRITICO", moderada: "CRITICO", mayor: "MUY CRITICO", maxima: "MUY CRITICO" },
        rango4: { minima: "NO CRITICO", menor: "SEMI-CRITICO", moderada: "SEMI-CRITICO", mayor: "CRITICO", maxima: "MUY CRITICO" },
        rango2: { minima: "NO CRITICO", menor: "NO CRITICO", moderada: "SEMI-CRITICO", mayor: "CRITICO", maxima: "MUY CRITICO" }
    };

    // Función para determinar el rango de consecuencia
    function determinarRangoConsecuencia(consecuencia) {
        if (consecuencia >= 0 && consecuencia < 2) return "minima";
        else if (consecuencia >= 2 && consecuencia < 4) return "menor";
        else if (consecuencia >= 4 && consecuencia < 6) return "moderada";
        else if (consecuencia >= 6 && consecuencia < 8) return "mayor";
        else if (consecuencia >= 8 && consecuencia <= 10) return "maxima";
        else return null; // Consecuencia fuera de rango
    }

    // Función para determinar el rango de frecuencia
    function determinarRangoFrecuencia(frecuencia) {
        if (frecuencia >= 8 && frecuencia <= 10) return "rango10";
        else if (frecuencia >= 6 && frecuencia < 8) return "rango8";
        else if (frecuencia >= 4 && frecuencia < 6) return "rango4";
        else if (frecuencia >= 0 && frecuencia < 4) return "rango2";
        else return null; // Frecuencia fuera de rango
    }

    // Determinar el rango de frecuencia y consecuencia
    const rangoFrecuencia = determinarRangoFrecuencia(frecuencia);
    const rangoConsecuencia = determinarRangoConsecuencia(consecuencia);

    // Validación de entradas
    if (!rangoFrecuencia || !rangoConsecuencia) {
        return "Valores de frecuencia o consecuencia fuera de rango";
    }

    // Obteniendo el resultado de riesgo textual
    const riesgoTexto = matrizTexto[rangoFrecuencia][rangoConsecuencia];

    return {riesgoTexto};
}




function actualizarDetallesFalla() {
    const mecanismoId = document.getElementById('mecanismo_falla').value;
    
    // Realizar una petición GET al backend con el id del mecanismo seleccionado
    fetch(`/LSA/obtener-detalles-falla/${mecanismoId}`)
        .then(response => response.json())
        .then(data => {
            const detalleFallaSelect = document.getElementById('detalle_falla');
            detalleFallaSelect.innerHTML = '<option value="" disabled selected>---- Selecciona Detalle de Falla ----</option>';

            
            // Recorrer los detalles y agregarlos como opciones al select

            data.forEach(detalle => {
                const option = document.createElement('option');
                option.value = detalle.id;
                option.text = detalle.nombre;
                detalleFallaSelect.appendChild(option);
            });


            // Si estamos en modo de edición, seleccionar la opción correspondiente
            if (editar === 'True') {
                // Obtener el valor del detalle de falla desde el atributo data-detallefalla
                const detalleFallaGuardado = detalleFallaSelect.getAttribute('data-detallefalla');
                console.log(detalleFallaGuardado)
                // Verificar si el valor almacenado coincide con alguna de las opciones y seleccionarla
                if (detalleFallaGuardado) {
                    // Iterar sobre las opciones para seleccionar la que coincida
                    for (let option of detalleFallaSelect.options) {
                        if (option.text === detalleFallaGuardado || option.value === detalleFallaGuardado) {
                            option.selected = true;
                            break;
                        }
                    }
                }
            }

        })
        .catch(error => console.error('Error al cargar los detalles de falla:', error));
}




function actualizarNombreFalla() {
    // Obtener el valor actual del código de modo de falla
    const selectCodigo = document.getElementById("codigo_modo_falla");
    const codigoModoFallaId = selectCodigo.value;

    // Obtener el estado de edición y el valor original del código
    const editar = selectCodigo.getAttribute("data-editar");
    const originalCodigoModoFallaId = selectCodigo.getAttribute("data-original-value");

    // Obtener id_equipo_info desde el campo oculto
    const id_equipo_info = document.getElementById("id_equipo_info").value;

    // Verificar si estamos en modo edición y si el código no ha cambiado
    if (editar === "True" && codigoModoFallaId === originalCodigoModoFallaId) {
        console.log("El código de modo de falla no ha cambiado, se mantiene el consecutivo.");
        return; // Salimos de la función sin hacer la petición
    }

    // Construir la URL de la petición
    let url = `/LSA/obtener-nombre-falla/${codigoModoFallaId}/${id_equipo_info}`;
    
    if (editar === "True") {
        // Obtener id_consecutivo_modo_falla desde el campo oculto
        const id_consecutivo_modo_falla = document.getElementById("id_consecutivo_modo_falla").value;
        url += `?editar=True&id_consecutivo_modo_falla=${id_consecutivo_modo_falla}`;
    }

    // Realiza una petición para obtener el nombre del modo de falla y el consecutivo
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }
            // Actualizar el nombre del modo de falla
            document.getElementById("nombre_modo_falla").value = data.nombre;

            // Actualizar el campo del consecutivo de modo de falla
            document.getElementById("consecutivo_modo_falla").value = data.consecutivo;

            // Guardar el id_consecutivo_modo_falla en un campo oculto
            document.getElementById("id_consecutivo_modo_falla").value = data.id_consecutivo_modo_falla;
        })
        .catch(error => console.error('Error al actualizar el nombre y consecutivo:', error));
}






function actualizarValoresConOnChange(nombreClasePadre) {
    const contenedorDiv = document.querySelector(`.${nombreClasePadre}`);
    if (!contenedorDiv) {
        console.error(`No se encontró ningún contenedor con la clase: ${nombreClasePadre}`);
        return;
    }
    // Buscar todos los selects dentro del contenedor que tienen el atributo onchange
    const selectsConOnChange = contenedorDiv.querySelectorAll('select[onchange]');
    console.log(selectsConOnChange)
    //mostrar alerta si no se encuentran atributos con onchange
    if (selectsConOnChange.length === 0) {
        console.warn('No se encontraron selects con el atributo onchange en el contenedor con la clase:', nombreClasePadre);
        return;
    }
    selectsConOnChange.forEach(selectElement => {
        const inputId = `${selectElement.id}_valor`;
        const inputElement = document.getElementById(inputId);

        if (inputElement) {
            actualizarValor(selectElement.id, inputId);
        }
    });
}



function actualizarValor(selectId, inputId) {
    // Obtener el select y la opción seleccionada
    var selectElement = document.getElementById(selectId);
    var selectedOption = selectElement.options[selectElement.selectedIndex];

    // Obtener el valor del atributo data-valor de la opción seleccionada
    var valor = selectedOption.getAttribute('data-valor');

    // Verificar que el valor existe antes de asignarlo al input
    if (valor) {
        document.getElementById(inputId).value = valor;
    }
    actualizarCalculos()
}





// Función para actualizar los cálculos automáticos

 // Declarar la lista de riesgos globalmente para que esté disponible para cualquier función
const listaRiesgos = JSON.parse(document.getElementById('id_riesgo').getAttribute('data-riesgos'));
function actualizarCalculos() {
    // Cálculos previos para obtener el valor de RPN
    var consecuenciaSeveridad = parseFloat(document.getElementById('fallo_oculto_valor').value) || 0;

    var seguridadFisica = parseFloat(document.getElementById('seguridad_fisica_valor').value) || 0;
    var medioAmbiente = parseFloat(document.getElementById('medio_ambiente_valor').value) || 0;
    var impactoOperacional = parseFloat(document.getElementById('impacto_operacional_valor').value) || 0;
    var costosReparacion = parseFloat(document.getElementById('costos_reparacion_valor').value) || 0;
    var flexibilidadOperacional = parseFloat(document.getElementById('flexibilidad_operacional_valor').value) || 0;

    //calculo original
    var Severidad = consecuenciaSeveridad * 0.05 + seguridadFisica * 0.2 + medioAmbiente * 0.1 + impactoOperacional * 0.3 + costosReparacion * 0.3+ flexibilidadOperacional * 0.05;
    document.getElementById('calculo_severidad').value = Severidad;

    var ocurrencia = parseFloat(document.getElementById('ocurrencia_valor').value) || 0;
    var deteccion = parseFloat(document.getElementById('probabilidad_deteccion_valor').value) || 0;
    
    const aorValue = parseFloat(document.querySelector('label[for="ocurrencia_matematica"]').getAttribute('data-aor')) || 0;
    const mtbfValue = parseFloat(document.getElementById('mtbf').value) || 0;
    let ocurrencia_matematica = 0;

    if (mtbfValue !== 0) {
        ocurrencia_matematica = aorValue / mtbfValue;
    }
    else{
        console.log("errores")
    }

    // Limitar el resultado a 2 decimales (opcional)
    ocurrencia_matematica = ocurrencia_matematica.toFixed(2);
    document.getElementById('ocurrencia_matematica').value = ocurrencia_matematica;

    var rpn = (Severidad * ocurrencia * deteccion)/100;
    document.getElementById('rpn').value = rpn;

    // Leer la lista de riesgos desde el atributo data-riesgos
    const riesgosInput = document.getElementById('riesgo');
    const listaRiesgos = JSON.parse(riesgosInput.getAttribute('data-riesgos'));

    // Determinar el riesgo según el RPN
    

    const resultado = obtenerRiesgo(ocurrencia, rpn);
    // Buscar el id del riesgo correspondiente en la lista de riesgos
    const idRiesgo = listaRiesgos.find(riesgo => riesgo.nombre === resultado.riesgoTexto)?.id || null;

    // Asignar el nombre del riesgo al campo de texto
    document.getElementById('riesgo').value = resultado.riesgoTexto;

    // Guardar el id del riesgo en el campo oculto para enviar al backend
    document.getElementById('id_riesgo').value = idRiesgo;

    // Debug: Mostrar en la consola para verificar
    console.log("Riesgo seleccionado:", resultado.riesgoTexto);
    console.log("ID del riesgo calculado:", idRiesgo);
}

// Puedes enlazar esta función a los eventos 'onchange' de los campos necesarios
document.getElementById('fallo_oculto_valor').addEventListener('input', actualizarCalculos);
document.getElementById('seguridad_fisica_valor').addEventListener('input', actualizarCalculos);
document.getElementById('medio_ambiente_valor').addEventListener('input', actualizarCalculos);
document.getElementById('impacto_operacional_valor').addEventListener('input', actualizarCalculos);
document.getElementById('costos_reparacion_valor').addEventListener('input', actualizarCalculos);
document.getElementById('flexibilidad_operacional_valor').addEventListener('input', actualizarCalculos);
////////////////////////////////////////////////////////////////////////////////////////////////////
document.getElementById('ocurrencia_valor').addEventListener('input', actualizarCalculos);

document.getElementById('probabilidad_deteccion_valor').addEventListener('input', actualizarCalculos);

document.addEventListener('DOMContentLoaded', function () {
    const fmeaForm = document.getElementById('fmea-form');

    if (fmeaForm) {
        fmeaForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar el envío automático del formulario

            // Mostrar alerta de confirmación con SweetAlert2
            Swal.fire({
                title: '¿Deseas registrar este modo de falla?',
                text: "Verifica que todos los datos estén correctos antes de continuar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, registrar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar el formulario si el usuario confirma
                    fmeaForm.submit();
                }
            });
        });
    }
});

