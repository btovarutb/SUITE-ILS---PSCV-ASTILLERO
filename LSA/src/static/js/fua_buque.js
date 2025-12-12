console.time("⏱️ Tiempo hasta equipos listos");

document.addEventListener("DOMContentLoaded", function () {
    const buqueId = window.buqueId;
    const equiposGlobal = window.equiposGlobal;
    let sistemasGlobal = window.sistemasGlobal || [];

    if (window.equipoPreseleccionadoId) {
        autoseleccionarEquipo(window.equipoPreseleccionadoId);
    }

    const grupos = [
        { id: 1, codigo: '100', nombre: 'Cascos y Estructuras' },
        { id: 2, codigo: '200', nombre: 'Maquinaria y Propulsión' },
        { id: 3, codigo: '300', nombre: 'Planta Eléctrica' },
        { id: 4, codigo: '400', nombre: 'Comando y Vigilancia' },
        { id: 5, codigo: '500', nombre: 'Sistemas Auxiliares' },
        { id: 6, codigo: '600', nombre: 'Acabados y Amoblamiento' },
        { id: 7, codigo: '700', nombre: 'Armamento' }
    ];

    inicializarVista();

    function inicializarVista() {
        const gruposList = document.getElementById("grupos-list");
        grupos.forEach(grupo => {
            gruposList.innerHTML += `
                <button onclick="seleccionarGrupo(${grupo.id}, event)" class="group-btn">
                    <span class="code">${grupo.codigo}</span>
                    <span class="desc">${grupo.nombre}</span>
                </button>`;
        });
    }

    window.seleccionarGrupo = function (grupoId, event) {
        document.querySelectorAll("#grupos-list button").forEach(btn => btn.classList.remove("selected-group"));
        event.currentTarget.classList.add("selected-group");

        const sistemasDelGrupo = sistemasGlobal.filter(s => s.grupo_constructivo_id == grupoId);
        const sistemasIds = sistemasDelGrupo.map(s => s.id);
        const equiposDelGrupo = equiposGlobal.filter(eq => sistemasIds.includes(eq.id_sistema_ils));

        const filtroContainer = document.getElementById("filtro-sistemas-container");
        const filtroSelect = document.getElementById("filtro-sistemas");

        if (equiposDelGrupo.length === 0) {
            filtroContainer.classList.add('hidden');
            document.getElementById("list-group-equipos").innerHTML = `<div class="no-equipos-msg">No se encontraron equipos para este grupo.</div>`;
        } else {
            filtroContainer.classList.remove('hidden');
            filtroSelect.innerHTML = `<option value="">Todos los sistemas</option>`;
            sistemasDelGrupo.forEach(sis => {
                filtroSelect.innerHTML += `<option value="${sis.id}">${sis.codigo} - ${sis.nombre}</option>`;
            });
            filtroSelect.onchange = () => {
                const sistemaId = filtroSelect.value;
                filtrarEquipos(equiposDelGrupo, sistemaId);
            };
            renderizarEquipos(equiposDelGrupo);
        }
    };

    function filtrarEquipos(equiposDelGrupo, sistemaId) {
        let filtrados = sistemaId ? equiposDelGrupo.filter(eq => eq.id_sistema_ils == sistemaId) : equiposDelGrupo;

        if (filtrados.length === 0) {
            document.getElementById("list-group-equipos").innerHTML = `<div class="no-equipos-msg">No hay equipos para el sistema seleccionado.</div>`;
        } else {
            renderizarEquipos(filtrados);
        }
    }

    function renderizarEquipos(equipos) {
        const equiposList = document.getElementById("list-group-equipos");
        equiposList.innerHTML = equipos.map(e => `
            <button 
                class="equipo-item" 
                onclick="seleccionarEquipo(this, '${e.id}')"
            >
                <div class="barra-morada"></div>
                <span class="equipo-texto">${e.nombre_equipo}</span>
            </button>
        `).join('');
        
    
        document.getElementById("buscar-equipo").addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase();
            const botones = equiposList.querySelectorAll(".equipo-item");
            botones.forEach(boton => {
                boton.style.display = boton.textContent.toLowerCase().includes(searchTerm) ? 'block' : 'none';
            });
        });
        console.timeEnd("⏱️ Tiempo hasta equipos listos");
    }

});

