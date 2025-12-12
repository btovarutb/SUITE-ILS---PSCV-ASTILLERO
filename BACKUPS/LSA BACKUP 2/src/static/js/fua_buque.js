document.addEventListener("DOMContentLoaded", function () {
    const buqueId = window.buqueId;
    const equiposGlobal = window.equiposGlobal;
    window.sistemasGlobal = window.sistemasGlobal || [];

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

    window.sistemasReady = fetch("http://localhost:8010/api/sistemas")
        .then(r => r.json())
        .then(data => (window.sistemasGlobal = Array.isArray(data) ? data : []))
        .catch(err => {
            console.error("Error cargando sistemas:", err);
            window.sistemasGlobal = [];
    });

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

    window.seleccionarGrupo = async function (grupoId, event) {
        // Asegura que la data esté lista aunque el usuario haga clic rápido
        try { await window.sistemasReady; } catch (e) {}

        document.querySelectorAll("#grupos-list button").forEach(btn => btn.classList.remove("selected-group"));
        event.currentTarget.classList.add("selected-group");

        const sistemasDelGrupo = window.sistemasGlobal.filter(
            s => Number(s.grupo_constructivo_id) === Number(grupoId)
        );
        const sistemasIds = sistemasDelGrupo.map(s => s.id);
        const equiposDelGrupo = equiposGlobal.filter(eq => sistemasIds.includes(eq.id_sistema_ils));

        const filtroContainer = document.getElementById("filtro-sistemas-container");
        const filtroSelect = document.getElementById("filtro-sistemas");

        if (equiposDelGrupo.length === 0) {
            filtroContainer.classList.add('hidden');
            document.getElementById("list-group-equipos").innerHTML =
            `<div class="no-equipos-msg">No se encontraron equipos para este grupo.</div>`;
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
    document.querySelectorAll('#section1 input').forEach(input => {
        input.addEventListener('input', () => {
            calcularFua(fuaFrData);
        });
    });
    calcularFua(fuaFrData);
}

function calcularFua(fuaFrData) {
    let suma = 0;
    Object.entries(fuaFrData.FUA).forEach(([key, value]) => {
        const porcentajeInput = document.getElementById(key);
        if (porcentajeInput) {
            const porcentaje = parseFloat(porcentajeInput.value) || 0;
            suma += porcentaje * 87.6; // Ejemplo de fórmula
        }
    });
    document.getElementById('resultado-fua').value = suma.toFixed(2);
    document.getElementById('resultado-fua-porcentaje').value = ((suma / 8760) * 100).toFixed(2);
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
    if (!equipoSeleccionado) return;

    // Mostrar contenedor detalle con animación
    detalleContainer.classList.remove('d-none');
    detalleContainer.classList.add('detalle-mostrando');

    setTimeout(() => {
        detalleContainer.classList.add('detalle-visible');
        detalleContainer.classList.remove('detalle-mostrando');
        toggleBar.classList.remove('hide');
        toggleBar.classList.add('show');
    }, 50);

    // Ajustar anchos
    gruposContainer.classList.remove('grupos-expanded-inicial');
    gruposContainer.classList.add('grupos-expanded');
    equiposContainer.classList.remove('equipos-expanded-inicial');
    equiposContainer.classList.add('equipos-after-detail');

    // Al mostrar el detalle, se contraen automáticamente los grupos:
    toggleGrupos();

    // Inyectar panel dinámico FUA/FR
    const fuaFrContainer = document.getElementById('contenedor-fua-fr');
    fuaFrContainer.innerHTML = `
        <div id="NavTools" class="row mb-3">
            <div class="buttons p-0">
                <button class="tab-button btn active" data-target="section1">Factor de utilización anual (FUA)</button>
                <button class="tab-button btn" data-target="section2">Factor de rendimiento (FR)</button>
            </div>
            <div id="EditionButton" style="width: 50px; display: flex; padding: 0; gap: 10px; justify-content: flex-end;">
                <button id="btn-editar" class="btn" onclick="toggler()">
                    <i id="icono-editar" class="bi bi-pencil"></i>
                </button>
            </div>
        </div>
        <div id="content">
            <div id="section1" class="zone section active">
                <p class="subtitulo mb-1">Puerto base</p>
                <div id="campos-estaticos-fua"></div>
                <p class="subtitulo pt-4 mb-1">Puerto extranjero</p>
                <div id="campos-misiones-fua"></div>
                <div class="row mt-3 mb-3">
                    <div class="col-md-12">
                        <p class="subtitulo mb-1">Resultados FUA</p>
                        <div class="row">
                            <div class="col-6 d-flex justify-content-around align-items-center">
                                <p class="m-0">AOR:</p>
                                <div class="withUnid" style="width: 50%">
                                    <input type="text" class="form-control" id="resultado-fua" readonly placeholder="0.00">
                                    <span class="input-group-text">horas</span>
                                </div>
                            </div>
                            <div class="col-6 d-flex justify-content-around align-items-center">
                                <p class="m-0">AOR Porcentual:</p>
                                <div class="withUnid" style="width: 50%">
                                    <input type="text" class="form-control" id="resultado-fua-porcentaje" readonly placeholder="0.00">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="section2" class="zone section">
                <div id="campos-estaticos-fr"></div>
                <div id="campos-misiones-fr"></div>
            </div>
            <div class="d-none flex-row-reverse espacioGuardado" style="padding: 1.2rem;">
                <button id="btn-guardar" type="button" class="btn"
                    style="background-color: #003366; color: white;"
                    onclick="guardarFuaFr()">Guardar</button>
            </div>
        </div>
    `;

    // Configuración de tabs internos
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
            button.classList.add('active');
            document.getElementById(button.dataset.target).classList.add('active');
        });
    });

    // Renderizar campos si tienes la función existente
    const fuaFrData = equipoSeleccionado.FUA_FR ? JSON.parse(equipoSeleccionado.FUA_FR) : { FUA: {}, FR: {} };
    renderCamposFuaFr(fuaFrData);
    configurarInputsYCalcular(fuaFrData);
}



function seleccionarEquipo(elemento, id) {
    document.querySelectorAll('.equipo-item').forEach(btn => btn.classList.remove('selected'));
    elemento.classList.add('selected');
    mostrarDetalleEquipo(id);
}