let isEditing = false;
let selectedEquipoId = null;

function formatearCampo(campo) {
    return campo.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
}

function toggler() {
    isEditing = !isEditing;
    document.querySelectorAll('#content input, #content textarea').forEach(el => el.readOnly = !isEditing);
    document.getElementById('icono-editar').classList.toggle('bi-pencil', !isEditing);
    document.getElementById('icono-editar').classList.toggle('bi-x', isEditing);
    document.querySelector('.espacioGuardado').classList.toggle('d-none', !isEditing);
    document.querySelector('.espacioGuardado').classList.toggle('d-flex', isEditing);
}

function configurarInputsYCalcular(fuaFrData) {
    const datosPuertoBase = window.datosPuertoBase;
    const misionesData = window.misiones;

    if (!datosPuertoBase) {
        console.error("❌ No se encontraron datos en window.datosPuertoBase");
        return;
    }

    if (!misionesData || !Array.isArray(misionesData)) {
        console.error("❌ window.misiones no es un arreglo válido");
        return;
    }

    const valoresEstaticos = {
        disponible_para_misiones: parseFloat(datosPuertoBase.disponible_misiones_1) || 0,
        disponibilidad_de_mantenimiento: parseFloat(datosPuertoBase.mant_basico_1) || 0,
        revision_periodica_roh: parseFloat(datosPuertoBase.roh_1) || 0
    };

    function calcularFua() {
        let sumaEstaticos = 0;
        let sumaDinamicos = 0;

        console.groupCollapsed("📊 [Cálculo de FUA] Nueva ejecución");

        console.group("🟦 Campos estáticos (Puerto Base)");
        Object.keys(valoresEstaticos).forEach(key => {
            const input = document.getElementById(key);
            if (input) {
                const inputValue = parseFloat(input.value) || 0;
                const peso = valoresEstaticos[key];
                const contribucion = (inputValue / 100) * peso;
                sumaEstaticos += contribucion;
                console.log(`✔️ ${key}: ${inputValue}% * ${peso} = ${contribucion}`);
            } else {
                console.warn(`❌ Input estático no encontrado: ${key}`);
            }
        });
        console.groupEnd();

        console.group("🟨 Campos dinámicos (Puerto Extranjero)");
        misionesData.forEach(mision => {
            const input = document.getElementById(mision.normalized_id);
            if (input) {
                const inputValue = parseFloat(input.value) || 0;
                const porcentaje = parseFloat(mision.porcentaje) || 0;
                const contribucion = (2500 * (porcentaje / 100)) * (inputValue / 100);
                sumaDinamicos += contribucion;
                console.log(`✔️ ${mision.mision}: (2500 * ${porcentaje}%) * ${inputValue}% = ${contribucion}`);
            } else {
                console.warn(`❌ Input dinámico no encontrado: ${mision.normalized_id}`);
            }
        });
        console.groupEnd();

        const resultadoTotal = sumaEstaticos + sumaDinamicos;

        const resultadoInput = document.getElementById('resultado-fua');
        const resultadoInputPorcentaje = document.getElementById('resultado-fua-porcentaje');

        if (resultadoInput && resultadoInputPorcentaje) {
            resultadoInput.value = resultadoTotal.toFixed(2);
            resultadoInputPorcentaje.value = ((resultadoTotal / 8760) * 100).toFixed(2);
            console.log(`✅ AOR: ${resultadoInput.value} horas | ${resultadoInputPorcentaje.value}%`);
        } else {
            console.warn("❗ No se encontraron inputs de resultado AOR");
        }

        console.groupEnd(); // fin grupo principal
    }

    // Escuchar cambios en inputs para recalcular
    const inputs = document.querySelectorAll('#section1 input');
    inputs.forEach(input => {
        input.removeEventListener('input', calcularFua);
        input.addEventListener('input', calcularFua);
    });

    calcularFua();
}
    
function renderCamposFuaFr(data) {
    const fuaCampos = data.FUA || {};
    const frCampos = data.FR || {};

    const fuaStaticHtml = Object.keys(fuaCampos).map(key => `
        <div class="row mb-2 ml-1">
            <div class="col-md-5"><label class="form-label">${formatearCampo(key)}</label></div>
            <div class="col-md-2 withUnid">
                <input type="number" class="form-control" id="${key}" value="${fuaCampos[key].porcentaje ?? ''}" readonly>
                <span class="input-group-text">%</span>
            </div>
            <div class="col-md-5">
                <textarea class="form-control" id="descripcion-${key}" readonly rows="2">${fuaCampos[key].descripcion ?? ''}</textarea>
            </div>
        </div>`).join('');
    document.getElementById('campos-estaticos-fua').innerHTML = fuaStaticHtml;

    const frStaticHtml = Object.keys(frCampos).map(key => `
        <div class="row mb-2">
            <div class="col-md-5"><label class="form-label">${formatearCampo(key)}</label></div>
            <div class="col-md-2 withUnid">
                <input type="number" class="form-control" id="fr-${key}" value="${frCampos[key].porcentaje ?? ''}" readonly>
                <span class="input-group-text">%</span>
            </div>
            <div class="col-md-5">
                <textarea class="form-control" id="descripcion-fr-${key}" readonly rows="2">${frCampos[key].descripcion ?? ''}</textarea>
            </div>
        </div>`).join('');
    document.getElementById('campos-estaticos-fr').innerHTML = frStaticHtml;
}

function toggleGrupos() {
    const gruposContainer = document.getElementById('grupos-container');
    const icon = document.getElementById('chevron-icon');

    if (gruposContainer.classList.contains('grupos-expanded')) {
        // Contraer con animación
        gruposContainer.classList.remove('grupos-expanded');
        gruposContainer.classList.add('grupos-collapsing');

        // Al finalizar animación ocultar completamente
        setTimeout(() => {
            gruposContainer.classList.add('grupos-hidden');
        }, 500);

        icon.classList.add('rotated');
    } else {
        // Expandir desde oculto
        gruposContainer.classList.remove('grupos-hidden');
        setTimeout(() => {
            gruposContainer.classList.remove('grupos-collapsing');
            gruposContainer.classList.add('grupos-expanded');
        }, 50);

        icon.classList.remove('rotated');
    }
}

function mostrarDetalleEquipo(equipoId) {
    console.log("Mostrar detalle de equipo ID:", equipoId);
    const detalleContainer = document.getElementById('detalle-equipo-container');
    const gruposContainer = document.getElementById('grupos-container');
    const equiposContainer = document.getElementById('equipos-container');
    const toggleBar = document.getElementById('toggle-bar');

    const equipoSeleccionado = window.equiposGlobal.find(e => e.id == equipoId);
    if (!equipoSeleccionado) {
        console.warn("⚠️ Equipo no encontrado en equiposGlobal");
        return;
    }

    console.log("📦 Datos brutos del equipo:", equipoSeleccionado);

    // Mostrar contenedor detalle
    detalleContainer.classList.remove('d-none');
    detalleContainer.classList.add('detalle-visible');
    toggleBar.classList.remove('hide');
    toggleBar.classList.add('show');

    // Ajustar anchos y contraer grupos
    gruposContainer.classList.remove('grupos-expanded-inicial');
    gruposContainer.classList.add('grupos-expanded');
    equiposContainer.classList.remove('equipos-expanded-inicial');
    equiposContainer.classList.add('equipos-after-detail');
    toggleGrupos();

    // Configurar tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
            button.classList.add('active');
            document.getElementById(button.dataset.target).classList.add('active');
        });
    });

    // Obtener datos de FUA_FR
    const fuaFrDataRaw = equipoSeleccionado.FUA_FR;
    let fuaFrData = { FUA: {}, FR: {} };

    try {
        fuaFrData = fuaFrDataRaw ? JSON.parse(fuaFrDataRaw) : { FUA: {}, FR: {} };
    } catch (error) {
        console.error("❌ Error al parsear FUA_FR:", error);
        console.warn("⛔ FUA_FR recibido:", fuaFrDataRaw);
    }

    console.log("✅ FUA_FR procesado:", fuaFrData);

    cargarDatosFormulario(fuaFrData);
    configurarInputsYCalcular(fuaFrData);
}

function cargarDatosFormulario(fuaFrData) {
    console.log("📝 Cargando datos FUA/FR en el formulario...");

    // Limpiar todos los campos
    document.querySelectorAll('#section1 input, #section1 textarea').forEach(el => el.value = "");
    document.querySelectorAll('#section2 input, #section2 textarea').forEach(el => el.value = "");

    // FUA
    Object.entries(fuaFrData.FUA || {}).forEach(([key, value]) => {
        const input = document.getElementById(key);
        const textarea = document.getElementById(`descripcion-${key}`);
        if (input) {
            input.value = value.porcentaje ?? "";
            console.log(`🟢 FUA -> ${key}: ${input.value}`);
        } else {
            console.warn(`🔴 No se encontró input FUA con ID: ${key}`);
        }
        if (textarea) {
            textarea.value = value.descripcion ?? "";
        }
    });

    // FR
    Object.entries(fuaFrData.FR || {}).forEach(([key, value]) => {
        const input = document.getElementById(`fr-${key}`);
        const textarea = document.getElementById(`descripcion-fr-${key}`);
        if (input) {
            input.value = value.porcentaje ?? "";
            console.log(`🟢 FR -> ${key}: ${input.value}`);
        } else {
            console.warn(`🔴 No se encontró input FR con ID: fr-${key}`);
        }
        if (textarea) {
            textarea.value = value.descripcion ?? "";
        }
    });
}

function seleccionarEquipo(elemento, id) {
    document.querySelectorAll('.equipo-item').forEach(btn => btn.classList.remove('selected'));
    elemento.classList.add('selected');

    selectedEquipoId = id; // <-- SOLUCIÓN AQUÍ ✅

    mostrarDetalleEquipo(id);
    loadDataFromSelectedEquipo();
    
}

function normalizeKey(text) {
    return text
        .normalize("NFD") // Separar tildes
        .replace(/[\u0300-\u036f]/g, "") // Eliminar acentos
        .toLowerCase()
        .replace(/\s+/g, "_") // Espacios a guiones bajos
        .replace(/[^\w\-]/g, ""); // Eliminar caracteres no válidos
}

function guardarFuaFr() {
    if (!selectedEquipoId) {
        Swal.fire({
            icon: 'warning',
            title: 'Equipo no seleccionado',
            text: 'Por favor, seleccione un equipo antes de guardar.',
            confirmButtonText: 'OK'
        });
        return;
    }

    Swal.fire({
        title: '¿Deseas guardar los datos?',
        text: "Se actualizarán los datos de FUA y FR para este equipo.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#003366',
        cancelButtonColor: '#888',
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (!result.isConfirmed) return;

        toggler(); // Cerrar modo edición

        const data = { FUA: {}, FR: {} };

        // Sección FUA
        document.querySelectorAll('#section1 .row').forEach(row => {
            const input = row.querySelector('input');
            const textarea = row.querySelector('textarea');
            const label = row.querySelector('label');

            if (!label || (input && input.id === 'resultado-fua')) return;

            const key = normalizeKey(label.textContent);
            data.FUA[key] = {
                porcentaje: input?.value || "",
                descripcion: textarea?.value || ""
            };
        });

        // Sección FR
        document.querySelectorAll('#section2 .row').forEach(row => {
            const input = row.querySelector('input');
            const textarea = row.querySelector('textarea');
            const label = row.querySelector('label');

            if (!label) return;

            const key = normalizeKey(label.textContent);
            data.FR[key] = {
                porcentaje: input?.value || "",
                descripcion: textarea?.value || ""
            };
        });

        // Calcular AOR
        const resultadoFuaInput = document.getElementById('resultado-fua');
        let AOR = null;
        if (resultadoFuaInput && resultadoFuaInput.value.trim() !== '') {
            AOR = parseFloat(resultadoFuaInput.value);
        }

        const dataToSend = { data, AOR };

        fetch(`/api/equipos/${selectedEquipoId}/fua_fr`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dataToSend)
        })
        .then(response => response.json())
        .then(result => {
            if (result.message) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Datos guardados!',
                    text: result.message || 'La información se guardó correctamente.'
                });

                // Actualizar cache local
                const equipo = window.equiposGlobal.find(e => e.id == selectedEquipoId);
                if (equipo) equipo.FUA_FR = JSON.stringify(data);
            } else {
                throw new Error(result.error || 'Error desconocido al guardar');
            }
        })
        .catch(error => {
            console.error('❌ Error al guardar FUA/FR:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error al guardar',
                text: 'Ocurrió un problema. Intenta nuevamente.'
            });
        });
    });
}

function loadDataFromSelectedEquipo() {
    if (!selectedEquipoId) {
        console.warn("⚠️ No hay equipo seleccionado para cargar datos.");
        return;
    }

    const equipo = window.equiposGlobal.find(e => e.id == selectedEquipoId);
    if (!equipo || !equipo.FUA_FR) {
        console.warn("⚠️ No se encontraron datos de FUA/FR para el equipo.");
        return;
    }

    let fuaFrData;
    try {
        fuaFrData = JSON.parse(equipo.FUA_FR);
    } catch (e) {
        console.error("❌ Error al parsear datos FUA_FR:", e);
        return;
    }

    Object.entries(fuaFrData.FUA || {}).forEach(([key, value]) => {
        const field = document.querySelector(`#section1 [name="${key}"], #section1 [id="${key}"]`);
        if (field) {
            if (field.type === "number") {
                field.value = value.porcentaje || "";
            } else {
                field.value = value.descripcion || "";
            }
        }
    });

    Object.entries(fuaFrData.FR || {}).forEach(([key, value]) => {
        const field = document.querySelector(`#section2 [name="${key}"], #section2 [id="${key}"]`);
        if (field) {
            if (field.type === "number") {
                field.value = value.porcentaje || "";
            } else {
                field.value = value.descripcion || "";
            }
        }
    });

    console.log("✅ Datos del equipo cargados correctamente.");
    
}

function autoseleccionarEquipo(equipoId) {
    const equipo = equiposGlobal.find(e => e.id == equipoId);
    if (!equipo) return;

    const sistema = sistemasGlobal.find(s => s.id === equipo.id_sistema_ils);
    if (!sistema) return;

    const grupoId = sistema.grupo_constructivo_id;

    let intentos = 0;
    const INTERVALO = 300;
    const MAX_INTENTOS = 20;

    const timer = setInterval(() => {
        intentos++;
        const grupoBtn = document.querySelector(`#grupos-list button:nth-child(${grupoId})`);
        if (grupoBtn) grupoBtn.click();

        const equipoBtn = document.querySelector(`.equipo-item[onclick*="'${equipo.id}'"]`);
        if (grupoBtn && equipoBtn) {
            equipoBtn.click();
            clearInterval(timer);
        }

        if (intentos > MAX_INTENTOS) {
            console.warn("⛔ No se pudo seleccionar automáticamente el equipo.");
            clearInterval(timer);
        }
    }, INTERVALO);
}
