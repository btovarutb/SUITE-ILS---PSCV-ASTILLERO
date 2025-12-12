const clasesObjetoTipo = [
    { codigo: "A1_BALIZAD", descripcion: "Buque Balizador" },
    { codigo: "A1_BDA", descripcion: "Buque Desembarco" },
    { codigo: "A1_BERGANT", descripcion: "Bergantín Barca" },
    { codigo: "A1_BONGO", descripcion: "Bongo" },
    { codigo: "A1_CORBETA", descripcion: "Corbeta" },
    { codigo: "A1_CPV", descripcion: "Patrullero De Costa" },
    { codigo: "A1_EMAF", descripcion: "Estación Móvil Fluvi" },
    { codigo: "A1_F.FERRY", descripcion: "Fast Ferry" },
    { codigo: "A1_FRAGATA", descripcion: "Fragata" },
    { codigo: "A1_HIDROGR", descripcion: "Buque Hidrográfico" },
    { codigo: "A1_HOVERCR", descripcion: "Hovercraft" },
    { codigo: "A1_OCEANOG", descripcion: "Buque Oceanográfico" },
    { codigo: "A1_OPV", descripcion: "Patrullero Oceanico" },
    { codigo: "A1_OSV", descripcion: "Buque de Apoyo OSV" },
    { codigo: "A1_PAF", descripcion: "Patrullera Apoy.Fluv" },
    { codigo: "A1_PRF", descripcion: "Patrullera Rápid.Flu" },
    { codigo: "A1_REMOLC", descripcion: "Remolcador" },
    { codigo: "A1_SUBMARI", descripcion: "Submarino" },
    { codigo: "A1_TENDER", descripcion: "Buque Logíst.Tender" },
    { codigo: "A1_YATE", descripcion: "Yate" },
    { codigo: "A2_APOSTLE", descripcion: "Bote Apostle" },
    { codigo: "A2_BALLEN", descripcion: "Bote Ballenera" },
    { codigo: "A2_BETA", descripcion: "Bote BETA I.M." },
    { codigo: "A2_CARIBE", descripcion: "Bote Caribe" },
    { codigo: "A2_DELFIN", descripcion: "Bote Delfín" },
    { codigo: "A2_DFENDER", descripcion: "Bote Defender" },
    { codigo: "A2_GUARDIA", descripcion: "Bote Guardián" },
    { codigo: "A2_MNE", descripcion: "Bote MidnightExpress" },
    { codigo: "A2_ORCA", descripcion: "Bote Orca" },
    { codigo: "A2_PATRULL", descripcion: "Patrullero Eduardoño" },
    { codigo: "A2_PILOT", descripcion: "Bote Pilot" },
    { codigo: "A2_SOC-R", descripcion: "Lancha SOC-R" },
    { codigo: "A2_VELERO", descripcion: "Velero" },
    { codigo: "A3_ACELERO", descripcion: "Acelerometro" },
    { codigo: "A3_ACMMTI", descripcion: "Acoplamiento mecanico del timon" },
    { codigo: "A3_AIRACON", descripcion: "Aire Acondicionado" },
    { codigo: "A3_AIS", descripcion: "Sistema Identif Aut" },
    { codigo: "A3_ALARMA", descripcion: "Alarma C/incendio" },
    { codigo: "A3_AME_.50", descripcion: "Ametralladora .50" },
    { codigo: "A3_AMPLIFI", descripcion: "Amplificador" },
    { codigo: "A3_ÁNODO", descripcion: "Ánodo Prot. Catodica" },
    { codigo: "A3_ANTENAS", descripcion: "Antenas" },
    { codigo: "A3_BALSAS", descripcion: "Balsa salvavidas" },
    { codigo: "A3_BATERIA", descripcion: "Baterias" },
    { codigo: "A3_BINTERD", descripcion: "Bote de interdicción y abordaje" },
    { codigo: "A3_BOMBAS", descripcion: "Bombas" },
    { codigo: "A3_BOTELLA", descripcion: "Botella Aire Comprim" },
    { codigo: "A3_C.BASUR", descripcion: "Equipo compactador de basura" },
    { codigo: "A3_C.EMPUJ", descripcion: "Cojinete de Empuje" },
    { codigo: "A3_C.SOPOR", descripcion: "Cojinete de Soporte" },
    { codigo: "A3_CABREST", descripcion: "Cabrestante" },
    { codigo: "A3_CALENTA", descripcion: "Calentador" },
    { codigo: "A3_CAÑON", descripcion: "Cañones" },
    { codigo: "A3_CARGAD", descripcion: "Cargador de Baterias" },
    { codigo: "A3_CARNAE", descripcion: "Carta de navegación electrónica (WECDIS)" },
    { codigo: "A3_COMPRES", descripcion: "Compresores" },
    { codigo: "A3_CONDEN", descripcion: "Condensador" },
    { codigo: "A3_CONSOLA", descripcion: "Consola de Operación" },
    { codigo: "A3_CONVERT", descripcion: "Convertidor Eléctric" },
    { codigo: "A3_CORREDE", descripcion: "Corredera" },
    { codigo: "A3_CPU", descripcion: "Unidad Procesadora C" },
    { codigo: "A3_DESALIN", descripcion: "Desalinizadora" },
    { codigo: "A3_E.COCIN", descripcion: "Equipos Cocina" },
    { codigo: "A3_E.LAVAN", descripcion: "Equipos Lavanderia" },
    { codigo: "A3_ECOSOND", descripcion: "Ecosonda" },
    { codigo: "A3_EJES", descripcion: "Eje Propulsión" },
    { codigo: "A3_ERDPNS", descripcion: "Estacion Reductora de presion" },
    { codigo: "A3_ESTCO2", descripcion: "Estacion de disparo CO2" },
    { codigo: "A3_EVAPORA", descripcion: "Evaporador" },
    { codigo: "A3_EXTINT", descripcion: "Extintor Contraincen" },
    { codigo: "A3_EXTRACT", descripcion: "Extractores de Aire" },
    { codigo: "A3_FILTROS", descripcion: "Filtros" },
    { codigo: "A3_FLEXBLE", descripcion: "Acople Flexible" },
    { codigo: "A3_FRENOS", descripcion: "Freno Ejes" },
    { codigo: "A3_GENERAD", descripcion: "Generatriz Generador" },
    { codigo: "A3_GIROCOM", descripcion: "Girocompas" },
    { codigo: "A3_GIROREP", descripcion: "Repetidor Girocompas" },
    { codigo: "A3_GPS", descripcion: "GPS" },
    { codigo: "A3_GRUA", descripcion: "Grúa" },
    { codigo: "A3_HELICE", descripcion: "Hélice Propulsora" },
    { codigo: "A3_HIDRJET", descripcion: "Propulsión Hidrojet" },
    { codigo: "A3_HIDROFL", descripcion: "Hidro acumulador" },
    { codigo: "A3_HIDROFO", descripcion: "Hidrofono" },
    { codigo: "A3_INFLABL", descripcion: "Bote Inflable" },
    { codigo: "A3_INTERCA", descripcion: "Intercambiador calor" },
    { codigo: "A3_LUZ.NAV", descripcion: "Luz Navegación" },
    { codigo: "A3_MDBOMB", descripcion: "Módulo de Bombeo" },
    { codigo: "A3_MDIESEL", descripcion: "Motor Diesel" },
    { codigo: "A3_MDSUMI", descripcion: "Módulo de Suministro" },
    { codigo: "A3_MELECTR", descripcion: "Motor Eléctrico" },
    { codigo: "A3_METEORO", descripcion: "Est. Meteorologica" },
    { codigo: "A3_MK_19", descripcion: "Lanza Gran MK-19" },
    { codigo: "A3_MODULAD", descripcion: "Modulador" },
    { codigo: "A3_MONITOR", descripcion: "Monitor" },
    { codigo: "A3_MOTFUBO", descripcion: "Motor Fuera de Borda" },
    { codigo: "A3_P.AGUA", descripcion: "Planta Agua potable" },
    { codigo: "A3_P.AIRE", descripcion: "Purificador Aire" },
    { codigo: "A3_P.CALEN", descripcion: "Precalentador" },
    { codigo: "A3_P.COMBU", descripcion: "Purificador Combusti" },
    { codigo: "A3_P.HANGA", descripcion: "Puerta de hangar" },
    { codigo: "A3_P.SEPAR", descripcion: "Separador Sentina" },
    { codigo: "A3_PALTIM", descripcion: "Pala de timon" },
    { codigo: "A3_PESCANT", descripcion: "Pescante" },
    { codigo: "A3_PILAUT", descripcion: "Piloto Automatico" },
    { codigo: "A3_PPACK", descripcion: "Unidad P.Hidráulica" },
    { codigo: "A3_PTAR", descripcion: "Planta Agua Residual" },
    { codigo: "A3_RADAR", descripcion: "Radar" },
    { codigo: "A3_RADIO", descripcion: "Radios" },
    { codigo: "A3_RA_ADFU", descripcion: "ADFU" },
    { codigo: "A3_RA_DDU", descripcion: "D.D.U" },
    { codigo: "A3_RA_VIU", descripcion: "VIU" },
    { codigo: "A3_REDUCTO", descripcion: "Engranaje Reductor" },
    { codigo: "A3_RGONIOM", descripcion: "Radiogoniometro" },
    { codigo: "A3_SELLOS", descripcion: "Sellos" },
    { codigo: "A3_SISCOMB", descripcion: "Sistema Combate" },
    { codigo: "A3_SKWS", descripcion: "Lanza Engaños" },
    { codigo: "A3_SONAR", descripcion: "Sonar" },
    { codigo: "A3_TABLER", descripcion: "Tablero Eléctrico" },
    { codigo: "A3_TANQUES", descripcion: "TK Almacenamiento" },
    { codigo: "A3_TEL.SAT", descripcion: "Telefonosl" },
    { codigo: "A3_THRUST", descripcion: "Propulsión Azimutal" },
    { codigo: "A3_TRANSFO", descripcion: "Transformador" },
    { codigo: "A3_TRGRAS", descripcion: "Trampa de Grasa" },
    { codigo: "A3_TTORPED", descripcion: "Tubo Torre Torpedos" },
    { codigo: "A3_UPS", descripcion: "Unid.Potenc.Eléctica" },
    { codigo: "A3_VÁLVULA", descripcion: "Válvulas" },
    { codigo: "A3_VENTILA", descripcion: "Ventiladores" },
    { codigo: "A3_WINCHE", descripcion: "Winche" },
];

// Lista de clases
const clases = [
    "ACOPLE_FLEXIBLE",
    "AIS",
    "ANTENA_SERVICIOS",
    "ARMAS_NAVALES",
    "BATERIAS",
    "BOMBAS",
    "BOTE_ABORDAJE",
    "BOTES",
    "BOTES_BALSAS_SALVA",
    "BOW_THRUSTER",
    "BUQUES",
    "CABRES_WINCHE",
    "CABRES_WINCHE_GRUA",
    "CARG_BATERIAS",
    "CARTA_WECDIS",
    "CALENTADOR_AGUA",
    "CASCO_CUBIERTA",
    "COJINETE",
    "COJINETES_EJES",
    "COM_BASURA",
    "COMPRESORES",
    "COMPAS_MAGNETICO",
    "COND_EVAP_INTERCAM",
    "CORREDERA",
    "CTRL_PROPULSION",
    "CARTA_WECDIS",
    "DEOILER",
    "DESALINIZADORA",
    "ECOSONDA",
    "EJE_PROPULSION",
    "ENG_REDUCTORES",
    "EQ_ELECT_RADAR_COM",
    "EQ_ELECTRIC_TALLER",
    "EQ_REFRIGER",
    "EQ_RESP_BOT_EXTINT",
    "EST_DISP_CO2",
    "EST_METEOROLOGICA",
    "EST_REDUCTORA",
    "FILTRO_UV",
    "FRENO_EJES",
    "GENERADORES",
    "GPS",
    "GRUP_VENT_BLOWER",
    "GRÚA",
    "HELICES",
    "HIDRO_ACUMULADOR",
    "LUZ_NAVEGACION",
    "MECHA_TIMON",
    "MOD_BOMBEO",
    "MOD_SUMINISTRO",
    "MONITOR",
    "MOTORES_DIESEL",
    "MOTORES_ELECTRICOS",
    "MOTORES_FUERA_BOR",
    "NAV_INERCIAL",
    "P_AZIMUTAL",
    "P_AUTOMATICO",
    "P_HANGAR",
    "P_HIDRO_JET",
    "PALA_TIMON",
    "PESCANTE",
    "PLANTA_TRATAMIENTO",
    "PRE_CALENTADOR",
    "PURIFICADORES",
    "RADIO_BASE",
    "SELLO_SIMPLEX",
    "SIS_ALARMA",
    "TABLERO_ELECTRICO",
    "TIPO_CONTROL",
    "TRAMPA_GRASA"
];


document.addEventListener("DOMContentLoaded", function () {
    const { PDFDocument, rgb, StandardFonts } = PDFLib;
    const buqueId = window.buqueId;
    const nombreBuque = window.nombreBuque;
    const equiposGlobal = window.equiposGlobal;
    const equipoSeleccionado = localStorage.getItem('equipoSeleccionado');
    const autoseleccionar = window.autoseleccionarEquipo && equipoSeleccionado;

    let sistemasGlobal = [];
    const {
        jsPDF
    } = window.jspdf || {};

    const gruposContainer = document.getElementById("grupos-container");
    const equiposContainer = document.getElementById("equipos-container");
    const toggleBar = document.getElementById("toggle-bar");

    // ⚓ Grupos fijos definidos
    const grupos = [{
            id: 1,
            codigo: '100',
            nombre: 'Cascos y Estructuras'
        },
        {
            id: 2,
            codigo: '200',
            nombre: 'Maquinaria y Propulsión'
        },
        {
            id: 3,
            codigo: '300',
            nombre: 'Planta Eléctrica'
        },
        {
            id: 4,
            codigo: '400',
            nombre: 'Comando y Vigilancia'
        },
        {
            id: 5,
            codigo: '500',
            nombre: 'Sistemas Auxiliares'
        },
        {
            id: 6,
            codigo: '600',
            nombre: 'Acabados y Amoblamiento'
        },
        {
            id: 7,
            codigo: '700',
            nombre: 'Armamento'
        }
    ];

    // 🧩 Inicializa grupos
    function inicializarGrupos() {
        const gruposList = document.getElementById("grupos-list");
        grupos.forEach(grupo => {
            gruposList.innerHTML += `
                <button onclick="seleccionarGrupo(${grupo.id}, event)" class="group-btn">
                    <span class="code">${grupo.codigo}</span>
                    <span class="desc">${grupo.nombre}</span>
                </button>
            `;
        });
    }

    inicializarGrupos();

    window.seleccionarGrupo = function (grupoId, event) {
        // 1. Marcar visualmente el grupo activo
        document.querySelectorAll("#grupos-list button").forEach(btn => btn.classList.remove("selected-group"));
        event.currentTarget.classList.add("selected-group");

        // 1.5. Si estamos en estado detalle (no inicial), ocultar grupos y mostrar equipos
        const gruposContainer = document.getElementById('grupos-container');
        const equiposContainer = document.getElementById('equipos-container');
        const toggleBar = document.getElementById('toggle-bar');
        const chevronIcon = document.getElementById('chevron-icon');
        const label = toggleBar.querySelector('.rotated-label');

        const estaEnDetalle = gruposContainer.classList.contains('grupos-expanded') &&
            !gruposContainer.classList.contains('grupos-expanded-inicial');

        if (estaEnDetalle) {
            gruposContainer.classList.remove('grupos-expanded');
            gruposContainer.classList.add('grupos-collapsing');

            setTimeout(() => {
                gruposContainer.classList.add('grupos-hidden');
            }, 500);

            // Mostrar equipos con fade
            equiposContainer.style.opacity = 0;
            equiposContainer.classList.remove('d-none');
            setTimeout(() => {
                equiposContainer.style.opacity = 1;
            }, 100);

            // Actualizar toggle a modo GRUPOS
            chevronIcon.classList.add('rotated');
            label.textContent = "GRUPOS";
        }

        // 2. Filtrar equipos por grupo
        const equiposDelGrupo = window.equiposGlobal.filter(eq => eq.id_grupo === grupoId);

        // 3. Mostrar u ocultar filtros
        const filtroContainer = document.getElementById("filtro-sistemas-container");
        const filtroSelect = document.getElementById("filtro-sistemas");

        if (equiposDelGrupo.length === 0) {
            filtroContainer.classList.add('hidden');
            document.getElementById("list-group-equipos").innerHTML = `
                <div class="no-equipos-msg">No se encontraron equipos para este grupo.</div>
            `;
        } else {
            filtroContainer.classList.remove('hidden');

            // ⚠️ Tomamos el primer id_subgrupo disponible del grupo para pedir los sistemas
            const primerSubgrupo = equiposDelGrupo[0].id_subgrupo;

            fetch(`${window.location.origin}/api/sistemas/${primerSubgrupo}`)
                .then(response => response.json())
                .then(sistemasDelGrupo => {
                    // Rellenar select
                    filtroSelect.innerHTML = `<option value="">Todos los sistemas</option>`;
                    sistemasDelGrupo.forEach(sis => {
                        filtroSelect.innerHTML += `<option value="${sis.id}">${sis.numeracion} - ${sis.nombre}</option>`;
                    });

                    // Evento de cambio de sistema
                    filtroSelect.onchange = () => {
                        const sistemaId = parseInt(filtroSelect.value);
                        filtrarEquipos(equiposDelGrupo, sistemaId);
                    };

                    // Mostrar equipos inicialmente
                    renderizarEquipos(equiposDelGrupo);
                })
                .catch(error => {
                    console.error("Error al cargar sistemas:", error);
                    filtroContainer.classList.add('hidden');
                });
        }

        window.grupoSeleccionado = grupoId; // recordar el último grupo clicado

        // Si el formulario "Nuevo equipo" ya está montado, autocompletar el select:
        const detalle = document.getElementById('detalle-equipo-container');
        const selectGrupo = detalle?.querySelector('#grupo_constructivo');
        if (selectGrupo) {
        selectGrupo.value = String(grupoId);
        // Dispara el change para que se recarguen subgrupos/sistemas con tu lógica existente
        selectGrupo.dispatchEvent(new Event('change'));
        }


    };

    function filtrarEquipos(equiposDelGrupo, sistemaId) {
        let filtrados = sistemaId ?
            equiposDelGrupo.filter(eq => eq.id_sistema === sistemaId) :
            equiposDelGrupo;

        if (filtrados.length === 0) {
            document.getElementById("list-group-equipos").innerHTML = `
                <div class="no-equipos-msg">No hay equipos para el sistema seleccionado.</div>
            `;
        } else {
            renderizarEquipos(filtrados);
        }
    }

    function renderizarEquipos(equipos) {
        console.log("Entramos a renderizar equipos co estos datos:", equipos)
        const equiposList = document.getElementById("list-group-equipos");

        equiposList.innerHTML = equipos.map(e => `
            <button 
                class="equipo-item" 
                data-id="${e.id_equipo}"
                onclick="mostrarDetalleEquipo('${e.id_equipo}', this)"
            >
                <div class="barra-azul"></div>
                <span class="equipo-texto">${e.cj} - ${e.nombre_equipo}</span>
            </button>
        `).join('');

        document.getElementById("buscar-equipo").addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase();
            const botones = equiposList.querySelectorAll(".equipo-item");
            botones.forEach(boton => {
                boton.style.display = boton.textContent.toLowerCase().includes(searchTerm) ? 'block' : 'none';
            });
        });

        // ✅ Aquí es donde ahora sí debe ejecutarse la autoselección
        if (window.equipoAutoSeleccion) {
            const boton = document.querySelector(`.equipo-item[data-id="${window.equipoAutoSeleccion}"]`);
            if (boton) {
                mostrarDetalleEquipo(window.equipoAutoSeleccion, boton);
                boton.classList.add('selected');
                delete window.equipoAutoSeleccion;
            }
        }
    } window.renderizarEquipos = renderizarEquipos;


    document.addEventListener('DOMContentLoaded', inicializarValidacionDimensiones);

    function mostrarDetalleEquipo(equipoId, boton = null, seccionActivaId = null) {
        const detalleContainer = document.getElementById('detalle-equipo-container');
        detalleContainer.classList.remove('d-none');
        detalleContainer.innerHTML = '<div class="text-center text-muted p-4" style="height:100%">Cargando detalles del equipo...</div>';

        const gruposContainer = document.getElementById("grupos-container");
        const equiposContainer = document.getElementById("equipos-container");
        const toggleBar = document.getElementById("toggle-bar");

        const enEstadoInicial = gruposContainer.classList.contains('grupos-expanded-inicial') &&
            equiposContainer.classList.contains('equipos-expanded-inicial');

        detalleContainer.classList.remove('detalle-mostrando');
        detalleContainer.classList.add('detalle-visible');
        toggleBar.classList.remove('hide');
        toggleBar.classList.add('show');

        gruposContainer.classList.remove('grupos-expanded-inicial');
        gruposContainer.classList.add('grupos-expanded');

        equiposContainer.classList.remove('equipos-expanded-inicial');
        equiposContainer.classList.add('equipos-after-detail');

        if (enEstadoInicial) {
            console.log("✅ Está en estado inicial, ocultamos grupos");
            toggleGrupos();
        }

        fetch(`/api/equipo_detalle/${equipoId}`)
            .then(res => {
                if (!res.ok) throw new Error("Error al obtener datos del equipo");
                return res.json();
            })
            .then(data => {
                if (data.error) {
                    detalleContainer.innerHTML = `<div class="text-danger p-3">${data.error}</div>`;
                    return;
                }

                detalleContainer.innerHTML = construirTabsHTML(data);

                nombreEquipo = data.equipo.nombre_equipo;

                // === Utilidad para whitelistar pestañas ===
                function applyTabWhitelist(allowed) {
                if (!Array.isArray(allowed) || allowed.length === 0) return;

                // Oculta botones de pestaña no permitidos
                document.querySelectorAll('.tab-button').forEach(btn => {
                    const target = btn.dataset.target || btn.getAttribute('data-target');
                    if (!allowed.includes(target)) {
                    btn.classList.add('d-none');
                    btn.disabled = true;
                    }
                });

                // Oculta secciones no permitidas
                document.querySelectorAll('.zone.section').forEach(sec => {
                    if (!allowed.includes(sec.id)) {
                    sec.classList.add('d-none');
                    sec.classList.remove('active');
                    }
                });

                // Activa una permitida si ninguna quedó activa
                const firstAllowed = allowed.find(id => document.getElementById(id));
                const anyActive = document.querySelector('.zone.section.active');
                if (!anyActive && firstAllowed) {
                    const btn = [...document.querySelectorAll('.tab-button')]
                    .find(b => (b.dataset.target || b.getAttribute('data-target')) === firstAllowed);
                    const sec = document.getElementById(firstAllowed);
                    if (btn) btn.classList.add('active');
                    if (sec) sec.classList.remove('d-none'), sec.classList.add('active');
                }
                }

                // === Luego de construir el detalle ===
                // detalleContainer.innerHTML = construirTabsHTML(data);
                if (window.allowedTabs && window.allowedTabs.length) {
                applyTabWhitelist(window.allowedTabs);
                }

                
                document.getElementById('btn-editar-diagrama-flujo')?.addEventListener('click', () => {
                    const equipoId = data.equipo.id;
                    const tipo = 'flujo';
                    const nombreEquipo = encodeURIComponent(data.equipo.nombre_equipo || '');
                    const xml = data.diagrama?.xml_diagrama_flujo || '';
                    const encodedXml = encodeURIComponent(xml);

                    const seccionActiva = 'section4'; // fija para este módulo
                    const fromTexto = 'representaciones_esquematicas';

                    const returnUrl = `${window.location.origin}/equipos_buque/${window.nombreBuque}?id_equipo_info=${equipoId}&section=${seccionActiva}&from=${fromTexto}`;
                    const encodedReturnUrl = encodeURIComponent(returnUrl);

                    if (xml) {
                        localStorage.setItem('drawio_xml', xml);
                    } else {
                        localStorage.removeItem('drawio_xml');
                    }

                    window.location.href = `/editor-diagrama?equipo_id=${equipoId}&tipo=${tipo}&nombre_equipo=${nombreEquipo}&from_url=${encodedReturnUrl}&xml_diagrama=${encodedXml}`;
                });

                // Editar diagrama de Caja Negra
                document.getElementById('btn-editar-diagrama-caja-negra')?.addEventListener('click', () => {
                    const equipoId = data.equipo.id;
                    const tipo = 'caja_negra';
                    const nombreEquipo = encodeURIComponent(data.equipo.nombre_equipo || '');
                    const xml = data.diagrama?.xml_diagrama_caja_negra || '';
                    const encodedXml = encodeURIComponent(xml);

                    const seccionActiva = 'section4';
                    const fromTexto = 'representaciones_esquematicas';
                    const returnUrl = `${window.location.origin}/equipos_buque/${window.nombreBuque}?id_equipo_info=${equipoId}&section=${seccionActiva}&from=${fromTexto}`;
                    const encodedReturnUrl = encodeURIComponent(returnUrl);

                    if (xml) {
                        localStorage.setItem('drawio_xml', xml);
                    } else {
                        localStorage.removeItem('drawio_xml');
                    }

                    window.location.href = `/editor-diagrama?equipo_id=${equipoId}&tipo=${tipo}&nombre_equipo=${nombreEquipo}&from_url=${encodedReturnUrl}&xml_diagrama=${encodedXml}`;
                });

                // Editar diagrama de Caja Transparente
                document.getElementById('btn-editar-diagrama-caja-transparente')?.addEventListener('click', () => {
                    const equipoId = data.equipo.id;
                    const tipo = 'caja_transparente';
                    const nombreEquipo = encodeURIComponent(data.equipo.nombre_equipo || '');
                    const xml = data.diagrama?.xml_diagrama_caja_transparente || '';
                    const encodedXml = encodeURIComponent(xml);

                    const seccionActiva = 'section4';
                    const fromTexto = 'representaciones_esquematicas';
                    const returnUrl = `${window.location.origin}/equipos_buque/${window.nombreBuque}?id_equipo_info=${equipoId}&section=${seccionActiva}&from=${fromTexto}`;
                    const encodedReturnUrl = encodeURIComponent(returnUrl);

                    if (xml) {
                        localStorage.setItem('drawio_xml', xml);
                    } else {
                        localStorage.removeItem('drawio_xml');
                    }

                    window.location.href = `/editor-diagrama?equipo_id=${equipoId}&tipo=${tipo}&nombre_equipo=${nombreEquipo}&from_url=${encodedReturnUrl}&xml_diagrama=${encodedXml}`;
                });


                // 🧩 Llamada centralizada a todas las inicializaciones
                inicializarComponentesDetalleEquipo(data);

                if (!boton) {
                    const listaEquipos = document.getElementById('list-group-equipos');
                    boton = listaEquipos?.querySelector(`.equipo-item[data-id="${equipoId}"]`);
                }

                localStorage.setItem('equipoSeleccionado', equipoId);
                document.querySelectorAll('.equipo-item').forEach(btn => btn.classList.remove('selected'));
                boton?.classList.add('selected');
                
                // ⚡⚡⚡ PRECARGA ULTRA-AGRESIVA: Iniciar descarga de modelo CAD INMEDIATAMENTE
                if (data.equipo.archivo_cad && window.cadPreloader) {
                    console.log('⚡⚡⚡ [ULTRA-PRECARGA] Iniciando descarga CAD en background apenas se selecciona el equipo');
                    
                    // Agregar badge de carga en la pestaña CAD
                    const tabCAD = document.querySelector('.tab-button[data-target="section13"]');
                    if (tabCAD && !tabCAD.querySelector('.preload-badge')) {
                        const badge = document.createElement('span');
                        badge.className = 'preload-badge';
                        badge.innerHTML = '<i class="bi bi-arrow-clockwise spinning"></i>';
                        badge.style.cssText = 'margin-left:6px; color:#2196f3; font-size:12px;';
                        tabCAD.appendChild(badge);
                        
                        // CSS para animación
                        const style = document.createElement('style');
                        style.textContent = `
                            @keyframes spin-preload {
                                0% { transform: rotate(0deg); }
                                100% { transform: rotate(360deg); }
                            }
                            .spinning {
                                display: inline-block;
                                animation: spin-preload 1s linear infinite;
                            }
                        `;
                        document.head.appendChild(style);
                    }
                    
                    // Iniciar precarga silenciosa (sin bloquear nada)
                    window.cadPreloader.prefetchModel(equipoId, 'ultra-high').then(() => {
                        console.log('✅ [ULTRA-PRECARGA] Modelo CAD completamente descargado y cacheado');
                        
                        // Cambiar badge a checkmark
                        const badge = tabCAD?.querySelector('.preload-badge');
                        if (badge) {
                            badge.innerHTML = '<i class="bi bi-check-circle-fill" style="color:#4caf50;"></i>';
                            // Remover después de 2 segundos
                            setTimeout(() => badge.remove(), 2000);
                        }
                    }).catch(err => {
                        console.warn('⚠️ [ULTRA-PRECARGA] No se pudo precargar modelo:', err);
                        const badge = tabCAD?.querySelector('.preload-badge');
                        if (badge) badge.remove();
                    });
                }

                const fmeaTable = document.querySelector('#section9 table tbody');
                const rcmTable = document.querySelector('#section10 table tbody');

                const rcmTabButton = document.getElementById('rcmTabButton');
                const mtaTabButton = document.getElementById('mtaTabButton');

                if (rcmTabButton) rcmTabButton.disabled = !fmeaTable || fmeaTable.children.length === 0;
                if (mtaTabButton) mtaTabButton.disabled = !rcmTable || rcmTable.children.length === 0;

                const observer = new MutationObserver(() => {
                    rcmTabButton.disabled = fmeaTable.children.length === 0;
                    mtaTabButton.disabled = rcmTable.children.length === 0;
                });

                if (fmeaTable) observer.observe(fmeaTable, { childList: true });
                if (rcmTable) observer.observe(rcmTable, { childList: true });

                inicializarScrollHorizontalEn(detalleContainer);
                inicializarBotonPDF();
                inicializarExportarExcel();
                activarBotonesEdicion();
                inicializarTabs();
                inicializarTabsInternosHerramientas();

                if (seccionActivaId) {
                    document.querySelectorAll('.zone.section').forEach(s => {
                        s.classList.remove('active');
                        if (!s.classList.contains('d-none')) s.classList.add('d-none');
                    });

                    const seccion = document.getElementById(seccionActivaId);
                    if (seccion) {
                        seccion.classList.add('active');
                        seccion.classList.remove('d-none');
                    }

                    document.querySelectorAll('.tab-button').forEach(btn => {
                        btn.classList.remove('active');
                        if (btn.dataset.target === seccionActivaId) {
                            btn.classList.add('active');
                        }
                    });
                }
            })
            .catch(err => {
                console.error("❌ Error en fetch:", err);
                detalleContainer.innerHTML = `<div class="text-danger p-3">Error al cargar los datos del equipo.</div>`;
            });
    }


    document.addEventListener("click", function (e) {
        // Busca el elemento disparador con la clase .open-modal (soporta clicks en iconos/children)
        const trigger = e.target.closest && e.target.closest('.open-modal');
        if (trigger) {
            const imgSrc = trigger.getAttribute("data-img");
            const imgTag = document.getElementById("imagenModal");
            if (imgTag) {
                // Si hay imagen, asignarla; si no, borrar src para evitar mostrar imagen previa
                imgTag.src = imgSrc || '';
            }
            // Dejar que Bootstrap abra el modal usando data-bs-toggle / data-bs-target
        }
    });


    function toggleGrupos() {
        const gruposContainer = document.getElementById('grupos-container');
        const equiposContainer = document.getElementById('equipos-container');
        const toggleBar = document.getElementById('toggle-bar');
        const chevronIcon = document.getElementById('chevron-icon');
        const label = toggleBar.querySelector('.rotated-label');

        // Si GRUPOS está visible, entonces lo ocultamos y mostramos EQUIPOS
        if (!gruposContainer.classList.contains('grupos-hidden')) {
            // Ocultar GRUPOS
            gruposContainer.classList.remove('grupos-expanded');
            gruposContainer.classList.add('grupos-collapsing');
            setTimeout(() => {
                gruposContainer.classList.add('grupos-hidden');
            }, 500);

            // Mostrar EQUIPOS (restaurar ancho si estaba oculto)
            equiposContainer.style.opacity = 0;
            equiposContainer.classList.remove('d-none');
            setTimeout(() => {
                equiposContainer.style.opacity = 1;
            }, 100);

            // Actualizar íconos y texto
            chevronIcon.classList.add('rotated');
            label.textContent = "GRUPOS";

        } else {
            // Ocultar EQUIPOS
            equiposContainer.style.opacity = 0;
            setTimeout(() => {
                equiposContainer.classList.add('d-none');
            }, 400);

            // Mostrar GRUPOS
            gruposContainer.classList.remove('grupos-hidden');
            setTimeout(() => {
                gruposContainer.classList.remove('grupos-collapsing');
                gruposContainer.classList.add('grupos-expanded');
            }, 50);

            // Actualizar íconos y texto
            chevronIcon.classList.remove('rotated');
            label.textContent = "EQUIPOS";
        }
    }

    

    function construirGeneralidadesHTML(data) {
        equipo = data.equipo;
        console.log(equipo)
        return `

        `;
    }


    // Función utilitaria global
    function obtenerSeccionesSeleccionadas() {
    const checks = document.querySelectorAll('#formConfiguracionPDF input[name="secciones"]:checked');
    const seleccionadas = Array.from(checks).map(cb => cb.value);

    const verticales = seleccionadas.filter(id => {
        const num = parseInt(id.replace("section", ""));
        return num >= 1 && num <= 5;
    });

    const horizontales = seleccionadas.filter(id => {
        const num = parseInt(id.replace("section", ""));
        return num >= 6 && num <= 11;
    });

    return { verticales, horizontales };
    }

    // Devuelve true si la sección (6..11) tiene al menos una fila "real" en cualquiera de sus tablas
    function seccionTieneDatos(sectionId) {
    const section = document.getElementById(sectionId);
    if (!section) return false;

    const tbodies = section.querySelectorAll('table tbody');
    for (const tbody of tbodies) {
        const rows = Array.from(tbody.querySelectorAll('tr'));
        if (rows.length === 0) continue;

        // Si hay más de una fila en el tbody, asumimos que hay datos
        if (rows.length > 1) return true;

        // rows.length === 1
        const tr = rows[0];
        const cells = Array.from(tr.querySelectorAll('td, th'));
        const txt = (tr.textContent || '').trim().toLowerCase();
        const colspan = parseInt(cells[0]?.getAttribute('colspan') || '1', 10);

        // Caso "placeholder": una sola celda, posiblemente con colspan grande y mensaje tipo "no hay / sin datos / no registrado"
        const esPlaceholder =
        cells.length === 1 &&
        (colspan > 1 || /no hay|sin datos|no disponible|no\s+registrad[oa]s?/.test(txt));

        // Si NO es placeholder, entonces es una fila real (aunque tenga "No disponible" en alguna celda)
        if (!esPlaceholder) return true;
    }

    return false;
    }


    function marcarOpcionSeccion(form, sectionValue, habilitada) {
    const input = form.querySelector(`input[name="secciones"][value="${sectionValue}"]`);
    if (!input) return;

    const label = input.closest('label') || input.parentElement;

    // Crear/recuperar la nota
    let note = label.querySelector('.nota-sin-info');
    if (!note) {
        note = document.createElement('span');
        note.className = 'nota-sin-info';
        label.appendChild(note);
    }

    if (habilitada) {
        input.disabled = false;
        input.setAttribute('aria-disabled', 'false');
        label.classList.remove('pdf-disabled');
        note.textContent = '';
        note.style.display = 'none';
        label.hidden = false;
        label.style.display = '';      // <- asegúrate de que se vea
    } else {
        input.checked = false;
        input.disabled = true;
        input.setAttribute('aria-disabled', 'true');
        label.classList.add('pdf-disabled'); // <- clase propia, no 'disabled'
        note.textContent = '— no tiene información';
        note.style.display = 'inline';
        label.hidden = false;
        label.style.display = '';      // <- que NO se oculte
    }
    }


    // Muestra solo en el modal (formConfiguracionPDF) las secciones 6..11 que tienen datos
    function refrescarSeccionesPDF_6a11() {
        const form = document.getElementById('formConfiguracionPDF');
        if (!form) return;

        // Solo 6..11
        const ids = ['section6','section7','section8','section9','section10','section11'];

        ids.forEach(id => {
            const habilitada = seccionTieneDatos(id);
            marcarOpcionSeccion(form, id, habilitada);
        });
    }



    // Función principal
    window.inicializarBotonPDF = function () {
    // (1) Tomar referencias NUEVAS cada vez (porque re-rendereas el DOM)
    const modal = document.getElementById("modalConfiguracionPDF");
    const contenido = modal?.querySelector(".modal-content");
    const cerrarBtn = document.getElementById("cerrarModalPDF");

    const btnAbrir = document.getElementById("botonPDF");
    const btnVisualizar = document.getElementById("visualizarPDF");
    const btnGenerar = document.getElementById("confirmarGeneracionPDF");

    if (!modal || !contenido || !btnAbrir) return; // si no están en el DOM, salimos

    // (2) Abrir modal (idempotente por elemento)
    if (!btnAbrir.dataset.listenerAttached) {
        btnAbrir.dataset.listenerAttached = "true";
            // Mostrar el modal (filtrando 6..11 según contenido actual)
        btnAbrir.addEventListener("click", (event) => {
        event.preventDefault();
        refrescarSeccionesPDF_6a11();   // 👈 filtra u oculta en caliente
        modal.style.display = "flex";
        });

    }

    // (3) Cerrar modal por backdrop (idempotente por el propio modal)
    if (!modal.dataset.backdropAttached) {
        modal.dataset.backdropAttached = "true";
        modal.addEventListener("click", function (e) {
        if (!contenido.contains(e.target)) modal.style.display = "none";
        });
    }

    // (4) Cerrar con la X (idempotente por el botón)
    if (cerrarBtn && !cerrarBtn.dataset.listenerAttached) {
        cerrarBtn.dataset.listenerAttached = "true";
        cerrarBtn.addEventListener("click", function () {
        modal.style.display = "none";
        });
    }

    // Generar o visualizar PDF según acción
    async function procesarPDF({ visualizar = false }) {
        console.log("📥 Ejecutando generación de PDF");

        try {
            const { verticales, horizontales } = obtenerSeccionesSeleccionadas();

            const pdfBlob1 = verticales.length > 0 ? await generatePDF("zone", verticales) : null;
            const pdfBlob2 = horizontales.length > 0 ? await generateSpecialPDF("special", horizontales) : null;

            if (!pdfBlob1 && !pdfBlob2) {
                console.warn("❌ No se seleccionó ninguna sección.");
                return;
            }

            let combinedPdfBlob;

            if (pdfBlob1 && pdfBlob2) {
            combinedPdfBlob = await combinePDFs(pdfBlob1, pdfBlob2);
            } else {
            combinedPdfBlob = pdfBlob1 || pdfBlob2;
            }

            const finalPdfBlob = await agregarNumeracionGlobal(combinedPdfBlob);
            downloadOrOpenPDF(finalPdfBlob, !visualizar);
            modal.style.display = "none";

        } catch (err) {
            console.error("❌ Error generando el PDF:", err);
        }
    }

    // (5) Botones de acción (ya usabas flags por botón: mantenlos)
    if (btnVisualizar && !btnVisualizar.dataset.listenerAttached) {
        btnVisualizar.dataset.listenerAttached = "true";
        btnVisualizar.addEventListener("click", () => {
        procesarPDF({ visualizar: true }); // tu función existente
        });
    }

    if (btnGenerar && !btnGenerar.dataset.listenerAttached) {
        btnGenerar.dataset.listenerAttached = "true";
        btnGenerar.addEventListener("click", () => {
        procesarPDF({ visualizar: false }); // tu función existente
        });
    }
    };


    // ----- Inicializador de botones de Excel (similar a inicializarBotonPDF) -----
    window.inicializarExportarExcel = function () {
    // Botón: Equipos y características
    const btnEquipos = document.getElementById('btnExcelEquipos');
    if (btnEquipos && !btnEquipos.dataset.listenerAttached) {
        btnEquipos.dataset.listenerAttached = 'true';
        btnEquipos.addEventListener('click', () => {
        console.log('🟢 Click en #btnExcelEquipos');
        try {
            if (typeof window.exportarExcel === 'function') {
            window.exportarExcel();
            } else {
            console.warn('⚠️ exportarExcel() no está disponible en window.');
            }
        } catch (err) {
            console.error('❌ Error ejecutando exportarExcel():', err);
        }
        });
    }

    // (Opcional) Botón: Ubicación técnica — deja el hook listo
    const btnUbic = document.getElementById('btnExcelUbicacion');
    if (btnUbic && !btnUbic.dataset.listenerAttached) {
        btnUbic.dataset.listenerAttached = 'true';
        btnUbic.addEventListener('click', () => {
        console.log('🟢 Click en #btnExcelUbicacion');
        if (typeof window.exportarExcelUbicacionTecnica === 'function') {
            window.exportarExcelUbicacionTecnica();
        } else {
            console.warn('⚠️ exportarExcelUbicacionTecnica() no está definida aún.');
        }
        });
    }
    };

    // ----- exportarExcel: versión completa usando /api/equipos_por_buque_excel/:id_buque -----
    window.exportarExcel = async function () {
    console.log('🚀 exportarExcel() ejecutándose.');
    try {
        if (typeof ExcelJS === 'undefined') {
        console.error('❌ ExcelJS no está disponible. Asegúrate de incluir el script de ExcelJS antes.');
        return;
        }

        const buqueId = window.buqueId;
        if (!buqueId) {
        console.warn('⚠️ window.buqueId no está definido. No se puede consultar el endpoint por buque.');
        return;
        }

        // Llamada a tu endpoint backend
        const url = `/api/equipos_por_buque_excel/${encodeURIComponent(buqueId)}`;
        console.log('Fetch a:', url);
        const response = await fetch(url);
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        const data = await response.json();
        console.log(`📦 Recibidos ${data.length} equipos`);

        // === Utilidad: formatea a DDMMAAAA ===
        function formatDDMMAAAA(input) {
            if (!input) return '';
            if (typeof input === 'string' && /^\d{8}$/.test(input)) return input; // ya DDMMAAAA
            if (typeof input === 'string' && /^\d{4}-\d{2}-\d{2}/.test(input)) {
                const [y, m, d] = input.substring(0, 10).split('-');
                return `${d}${m}${y}`;
            }
            if (typeof input === 'string' && /^\d{2}\/\d{2}\/\d{4}$/.test(input)) {
                const [d, m, y] = input.split('/');
                return `${d}${m}${y}`;
            }
            const dt = new Date(input); // maneja "Wed, 13 Aug 2025 00:00:00 GMT", ISO, etc.
            if (!isNaN(dt.getTime())) {
                const d = String(dt.getDate()).padStart(2, '0');
                const m = String(dt.getMonth() + 1).padStart(2, '0');
                const y = String(dt.getFullYear());
                return `${d}${m}${y}`;
            }
            return '';
        }

        // Normaliza fechas antes de construir el Excel
        const rows = data.map(r => ({
        ...r,
        datsl: formatDDMMAAAA(r.datsl),
        inbdt: formatDDMMAAAA(r.inbdt),
        }));

        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet('Equipos');

        // Estilos
        const estiloEstatico = {
        fill: { type: 'pattern', pattern: 'solid', fgColor: { argb: '548235' } }, // Verde
        border: { top: { style: 'thin' }, left: { style: 'thin' }, bottom: { style: 'thin' }, right: { style: 'thin' } },
        };
        const estiloVacio = {
        fill: { type: 'pattern', pattern: 'solid', fgColor: { argb: 'F8CBAD' } }, // Rosado
        border: { top: { style: 'thin' }, left: { style: 'thin' }, bottom: { style: 'thin' }, right: { style: 'thin' } },
        };
        const estiloDinamico = {
        fill: { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FFFF00' } }, // Amarillo
        border: { top: { style: 'thin' }, left: { style: 'thin' }, bottom: { style: 'thin' }, right: { style: 'thin' } },
        };

        // Orden de columnas según especificación (igual a tu app original)
        const columnasOrdenadas = [
        'datsl', 'eqtyp', 'shtxt', 'brgew', 'gewei', 'groes', 'invnr', 'inbdt',
        'eqart', 'answt', 'ansdt', 'waers', 'herst', 'herld', 'typbz', 'baujj',
        'baumm', 'mapar', 'serge', 'datab', 'swerk', 'Local', 'abckz', 'eqfnr',
        'bukrs', 'kostl', 'iwerk', 'ingrp', 'gewrk', 'wergw', 'rbnr', 'tplnr',
        'heqnr', 'hstps', 'posnr', 'lbbsa', 'b_werk', 'b_lager', 'class',
        ];

        const encabezadosMap = {
        datsl: 'datsl(008), " VALIDO EL',
        eqtyp: 'eqtyp(001), " TIPO DE EQUIPO',
        shtxt: 'shtxt(040), " DENOMINACIÓN',
        brgew: 'brgew(013), " Peso del objeto',
        gewei: 'gewei(003), " Unidad de peso',
        groes: 'groes(018), " Tamaño/Dimensión',
        invnr: 'invnr(025), " Número de inventario',
        inbdt: 'inbdt(008), " Fecha de puesta en servicio de objeto técnico',
        eqart: 'eqart(010), " CLASE DE OBJETO TIPO DE EQUIPO',
        answt: 'answt(013), " Valor de adquisición',
        ansdt: 'ansdt(008), " Fecha de adquisición',
        waers: 'waers(005), " Clave de moneda',
        herst: 'herst(030), " Fabricante del activo fijo',
        herld: 'herld(003), " País de fabricación',
        typbz: 'typbz(020), " Denominación de tipo del fabricante',
        baujj: 'baujj(004), " Año de construcción',
        baumm: 'baumm(002), " Mes de construcción',
        mapar: 'mapar(040), " Número de pieza de fabricante',
        serge: 'serge(030), " Número de serie según el fabricante',
        datab: 'datab(008), " VALIDO DE',
        swerk: 'swerk(004), " Centro de emplazamiento',
        Local: 'Local',
        abckz: 'abckz(001), " Indicador ABC para objeto técnico CRITICIDAD',
        eqfnr: 'eqfnr(030), " Campo de clasificación',
        bukrs: 'bukrs(004), " Sociedad',
        kostl: 'kostl(010), " Ceco',
        iwerk: 'iwerk(004), " Centro',
        ingrp: 'ingrp(003), " Grupo planific p.servicio cliente mantenimiento',
        gewrk: 'gewrk(008), " Puesto trabajo responsable medidas mantenimient DIVISIÓN DE MANTENIMIENTO',
        wergw: 'wergw(004), " Centro del puesto de trabajo responsable',
        rbnr: 'rbnr(009), " Perfil de catálogo',
        tplnr: 'tplnr(030), " Ubicación técnica',
        heqnr: 'heqnr(018), " Equipo superior',
        hstps: 'hstps(004), " Posición equipo lugarmontaje(eq.sup./ubic.técn)',
        posnr: 'posnr(004), " Posición en objeto técnico superior',
        lbbsa: 'lbbsa(002), " Tipo stocks',
        b_werk: 'b_werk(004), " Centro',
        b_lager: 'b_lager(004), " Almacén',
        class:  'class(018), " N° de clase',
        };

        // Calcular máximo de características dinámicas a partir del JSON de cada fila
        const maxCaracteristicas = Math.max(
        0,
        ...rows.map((row) => {
            let car = row.caracteristicas;
            if (!car) return 0;
            try { if (typeof car === 'string') car = JSON.parse(car || '{}'); }
            catch { car = {}; }
            return Object.keys(car || {}).length;
        })
        );

        // Definir columnas dinámicas carNN / valNN
        const columnasDinamicas = [];
        for (let i = 1; i <= maxCaracteristicas; i++) {
        const indexStr = i.toString().padStart(2, '0');
        columnasDinamicas.push(`car${indexStr}(030), " Caracteristica ${indexStr}`);
        columnasDinamicas.push(`val${indexStr}(030), " valor`);
        }

        // Encabezados
        const encabezados = [...columnasOrdenadas, ...columnasDinamicas];
        const filaEncabezados = worksheet.addRow(encabezados.map((col) => encabezadosMap[col] || col));

        // Estilos de encabezado
        filaEncabezados.eachCell((cell, colNumber) => {
        const header = encabezados[colNumber - 1];
        if (columnasOrdenadas.includes(header)) {
            if ([
            'invnr','datab','swerk','Local','eqfnr','bukrs','kostl','iwerk',
            'ingrp','wergw','rbnr','heqnr','hstps','posnr','lbbsa','b_werk','b_lager'
            ].includes(header)) {
            cell.style = estiloVacio;   // Vacías por defecto
            } else {
            cell.style = estiloEstatico;// Fijas
            }
        } else {
            cell.style = estiloEstatico;  // Dinámicas en verde
        }
        });

        // Filas de datos
        rows.forEach((row) => {
        // Base de columnas fijas
        const filaDatos = columnasOrdenadas.map((c) => row[c] ?? '');

        // Parse de características
        let carObj = {};
        try {
            carObj = typeof row.caracteristicas === 'string'
            ? JSON.parse(row.caracteristicas || '{}')
            : (row.caracteristicas || {});
        } catch {
            carObj = {};
        }
        const keys = Object.keys(carObj);

        // Rellenar dinámicas carNN / valNN
        for (let i = 0; i < maxCaracteristicas; i++) {
            const k = keys[i] || '';
            const v = k ? (carObj[k] ?? '') : '';
            filaDatos.push(k);
            filaDatos.push(v);
        }

        const fila = worksheet.addRow(filaDatos);

        // Estilos por celda
        fila.eachCell((cell, colNumber) => {
            const header = encabezados[colNumber - 1];
            const value  = filaDatos[colNumber - 1];

            if (columnasOrdenadas.includes(header)) {
            if ([
                'invnr','datab','swerk','Local','eqfnr','bukrs','kostl','iwerk',
                'ingrp','wergw','rbnr','heqnr','hstps','posnr','lbbsa','b_werk','b_lager'
            ].includes(header)) {
                cell.style = estiloVacio;
            } else if (value !== null && value !== undefined && value !== '') {
                cell.style = estiloEstatico;
            } else {
                cell.style = estiloDinamico;
            }
            } else {
            // columnas dinámicas
            cell.style = (value !== null && value !== undefined && value !== '') ? estiloEstatico : estiloDinamico;
            }
        });
        });

        // Ancho de columnas
        worksheet.columns = encabezados.map((h) => ({ width: Math.max(18, String(h).length + 8) }));

        // Descargar
        const buffer = await workbook.xlsx.writeBuffer();
        const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        const urlBlob = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = urlBlob;
        a.download = 'equipos.xlsx';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(urlBlob);

        console.log('✅ Excel generado y descargado: equipos.xlsx');
    } catch (error) {
        console.error('Error al exportar el Excel:', error);
        if (window.Swal) {
        Swal.fire({ icon: 'error', title: 'Error', text: 'Ocurrió un error al exportar el Excel.', confirmButtonColor: '#763626' });
        } else {
        alert('Ocurrió un error al exportar el Excel.');
        }
    }
    };
    
    window.exportarExcelUbicacionTecnica = async function () {
    console.log('🚀 exportarExcelUbicacionTecnica() ejecutándose.');
    try {
        if (typeof ExcelJS === 'undefined') {
        console.error('❌ ExcelJS no está disponible. Asegúrate de incluir el script de ExcelJS antes.');
        return;
        }

        const buqueId = window.buqueId;
        if (!buqueId) {
        console.warn('⚠️ window.buqueId no está definido. No se puede consultar el endpoint por buque.');
        return;
        }

        // ---------------- Helpers ----------------
        const s = (v) => (v === null || v === undefined) ? '' : String(v);
        const obtenerDescripcionNivelFallback = async (_rutaParcial, _segmentos, idx) =>
        idx === 0 ? 'Número del casco' : `Nivel ${idx + 1}`;
        const obtenerDescripcionNivel =
        (typeof window.obtenerDescripcionNivel === 'function')
            ? window.obtenerDescripcionNivel
            : obtenerDescripcionNivelFallback;
        const parseCaracteristicas = (value) => {
        if (!value) return {};
        try {
            if (typeof value === 'string') return JSON.parse(value || '{}') || {};
            if (typeof value === 'object') return value || {};
        } catch (e) {}
        return {};
        };
        const norm = (t) => s(t).toUpperCase().replace(/[^A-Z0-9]/g, '');
        const parseToken = (t) => {
        const m = t.match(/^([A-Za-z]*)(\d+)?$/);
        return {
            prefix: (m && m[1]) ? m[1] : '',
            num: (m && m[2]) ? parseInt(m[2], 10) : (/^\d+$/.test(t) ? parseInt(t, 10) : NaN),
            raw: t
        };
        };
        const cmpRuta = (a, b) => {
        const sa = a.split('-'), sb = b.split('-');
        const len = Math.max(sa.length, sb.length);
        for (let i = 0; i < len; i++) {
            const ta = sa[i], tb = sb[i];
            if (ta === undefined) return -1;
            if (tb === undefined) return 1;
            const pa = parseToken(ta), pb = parseToken(tb);
            const px = pa.prefix.localeCompare(pb.prefix, undefined, { sensitivity: 'base' });
            if (px !== 0) return px;
            const na = isNaN(pa.num) ? Number.NEGATIVE_INFINITY : pa.num;
            const nb = isNaN(pb.num) ? Number.NEGATIVE_INFINITY : pb.num;
            if (na !== nb) return na - nb;
            const lx = ta.localeCompare(tb, undefined, { numeric: true, sensitivity: 'base' });
            if (lx !== 0) return lx;
        }
        return 0;
        };

        // ---------------- Datos ----------------
        // 1) equipos
        const url = `/api/equipos_por_buque_excel/${encodeURIComponent(buqueId)}`;
        const resp = await fetch(url);
        if (!resp.ok) throw new Error(`HTTP ${resp.status} al consultar ${url}`);
        const equipos = await resp.json();

        // 2) datos_sap
        const urlSap = `/api/buques/${encodeURIComponent(buqueId)}/datos-sap`;
        let datosSap = {};
        let numeroCasco = '';
        let nombreBuque = '';
        let pesoBuque = '';
        let unidadPeso = '';
        let tamanoDimension = '';
        try {
        const r = await fetch(urlSap);
        if (r.ok) {
            const j = await r.json();
            datosSap = j.datos_sap ?? j.datosSap ?? {};
            if (typeof datosSap === 'string') {
            try { datosSap = JSON.parse(datosSap); } catch (e) { datosSap = {}; }
            }
            numeroCasco      = s(j.numero_casco || '');
            nombreBuque      = s(j.nombre_buque || '');
            pesoBuque        = s(j.peso_buque || '');
            unidadPeso       = s(j.unidad_peso || '');
            tamanoDimension  = s(j.tamano_dimension_buque || '');
            console.log('ℹ️ datos_sap:', datosSap, 'numero_casco:', numeroCasco, 'nombre_buque:', nombreBuque);
        } else {
            console.warn('⚠️ No se pudo obtener datos_sap:', r.status);
        }
        } catch (e) {
        console.warn('⚠️ Error consultando datos_sap:', e);
        }

        const dsTec = (datosSap && (datosSap.tecnico   || datosSap.DATO_TECNIC_BUQUE))  || {};
        const dsLog = (datosSap && (datosSap.logistico || datosSap.DATO_LOGIST_BUQUE))  || {};
        const dsHis = (datosSap && (datosSap.historico || datosSap.DATO_HISTOR_BUQUE))  || {};

        // ---------------- Libro / Hoja ----------------
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet('Ubicaciones Técnicas');

        // Encabezados A..I
        const headersAI = [
        'Identificación de ubicación técnica',
        'Indicador de estructura ubicación técnica',
        'Tipo de ubicación técnica',
        'Denominación de la ubicación técnica',
        'Peso del objeto',
        'Unidad de peso',
        'Tamaño/Dimensión',
        'Fecha de puesta en servicio de objeto técnico',
        'Clase de objeto'
        ];

        // J..AU: car/val
        const headersCarVal = [];
        for (let i = 1; i <= 19; i++) {
        headersCarVal.push(`car${i.toString().padStart(2, '0')}(030),\n" Caracteristica ${i}`);
        headersCarVal.push(`val${i.toString().padStart(2, '0')}(030),\n" valor`);
        }

        // Columnas extra
        const headersExtras = [
        'Centro de emplazamiento',
        'Emplazamiento del objeto de mantenimiento',
        'Campo de clasificacion',
        'Sociedad',
        'Centro de costo',
        'Centro',
        'Grupo planificación servicio cliente mantenimiento',
        'Puesto trabajo responsable medidas mantenimiento',
        'Centro del puesto de trabajo responsable',
        'Perfil de catálogo',
        'Ubicación técnica superior',
        'Se permite montaje equipos en ubicación técnica',
        'Montaje individual equipo en ubicación técnica',
        'CAPACIDAD DE AGUA',
        'CAPACIDAD DE LUBRICANTE',
        'DESPLAZAMIENTO',
        'MANUALES TECNICOS',
        'LUGAR DE CONSTRUCCION',
        'FECHA DE CONSTRUCCION',
        'NUMERO CASCO JEMAN',
        'SIGLA INTERNACIONAL UNIDAD',
        'FUERZA',
        'Fecha Resolucion Alta',
        'Fecha Resolucion Baja',
        'Fecha Resolucion Traslado',
        'ULTIMA SUBIDA DIQUE',
        'ULTIMA BAJADA DIQUE',
        'TIPO DE ACEITE 1',
        'TIPO DE ACEITE 2',
        'TIPO DE ACEITE 3',
        'TIPO DE ACEITE 4',
        'TIPO DE GRASA 1',
        'TIPO DE GRASA 2',
        'TIPO DE COMBUSTIBLE 1',
        'SITUACION PROYECTADA A 1 MES'
        ];

        const encabezados = [...headersAI, ...headersCarVal, ...headersExtras];
        worksheet.addRow(encabezados);
        worksheet.getRow(1).height = 60;
        worksheet.getRow(1).eachCell((cell) => {
        cell.alignment = { vertical: 'middle', horizontal: 'center', wrapText: true };
        cell.font = { name: 'Arial', size: 9 };
        });

        // ---- Fila 2 plantilla
        const PLANTILLA_A_I = [40, 4, 1, 40, 13, 3, 18, 8, 10];
        const fila2 = [];
        fila2.push(...PLANTILLA_A_I);
        for (let i = 0; i < 38; i++) fila2.push(''); // J..AU
        const PLANTILLA_24_EXTRAS = [8, 10, 13, 8, 5, 30, 3, 20, 4, 2, 30, 30, 4, 10, 30, 4, 10, 4, 3, 4, 9, 30, 1, 1];
        fila2.push(...PLANTILLA_24_EXTRAS);
        for (let i = 0; i < (headersExtras.length - PLANTILLA_24_EXTRAS.length); i++) fila2.push('');
        const row2 = worksheet.addRow(fila2);
        row2.eachCell((c) => {
        c.font = { name: 'Arial', size: 9 };
        c.alignment = { horizontal: 'center' };
        });

        // ---- Anchos
        const anchosColumnas = [
        26.86, 10.71, 7.86, 73.29, 7.29, 7.43, 24.43, 40.14, 26.14,
        31.86, 17.57, 17.57, 17.57, 17.57, 17.57, 17.57, 17.57, 17.57, 17.57, 17.57,
        17.57, 17.57, 17.57, 17.57, 17.57, 17.57, 17.57, 17.57, 17.57, 17.57,
        17.57, 17.57, 17.57, 17.57
        ];
        worksheet.columns.forEach((col, i) => { col.width = anchosColumnas[i] || 15; });

        // ---------------- Catálogo (si llegas a usarlo)
        const catalogoGlobalPorClase =
        (typeof window.caracteristicas === 'object' && window.caracteristicas) ? window.caracteristicas : null;

        const inferidoPorClase = new Map();
        if (!catalogoGlobalPorClase) {
        for (const eq of equipos) {
            const clase = s(eq.class);
            if (!clase) continue;
            const obj = parseCaracteristicas(eq.caracteristicas);
            const keys = Object.keys(obj).filter(k => k && k.trim());
            if (!inferidoPorClase.has(clase)) inferidoPorClase.set(clase, []);
            const lista = inferidoPorClase.get(clase);
            for (const k of keys) {
            if (lista.length >= 19) break;
            if (!lista.includes(k)) lista.push(k);
            }
        }
        }
        const getListaCaracteristicas = (claseObjeto) => {
        if (!claseObjeto) return [];
        if (catalogoGlobalPorClase && Array.isArray(catalogoGlobalPorClase[claseObjeto])) {
            return catalogoGlobalPorClase[claseObjeto].slice(0, 19);
        }
        if (inferidoPorClase.has(claseObjeto)) return inferidoPorClase.get(claseObjeto);
        return [];
        };

        // ---------------- Mapeos + árbol ----------------
        const nombrePorRuta = new Map();
        const setRutas = new Set();
        const hojasPorRuta = new Map();

        for (const eq of equipos) {
        const tplnr = s(eq.tplnr).trim();
        if (!tplnr) continue;
        const segs = tplnr.split('-').map(x => x.trim()).filter(Boolean);
        if (!segs.length) continue;

        const casco = segs[0];
        const g   = s(eq.grupo_numeracion || eq.grupo_numeracion);
        const sg  = s(eq.subgrupo_numeracion || eq.subgrupo_numeracion);
        const sis = s(eq.sistema_numeracion || eq.sistema_numeracion);
        const ssr = s(eq.subsistema_num_ref || eq.subsistema_num_ref);

        if (g) {
            const rutaG = `${casco}-${g}`;
            if (!nombrePorRuta.has(rutaG)) {
            const nom = s(eq.grupo_nombre || eq.grupo_nombre);
            if (nom) nombrePorRuta.set(rutaG, `GRUPO ${g} ${nom}`);
            }
        }
        if (g && sg) {
            const rutaSG = `${casco}-${g}-${sg}`;
            if (!nombrePorRuta.has(rutaSG)) {
            const nom = s(eq.subgrupo_nombre || eq.subgrupo_nombre);
            if (nom) nombrePorRuta.set(rutaSG, nom);
            }
        }
        if (g && sg && sis) {
            const rutaSIS = `${casco}-${g}-${sg}-${sis}`;
            if (!nombrePorRuta.has(rutaSIS)) {
            const nom = s(eq.sistema_nombre || eq.sistema_nombre);
            if (nom) nombrePorRuta.set(rutaSIS, nom);
            }
        }
        if (g && sg && sis && ssr) {
            const rutaSS = `${casco}-${g}-${sg}-${sis}-${ssr}`;
            if (!nombrePorRuta.has(rutaSS)) {
            const nom = s(eq.subsistema_descripcion || eq.subsistema_descripcion);
            if (nom) nombrePorRuta.set(rutaSS, nom);
            }
        }

        let r = '';
        for (let i = 0; i < segs.length; i++) {
            r = (i === 0) ? segs[0] : `${r}-${segs[i]}`;
            setRutas.add(r);
        }
        if (!hojasPorRuta.has(tplnr)) hojasPorRuta.set(tplnr, eq);
        }

        const rutasOrdenadas = Array.from(setRutas).sort(cmpRuta);

        // Construcción de filas (A..I, sin SAP)
        const routeToRow = new Map();
        for (const ruta of rutasOrdenadas) {
        const segs = ruta.split('-');
        const idx = segs.length - 1;
        const eq = hojasPorRuta.get(ruta);
        const esHoja = !!eq;

        let descripcion = nombrePorRuta.get(ruta);
        if (!descripcion) {
            descripcion = await obtenerDescripcionNivel(ruta, segs, idx);
        }

        const filaAI = esHoja
            ? [ruta, '', '', descripcion, s(eq.brgew), s(eq.gewei), s(eq.groes), '', '']
            : [ruta, '', '', descripcion, '', '', '', '', ''];

        const row = worksheet.addRow([
            ...filaAI,
            ...Array(38).fill(''),
            ...Array(headersExtras.length).fill('')
        ]);
        row.eachCell((c)=>{ c.font = { name:'Arial', size:9 }; });

        routeToRow.set(ruta, row);
        }

        // ---------- Aplicar TECNICO (casco), LOGISTICO (primer nivel 2), HISTORICO (primer nivel 3) ----------
        const COL_J = 10;

        // casco (profundidad 1)
        const cascoRuta = rutasOrdenadas.find(r => r.split('-').length === 1) || '';
        const rowCasco  = cascoRuta ? routeToRow.get(cascoRuta) : null;

        // primer nivel 2 bajo ese casco (ej: ARC24-300)
        const rutaNivel2 = rutasOrdenadas.find(r => r.startsWith(cascoRuta + '-') && r.split('-').length === 2);
        const rowNivel2  = rutaNivel2 ? routeToRow.get(rutaNivel2) : null;

        // primer nivel 3 bajo ese casco (ej: ARC24-300-310)
        const rutaNivel3 = rutasOrdenadas.find(r => r.startsWith(cascoRuta + '-') && r.split('-').length === 3);
        const rowNivel3  = rutaNivel3 ? routeToRow.get(rutaNivel3) : null;

        const valorSAP = (clave) => {
        if (clave === 'numero_casco_unidad_naval') {
            return s(datosSap[clave] ?? numeroCasco ?? 'PENDIENTE');
        }
        const v = datosSap[clave];
        return (v === undefined || v === null || v === '') ? 'PENDIENTE' : s(v);
        };

        const catalogoSAP = [
        ['ESLORA', 'eslora'],
        ['MANGA', 'manga'],
        ['PUNTAL', 'puntal'],
        ['Calado en Metros', 'calado_metros'],
        ['Altura Mastil', 'altura_mastil'],
        ['Altura Maxima del Buque', 'altura_maxima_buque'],
        ['Tipo de Material Construccion', 'tipo_material_construccion'],
        ['Sigla Internacional Unidad', 'sigla_internacional_unidad'],
        ['Tipo de Buque', 'tipo_buque'],
        ['Número de Casco Unidad Naval', 'numero_casco_unidad_naval'],
        ['Plano Numero', 'plano_numero'],
        ['Autonomia Dias', 'autonomia_dias'],
        ['Autonomia Millas Nauticas', 'autonomia_millas_nauticas'],
        ['Desp Cond 1 Peso en Rosca', 'desp_cond_1_peso_rosca'],
        ['Desp Cond 2 10% de Consumibles', 'desp_cond_2_10_consumibles'],
        ['Desp Cond 3 Minima Operacional', 'desp_cond_3_minima_operacional'],
        ['Desp Cond 4 50% de Consumibles', 'desp_cond_4_50_consumibles'],
        ['Desp Cond 5 Optima Operacional', 'desp_cond_5_optima_operacional'],
        ['Desp Cond 6 Zarpe Plena Carga', 'desp_cond_6_zarpe_plena_carga'],
        ];

        const putPairs = (row, dict) => {
        if (!row || !dict) return;
        const entries = Object.entries(dict);
        for (let i = 0; i < Math.min(entries.length, 19); i++) {
            const [label, value] = entries[i];
            const colCar = COL_J + (i * 2);
            const colVal = colCar + 1;
            row.getCell(colCar).value = String(label);
            row.getCell(colVal).value = (value === null || value === undefined || value === '') ? 'PENDIENTE' : String(value);
        }
        };

        // TECNICO en casco
        if (rowCasco) {
        if (nombreBuque) rowCasco.getCell(4).value = nombreBuque.toUpperCase();
        rowCasco.getCell(5).value = pesoBuque;
        rowCasco.getCell(6).value = unidadPeso;
        rowCasco.getCell(7).value = tamanoDimension;
        rowCasco.getCell(9).value = 'DATO_TECNIC_BUQUE';
        for (let i = 0; i < Math.min(catalogoSAP.length, 19); i++) {
            const [label, key] = catalogoSAP[i];
            const colCar = COL_J + (i * 2);
            const colVal = colCar + 1;
            rowCasco.getCell(colCar).value = label;
            rowCasco.getCell(colVal).value = valorSAP(key);
        }
        }

        // LOGISTICO en primer nivel 2 EXISTENTE (ej: ARC24-300)
        if (rowNivel2) {
        rowNivel2.getCell(9).value = 'DATO_LOGIST_BUQUE';
        putPairs(rowNivel2, dsLog);
        }

        // HISTORICO en primer nivel 3 EXISTENTE (ej: ARC24-300-310)
        if (rowNivel3) {
        rowNivel3.getCell(9).value = 'DATO_HISTOR_BUQUE';
        putPairs(rowNivel3, dsHis);
        }

        // ✅ NUEVO: características SOLO para ubicaciones técnicas completas (hojas profundas)
        // (no tocar las filas donde pusimos SAP; profundidad > 3, p.ej. ARC24-300-310-311-3112)
        const sapRows = new Set([rowCasco, rowNivel2, rowNivel3].filter(Boolean));
        for (const [ruta, eq] of hojasPorRuta.entries()) {
        const row = routeToRow.get(ruta);
        if (!row || sapRows.has(row)) continue;             // no sobreescribir SAP
        if (ruta.split('-').length <= 3) continue;          // solo hojas profundas (ubicación completa)

        // ➕ NUEVO: escribir Clase de objeto (columna I) con la clase real del equipo
        if (!row.getCell(9).value && eq && eq.class) {
            row.getCell(9).value = String(eq.class);
        }

        // características del equipo (hasta 19 pares)
        const obj = parseCaracteristicas(eq.caracteristicas);
        const entries = Object.entries(obj).filter(([k]) => k && String(k).trim());
        if (!entries.length) continue;

        for (let i = 0; i < Math.min(entries.length, 19); i++) {
            const [label, value] = entries[i];
            const colCar = COL_J + (i * 2);
            const colVal = colCar + 1;
            if (!row.getCell(colCar).value) row.getCell(colCar).value = String(label);
            row.getCell(colVal).value = (value === null || value === undefined) ? '' : String(value);
        }
        }

        // ---------------- Colores por columna (conservar) ----------------
        const coloresAI = [
        '76933C','D9D9D9','D9D9D9','76933C','76933C','76933C','76933C','D9D9D9','D9D9D9'
        ];
        const coloresCarVal = Array(38).fill('76933C');
        const coloresExtras = Array(headersExtras.length).fill('E6B8B7');
        const coloresColumnas = [...coloresAI, ...coloresCarVal, ...coloresExtras];

        worksheet.columns.forEach((column, idx) => {
        if (idx < coloresColumnas.length) {
            column.eachCell({ includeEmpty: true }, (cell) => {
            cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: coloresColumnas[idx] } };
            });
        }
        });

        // Bordes globales
        worksheet.eachRow((row) => {
        row.eachCell({ includeEmpty: true }, (cell) => {
            cell.border = {
            top: { style: 'thin' },
            left: { style: 'thin' },
            bottom: { style: 'thin' },
            right: { style: 'thin' }
            };
        });
        });

        // Centrar columna D
        worksheet.getColumn(4).eachCell({ includeEmpty: true }, (cell) => {
        cell.alignment = { ...(cell.alignment || {}), horizontal: 'center' };
        });

        // Descargar
        const buffer = await workbook.xlsx.writeBuffer();
        const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        const urlBlob = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = urlBlob;
        a.download = `ubicaciones_tecnicas_${buqueId}.xlsx`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(urlBlob);

        console.log('✅ Exportación completada.');
    } catch (error) {
        console.error('Error al exportar Excel:', error);
        if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error al exportar el Excel.',
            confirmButtonColor: '#763626',
        });
        }
    }
    };

    // ========= Tabs (una sola implementación) =========
    (function initTabsExportables(){
    if (window._tabsExportablesInit) return;
    window._tabsExportablesInit = true;

    // Hago accesible switchTab dentro y fuera (lo usa inicializarBotonPDF)
    window.switchTab = function(tabId){
        const container = document.getElementById('modalConfiguracionPDF');
        if (!container) return;
        const tabButtons = container.querySelectorAll('.tabs-exportables .tab-btn');
        const tabPanels  = container.querySelectorAll('.tab-panel');
        tabButtons.forEach(b => b.classList.toggle('active', b.dataset.tab === tabId));
        tabPanels.forEach(p => p.classList.toggle('active', p.id === tabId));
    }

    // Vincular botones de pestañas
    document.querySelectorAll('.tabs-exportables .tab-btn').forEach(btn => {
        if (btn.dataset.listenerAttached) return;
        btn.dataset.listenerAttached = 'true';
        btn.addEventListener('click', () => window.switchTab(btn.dataset.tab));
    });
    })();


    async function agregarNumeracionGlobal(pdfBlob) {
        const arrayBuffer = await pdfBlob.arrayBuffer();
        const pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer);
        const font = await pdfDoc.embedFont(PDFLib.StandardFonts.Helvetica);
        const totalPages = pdfDoc.getPageCount();

        for (let i = 1; i < totalPages; i++) {
            const page = pdfDoc.getPage(i);
            const { width } = page.getSize();

            page.drawText(`Página ${i + 1} | ${totalPages}`, {
            x: width - 140,                // ⬅️ izquierda
            y: 55,                // ⬅️ desde el borde inferior
            size: 10,             // tamaño de fuente
            font: font,
            color: PDFLib.rgb(0, 0.2, 0.6) // azul oscuro
            });
        }

        const finalBytes = await pdfDoc.save();
        return new Blob([finalBytes], { type: 'application/pdf' });
        }

    document.addEventListener("DOMContentLoaded", () => {
    window.inicializarBotonPDF();
    });


    function construirTabsHTML(data) {
        console.log("data recibida:", data);
        const equipo = data.equipo;
        equipo.datsl = formatFecha(equipo.datsl);
        equipo.inbdt = formatFecha(equipo.inbdt);
        equipo.ansdt = formatFecha(equipo.ansdt);
        console.log(equipo)
        return `
            <!-- HTML -->
            <div class="row toolBar">
                <div class="m-0 tab-nav-wrapper">
                    <button class="scroll-btn left-btn" onclick="scrollTabs('left')">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <div class="tab-scroll-container">
                        <div class="buttons" id="tabButtons">
                            <button class="tab-button btn active" data-target="section1">Generalidades</button>
                            <button class="tab-button btn" data-target="section13">Modelo CAD</button>
                            <button class="tab-button btn" data-target="section2">Detalles del Equipo</button>
                            <button class="tab-button btn" data-target="section3">Procedimientos</button>
                            <button class="tab-button btn" data-target="section4">Representaciones esquemáticas</button>
                            <button class="tab-button btn" data-target="section5">Datos de Fiabilidad</button>
                            <button class="tab-button btn" data-target="section6">Análisis Funcional</button>
                            <button class="tab-button btn" data-target="section7">Módulo de Herramientas</button>
                            <button class="tab-button btn" data-target="section8">Módulo de Repuestos</button>
                            <button class="tab-button btn" data-target="section9">FMEA</button>
                            <button id="rcmTabButton" class="tab-button btn" data-target="section10">RCM</button>
                            <button id="mtaTabButton" class="tab-button btn" data-target="section11">MTA LORA</button>
                            <button class="tab-button btn" data-target="section12">FUA</button>
                            <button id="btn-eliminar-equipo" class="btn btn-danger no-print" style="background-color: #b02a37;" data-equipo-id="${data.equipo.id}">
                                <i class="bi bi-trash-fill" style="color: whitesmoke;"></i>
                            </button>
                        </div>
                    </div>
                    <button class="scroll-btn right-btn" onclick="scrollTabs('right')">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>

    
            <div class="content">
                <div id="section1" class="zone section active padding pt-3 pb-3" data-id-equipo="${equipo.id}">
                    <div class="encabezado-generalidades d-flex align-items-center justify-content-center gap-3" style="border-bottom: 1px solid rgb(229 231 235); padding-bottom: 6px;">
                        <h3 class="titulo mb-0">Generalidades</h3>

                        <div class="d-flex gap-2">
                            <!-- Botón de lápiz/cerrar -->
                            <button 
                                class="btn btn-sm no-print btn-toggle-edicion d-flex align-items-center justify-content-center"
                                data-section="section1"
                                id="btn-toggle-edicion-section1"
                                style="width: 30px; height: 30px; border: 1px solid #003366;">
                                <i class="bi bi-pen" style="color: #003366; font-size: 18px;"></i>
                            </button>

                            <!-- Botón guardar -->
                            <button 
                                class="btn btn-sm no-print btn-guardar-edicion d-flex align-items-center justify-content-center"
                                id="btn-guardar-edicion-section1"
                                style="width: 30px; height: 30px; border: 1px solid #003366; display: none;">
                                <i class="bi bi-floppy" style="color: #003366; font-size: 16px;"></i>
                            </button>
                        </div>
                    </div>



                    <div class="row pt-3">
                        <div class="col-md-6">
                            <!-- CJ no editable -->
                            <div class="mb-1">
                                <label><strong style=" font-size: 18px;">CÓDIGO JERÁRQUICO (CJ):</strong></label>
                                <span style="font-weight: bold; font-size: 18px;" class="vista">${equipo.cj || 'No disponible'}</span>
                            </div>
                            <!-- Nombre del equipo -->
                            <div class="mb-1">
                                <label><strong>Nombre de equipo:</strong></label>
                                <span id="nombreEquipo" class="vista">${equipo.nombre_equipo || 'No disponible'}</span>
                                <input class="form-control edicion d-none" name="nombre_equipo" value="${equipo.nombre_equipo || ''}">
                            </div>
                            <!-- Tipo de equipo -->
                            <div class="mb-1">
                                <label><strong>Tipo de equipo:</strong></label>
                                <span class="vista">${data.tipo_equipo?.nombre || 'No disponible'}</span>
                                <select class="form-control edicion d-none" id="tipo_equipo" name="tipo_equipo">
                                    <option value="">Seleccione Tipo de Equipo</option>
                                    ${(data.tipos_equipos || []).map(tipo => {
                                        let prefix = '';
                                        const nombre = tipo.nombre.toLowerCase();

                                        if (nombre.includes('electrico')) prefix = '4 - equipo eléctrico';
                                        else if (nombre.includes('electronico')) prefix = '5 - equipo electrónico';
                                        else if (nombre.includes('mecanico')) prefix = 'G - equipo mecánico';
                                        else if (nombre.includes('rotativo')) prefix = 'F - equipo rotativo';
                                        else if (nombre.includes('seguridad') || nombre.includes('armamento')) prefix = 'T - equipo de seguridad';
                                        else if (nombre.includes('submarino')) prefix = 'Equipo submarino';
                                        else prefix = tipo.nombre; // por si acaso alguno no entra

                                        return `<option value="${tipo.id}" ${data.tipo_equipo?.id === tipo.id ? 'selected' : ''}>${prefix} (${tipo.nombre})</option>`;
                                    }).join('')}
                                </select>
                            </div>

                            <!-- Equipo -->
                            <div class="mb-1">
                                <label><strong>Equipo:</strong></label>
                                <span class="vista">${data.datos_equipo?.nombre || 'No disponible'}</span>
                                <select class="form-control edicion d-none" id="equipo_select" name="equipo">
                                    <option value="">Seleccione Equipo</option>
                                    ${(data.equipos || []).map(eq => `
                                    <option value="${eq.id}" ${data.datos_equipo?.id === eq.id ? 'selected' : ''}>${eq.nombre}</option>
                                    `).join('')}
                                </select>
                            </div>
                            <!-- Fecha -->
                            <div class="mb-1">
                                <label><strong>Fecha de creación:</strong></label>
                                <span class="vista">${new Date(equipo.fecha).toLocaleDateString('es-CO')}</span>
                                <input 
                                    type="date" 
                                    class="form-control edicion d-none" 
                                    id="fecha" 
                                    name="fecha" 
                                    value="${(equipo.fecha && new Date(equipo.fecha).toISOString().slice(0, 10)) || ''}">
                            </div>
                            <!-- Grupo constructivo -->
                            <div class="mb-1">
                                <label><strong>Grupo constructivo:</strong></label>
                                <span class="vista">${data.grupo_constructivo?.nombre || 'No disponible'}</span>
                                <select class="form-control edicion d-none" id="grupo_constructivo" name="grupo_constructivo">
                                    <option value="">Seleccione Grupo Constructivo</option>
                                    ${(data.grupos || []).map(grupo => `
                                    <option value="${grupo.id}" ${data.grupo_constructivo?.id === grupo.id ? 'selected' : ''}>
                                        ${grupo.numeracion} - ${grupo.nombre}
                                    </option>
                                    `).join('')}
                                </select>
                            </div>
                            <!-- Subgrupo constructivo -->
                            <div class="mb-1">
                                <label for="subgrupo_constructivo"><strong>Subgrupo Constructivo:</strong></label>
                                <span class="vista">${data.subgrupo_constructivo?.nombre || 'No disponible'}</span>
                                <select 
                                    class="form-control edicion d-none" 
                                    id="subgrupo_constructivo" 
                                    name="subgrupo_constructivo"
                                    data-selected-id="${data.subgrupo_constructivo?.id || ''}">
                                    <option value="">Seleccione Subgrupo Constructivo</option>
                                    ${(data.subgrupos || []).map(sub => `
                                        <option value="${sub.id}" ${data.subgrupo_constructivo?.id === sub.id ? 'selected' : ''}>
                                            ${sub.numeracion} - ${sub.nombre}
                                        </option>
                                    `).join('')}
                                </select>
                            </div>
                            <!-- Sistema -->
                            <div class="mb-1">
                                <label><strong>Sistema:</strong></label>
                                <span class="vista">${data.sistema?.nombre || 'No disponible'}</span>
                                <select class="form-control edicion d-none" id="sistema" name="sistema">
                                    <option value="">Seleccione Sistema</option>
                                    ${(data.sistemas || []).map(sys => `
                                    <option value="${sys.id}" ${data.sistema?.id === sys.id ? 'selected' : ''}>
                                        ${sys.numeracion} - ${sys.nombre}
                                    </option>
                                    `).join('')}
                                </select>
                            </div>
                            <!-- Subsistema -->
                            <div class="mb-1">
                                <label><strong>Subsistema:</strong></label>
                                <span class="vista">${data.subsistema?.descripcion || 'No disponible'}</span>
                                <select class="form-control edicion d-none" id="subsistema" name="subsistema">
                                    <option value="">Seleccione Subsistema</option>
                                    <option value="${data.subsistema?.id}" selected>
                                        ${data.subsistema?.numero_de_referencia} - ${data.subsistema?.descripcion}
                                    </option>
                                </select>
                            </div>
                            <!-- Responsable -->
                            <div class="mb-1">
                                <label><strong>Responsable:</strong></label>
                                <span class="vista">${data.responsable?.nombre_completo || 'No disponible'}</span>
                                <div class="input-group edicion d-none">
                                    <select class="form-control" id="responsable" name="responsable">
                                    ${(data.responsables || []).map(p => `
                                    <option value="${p.id}" ${data.responsable?.id === p.id ? 'selected' : ''}>${p.nombre_completo}</option>
                                    `).join('')}
                                    </select>
                                    <button type="button" class="btn btn-secondary" id="add_personal"><i class="bi bi-plus-circle"></i></button>
                                    <button type="button" class="btn btn-danger" id="delete_personal"><i class="bi bi-trash-fill"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Columna derecha: Imagen y descripción (solo en edición) -->
                        <div class="col-md-6" style="position: relative;">
                            <div id="contenedorImagenEquipo" class="position-relative w-100">
                                <div class="position-relative">
                                    <img 
                                        id="preview-imagen-equipo"
                                        src="${equipo.imagen || '/static/img/default_image.png'}"
                                        alt="Imagen del equipo"
                                        class="w-100 object-cover rounded"
                                        style="height: 276px; max-width: 100%;">
                                    
                                    <label for="imagen_equipo" 
                                        class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-black bg-opacity-50 text-white fw-semibold rounded cursor-pointer edicion d-none"
                                        style="font-size: 14px;">
                                        Actualizar Foto
                                    </label>

                                    <button type="button" 
                                        id="btn-eliminar-imagen-equipo"
                                        class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow edicion d-none"
                                        style="z-index: 10;"
                                        title="Eliminar imagen">
                                        ✕
                                    </button>
                                </div>

                                <input type="file" id="imagen_equipo" name="imagen_equipo" accept="image/*" class="d-none">
                                <input type="hidden" name="remove_imagen_equipo" id="remove_imagen_equipo" value="false">

                                <!-- Descripción en modo edición -->
                                <div class="edicion d-none mt-3" id="descripcion-edicion">
                                    <label><strong>Descripción del Equipo:</strong></label>
                                    <textarea class="form-control" name="descripcion">${equipo.descripcion || ''}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Descripción en modo vista -->
                    <div class="mb-2 mt-3 vista" id="descripcionEquipo">
                        <label><strong>Descripción del Equipo:</strong></label>
                        <p>${equipo.descripcion || 'No disponible'}</p>
                    </div>

                </div>

    
              <div id="section2" class="zone section d-none padding pt-3" data-id-equipo="${equipo.id}">
                <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                    <h3 class="titulo">Detalles del Equipo</h3>

                    <!-- Botón editar/cancelar -->
                    <button 
                        class="btn btn-sm no-print btn-toggle-edicion d-flex align-items-center justify-content-center"
                        data-section="section2"
                        id="btn-toggle-edicion-section2"
                        style="width: 30px; height: 30px; border: 1px solid #003366;">
                        <i class="bi bi-pen" style="color: #003366; font-size: 18px;"></i>
                    </button>

                    <!-- Botón guardar -->
                    <button 
                        class="btn btn-sm no-print btn-guardar-edicion d-flex align-items-center justify-content-center"
                        id="btn-guardar-edicion-section2"
                        style="width: 30px; height: 30px; border: 1px solid #003366; display: none;">
                        <i class="bi bi-floppy" style="color: #003366; font-size: 16px;"></i>
                    </button>
                </div>

                <div id="fade-container"></div>
                <p id="detalle-titulo" style="visibility: hidden;"></p>
                    <form id="form-equipo-detalle">
                        <!-- Marca y Modelo -->
                        <div class="row">
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="text" id="marca" name="marca" class="form-control edicion" placeholder="Marca" value="${equipo.marca || ''}">
                                <label for="marca">Marca</label>
                            </div>
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="text" id="modelo" name="modelo" class="form-control edicion" placeholder="Modelo" value="${equipo.modelo || ''}">
                                <label for="modelo">Modelo</label>
                            </div>
                        </div>

                        <!-- Clasificación -->
                        <div class="row">
                            <div class="col-md-6 mb-3 form-floating">
                                <select id="eqart" name="eqart" class="form-control select2 edicion" required data-value="${equipo.eqart || ''}">
                                    <option value="">Seleccione una clase de objeto / tipo</option>
                                </select>
                                <label for="eqart">Clase de objeto / Tipo</label>
                            </div>
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="text" id="typbz" name="typbz" class="form-control edicion" maxlength="20" placeholder="Denominación del tipo" value="${equipo.typbz || ''}">
                                <label for="typbz">Denominación del tipo</label>
                            </div>
                        </div>

                        <!-- Ciclo de vida -->
                        <div class="row">
                            <div class="col-md-3 mb-3 form-floating">
                                <input type="date" id="datsl" name="datsl" class="form-control edicion" placeholder="Fecha de validez del objeto técnico" value="${equipo.datsl || ''}">
                                <label for="datsl">Fecha de validez</label>
                            </div>
                            <div class="col-md-3 mb-3 form-floating">
                                <input type="date" id="inbdt" name="inbdt" class="form-control edicion" placeholder="Fecha de puesta en servicio" value="${equipo.inbdt || ''}">
                                <label for="inbdt">Fecha de puesta en servicio</label>
                            </div>
                            <div class="col-md-3 mb-3 form-floating">
                                <select id="baujj" name="baujj" class="form-control edicion" data-value="${equipo.baujj || ''}"></select>
                                <label for="baujj">Año de construcción</label>
                            </div>
                            <div class="col-md-3 mb-3 form-floating">
                                <select id="baumm" name="baumm" class="form-control edicion" data-value="${equipo.baumm || ''}">
                                    <option value="">Seleccione un mes</option>
                                </select>
                                <label for="baumm">Mes de construcción</label>
                            </div>
                        </div>

                        <!-- Especificaciones técnicas -->
                        <div class="row">
                            <div class="col-md-4 mb-3 form-floating">
                                <input type="number" step="0.001" id="brgew" name="brgew" class="form-control edicion" placeholder="Peso del objeto" value="${equipo.peso_seco || ''}">
                                <label for="brgew">Peso del objeto</label>
                            </div>
                            <div class="col-md-4 mb-3 form-floating">
                                <select id="gewei" name="gewei" class="form-control edicion" required data-value="${equipo.gewei || ''}">
                                    <option value="" disabled>Seleccione una unidad de peso</option>
                                </select>
                                <label for="gewei">Unidad de peso</label>
                            </div>
                            <div id="groes-container" class="col-md-4 mb-3 form-floating">
                                <input type="text" id="groes" name="groes" class="form-control edicion" maxlength="50" placeholder="Tamaño/Dimensión" value="${equipo.groes || equipo.dimensiones || ''}">
                                <label for="groes">Tamaño/Dimensión</label>
                                <div id="groes-help" class="invalid-feedback d-none" style="font-size: 0.8rem;">
                                    Formato inválido. Use el formato: número + unidad x número + unidad x número + unidad (ej: 10cmx20cmx5cm)
                                </div>
                            </div>
                        </div>

                        <!-- Adquisición -->
                        <div class="row">
                            <div class="col-md-4 mb-3 form-floating">
                                <input type="date" id="ansdt" name="ansdt" class="form-control edicion" placeholder="Fecha de adquisición" value="${equipo.ansdt || ''}">
                                <label for="ansdt">Fecha de adquisición</label>
                            </div>
                            <div class="col-md-4 mb-3 form-floating">
                                <input type="number" step="0.01" id="answt" name="answt" class="form-control edicion" placeholder="Valor de adquisición" value="${equipo.answt || ''}">
                                <label for="answt">Valor de adquisición</label>
                            </div>
                            <div class="col-md-4 mb-3 form-floating">
                                <select id="waers" name="waers" class="form-control select2 edicion" required data-value="${equipo.waers || ''}">
                                    <option value="">Seleccione una moneda</option>
                                </select>
                                <label for="waers">Clave de moneda</label>
                            </div>
                        </div>

                        <!-- Fabricación -->
                        <div class="row">
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="text" id="herst" name="herst" class="form-control edicion" maxlength="30" placeholder="Fabricante" value="${equipo.herst || ''}">
                                <label for="herst">Fabricante</label>
                            </div>
                            <div class="col-md-6 mb-3 form-floating">
                                <select id="herld" name="herld" class="form-control select2 edicion" required data-value="${equipo.herld || ''}">
                                    <option value="">Seleccione un país de fabricación</option>
                                </select>
                                <label for="herld">País de fabricación</label>
                            </div>
                        </div>

                        <!-- Identificadores técnicos -->
                        <div class="row">
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="text" id="mapar" name="mapar" class="form-control edicion" maxlength="40" placeholder="Número de pieza del fabricante" value="${equipo.mapar || ''}">
                                <label for="mapar">Número de pieza del fabricante</label>
                            </div>
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="text" id="serge" name="serge" class="form-control edicion" maxlength="40" placeholder="Número de serie según el fabricante" value="${equipo.serge || ''}">
                                <label for="serge">Número de serie según el fabricante</label>
                            </div>
                        </div>

                        <!-- Mantenimiento -->
                        <div class="row">
                            <div class="col-md-4 mb-3 form-floating">
                                <select id="abckz" name="abckz" class="form-control edicion">
                                    <option value="" disabled>Seleccione un indicador</option>
                                    <option value="A" ${equipo.abckz === 'A' ? 'selected' : ''}>A - Muy Alta / Inmediata</option>
                                    <option value="B" ${equipo.abckz === 'B' ? 'selected' : ''}>B - Alta / 3 días</option>
                                    <option value="C" ${equipo.abckz === 'C' ? 'selected' : ''}>C - Media / 10 días</option>
                                    <option value="D" ${equipo.abckz === 'D' ? 'selected' : ''}>D - Baja / 120 días</option>
                                    <option value="F" ${equipo.abckz === 'F' ? 'selected' : ''}>F - Sin (Próx Inspec)</option>
                                </select>
                                <label for="abckz">Indicador ABC (Criticidad)</label>
                            </div>
                            <div class="col-md-4 mb-3 form-floating">
                                <input type="text" id="gewrk" name="gewrk" class="form-control edicion" maxlength="8" placeholder="División de mantenimiento" value="${equipo.gewrk || ''}">
                                <label for="gewrk">División de mantenimiento</label>
                            </div>
                            <div class="col-md-4 mb-3 form-floating">
                                <input type="text" id="tplnr" name="tplnr" class="form-control edicion" maxlength="30" placeholder="Ubicación técnica" value="${equipo.tplnr || ''}">
                                <label for="tplnr">Ubicación técnica</label>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3 mt-3 d-flex align-items-center">
                            <div class="flex-grow-1">
                                <hr class="m-0">
                            </div>

                            <div class="px-3" style="min-width: 250px;">
                                <div class="form-floating">
                                    <select id="class" name="class"
                                            class="form-control select2 edicion"
                                            required data-value="${equipo.class || ''}">
                                        <option value="">Seleccione una clase</option>
                                    </select>
                                    <label for="class" style="padding-left: 7px;">N° de clase</label>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                <hr class="m-0">
                            </div>
                        </div>

                        <div id="campos-dinamicos" class="row">
                            <!-- Mensaje predeterminado -->
                            <div id="mensaje-campos-dinamicos" class="text-center text-muted w-100 p-4">
                            </div>
                        </div>
                    </form>
                </div>


                <!-- sección: Modelo CAD -->
                <div id="section13" class="zone section d-none pt-3" data-id-equipo="${equipo.id}" style="width: 100%; max-width: 100%; padding-left: 15px; padding-right: 15px;">
                    <div class="encabezado-modelo-cad d-flex align-items-center justify-content-between" style="border-bottom: 1px solid rgb(229 231 235); padding-bottom: 12px;">
                        <div class="d-flex align-items-center gap-3">
                            <h3 class="titulo mb-0">Modelo CAD</h3>
                            ${equipo.archivo_cad ? `
                                <div class="d-flex align-items-center gap-2 text-muted">
                                    <i class="bi bi-file-earmark-3d text-primary" style="font-size: 20px;"></i>
                                    <div class="d-flex flex-column" style="line-height: 1.2;">
                                        <span style="font-size: 14px; font-weight: 500;">${equipo.nombre_archivo_cad}</span>
                                        <small style="font-size: 12px;">
                                            ${(equipo.tipo_archivo_cad || '').toUpperCase()} | 
                                            ${equipo.tamanio_archivo_cad ? (equipo.tamanio_archivo_cad / 1024 / 1024).toFixed(2) + ' MB' : 'Tamaño desconocido'}
                                        </small>
                                    </div>
                                </div>
                            ` : ''}
                        </div>
                        ${equipo.archivo_cad ? `
                            <div class="d-flex gap-2">
                                <button id="btn-download-cad" class="btn btn-sm no-print btn-outline-primary d-flex align-items-center gap-2" data-equipo-id="${equipo.id}">
                                    <i class="bi bi-download" style="font-size: 16px;"></i>
                                    <span>Descargar</span>
                                </button>
                                <button id="btn-delete-cad" class="btn btn-sm no-print btn-outline-danger d-flex align-items-center gap-2" data-equipo-id="${equipo.id}">
                                    <i class="bi bi-trash" style="font-size: 16px;"></i>
                                    <span>Eliminar</span>
                                </button>
                            </div>
                        ` : ''}
                    </div>

                    <div class="row pt-3">
                        ${equipo.archivo_cad ? `
                            <div class="col-12">
                                <div class="w-100" style="background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                                    <div id="cad-viewer-container" style="width: 100%; height: 70vh; min-height: 600px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); display: flex; align-items: center; justify-content: center; position: relative;">
                                        <div class="text-center">
                                            <i class="bi bi-box-seam text-primary" style="font-size: 48px; margin-bottom: 16px;"></i>
                                            <p class="mt-2 mb-2 text-muted" style="font-size: 18px; font-weight: 500;">Visor CAD 3D</p>
                                            <button id="btn-ver-cad" class="btn btn-primary btn-lg mt-2" 
                                                    onclick="window.cargarVisorCAD('${equipo.id}')"
                                                    data-equipo-id="${equipo.id}">
                                                <i class="bi bi-play-circle me-2"></i> Ver modelo
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ` : `
                            <div class="col-12">
                                <div class="upload-zone text-center" style="
                                    width: 100%; 
                                    min-height: 500px; 
                                    background: #f8f9fa; 
                                    border: 2px dashed #dee2e6; 
                                    border-radius: 12px; 
                                    display: flex; 
                                    flex-direction: column; 
                                    align-items: center; 
                                    justify-content: center; 
                                    padding: 2rem;
                                    transition: all 0.3s ease;
                                ">
                                    <i class="bi bi-cloud-upload text-primary" style="font-size: 48px;"></i>
                                    <h5 class="mt-3 mb-2">No hay archivo CAD cargado</h5>
                                    <p class="text-muted mb-3">Arrastra y suelta un archivo CAD aquí o haz clic para seleccionar</p>
                                    <p class="text-muted small">Formatos soportados: STEP, STP, GLB, IGES, IGS, STL, OBJ, PLY</p>
                                    <button id="btn-upload-cad-${equipo.id}" class="btn btn-primary" 
                                            data-equipo-id="${equipo.id}">
                                        <i class="bi bi-folder2-open"></i> Seleccionar Archivo
                                    </button>
                                    <input type="file" 
                                           id="file-input-cad-${equipo.id}" 
                                           accept=".step,.stp,.iges,.igs,.stl,.obj,.ply,.glb" 
                                           style="display: none;"
                                           data-equipo-id="${equipo.id}">
                                </div>
                            </div>
                        `}
                    </div>
                </div>

    
                <!-- Procedimientos -->
                <div id="section3" class="zone section d-none padding pt-3">
                   <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                        <h3 class="titulo">Procedimientos</h3>

                        <!-- Botón editar/cancelar -->
                        <button 
                            class="btn btn-sm no-print btn-toggle-edicion d-flex align-items-center justify-content-center"
                            data-section="section3"
                            id="btn-toggle-edicion-section3"
                            style="width: 30px; height: 30px; border: 1px solid #003366;">
                            <i class="bi bi-pen" style="color: #003366; font-size: 18px;"></i>
                        </button>

                        <!-- Botón guardar -->
                        <button 
                            class="btn btn-sm no-print btn-guardar-edicion d-flex align-items-center justify-content-center"
                            id="btn-guardar-edicion-section3"
                            style="width: 30px; height: 30px; border: 1px solid #003366; display: none;">
                            <i class="bi bi-floppy" style="color: #003366; font-size: 16px;"></i>
                        </button>
                    </div>


                    <div class="pt-3">
                        <!-- Procedimiento de Arranque -->
                        <p class="mt-3"><strong>Procedimiento de Arranque:</strong></p>
                        <div id="arranque-container" class="mb-3"></div>
                        <button id="btn-add-seccion-arranque" class="btn btn-outline-primary btn-sm mb-4" style="margin-left: 20px; width: calc(100% - 20px);">+ Añadir sección</button>

                        <!-- Procedimiento de Parada -->
                        <p class="mt-3"><strong>Procedimiento de Parada:</strong></p>
                        <div id="parada-container" class="mb-3"></div>
                        <button id="btn-add-seccion-parada" class="btn btn-outline-primary btn-sm mb-4" style="margin-left: 20px; width: calc(100% - 20px);">+ Añadir sección</button>

                        <!-- Campos ocultos para guardar los procedimientos serializados -->
                        <input type="hidden" id="input-arranque" name="procedimiento_arranque">
                        <input type="hidden" id="input-parada" name="procedimiento_parada">
                    </div>
                </div>


    
                <!-- Representaciones esquemáticas -->
                <div id="section4" class="zone section d-none padding pt-3" data-id-equipo="${equipo.id}">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                        <h3 class="titulo">Representaciones Esquemáticas</h3>

                        <!-- Botón editar/cancelar -->
                        <button 
                        class="btn btn-sm no-print btn-toggle-edicion d-flex align-items-center justify-content-center"
                        data-section="section4"
                        id="btn-toggle-edicion-section4"
                        style="width: 30px; height: 30px; border: 1px solid #003366;">
                        <i class="bi bi-pen" style="color: #003366; font-size: 18px;"></i>
                        </button>

                        <!-- Botón guardar -->
                        <button 
                        class="btn btn-sm no-print btn-guardar-edicion d-flex align-items-center justify-content-center"
                        id="btn-guardar-edicion-section4"
                        style="width: 30px; height: 30px; border: 1px solid #003366; display: none;">
                        <i class="bi bi-floppy" style="color: #003366; font-size: 16px;"></i>
                        </button>
                    </div>

                    <!-- Diagrama de Flujo -->
                    <div class="diagrama mt-5">
                        <h4 style="font-weight: bold;">Diagrama de Flujo</h4>
                        <div class="position-relative w-100">
                        <div class="position-relative d-flex justify-content-center">
                            <img
                            id="preview-diagrama-flujo"
                            src="${data.diagrama?.diagrama_flujo?.length > 100 
                                ? 'data:image/png;base64,' + data.diagrama.diagrama_flujo 
                                : '/static/img/default_image.png'}"
                            alt="Diagrama de Flujo"
                            class="object-cover rounded"
                            style="max-width: 100%;"
                            onerror="this.src='/static/img/default_image.png'">

                            <label for="diagrama_flujo"
                            class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-black bg-opacity-50 text-white fw-semibold rounded cursor-pointer edicion d-none"
                            style="font-size: 14px;">
                            Actualizar Imagen
                            </label>

                            <!-- Grupo de botones -->
                            <div class="botones-diagramas position-absolute start-0 w-100 d-flex justify-content-end px-0 mt-0">
                                <!-- Botón: Descargar Imagen -->
                                <a
                                    id="btn-descargar-diagrama-flujo"
                                    class="btn btn-sm m-2 me-10 rounded shadow"
                                    title="Descargar imagen"
                                    download="diagrama_flujo.png"
                                    href="${data.diagrama?.diagrama_flujo?.length > 100 
                                        ? 'data:image/png;base64,' + data.diagrama.diagrama_flujo 
                                        : '/static/img/default_image.png'}">
                                    <i class="bi bi-download"></i>
                                </a>

                                <!-- Botón: Editar en Interfaz (Draw.io) -->
                                <button type="button"
                                    id="btn-editar-diagrama-flujo"
                                    class="btn btn-sm btn-primary end-0 rounded shadow edicion d-none"
                                    title="Editar en Draw.io">
                                    Editar en Interfaz
                                </button>

                                <button type="button"
                                id="btn-eliminar-diagrama-flujo"
                                class="btn btn-sm  m-2 rounded shadow edicion d-none"
                                style="z-index: 10; width: 32px;"
                                title="Eliminar imagen">
                                ✕
                                </button>
                            </div>
                        </div>

                        <input type="file" id="diagrama_flujo" name="diagrama_flujo" accept="image/*" class="d-none">
                        <input type="hidden" name="remove_diagrama_flujo" id="remove_diagrama_flujo" value="false">
                        </div>
                    </div>

                    <!-- Diagrama Caja Negra -->
                    <div class="diagrama mt-5">
                    <h4 style="font-weight: bold;">Diagrama Caja Negra</h4>
                    <div class="position-relative w-100">
                        <div class="position-relative d-flex justify-content-center">
                        
                        <img
                            id="preview-diagrama-caja-negra"
                            src="${data.diagrama?.diagrama_caja_negra?.length > 100 
                                ? 'data:image/png;base64,' + data.diagrama.diagrama_caja_negra 
                                : '/static/img/default_image.png'}"
                            alt="Diagrama Caja Negra"
                            class="object-cover rounded"
                            style="max-width: 100%;"
                            onerror="this.src='/static/img/default_image.png'">

                        <label for="diagrama_caja_negra"
                            class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-black bg-opacity-50 text-white fw-semibold rounded cursor-pointer edicion d-none"
                            style="font-size: 14px;">
                            Actualizar Imagen
                        </label>

                        <!-- Grupo de botones -->
                        <div class="botones-diagramas position-absolute start-0 w-100 d-flex justify-content-end px-0 mt-0">
                            <!-- Botón: Descargar Imagen -->
                            <a
                            id="btn-descargar-diagrama-caja-negra"
                            class="btn btn-sm m-2 me-10 rounded shadow"
                            title="Descargar imagen"
                            download="diagrama_caja_negra.png"
                            href="${data.diagrama?.diagrama_caja_negra?.length > 100 
                                ? 'data:image/png;base64,' + data.diagrama.diagrama_caja_negra 
                                : '/static/img/default_image.png'}">
                            <i class="bi bi-download"></i>
                            </a>

                            <!-- Botón: Editar en Interfaz (Draw.io) -->
                            <button type="button"
                            id="btn-editar-diagrama-caja-negra"
                            class="btn btn-sm btn-primary end-0 rounded shadow edicion d-none"
                            title="Editar en Draw.io">
                            Editar en Interfaz
                            </button>

                            <button type="button"
                            id="btn-eliminar-diagrama-caja-negra"
                            class="btn btn-sm m-2 rounded shadow edicion d-none"
                            style="z-index: 10; width: 32px;"
                            title="Eliminar imagen">
                            ✕
                            </button>
                        </div>
                        </div>

                        <input type="file" id="diagrama_caja_negra" name="diagrama_caja_negra" accept="image/*" class="d-none">
                        <input type="hidden" name="remove_diagrama_caja_negra" id="remove_diagrama_caja_negra" value="false">
                    </div>
                    </div>


                    <!-- Diagrama Caja Transparente -->
                    <div class="diagrama mt-5">
                        <h4 style="font-weight: bold;">Diagrama Caja Transparente</h4>
                        <div class="position-relative w-100">
                            <div class="position-relative d-flex justify-content-center">       
                                <img
                                    id="preview-diagrama-caja-transparente"
                                    src="${data.diagrama?.diagrama_caja_transparente?.length > 100 
                                        ? 'data:image/png;base64,' + data.diagrama.diagrama_caja_transparente 
                                        : '/static/img/default_image.png'}"
                                    alt="Diagrama Caja Transparente"
                                    class="object-cover rounded"
                                    style="max-width: 100%;"
                                    onerror="this.src='/static/img/default_image.png'">

                                <label for="diagrama_caja_transparente"
                                    class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-black bg-opacity-50 text-white fw-semibold rounded cursor-pointer edicion d-none"
                                    style="font-size: 14px;">
                                    Actualizar Imagen
                                </label>

                                <!-- Grupo de botones -->
                                <div class="botones-diagramas position-absolute start-0 w-100 d-flex justify-content-end px-0 mt-0">
                                    <!-- Botón: Descargar Imagen -->
                                    <a
                                    id="btn-descargar-diagrama-caja-transparente"
                                    class="btn btn-sm m-2 me-10 rounded shadow"
                                    title="Descargar imagen"
                                    download="diagrama_caja_transparente.png"
                                    href="${data.diagrama?.diagrama_caja_transparente?.length > 100 
                                        ? 'data:image/png;base64,' + data.diagrama.diagrama_caja_transparente 
                                        : '/static/img/default_image.png'}">
                                    <i class="bi bi-download"></i>
                                    </a>

                                    <!-- Botón: Editar en Interfaz (Draw.io) -->
                                    <button type="button"
                                    id="btn-editar-diagrama-caja-transparente"
                                    class="btn btn-sm btn-primary end-0 rounded shadow edicion d-none"
                                    title="Editar en Draw.io">
                                    Editar en Interfaz
                                    </button>

                                    <button type="button"
                                    id="btn-eliminar-diagrama-caja-transparente"
                                    class="btn btn-sm m-2 rounded shadow edicion d-none"
                                    style="z-index: 10; width: 32px;"
                                    title="Eliminar imagen">
                                    ✕
                                    </button>
                                </div>
                            </div>
                            <input type="file" id="diagrama_caja_transparente" name="diagrama_caja_transparente" accept="image/*" class="d-none">
                            <input type="hidden" name="remove_diagrama_caja_transparente" id="remove_diagrama_caja_transparente" value="false">
                        </div>
                    </div>
                </div>


                <!-- Datos de Fiabilidad -->
                <div id="section5" class="zone section d-none padding pt-3">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 12px; height: 40px;">
                        <h3 class="titulo">Datos de Fiabilidad</h3>  
                    </div>
                    <div class="row d-flex pt-3">
                        <div class="col-6">
                            <p><strong>Grado de escencialidad (GRES):</strong> ${data.equipo.GRES ?? 'No disponible'}</p>
                            <p class="text-muted">
                                El GRES indica la criticidad del equipo dentro del sistema. Un valor más alto sugiere que el equipo es esencial para las operaciones y su falla podría tener un impacto significativo.
                            </p>
                            <p><strong>Mean Time Between Failures (MTBF) en horas:</strong> ${data.equipo.MTBF ?? 'No disponible'}</p>
                            <p class="text-muted">
                                El MTBF representa el tiempo promedio entre fallas del equipo, medido en horas. Un valor mayor indica mayor confiabilidad del equipo.
                            </p>
                        </div>
                        <div class="col-6">
                            <p><strong>AOR:</strong> ${data.equipo.AOR ?? 0} (horas)</p>
                            <p class="text-muted">
                                El AOR (Average Operating Rate) refleja el tiempo promedio en el que el equipo estuvo operativo durante un año. 
                            </p>
                            <p><strong>AOR porcentual:</strong> ${data.equipo.AOR_porcentual ?? 0}%</p>
                            <p class="text-muted">
                                Este porcentaje muestra la relación entre el tiempo operativo y el tiempo total disponible (8760 horas, un año), indicando la eficiencia del equipo.
                            </p>
                        </div>
                    </div>
                </div>


                <div id="section6" class="zone section special d-none padding pt-3">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                        <h3 class="titulo">Análisis Funcional</h3>  
                        <button 
                            data-url="${"/LSA/equipo/mostrar-analisis-funcional-ext?id_equipo_info=" + data.equipo.id + "&section=section6&from=" + encodeURIComponent(window.location.href)}"
                            data-section="section6" 
                            class="btn btn-primary btn-edicion no-print">
                            <i class="bi bi-pen" style="color: whitesmoke; font-size: 14px;"></i>
                        </button>
                    </div>

                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Sistema</th>
                                <th>Subsistema</th>
                                <th>Verbo</th>
                                <th>Acción</th>
                                <th>Estándar de desempeño</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.analisis_funcionales.map(a => `
                                <tr class="analisis-row" onclick="toggleComponentes(${a.id})">
                                    <td>${data.sistema?.nombre || 'No disponible'}</td>
                                    <td>${a.subsistema_nombre}</td>
                                    <td>${a.verbo}</td>
                                    <td>${a.accion}</td>
                                    <td>${a.estandar_desempeño}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>

                    ${data.analisis_funcionales.map(analisis => `
                        <table id="componentes-${analisis.id}" class="table componentes table-bordered" style="display: none;">
                            <thead>
                                <tr><th colspan="3">${analisis.subsistema_nombre}</th></tr>
                                <tr><th>Nombre</th><th>Verbo</th><th>Acción</th></tr>
                            </thead>
                            <tbody>
                                ${
                                    data.componentes
                                        .filter(c => c.id_analisis_funcional === analisis.id)
                                        .map(c => `
                                            <tr>
                                                <td>${c.nombre}</td>
                                                <td>${c.verbo}</td>
                                                <td>${c.accion}</td>
                                            </tr>
                                        `).join('')
                                }
                            </tbody>
                        </table>
                    `).join('')}
                </div>

                <div id="section7" class="zone section special d-none padding pt-3">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                        <h3 class="titulo">Módulo de Herramientas</h3>
                        <button 
                            data-url="${"/LSA/mostrar-herramientas-especiales-ext?id_equipo_info=" + data.equipo.id + "&section=section7&from=" + encodeURIComponent(window.location.href)}"
                            data-section="section7" 
                            class="btn btn-primary btn-edicion no-print">
                            <i class="bi bi-pen" style="color: whitesmoke; font-size: 14px;"></i>
                        </button>
                    </div>

                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs mt-3" id="tabsHerramientas" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-gen" data-bs-toggle="tab" data-bs-target="#tab-generales" type="button" role="tab">Herramientas Generales</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-esp" data-bs-toggle="tab" data-bs-target="#tab-especiales" type="button" role="tab">Herramientas Especiales</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content pt-2" id="contenidoTabsHerramientas">

                        <!-- Herramientas Generales -->
                        <div class="tab-pane fade show active" id="tab-generales" role="tabpanel">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Parte número</th>
                                        <th>Dibujo de sección transversal</th>
                                        <th>Cantidad</th>
                                        <th>Costo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${
                                        data.analisis.map(tool => `
                                            <tr>
                                                <td>${tool.nombre}</td>
                                                <td>${tool.parte_numero}</td>
                                                <td>
                                                ${
                                                    tool.dibujo_seccion_transversal
                                                    ? (tool.dibujo_seccion_transversal.startsWith('iVBOR') || tool.dibujo_seccion_transversal.startsWith('/9j/4'))
                                                        ? `<a href="#" class="open-modal" data-bs-toggle="modal" data-bs-target="#modalImagen" data-img="data:image/png;base64,${tool.dibujo_seccion_transversal}">
                                                            Ver imagen
                                                        </a>`
                                                        : `<span class="text-muted">Imagen no disponible</span>`
                                                    : `<span class="text-muted">Sin imagen</span>`
                                                }
                                                </td>
                                                <td>${tool.cantidad}</td>
                                                <td>${parseFloat(tool.valor || 0).toLocaleString('es-CO', { style: 'currency', currency: 'COP' })}</td>
                                            </tr>
                                        `).join('')
                                    }
                                </tbody>
                            </table>
                        </div>

                        <!-- Herramientas Especiales -->
                        <div class="tab-pane fade" id="tab-especiales" role="tabpanel">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Parte número</th>
                                        <th>Dibujo de sección transversal</th>
                                        <th>Cantidad</th>
                                        <th>Costo</th>
                                        <th>Manual referenciado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${
                                        data.herramientas.map(tool => `
                                            <tr>
                                                <td>${tool.nombre_herramienta}</td>
                                                <td>${tool.parte_numero}</td>
                                                 <td>
                                                ${
                                                    tool.dibujo_seccion_transversal
                                                    ? (tool.dibujo_seccion_transversal.startsWith('iVBOR') || tool.dibujo_seccion_transversal.startsWith('/9j/4'))
                                                        ? `<a href="#" class="open-modal" data-bs-toggle="modal" data-bs-target="#modalImagen" data-img="data:image/png;base64,${tool.dibujo_seccion_transversal}">
                                                            Ver imagen
                                                        </a>`
                                                        : `<span class="text-muted">Imagen no disponible</span>`
                                                    : `<span class="text-muted">Sin imagen</span>`
                                                }
                                                </td>
                                                <td>${tool.cantidad}</td>
                                                <td>${parseFloat(tool.valor || 0).toLocaleString('es-CO', { style: 'currency', currency: 'COP' })}</td>
                                                <td>${tool.manual_referencia || ''}</td>
                                            </tr>
                                        `).join('')
                                    }
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="section8" class="zone section special d-none padding pt-3">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                        <h3 class="titulo">Módulo de Repuestos</h3>
                        <button 
                            data-url="${"/LSA/mostrar-repuesto-ext?id_equipo_info=" + data.equipo.id + "&section=section8&from=" + encodeURIComponent(window.location.href)}"
                            data-section="section8" 
                            class="btn btn-primary btn-edicion no-print">
                            <i class="bi bi-pen" style="color: whitesmoke; font-size: 14px;"></i>
                        </button>

                    </div>

                    <table class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th>Nombre del repuesto</th>
                                <th>Valor</th>
                                <th>Dibujo de sección transversal</th>
                                <th>MTBF</th>
                                <th>Código OTAN</th>
                                <th>Notas</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${
                                data.repuestos.length > 0 
                                ? data.repuestos.map(r => `
                                    <tr>
                                        <td>${r.nombre_repuesto || '—'}</td>
                                        <td>${parseFloat(r.valor || 0).toLocaleString('es-CO', { style: 'currency', currency: 'COP' })}</td>
                                        <td>
                                            ${r.dibujo_transversal
                                                ? (r.dibujo_transversal.startsWith && (r.dibujo_transversal.startsWith('iVBOR') || r.dibujo_transversal.startsWith('/9j/4')))
                                                                                                        ? `<a href="#" class="open-modal" data-bs-toggle="modal" data-bs-target="#modalImagen" data-img="data:image/png;base64,${r.dibujo_transversal}">Ver imagen</a>`
                                                    : `<span class="text-muted">Imagen no disponible</span>`
                                                : `<span class="text-muted">Sin imagen</span>`
                                            }
                                        </td>
                                        <td>${r.mtbf || '—'}</td>
                                        <td>${r.codigo_otan || '—'}</td>
                                        <td>${r.notas || ''}</td>
                                    </tr>
                                `).join('')
                                : `<tr><td colspan="6" class="text-center text-muted">No hay repuestos registrados.</td></tr>`
                            }
                        </tbody>
                    </table>
                </div>

               <div id="section9" class="zone section special d-none padding pt-3">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                        <h3 class="titulo">Failure Modes and Effects Analysis (FMEA)</h3>
                        <button 
                            data-url="${"/LSA/equipo/editar-FMEA/" + data.equipo.id + "?section=section9&from=" + encodeURIComponent(window.location.href)}"
                            data-section="section9" 
                            class="btn btn-primary btn-edicion no-print">
                            <i class="bi bi-pen" style="color: whitesmoke; font-size: 14px;"></i>
                        </button>
                    </div>

                    <!-- Botones de scroll -->
                    <button class="scroll-button left hidden scroll-left">◀</button>

                    <div class="scroll-container-horizontal mt-4">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>No. Función</th>
                            <th>Función del activo</th>
                            <th>Sistema</th>
                            <th>Falla Funcional</th>
                            <th>Descripción FF</th>
                            <th>Componente</th>
                            <th>Tag/Referencia</th>
                            <th>Función Item</th>
                            <th>No. Modo Falla</th>
                            <th>Modo Falla</th>
                            <th>Causa</th>
                            <th>No. Efecto</th>
                            <th>Efecto</th>
                            <th>FO</th>
                            <th>SF</th>
                            <th>MA</th>
                            <th>IO</th>
                            <th>OR</th>
                            <th>FO (Flex.)</th>
                            <th>Severidad</th>
                            <th>Ocurrencia</th>
                            <th>Detección</th>
                            <th>RPN</th>
                            <th>Riesgo</th>
                            <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${
                            data.fmeas.length > 0
                                ? data.fmeas.map((fmea, idx) => `
                                <tr>
                                    <td>${idx + 1}</td>
                                    <td>${fmea.no_funcion}</td>
                                    <td>${fmea.funcion_activo}</td>
                                    <td>${fmea.sistema}</td>
                                    <td>${fmea.falla_funcional}</td>
                                    <td>${fmea.descripcion_falla_funcional}</td>
                                    <td>${fmea.componente}</td>
                                    <td>${fmea.ref_elemento_tag}</td>
                                    <td>${fmea.funcion_item_componente}</td>
                                    <td>${fmea.no_modo_falla}</td>
                                    <td>${fmea.codigo_modo_falla}</td>
                                    <td>${fmea.causa}</td>
                                    <td>${fmea.no_efecto_falla}</td>
                                    <td>${fmea.efecto_falla}</td>
                                    <td>${fmea.fallo_oculto_valor}</td>
                                    <td>${fmea.seguridad_fisica_valor}</td>
                                    <td>${fmea.medio_ambiente_valor}</td>
                                    <td>${fmea.impacto_operacional_valor}</td>
                                    <td>${fmea.costos_reparacion_valor}</td>
                                    <td>${fmea.flexibilidad_operacional_valor}</td>
                                    <td>${fmea.calculo_severidad}</td>
                                    <td>${fmea.ocurrencia_valor}</td>
                                    <td>${fmea.probabilidad_deteccion_valor}</td>
                                    <td>${fmea.RPN}</td>
                                    <td>${fmea.nombre_riesgo}</td>
                                    <td>${fmea.observaciones}</td>
                                </tr>
                                `).join('')
                                : `<tr><td colspan="26" class="text-center text-muted">No hay análisis FMEA registrados.</td></tr>`
                            }
                        </tbody>
                        </table>
                    </div>

                    <button class="scroll-button right scroll-right">▶</button>
                </div>


                <!-- Sección RCM -->
                <div id="section10" class="zone section special d-none padding pt-3">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                        <h3 class="titulo">Formato de Cuadro de Decisiones (RCM)</h3>
                        <button 
                            data-url="${"/LSA/equipo/editar_RCM_lista/" + data.equipo.id + "?section=section10&from=" + encodeURIComponent(window.location.href)}"
                            data-section="section10" 
                            class="btn btn-primary btn-edicion no-print">
                            <i class="bi bi-pen" style="color: whitesmoke; font-size: 14px;"></i>
                        </button>
                    </div>

                    <button class="scroll-button left hidden scroll-left">◀</button>

                    <div class="scroll-container-horizontal mt-3">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>No. Función (F)</th>
                            <th>Falla funcional (FF)</th>
                            <th>No. Modo de falla (MF)</th>
                            <th>No. Efecto de falla (EF)</th>
                            <th>Hidden failures</th>
                            <th>Safety</th>
                            <th>Environment</th>
                            <th>Operation</th>
                            <th>H1/S1/N1/O1</th>
                            <th>H2/S2/N2/O2</th>
                            <th>H3/S3/N3/O3</th>
                            <th>H4/S4</th>
                            <th>h3</th>
                            <th>Patrón de falla</th>
                            <th>Tarea propuesta</th>
                            <th>Frecuencia</th>
                            <th>A Realizar por LORA</th>
                            <th>Severidad</th>
                            <th>Ocurrencia</th>
                            <th>Detección</th>
                            <th>NPRR</th>
                            <th>Riesgo</th>
                            <th>Tarea en plan actual</th>
                            <th>Fuente</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.rcms.map((rcm, idx) => `
                            <tr>
                                <td>${idx + 1}</td>
                                <td>${rcm.no_funcion}</td>
                                <td>${rcm.falla_funcional}</td>
                                <td>${rcm.no_modo_falla}</td>
                                <td>${rcm.no_efecto_falla}</td>
                                <td>${rcm.hidden_failures}</td>
                                <td>${rcm.safety}</td>
                                <td>${rcm.environment}</td>
                                <td>${rcm.operation}</td>
                                <td>${rcm.h1_s1_n1_o1}</td>
                                <td>${rcm.h2_s2_n2_o2}</td>
                                <td>${rcm.h3_s3_n3_o3}</td>
                                <td>${rcm.h4_s4}</td>
                                <td>${rcm.h3}</td>
                                <td>
                                ${rcm.patron_de_falla ? `
                                    <a href="#" class="open-modal" data-bs-toggle="modal" data-bs-target="#modalImagen" style="color: #003366"
                                    data-img="${rcm.patron_de_falla}">
                                    Abrir Imagen
                                    </a>` : `No disponible`}
                                </td>
                                <td>${rcm.tarea}</td>
                                <td>${rcm.intervalo_inicial_horas}</td>
                                <td>${rcm.actividades}</td>
                                <td>${rcm.calculo_severidad}</td>
                                <td>${rcm.ocurrencia_valor}</td>
                                <td>${rcm.probabilidad_deteccion}</td>
                                <td>${rcm.rpn}</td>
                                <td>${rcm.riesgo}</td>
                                <td>${rcm.tarea_contemplada}</td>
                                <td>${rcm.fuente}</td>
                            </tr>
                            `).join('')}
                        </tbody>
                        </table>
                    </div>

                    <button class="scroll-button right scroll-right">▶</button>
                </div>

                <div id="section11" class="zone section special d-none padding pt-3">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                        <h3 class="titulo">Maintenance Task Analysis (MTA) & Level Of Repair Analysis (LORA)</h3>
                        <button 
                            data-url="${"/LSA/editar-MTA-lista/" + data.equipo.id + "?section=section11&from=" + encodeURIComponent(window.location.href)}"
                            data-section="section11" 
                            class="btn btn-primary btn-edicion no-print">
                            <i class="bi bi-pen" style="color: whitesmoke; font-size: 14px;"></i>
                        </button>
                    </div>

                    <button class="scroll-button left hidden scroll-left">◀</button>
                    <div class="scroll-container-horizontal mt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sistema</th>
                                    <th>Item o componente</th>
                                    <th>Falla Funcional</th>
                                    <th>Descripción Modo de Falla</th>
                                    <th>Tipo de Mantenimiento</th>
                                    <th>Tarea de Mantenimiento</th>
                                    <th>Cantidad de Personal Requerido</th>
                                    <th>Requeridos por Tarea</th>
                                    <th>Ambientales</th>
                                    <th>Estado del equipo</th>
                                    <th>Especiales</th>
                                    <th>Horas</th>
                                    <th>Minutos</th>
                                    <th>Detalle de la tarea</th>
                                    <th>Nivel</th>
                                    <th>Actividades</th>
                                    <th>Operario</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${
                                    data.mtas.length > 0
                                    ? data.mtas.map((mta, idx) => `
                                        <tr>
                                            <td>${idx + 1}</td>
                                            <td>${mta.sistema}</td>
                                            <td>${mta.componente}</td>
                                            <td>${mta.falla_funcional}</td>
                                            <td>${mta.descripcion_modo_falla}</td>
                                            <td>${mta.tipo_mantenimiento}</td>
                                            <td>${mta.tarea_mantenimiento}</td>
                                            <td>${mta.cantidad_personal}</td>
                                            <td>${mta.requeridos_tarea}</td>
                                            <td>${mta.condiciones_ambientales}</td>
                                            <td>${mta.condiciones_estado_equipo}</td>
                                            <td>${mta.condiciones_especiales}</td>
                                            <td>${mta.horas}</td>
                                            <td>${mta.minutos}</td>
                                            <td>${mta.detalle_tarea}</td>
                                            <td>${mta.nivel}</td>
                                            <td>${mta.actividades}</td>
                                            <td>${mta.operario}</td>
                                        </tr>
                                    `).join('')
                                    : `<tr><td colspan="18" class="text-center text-muted">No hay tareas MTA registradas.</td></tr>`
                                }
                            </tbody>
                        </table>
                    </div>
                    <button class="scroll-button right scroll-right">▶</button>
                </div>

                <div id="section12" class="zone section d-none padding pt-3">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                        <h3 class="titulo">Datos de FUA</h3>
                       <button 
                            data-url="/FUA/${nombreBuque}?id_equipo_info=${data.equipo.id}&section=section12" 
                            data-section="section12" 
                            class="btn btn-primary btn-edicion no-print">
                            <i class="bi bi-pen" style="color: whitesmoke; font-size: 14px;"></i>
                        </button>
                    </div>

                    <div class="table-responsive mt-3" style="border-radius: 10px;">
                        <table class="table">
                            ${
                                data.datosFUA?.FUA
                                ? `
                                <thead>
                                    <tr>
                                        <th style="width: 30%; color: #6b7280; font-size: 12px;">MISIÓN</th>
                                        <th style="width: 10%; color: #6b7280; font-size: 12px;">PORCENTAJE (%)</th>
                                        <th style="width: 50%; color: #6b7280; font-size: 12px;">DESCRIPCIÓN</th>
                                    </tr>
                                </thead>
                                `
                                : ''
                            }
                            <tbody>
                                ${
                                    data.datosFUA?.FUA
                                    ? Object.entries(data.datosFUA.FUA).map(([key, value]) => `
                                        <tr>
                                            <td class="text-capitalize">${key.replace(/_/g, ' ')}</td>
                                            <td>
                                                <input type="text" class="form-control" value="${value.porcentaje}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="${value.descripcion}" readonly>
                                            </td>
                                        </tr>
                                    `).join('')
                                    : `
                                        <tr>
                                            <td colspan="3" class="text-center">No hay datos de FUA disponibles.</td>
                                        </tr>
                                    `
                                }
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="col-1 pt-3 d-flex justify-content-end pr-4 gap-2">
                    <button class="reporte no-print btn-exportables" id="botonPDF"
                            data-nombre-equipo="${equipo.nombre_equipo}"
                            data-marca-equipo="${equipo.marca}"
                            data-modelo-equipo="${equipo.modelo}">
                        <i id="icono-descargas" class="bi bi-file-earmark-arrow-down-fill"></i>
                        <span class="text">Exportables</span>
                    </button>
                </div>

                <!-- Modal de Imagen -->
                <div class="modal fade" id="modalImagen" tabindex="-1" aria-labelledby="modalImagenLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body text-center">
                            <img id="imagenModal" class="img-fluid rounded" style="max-width: 90%; max-height: 80vh;" alt="Imagen no disponible">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    } window.construirTabsHTML = construirTabsHTML;


    // ✅ Exportar al global para que funcione el onclick del botón
    window.mostrarDetalleEquipo = mostrarDetalleEquipo;
    window.toggleGrupos = toggleGrupos;

    if (autoseleccionar) {
        window.equipoAutoSeleccion = equipoSeleccionado;
        const equipo = equiposGlobal.find(eq => eq.id_equipo == equipoSeleccionado);
        if (equipo) {
            seleccionarGrupo(equipo.id_grupo, {
                currentTarget: document.querySelector(`#grupos-list button:nth-child(${equipo.id_grupo})`)
            });
        }
    }

    // Helper: asegura que exista y esté visible el panel lateral de detalle
    function asegurarPanelDetalle() {
    let detalle = document.getElementById('detalle-equipo-container');
    if (!detalle) {
        // Si tu HTML NO crea de fábrica el contenedor, lo creamos aquí.
        // Si ya existe en tu plantilla, este bloque no se ejecuta.
        detalle = document.createElement('div');
        detalle.id = 'detalle-equipo-container';
        detalle.className = 'detalle-visible'; // misma clase que usa mostrarDetalleEquipo
        // Inserta en un contenedor apropiado. Si tienes un wrapper específico, úsalo aquí.
        // Por defecto, lo agregamos al final de <body>.
        document.body.appendChild(detalle);
    }
    // Asegurar clases de visibilidad (coherentes con mostrarDetalleEquipo)
    detalle.classList.remove('d-none', 'detalle-mostrando');
    detalle.classList.add('detalle-visible');

    // Sincronizar barra de toggle y columnas como hace mostrarDetalleEquipo
    const gruposContainer = document.getElementById('grupos-container');
    const equiposContainer = document.getElementById('equipos-container');
    const toggleBar = document.getElementById('toggle-bar');

    if (toggleBar) {
        toggleBar.classList.remove('hide');
        toggleBar.classList.add('show');
    }

    if (gruposContainer && equiposContainer) {
        const enEstadoInicial =
        gruposContainer.classList.contains('grupos-expanded-inicial') &&
        equiposContainer.classList.contains('equipos-expanded-inicial');

        gruposContainer.classList.remove('grupos-expanded-inicial');
        gruposContainer.classList.add('grupos-expanded');

        equiposContainer.classList.remove('equipos-expanded-inicial');
        equiposContainer.classList.add('equipos-after-detail');

        if (enEstadoInicial && typeof toggleGrupos === 'function') {
        // Misma UX de "primer click" que usas al abrir un equipo
        toggleGrupos();
        }
    }

    return detalle;
    }

    // === NUEVO: Abrir formulario "Nuevo equipo" con mismos campos que EDITAR (Generalidades) ===
    const btnNuevoEquipo = document.getElementById('btn-nuevo-equipo');
    if (btnNuevoEquipo) {
    btnNuevoEquipo.addEventListener('click', async () => {
        const detalle = asegurarPanelDetalle(); 

        const toggleBar = document.getElementById('toggle-bar');
        toggleBar?.classList.remove('hide');
        toggleBar?.classList.add('show');

        // Reproduce la misma UX de abrir detalle
        const gruposContainer = document.getElementById("grupos-container");
        const equiposContainer = document.getElementById("equipos-container");
        const enEstadoInicial = gruposContainer.classList.contains('grupos-expanded-inicial') &&
                                equiposContainer.classList.contains('equipos-expanded-inicial');

        detalle.classList.remove('d-none');
        detalle.classList.add('detalle-visible');
        toggleBar?.classList.add('show');
        gruposContainer.classList.remove('grupos-expanded-inicial');
        gruposContainer.classList.add('grupos-expanded');
        equiposContainer.classList.remove('equipos-expanded-inicial');
        equiposContainer.classList.add('equipos-after-detail');
        if (enEstadoInicial) toggleGrupos(); // ya existe

        detalle.innerHTML = '<div class="text-center text-muted p-4">Cargando formulario…</div>';

        // Cargar catálogos mínimos
        const [grupos, responsables, tiposEquipos] = await Promise.all([
        fetch('/api/grupos').then(r => r.json()).catch(() => []),
        fetch('/api/responsables').then(r => r.json()).catch(() => []),
        fetch('/api/tipos_equipos').then(r => r.json()).catch(() => [])
        ]);

        // Inyectar el formulario con los mismos campos/ids/names que "editar"
        detalle.innerHTML = construirFormularioNuevoEquipoHTML({ grupos, responsables, tiposEquipos });

        // Inicializa las cascadas usando tu lógica existente
        inicializarGeneralidades(); // usa ids: grupo_constructivo, subgrupo_constructivo, sistema, subsistema, equipo_select, tipo_equipo :contentReference[oaicite:11]{index=11}

        const selectGrupoNuevo = document.getElementById('grupo_constructivo');
        if (selectGrupoNuevo && window.grupoSeleccionado) {
        selectGrupoNuevo.value = String(window.grupoSeleccionado);
        selectGrupoNuevo.dispatchEvent(new Event('change'));
        }

        // Guardar referencia "nuevo" para el guardado
        const section1 = document.getElementById('section1-nuevo');
        if (section1) section1.dataset.idEquipo = 'nuevo';
    });
    }

});

// === NUEVO: HTML del formulario "Nuevo equipo" (mismos inputs/labels que EDITAR - Generalidades) ===
function construirFormularioNuevoEquipoHTML({ grupos = [], responsables = [], tiposEquipos = [] }) {
  const hoy = new Date().toISOString().slice(0,10);

  return `
  <div class="row toolBar">
    <div class="m-0">
      <div class="buttons">
        <button class="tab-button btn active" data-target="section1">Generalidades</button>
      </div>
    </div>
  </div>

  <div class="content">
    <div id="section1-nuevo" class="zone section active padding pt-3">
      <div class="row pt-3">
        <!-- Columna izquierda -->
        <div class="col-md-6">
          <!-- CJ (solo informativo) -->
          <div class="mb-1">
            <label><strong style="font-size:18px;">CÓDIGO JERÁRQUICO (CJ):</strong></label>
            <span style=" font-size:14px;">Se asignará al guardar</span>
          </div>

          <!-- Nombre de equipo -->
          <div class="mb-1">
            <label><strong>Nombre de equipo:</strong></label>
            <input class="form-control edicion" name="nombre_equipo" value="">
          </div>

          <!-- Tipo de equipo -->
          <div class="mb-1">
            <label><strong>Tipo de equipo:</strong></label>
            <select class="form-control edicion" id="tipo_equipo" name="tipo_equipo">
              <option value="">Seleccione Tipo de Equipo</option>
              ${tiposEquipos.map(t => `<option value="${t.id}">${t.nombre}</option>`).join('')}
            </select>
          </div>

          <!-- Equipo -->
          <div class="mb-1">
            <label><strong>Equipo:</strong></label>
            <select class="form-control edicion" id="equipo_select" name="equipo">
              <option value="">Seleccione Equipo</option>
            </select>
          </div>

          <!-- Fecha de creación -->
          <div class="mb-1">
            <label><strong>Fecha de creación:</strong></label>
            <input type="date" class="form-control edicion" id="fecha" name="fecha" value="${hoy}">
          </div>

          <!-- Grupo constructivo -->
          <div class="mb-1">
            <label><strong>Grupo constructivo:</strong></label>
            <select class="form-control edicion" id="grupo_constructivo" name="grupo_constructivo">
              <option value="">Seleccione Grupo Constructivo</option>
              ${grupos.map(g => `<option value="${g.id}">${(g.numeracion||'') } ${g.numeracion?'- ':''}${g.nombre}</option>`).join('')}
            </select>
          </div>

          <!-- Subgrupo constructivo -->
          <div class="mb-1">
            <label><strong>Subgrupo constructivo:</strong></label>
            <select class="form-control edicion" id="subgrupo_constructivo" name="subgrupo_constructivo" data-selected-id="">
              <option value="">Seleccione Subgrupo Constructivo</option>
            </select>
          </div>

          <!-- Sistema -->
          <div class="mb-1">
            <label><strong>Sistema:</strong></label>
            <select class="form-control edicion" id="sistema" name="sistema">
              <option value="">Seleccione Sistema</option>
            </select>
          </div>

          <!-- Subsistema -->
          <div class="mb-1">
            <label><strong>Subsistema:</strong></label>
            <select class="form-control edicion" id="subsistema" name="subsistema">
              <option value="">Seleccione Subsistema</option>
            </select>
          </div>

          <!-- Responsable -->
          <div class="mb-1">
            <label><strong>Responsable:</strong></label>
            <div class="input-group edicion">
              <select class="form-control" id="responsable" name="responsable">
                <option value="">Seleccione Responsable</option>
                ${responsables.map(p => `<option value="${p.id}">${p.nombre_completo}</option>`).join('')}
              </select>
              <small id="responsableHelp" class="text-muted d-block mt-1"></small>
              <button type="button" class="btn btn-secondary" id="add_personal"><i class="bi bi-plus-circle"></i></button>
              <button type="button" class="btn btn-danger" id="delete_personal"><i class="bi bi-trash-fill"></i></button>
            </div>
          </div>
        </div>

        <!-- Columna derecha -->
        <div class="col-md-6" style="position:relative;">
          <div id="contenedorImagenEquipo" class="position-relative w-100">
            <div class="position-relative">
              <img id="preview-imagen-equipo" src="/static/img/default_image.png"
                   alt="Imagen del equipo" class="w-100 object-cover rounded"
                   style="height:276px; max-width:100%;">
              <label for="imagen_equipo"
                     class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-black bg-opacity-50 text-white fw-semibold rounded cursor-pointer edicion"
                     style="font-size:14px;">Subir Foto</label>
              <button type="button" id="btn-eliminar-imagen-equipo"
                      class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow edicion"
                      style="z-index:10;" title="Eliminar imagen">✕</button>
            </div>
            <input type="file" id="imagen_equipo" name="imagen_equipo" accept="image/*" class="d-none">
            <input type="hidden" name="remove_imagen_equipo" id="remove_imagen_equipo" value="false">

            <div class="edicion mt-3" id="descripcion-edicion">
              <label><strong>Descripción del Equipo:</strong></label>
              <textarea class="form-control" name="descripcion"></textarea>
            </div>
          </div>
        </div>

        <!-- Acciones -->
        <div class="mt-3 d-flex gap-2 justify-content-end" style="font-size:14px">
            <button id="btn-guardar-nuevo-equipo" class="btn btn-azul py-1">
            <i class="bi bi-floppy"></i> Guardar
            </button>
            <button id="btn-cancelar-nuevo-equipo" class="btn btn-outline-secondary py-1">Cancelar</button>
        </div>
      </div>

     `;
}



// === NUEVO: Guardar el nuevo equipo (POST) y refrescar lista/abrir detalle ===
document.addEventListener('click', async (e) => {
  // Guardar
  if (e.target.closest('#btn-guardar-nuevo-equipo')) {
    e.preventDefault();
    const section = document.getElementById('section1-nuevo');
    if (!section) return;

    const formData = new FormData();
    // Campos .edicion (misma estrategia que usas al actualizar) :contentReference[oaicite:12]{index=12}
    section.querySelectorAll('.edicion').forEach(el => {
      if (el.name && el.type !== 'file') formData.append(el.name, el.value);
    });

    // Campos especiales
    const responsable = section.querySelector('select[name="responsable"]');
    if (responsable) formData.append('responsable', responsable.value || '');
    const imagenInput = section.querySelector('input[type="file"][name="imagen_equipo"]');
    if (imagenInput?.files?.length) formData.append('imagen_equipo', imagenInput.files[0]);
    const descripcion = section.querySelector('textarea[name="descripcion"]');
    if (descripcion) formData.append('descripcion', descripcion.value || '');
    if (window.buqueId) formData.append('buque_id', window.buqueId);

    try {
      const res = await fetch('/LSA/crear-equipo', { method: 'POST', body: formData });
      const data = await res.json();
      if (!res.ok || !data?.success) throw new Error(data?.message || 'No se pudo crear el equipo');

      // Refrescar lista y abrir el nuevo (mismo patrón que al guardar sección 1) :contentReference[oaicite:13]{index=13}
      const buqueId = window.buqueId;
      const resp = await fetch(`/api/equipos_resumen/${buqueId}`);
      const equiposActualizados = await resp.json();
      window.equiposGlobal = equiposActualizados;
      renderizarEquipos(window.equiposGlobal); // tu función existente :contentReference[oaicite:14]{index=14}

      // Re-seleccionar grupo si el backend lo devuelve; si no, usa el seleccionado en el form
      const idGrupo = data?.id_grupo || section.querySelector('#grupo_constructivo')?.value || null;
      if (idGrupo) {
        const grupoBtn = Array.from(document.querySelectorAll('.group-btn'))
          .find(btn => (btn.getAttribute('onclick') || '').includes(`seleccionarGrupo(${idGrupo}`));
        if (grupoBtn) seleccionarGrupo(parseInt(idGrupo), { currentTarget: grupoBtn });
      }

      // Abrir detalle del nuevo
      if (data?.id_equipo_info) {
        localStorage.setItem('equipoSeleccionado', data.id_equipo_info);
        setTimeout(() => { mostrarDetalleEquipo(data.id_equipo_info); }, 600);
      }

      Swal.fire('Creado', 'Equipo creado correctamente.', 'success');
    } catch (err) {
      console.error(err);
      Swal.fire('Error', err.message || 'Error al crear el equipo.', 'error');
    }
  }

  // Cancelar
  if (e.target.closest('#btn-cancelar-nuevo-equipo')) {
    e.preventDefault();
    const detalle = document.getElementById('detalle-equipo-container');
    if (detalle) {
      detalle.innerHTML = `
        <div class="mensaje-seleccion-equipo p-5">
          <div class="card-seleccion">
            <i class="bi bi-info-circle-fill" style="font-size:28px; color:#003366;"></i>
            <p class="mt-3 mb-0">Seleccione un equipo</p>
          </div>
        </div>`;
      detalle.classList.remove('detalle-visible');
    }
    localStorage.removeItem('equipoSeleccionado');
  }

});

document.addEventListener('click', function (e) {
    const guardarBtn = e.target.closest('.btn-guardar-edicion');
    if (!guardarBtn) return;

    const section = guardarBtn.closest('.zone.section');
    const sectionId = guardarBtn.id; // ejemplo: "btn-guardar-edicion-section3"

    const idEquipo = localStorage.getItem('equipoSeleccionado');


    if (sectionId === 'btn-guardar-edicion-section1') {
        const idEquipo = section.dataset.idEquipo;
        const formData = new FormData();

        formData.append('id_equipo_info', idEquipo);

        // ✅ Campo: Responsable (select)
        const responsableSelect = section.querySelector('select[name="responsable"]');
        if (responsableSelect) {
            formData.append('responsable', responsableSelect.value);
        }

        // ✅ Campo: Imagen (file)
        const imagenInput = section.querySelector('input[type="file"][name="imagen_equipo"]');
        if (imagenInput?.files?.length > 0) {
            formData.append('imagen_equipo', imagenInput.files[0]);
        }

        // Agregar descripción manualmente si existe
        const descripcionTextarea = section.querySelector('textarea[name="descripcion"]');
        if (descripcionTextarea) {
            formData.append('descripcion', descripcionTextarea.value);
        }


        // ✅ Resto de campos
        section.querySelectorAll('.edicion').forEach(el => {
            if (el.name && el.type !== 'file') {
                formData.append(el.name, el.value);
            }
        });

        fetch('/LSA/actualizar-parametros-equipo', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                section.classList.remove('modo-edicion');
                guardarBtn.classList.add('d-none');
                const toggleBtn = document.querySelector('[data-section="section1"]');
                const icon = toggleBtn?.querySelector('i');
                if (icon) icon.classList.replace('bi-x', 'bi-pen');
                section.querySelectorAll('.vista').forEach(el => el.classList.remove('d-none'));
                section.querySelectorAll('.edicion').forEach(el => el.classList.add('d-none'));

                Swal.fire('Guardado', 'Generalidades actualizadas correctamente.', 'success').then(() => {
                    const buqueId = window.buqueId;

                    fetch(`/api/equipos_resumen/${buqueId}`)
                    .then(response => response.json())
                    .then(equiposActualizados => {
                        window.equiposGlobal = equiposActualizados;
                        const grupoBtnSeleccionado = document.querySelector('.group-btn.selected-group');
                        let grupoId = null;

                        if (grupoBtnSeleccionado) {
                            const onclickValue = grupoBtnSeleccionado.getAttribute('onclick');
                            const match = onclickValue?.match(/seleccionarGrupo\((\d+)/);
                            if (match && match[1]) {
                                grupoId = parseInt(match[1]);
                                console.log("✅ grupoId seleccionado:", grupoId);
                                seleccionarGrupo(grupoId, { currentTarget: grupoBtnSeleccionado });

                                const equipoId = localStorage.getItem('equipoSeleccionado');

                                setTimeout(() => {
                                    mostrarDetalleEquipo(equipoId);
                                }, 700);
                            } else {
                                console.warn("⚠️ No se pudo obtener el grupoId del botón seleccionado.");
                            }
                        } else {
                            console.warn("⚠️ No hay botón de grupo con clase 'selected-group'.");
                        }
                    })
                    .catch(err => console.error("❌ Error al refrescar lista de equipos:", err));

                });
            } else {
                Swal.fire('Error', res.message || 'No se pudo guardar.', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'Error de red al guardar.', 'error');
        });

        return; // Detener ejecución de otras secciones
    }

    if (sectionId === 'btn-guardar-edicion-section2') {
        
        const idEquipo = section.dataset.idEquipo;
        const formData = new FormData();

        formData.append('id_equipo_info', idEquipo);

        section.querySelectorAll('.edicion').forEach(el => {
            if (el.name && el.type !== 'file') {
                formData.append(el.name, el.value);
            }
        });

        const caracteristicas = obtenerDatosDinamicos();
        formData.append('caracteristicas', JSON.stringify(caracteristicas));

        fetch('/LSA/actualizar-parametros-equipo', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                section.classList.remove('modo-edicion');
                guardarBtn.classList.add('d-none');
                const toggleBtn = document.querySelector('[data-section="section2"]');
                const icon = toggleBtn?.querySelector('i');
                if (icon) icon.classList.replace('bi-x', 'bi-pen');
                section.querySelectorAll('.vista').forEach(el => el.classList.remove('d-none'));
                section.querySelectorAll('.edicion').forEach(el => el.classList.add('d-none'));

                Swal.fire('Guardado', 'Detalles del equipo actualizados correctamente.', 'success').then(() => {
                    recargarDetalleEquipoActual();
                });
            } else {
                Swal.fire('Error', res.message || 'No se pudo guardar los detalles.', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'Error de red al guardar.', 'error');
        });

        return; // Evita que se ejecute el resto del listener
    }

    if (sectionId === 'btn-guardar-edicion-section3') {
        const arranqueContainer = document.getElementById('arranque-container');
        const paradaContainer = document.getElementById('parada-container');

        const arranqueTexto = serializarProcedimiento(arranqueContainer);
        const paradaTexto = serializarProcedimiento(paradaContainer);


        if (!idEquipo) {
            alert('No se encontró el ID del equipo.');
            return;
        }

        fetch('/LSA/actualizar-parametros-equipo', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                id_equipo_info: idEquipo,
                procedimiento_arranque: arranqueTexto,
                procedimiento_parada: paradaTexto
            })
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                Swal.fire('Guardado', 'Procedimientos actualizados correctamente.', 'success').then(() => {
                    recargarDetalleEquipoActual();
                });
            } else {
                Swal.fire('Error', res.message || 'No se pudo guardar procedimientos.', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'Error de red al guardar procedimientos.', 'error');
        });

        return; // ⛔ Salir para no ejecutar el resto del guardado
    }

    if (sectionId === 'btn-guardar-edicion-section4') {
        const idEquipo = section.dataset.idEquipo;
        const formData = new FormData();

        formData.append('id_equipo_info', idEquipo);

        // Imágenes de diagramas
        const imgFields = ['diagrama_flujo', 'diagrama_caja_negra', 'diagrama_caja_transparente'];

        imgFields.forEach(field => {
            const input = section.querySelector(`input[type="file"][name="${field}"]`);
            if (input?.files?.length > 0) {
                formData.append(field, input.files[0]);
            }

            const removeInput = section.querySelector(`input[name="remove_${field}"]`);
            if (removeInput) {
                formData.append(`remove_${field}`, removeInput.value);
            }
        });

        fetch('/LSA/actualizar-parametros-equipo', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                section.classList.remove('modo-edicion');
                guardarBtn.classList.add('d-none');
                const toggleBtn = document.querySelector('[data-section="section4"]');
                const icon = toggleBtn?.querySelector('i');
                if (icon) icon.classList.replace('bi-x', 'bi-pen');
                section.querySelectorAll('.vista').forEach(el => el.classList.remove('d-none'));
                section.querySelectorAll('.edicion').forEach(el => el.classList.add('d-none'));

                Swal.fire('Guardado', 'Diagramas actualizados correctamente.', 'success').then(() => {
                    const seccionActivaId = section.id;
                    recargarDetalleEquipoActual(seccionActivaId);
                });
            } else {
                Swal.fire('Error', res.message || 'No se pudo guardar los diagramas.', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'Error de red al guardar los diagramas.', 'error');
        });

        return;
    }

  
});

function inicializarComponentesDetalleEquipo(data) {
    inicializarGeneralidades();               // Sección 1
    inicializarBotonModoEdicion();            // Botones toggle edición
    inicializarRepresentacionesEsquematicas();// Sección 4: Esquemáticos
    inicializarClaseObjetoTipo();             // Campo: Clase de objeto
    inicializarValidacionDimensiones();       // Campo: Dimensiones (groes)
    inicializarUnidadesPeso();                // Campo: Unidad de peso
    inicializarFechaConstruccion();           // Campos: Año y mes construcción
    inicializarProcedimientos(data);          // Sección 3: Procedimientos
    inicializarTabs();                        // Navegación de tabs
    inicializarTabsInternosHerramientas();    // Navegación herramientas
    inicializarScrollHorizontalEn(document.getElementById('detalle-equipo-container')); // scroll
    inicializarBotonPDF();                    // Generación PDF
    activarBotonesEdicion();                  // Mostrar/ocultar botones de guardar
    inicializarClaveMoneda();
    inicializarPaisFabricacion();
    inicializarMesConstruccion();
    actualizarUbicacionTecnica(data.datos_buque?.numero_casco || '');
    
    const caracteristicas = data?.equipo?.caracteristicas 
        ? JSON.parse(data.equipo.caracteristicas) 
        : null;

    cargarClases(caracteristicas);
    inicializarClaseSeleccionada();   
    inicializarBotonEliminarEquipo();
    inicializarBotonesCAD(data);
}

function inicializarGeneralidades() {
  const grupoConstructivo = document.getElementById('grupo_constructivo');
  const subgrupoConstructivo = document.getElementById('subgrupo_constructivo');
  const sistema = document.getElementById('sistema');
  const subsistema = document.getElementById('subsistema');
  const equipo = document.getElementById('equipo_select');
  const tipoEquipo = document.getElementById('tipo_equipo');
  const addPersonalBtn = document.getElementById('add_personal');
  const deletePersonalBtn = document.getElementById('delete_personal');
  const responsable = document.getElementById('responsable');
  const inputImagen = document.getElementById('imagen_equipo');
  const previewImagen = document.getElementById('preview-imagen-equipo');
  const btnEliminarImagen = document.getElementById('btn-eliminar-imagen-equipo');
  const campoRemoveImagen = document.getElementById('remove_imagen_equipo');

    // 🧩 Si ya hay un grupo cargado al inicio, precargar subgrupos
    if (grupoConstructivo && grupoConstructivo.value) {
        fetch(`/api/subgrupos/${grupoConstructivo.value}`)
            .then(response => response.json())
            .then(data => {
                subgrupoConstructivo.innerHTML = '<option value="">Seleccione Subgrupo Constructivo</option>';
                data.forEach(sub => {
                    const selected = sub.id == subgrupoConstructivo.getAttribute('data-selected-id') ? 'selected' : '';
                    subgrupoConstructivo.innerHTML += `<option value="${sub.id}" ${selected}>${sub.numeracion} - ${sub.nombre}</option>`;
                });
            })
            .catch(error => console.error('Error al cargar subgrupos iniciales:', error));
    }


  grupoConstructivo?.addEventListener('change', () => {
    const grupoId = grupoConstructivo.value;
    if (grupoId) {
        fetch(`/api/subgrupos/${grupoId}`)
        .then(response => response.json())
        .then(data => {
            subgrupoConstructivo.innerHTML = '<option value="">Seleccione Subgrupo Constructivo</option>';
            data.forEach(subgrupo => {
            subgrupoConstructivo.innerHTML += `<option value="${subgrupo.id}">${subgrupo.numeracion} - ${subgrupo.nombre}</option>`;
            });
        })
        .catch(error => console.error('Error al obtener subgrupos:', error));
    } else {
        subgrupoConstructivo.innerHTML = '<option value="">Seleccione Subgrupo Constructivo</option>';
    }

    sistema.innerHTML = '<option value="">Seleccione Sistema</option>';
    subsistema.innerHTML = '<option value="">Seleccione Subsistema</option>';
  });

 subgrupoConstructivo?.addEventListener('change', () => {
  const subgrupoId = subgrupoConstructivo.value;
  if (subgrupoId) {
    fetch(`/api/sistemas/${subgrupoId}`)
      .then(response => response.json())
      .then(data => {
        sistema.innerHTML = '<option value="">Seleccione Sistema</option>';
        data.forEach(sistemaItem => {
          sistema.innerHTML += `<option value="${sistemaItem.id}">${sistemaItem.numeracion} - ${sistemaItem.nombre}</option>`;
        });
      })
      .catch(error => console.error('Error al obtener sistemas:', error));
  } else {
    sistema.innerHTML = '<option value="">Seleccione Sistema</option>';
  }

  subsistema.innerHTML = '<option value="">Seleccione Subsistema</option>';

});

    sistema?.addEventListener('change', () => {
    const sistemaId = sistema.value;

    if (sistemaId) {
      // Cargar equipos
      fetch(`/api/equipos/${sistemaId}`)
        .then(response => response.json())
        .then(data => {
          data.forEach(equipoItem => {
            equipo.innerHTML += `<option value="${equipoItem.id}">${equipoItem.nombre}</option>`;
          });
        })
        .catch(error => console.error('Error al obtener equipos:', error));

      // Cargar subsistemas
      fetch(`/api/subsistemas/${sistemaId}`)
        .then(response => response.json())
        .then(data => {
          subsistema.innerHTML = '<option value="">Seleccione Subsistema</option>';
          console.log(data)
          data.forEach(sub => {
            subsistema.innerHTML += `<option value="${sub.id}">${sub.numero_de_referencia} - ${sub.descripcion}</option>`;
          });
        })
        .catch(error => console.error('Error al obtener subsistemas:', error));
    } else {
      subsistema.innerHTML = '<option value="">Seleccione Subsistema</option>';
    }
  });

    // 👇 NUEVO: dentro de inicializarGeneralidades(), después de configurar 'sistema'
    subsistema?.addEventListener('change', async () => {
        const subsistemaId = subsistema.value;
        const selectEquipo = document.getElementById('equipo_select');
        if (!selectEquipo) return;

        // Limpia opciones
        selectEquipo.innerHTML = '<option value="">Seleccione Equipo</option>';

        // Sin subsistema => no cargamos nada
        if (!subsistemaId) return;

        try {
            // Ajusta el endpoint si tu backend usa otro (p.ej. /api/equipos?subsistema=ID)
            const res = await fetch(`/api/subsistemas/${subsistemaId}`);
            const equipos = await res.json();

            equipos.forEach(eq => {
            const opt = document.createElement('option');
            opt.value = eq.id;
            opt.textContent = eq.nombre;
            selectEquipo.appendChild(opt);
            });
        } catch (err) {
            console.error('Error al cargar equipos del subsistema:', err);
        }
    });

    tipoEquipo?.addEventListener('change', () => {
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
            .catch(error => console.error('Error al obtener equipos por tipo:', error));
        } else {
        equipo.innerHTML = '<option value="">Seleccione Equipo</option>';
        }
    });

    addPersonalBtn?.addEventListener('click', () => {
    Swal.fire({
        title: 'Adicionar Personal',
        text: 'Ingrese el nombre completo del nuevo personal:',
        input: 'text',
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#003366',
        inputValidator: (value) => {
        if (!value) {
            return 'Debe ingresar un nombre válido';
        }
        }
    }).then((result) => {
        if (result.isConfirmed) {
        fetch('/api/crear_personal', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre_completo: result.value })
        })
        .then(response => response.json())
        .then(data => {
            responsable.innerHTML += `<option value="${data.id}">${data.nombre_completo}</option>`;
            responsable.value = data.id;

            Swal.fire('Agregado', 'El personal fue creado correctamente.', 'success');
        })
        .catch(error => {
            Swal.fire('Error', 'Error al crear personal: ' + error.message, 'error');
        });
        }
    });
    });

    deletePersonalBtn?.addEventListener('click', () => {
        const idPersonal = responsable.value;
        const nombrePersonal = responsable.options[responsable.selectedIndex]?.text;

        if (idPersonal) {
            Swal.fire({
            title: '¿Está seguro?',
            text: `¿Desea eliminar a ${nombrePersonal}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.isConfirmed) {
                fetch('/api/eliminar_personal', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id_personal: idPersonal })
                })
                .then(response => response.json())
                .then(() => {
                responsable.querySelector(`option[value="${idPersonal}"]`)?.remove();
                responsable.value = '';
                Swal.fire('Eliminado', 'El personal fue eliminado correctamente.', 'success');
                })
                .catch(error => {
                Swal.fire('Error', 'Error al eliminar personal: ' + error.message, 'error');
                });
            }
            });
        } else {
            Swal.fire('Atención', 'Por favor, seleccione un personal para eliminar', 'info');
        }
    });

  const nombreEquipoInput = document.querySelector('[name="nombre_equipo"]');
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
          }
        };
        xhr.send('nombre_equipo=' + encodeURIComponent(nombreEquipo));
      }
    });
  }

    inputImagen?.addEventListener('change', () => {
        if (inputImagen.files && inputImagen.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
            previewImagen.src = e.target.result;
            campoRemoveImagen.value = 'false'; // asegúrate de no eliminar
            };
            reader.readAsDataURL(inputImagen.files[0]);
        }
        });

        // Eliminar imagen
        btnEliminarImagen?.addEventListener('click', () => {
        previewImagen.src = '/static/img/default_image.png';
        inputImagen.value = '';
        campoRemoveImagen.value = 'true';
    });

    ['grupo_constructivo', 'subgrupo_constructivo', 'sistema', 'subsistema'].forEach(id => {
        const select = document.getElementById(id);
        if (select) {
            select.addEventListener('change', actualizarUbicacionTecnica);
        }
    });

}

function inicializarBotonModoEdicion() {
  document.querySelectorAll('.btn-toggle-edicion').forEach(toggleBtn => {
    const sectionId = toggleBtn.dataset.section;
    const guardarBtn = document.getElementById(`btn-guardar-edicion-${sectionId}`);
    const section = document.getElementById(sectionId);

    if (!guardarBtn || !section) return;

    // Ocultar botón guardar inicialmente solo si es section1 o section4
    if (sectionId === 'section1' || sectionId === 'section4') {
      guardarBtn.classList.add('d-none');
    }

    toggleBtn.addEventListener('click', () => {
      const icon = toggleBtn.querySelector('i');
      const isEditing = section.classList.contains('modo-edicion');

      if (!isEditing) {
        section.classList.add('modo-edicion');
        section.querySelectorAll('.vista')?.forEach(el => el.classList.add('d-none'));
        section.querySelectorAll('.edicion')?.forEach(el => el.classList.remove('d-none'));
        icon.classList.replace('bi-pen', 'bi-x');

        // Mostrar botón guardar solo si es section1 o section4
        if (sectionId === 'section1' || sectionId === 'section4') {
          guardarBtn.classList.remove('d-none');
        }

      } else {
        section.classList.remove('modo-edicion');
        section.querySelectorAll('.vista')?.forEach(el => el.classList.remove('d-none'));

        // Ocultar elementos de edición solo si es section1 o section4
        if (sectionId === 'section1' || sectionId === 'section4') {
          section.querySelectorAll('.edicion')?.forEach(el => el.classList.add('d-none'));
          guardarBtn.classList.add('d-none');
        }

        icon.classList.replace('bi-x', 'bi-pen');
      }
    });
  });
}

function inicializarRepresentacionesEsquematicas() {
    const section = document.getElementById('section4');

    const items = [
        {
            inputId: 'diagrama_flujo',
            previewId: 'preview-diagrama-flujo',
            removeBtnId: 'btn-eliminar-diagrama-flujo',
            hiddenFlagId: 'remove_diagrama_flujo'
        },
        {
            inputId: 'diagrama_caja_negra',
            previewId: 'preview-diagrama-caja-negra',
            removeBtnId: 'btn-eliminar-diagrama-caja-negra',
            hiddenFlagId: 'remove_diagrama_caja_negra'
        },
        {
            inputId: 'diagrama_caja_transparente',
            previewId: 'preview-diagrama-caja-transparente',
            removeBtnId: 'btn-eliminar-diagrama-caja-transparente',
            hiddenFlagId: 'remove_diagrama_caja_transparente'
        }
    ];

    // Guardar imágenes originales para restaurar si se cancela edición
    const imagenesOriginales = {};

    items.forEach(item => {
        const input = document.getElementById(item.inputId);
        const preview = document.getElementById(item.previewId);
        const removeBtn = document.getElementById(item.removeBtnId);
        const hiddenInput = document.getElementById(item.hiddenFlagId);

        if (!input || !preview || !removeBtn || !hiddenInput) return;

        // Guardar estado original
        imagenesOriginales[item.previewId] = preview.src;

        // Previsualización al seleccionar nueva imagen
        input.addEventListener('change', () => {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    hiddenInput.value = 'false';
                };
                reader.readAsDataURL(input.files[0]);
            }
        });

        // Eliminar imagen: volver a default y marcar flag
        removeBtn.addEventListener('click', () => {
            preview.src = '/static/img/default_image.png';
            hiddenInput.value = 'true';
            input.value = ''; // Limpiar input para evitar sobrescritura
        });
    });

    // Botón cancelar edición de section4: revertir cambios
    const toggleBtn = document.getElementById('btn-toggle-edicion-section4');
    const guardarBtn = document.getElementById('btn-guardar-edicion-section4');
    if (toggleBtn && guardarBtn && section) {
        toggleBtn.addEventListener('click', () => {
            const isEditing = section.classList.contains('modo-edicion');
            if (!isEditing) {
                // Revertir imágenes a original
                items.forEach(item => {
                    const preview = document.getElementById(item.previewId);
                    const hiddenInput = document.getElementById(item.hiddenFlagId);
                    const input = document.getElementById(item.inputId);
                    if (preview && imagenesOriginales[item.previewId]) {
                        preview.src = imagenesOriginales[item.previewId];
                        hiddenInput.value = 'false';
                        if (input) input.value = ''; // limpiar selección temporal
                    }
                });
            }
        });
    }
}

function inicializarBotonesCAD(data) {
    const equipoId = data.equipo?.id;
    if (!equipoId) return;

    // Botón de descarga CAD
    const btnDownloadCad = document.getElementById('btn-download-cad');
    if (btnDownloadCad) {
        btnDownloadCad.addEventListener('click', function() {
            const equipoIdBtn = this.getAttribute('data-equipo-id');
            console.log('🔽 Descargando archivo CAD para equipo:', equipoIdBtn);
            
            // Crear enlace de descarga temporal
            const link = document.createElement('a');
            link.href = `/LSA/get-cad-file/${equipoIdBtn}`;
            link.download = `modelo_cad_equipo_${equipoIdBtn}.${data.equipo?.tipo_archivo_cad || 'step'}`;
            link.style.display = 'none';
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            console.log('✅ Descarga iniciada');
        });
    }

    // Botón de eliminación CAD
    const btnDeleteCad = document.getElementById('btn-delete-cad');
    if (btnDeleteCad) {
        btnDeleteCad.addEventListener('click', function() {
            const equipoIdBtn = this.getAttribute('data-equipo-id');
            console.log('🗑️ Eliminando archivo CAD para equipo:', equipoIdBtn);
            console.log('🔍 Tipo de dato:', typeof equipoIdBtn);
            console.log('🔍 Valor raw:', equipoIdBtn);
            console.log('🔍 Elemento completo:', this);
            console.log('🔍 Todos los atributos:', this.attributes);
            
            // Verificación de emergencia - usar currentEquipoId global si existe
            let equipoIdFinal = equipoIdBtn;
            if (!equipoIdBtn || equipoIdBtn === '0' || equipoIdBtn === 'null') {
                console.warn('⚠️ data-equipo-id inválido, buscando alternativas...');
                
                // Buscar en variables globales
                if (typeof currentEquipoId !== 'undefined' && currentEquipoId > 0) {
                    equipoIdFinal = currentEquipoId.toString();
                    console.log('🔄 Usando currentEquipoId global:', equipoIdFinal);
                }
                // Buscar en URL o localStorage como último recurso
                else if (window.location.pathname.includes('/equipo/')) {
                    const urlParts = window.location.pathname.split('/');
                    const urlEquipoId = urlParts[urlParts.indexOf('equipo') + 1];
                    if (urlEquipoId && !isNaN(parseInt(urlEquipoId))) {
                        equipoIdFinal = urlEquipoId;
                        console.log('🔄 Usando ID de URL:', equipoIdFinal);
                    }
                }
            }
            
            // Validación final
            if (!equipoIdFinal || equipoIdFinal === '0' || equipoIdFinal === 'null' || equipoIdFinal === 'undefined') {
                console.error('❌ ID de equipo inválido después de todas las verificaciones:', equipoIdFinal);
                Swal.fire('Error', 'No se puede determinar el ID del equipo. Recarga la página e intenta nuevamente.', 'error');
                return;
            }
            
            // Confirmación con SweetAlert
            Swal.fire({
                title: '¿Eliminar archivo CAD?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const equipoIdNumerico = parseInt(equipoIdFinal);
                    console.log('🔢 ID final convertido a número:', equipoIdNumerico);
                    
                    if (isNaN(equipoIdNumerico) || equipoIdNumerico <= 0) {
                        console.error('❌ ID numérico inválido:', equipoIdNumerico);
                        Swal.fire('Error', `ID de equipo no es un número válido: ${equipoIdFinal}`, 'error');
                        return;
                    }
                    
                    // Realizar petición de eliminación usando la ruta correcta
                    console.log('📤 Enviando petición de eliminación con ID:', equipoIdNumerico);
                    fetch('/LSA/delete-cad', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-From-Laravel': 'true'
                        },
                        body: JSON.stringify({
                            equipo_id: equipoIdNumerico
                        })
                    })
                    .then(response => {
                        console.log('📥 Respuesta del servidor:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('📊 Datos de respuesta:', data);
                        if (data.success) {
                            Swal.fire('Eliminado', 'El archivo CAD ha sido eliminado exitosamente', 'success')
                            .then(() => {
                                // Actualizar la vista sin recargar la página
                                actualizarVistaEquipoDespuesDeEliminarCAD(equipoIdFinal);
                            });
                        } else {
                            console.error('❌ Error del servidor:', data.error);
                            Swal.fire('Error', data.error || 'Error al eliminar el archivo CAD', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('❌ Error eliminando archivo CAD:', error);
                        Swal.fire('Error', `Error de conexión: ${error.message}`, 'error');
                    });
                }
            });
        });
    }

    // ======================================
    // FUNCIONALIDAD DRAG & DROP PARA UPLOAD-ZONE
    // ======================================
    const uploadZone = document.querySelector('.upload-zone');
    const btnUploadCad = document.getElementById(`btn-upload-cad-${equipoId}`);
    const fileInputCad = document.getElementById(`file-input-cad-${equipoId}`);

    // Event listener para el botón de seleccionar archivo
    if (btnUploadCad && fileInputCad) {
        btnUploadCad.addEventListener('click', function() {
            console.log('🖱️ Botón seleccionar archivo clicado');
            fileInputCad.click();
        });

        // Event listener para cuando se selecciona un archivo
        fileInputCad.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                console.log('📁 Archivo seleccionado:', file.name);
                window.subirArchivoCAD(equipoId, file);
            }
        });
    }

    // Configurar drag & drop si existe la upload-zone
    if (uploadZone) {
        console.log('🎯 Configurando drag & drop para upload-zone');

        // Prevenir comportamiento por defecto para todos los eventos de drag
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop area cuando el archivo está siendo arrastrado sobre ella
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, unhighlight, false);
        });

        // Manejar el drop del archivo
        uploadZone.addEventListener('drop', handleDrop, false);

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            uploadZone.style.borderColor = '#007bff';
            uploadZone.style.backgroundColor = '#e7f3ff';
            uploadZone.style.transform = 'scale(1.02)';
        }

        function unhighlight(e) {
            uploadZone.style.borderColor = '#dee2e6';
            uploadZone.style.backgroundColor = '#f8f9fa';
            uploadZone.style.transform = 'scale(1)';
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                const file = files[0];
                console.log('📁 Archivo soltado:', file.name);
                
                // Validar formato de archivo
                const formatosPermitidos = ['.step', '.stp', '.iges', '.igs', '.stl', '.obj', '.ply', '.glb', '.gltf'];
                const extension = '.' + file.name.split('.').pop().toLowerCase();
                
                if (formatosPermitidos.includes(extension)) {
                    window.subirArchivoCAD(equipoId, file);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Formato no válido',
                        text: `El archivo debe ser de uno de estos formatos: ${formatosPermitidos.join(', ')}`
                    });
                }
            }
        }
    }
}

function inicializarClaseObjetoTipo() {
    const $eqart = $('#eqart');
    console.log ($eqart)
    if (!$eqart.length) return;

    // Evitar duplicados
    if ($eqart.hasClass('select2-hidden-accessible')) {
        $eqart.select2('destroy');
    }

    $eqart.empty().append('<option value="">Seleccione una clase de objeto / tipo</option>');
    clasesObjetoTipo.forEach(op => {
        $eqart.append(new Option(`${op.codigo} - ${op.descripcion}`, op.codigo));
    });

    $eqart.select2({
        width: '100%',
        placeholder: 'Seleccione una clase de objeto / tipo'
    });

    const valorGuardado = $eqart.data('value');
    if (valorGuardado) {
        $eqart.val(valorGuardado).trigger('change');
    }
}

function inicializarValidacionDimensiones() {
    const input = document.getElementById('groes');
    const mensaje = document.getElementById('groes-help');

    if (!input || !mensaje ) return;

    // Formato: número (opcional decimal) + unidad, tres veces, separados por "x", sin espacios
    const regex = /^\d+(\.\d+)?(mm|cm|m|in|ft)x\d+(\.\d+)?(mm|cm|m|in|ft)x\d+(\.\d+)?(mm|cm|m|in|ft)$/i;

    // Al salir del campo
    input.addEventListener('blur', function () {
        let valor = input.value.trim().toLowerCase();

        // Quitar espacios alrededor de cada "x"
        valor = valor.replace(/\s*x\s*/g, 'x');
        input.value = valor;

        if (valor === '' || regex.test(valor)) {
            mensaje.classList.add('d-none');
            input.classList.remove('is-invalid');
        } else {
            mensaje.classList.remove('d-none');
            input.classList.add('is-invalid');
        }
    });

    // En tiempo real, ocultar errores si comienza a corregir
    input.addEventListener('input', function () {
        input.classList.remove('is-invalid');
        mensaje.classList.add('d-none');
    });
}

function inicializarUnidadesPeso() {
    const unidades = [
        { codigo: 'KG', descripcion: 'Kilogramo' },
        { codigo: 'G', descripcion: 'Gramo' },
        { codigo: 'MG', descripcion: 'Miligramo' },
        { codigo: 'LB', descripcion: 'Libra' },
        { codigo: 'OZ', descripcion: 'Onza' },
        { codigo: 'TON', descripcion: 'Tonelada' },
        { codigo: 'ST', descripcion: 'Stone' }
    ];

    const select = document.getElementById('gewei');
    if (!select) return;

    // Elimina otras opciones que no sean la primera (placeholder)
    select.querySelectorAll('option:not([value=""])').forEach(opt => opt.remove());

    unidades.forEach(u => {
        const option = document.createElement('option');
        option.value = u.codigo;
        option.textContent = `${u.codigo} - ${u.descripcion}`;
        select.appendChild(option);
    });
}

function inicializarFechaConstruccion() {
    const selectAnio = document.getElementById('baujj');
    const selectMes = document.getElementById('baumm');

    if (selectAnio) {
        const anioActual = new Date().getFullYear();
        for (let anio = anioActual; anio >= 2000; anio--) {
            const option = document.createElement('option');
            option.value = anio;
            option.textContent = anio;
            selectAnio.appendChild(option);
        }
    }

    if (selectMes && selectMes.children.length <= 1) {
        const meses = [
            'Enero', 'Febrero', 'Marzo', 'Abril',
            'Mayo', 'Junio', 'Julio', 'Agosto',
            'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        meses.forEach((mes, index) => {
            const option = document.createElement('option');
            option.value = String(index + 1).padStart(2, '0'); // 01, 02, ..., 12
            option.textContent = mes;
            selectMes.appendChild(option);
        });
    }
}

function obtenerTextoProcedimiento(container) {
    return Array.from(container.querySelectorAll('.input-paso'))
        .map(div => div.innerText.trim())
        .filter(texto => texto.length > 0)
        .map((texto, index) => `${index + 1}. ${texto}.`)
        .join('\n');
}

function inicializarTabs() {
    const scrollContainer = document.querySelector('.tab-scroll-container');
    const tabButtons = document.querySelectorAll('.tab-button');

    // Reasignar scroll automático al hacer clic
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            scrollToTabButton(button);
        });
    });

    // Activar comportamiento por defecto de selección
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.dataset.target;

            // Ocultar todas las secciones
            document.querySelectorAll('.zone.section').forEach(section => {
                section.classList.remove('active');
                if (!section.classList.contains('d-none')) {
                    section.classList.add('d-none');
                }
            });

            // Mostrar la sección correspondiente
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.classList.add('active');
                targetSection.classList.remove('d-none');
                console.log('Sección activada:', targetId);
                
                // ⚡ OPTIMIZACIÓN 3: Precargar modelo CAD cuando el usuario navega cerca de la pestaña
                if (window.cadPreloader && targetSection.id === 'section13') {
                    // Usuario abrió la pestaña de Modelo CAD - precargar con alta prioridad
                    const equipoId = targetSection.dataset.idEquipo;
                    if (equipoId) {
                        console.log('⚡ Precargando modelo CAD con prioridad ALTA');
                        window.cadPreloader.prefetchModel(equipoId, 'high');
                    }
                } else if (window.cadPreloader && (targetId === 'section4' || targetId === 'section3')) {
                    // Usuario está cerca de la pestaña CAD - precargar con prioridad media
                    const section13 = document.getElementById('section13');
                    const equipoId = section13?.dataset.idEquipo;
                    if (equipoId) {
                        console.log('⚡ Precargando modelo CAD en segundo plano (prioridad media)');
                        window.cadPreloader.prefetchModel(equipoId, 'medium');
                    }
                }
            }

            // Actualizar pestañas activas
            tabButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
        });
    });

    // Scroll buttons
    const leftBtn = document.querySelector('.scroll-btn.left-btn');
    const rightBtn = document.querySelector('.scroll-btn.right-btn');

    if (leftBtn && rightBtn) {
        leftBtn.addEventListener('click', () => scrollTabs('left'));
        rightBtn.addEventListener('click', () => scrollTabs('right'));
    }

    if (scrollContainer) {
        scrollContainer.addEventListener('scroll', actualizarVisibilidadScrollButtons);
        actualizarVisibilidadScrollButtons();
    }
}

function inicializarTabsInternosHerramientas() {
    const tabTriggerList = document.querySelectorAll('#tabsHerramientas .nav-link');

    tabTriggerList.forEach(tabEl => {
        const trigger = new bootstrap.Tab(tabEl);

        tabEl.addEventListener('click', function (e) {
            e.preventDefault();

            // Desactivar todos los botones
            tabTriggerList.forEach(btn => btn.classList.remove('active'));
            tabEl.classList.add('active');

            // Ocultar todos los contenidos
            const panes = document.querySelectorAll('#contenidoTabsHerramientas .tab-pane');
            panes.forEach(pane => pane.classList.remove('show', 'active'));

            // Activar el correspondiente
            const target = tabEl.getAttribute('data-bs-target');
            const pane = document.querySelector(target);
            if (pane) {
                pane.classList.add('show', 'active');
            }
        });
    });
}

window.inicializarScrollHorizontalEn = function (container) {
    const scrollContainers = container.querySelectorAll('.scroll-container-horizontal');

    scrollContainers.forEach((scrollContainer) => {
        const scrollLeftButton = scrollContainer.parentElement.querySelector('.scroll-button.left');
        const scrollRightButton = scrollContainer.parentElement.querySelector('.scroll-button.right');

        const scrollAmount = 10;
        let scrollInterval;

        function updateButtonVisibility() {
            const scrollLeft = scrollContainer.scrollLeft;
            const maxScrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;

            // Mostrar solo si hay desbordamiento real
            const hayDesbordamiento = scrollContainer.scrollWidth > scrollContainer.clientWidth;

            if (scrollLeftButton && scrollRightButton) {
                scrollLeftButton.classList.toggle('hidden', scrollLeft === 0 || !hayDesbordamiento);
                scrollRightButton.classList.toggle('hidden', scrollLeft >= maxScrollLeft || !hayDesbordamiento);
            }
        }

        function startScrolling(direction) {
            stopScrolling();
            scrollInterval = setInterval(() => {
                scrollContainer.scrollBy({
                    left: direction * scrollAmount
                });
            }, 10);
        }

        function stopScrolling() {
            clearInterval(scrollInterval);
        }

        if (scrollLeftButton && scrollRightButton) {
            scrollLeftButton.addEventListener('mousedown', () => startScrolling(-1));
            scrollLeftButton.addEventListener('mouseup', stopScrolling);
            scrollLeftButton.addEventListener('mouseleave', stopScrolling);

            scrollRightButton.addEventListener('mousedown', () => startScrolling(1));
            scrollRightButton.addEventListener('mouseup', stopScrolling);
            scrollRightButton.addEventListener('mouseleave', stopScrolling);
        }

        scrollContainer.addEventListener('scroll', updateButtonVisibility);

        // 🔁 FORZAR verificación de scrollWidth real tras render
        requestAnimationFrame(() => {
            setTimeout(() => {
                updateButtonVisibility();
            }, 50);
        });

        // Opcional: usar ResizeObserver por si cambia tamaño luego
        const resizeObserver = new ResizeObserver(updateButtonVisibility);
        resizeObserver.observe(scrollContainer);
    });
}

function scrollTabs(direction) {
    const container = document.querySelector('.tab-scroll-container');
    const scrollAmount = 150;
    container.scrollBy({
        left: direction === 'right' ? scrollAmount : -scrollAmount,
        behavior: 'smooth'
    });

    // Asegura que se actualice luego del scroll animado
    setTimeout(actualizarVisibilidadScrollButtons, 300);
}

function scrollToTabButton(button) {
    const scrollContainer = document.querySelector('.tab-scroll-container');
    if (!scrollContainer || !button) return;

    const containerRect = scrollContainer.getBoundingClientRect();
    const buttonRect = button.getBoundingClientRect();

    // Obtener la posición relativa del botón respecto al contenedor
    const offsetLeft = buttonRect.left - containerRect.left;
    const offsetRight = buttonRect.right - containerRect.right;

    const scrollAmount = 100; // desplazamiento mínimo para empujar el scroll si el botón está parcialmente oculto

    if (offsetLeft < 0) {
        // Botón oculto a la izquierda
        scrollContainer.scrollBy({
            left: offsetLeft - scrollAmount,
            behavior: 'smooth'
        });
    } else if (offsetRight > 0) {
        // Botón oculto a la derecha
        scrollContainer.scrollBy({
            left: offsetRight + scrollAmount,
            behavior: 'smooth'
        });
    } else {
        // Opcional: centrar si está visible pero deseas una mejor experiencia
        const scrollTo = button.offsetLeft - scrollContainer.offsetWidth / 2 + button.offsetWidth / 2;
        scrollContainer.scrollTo({
            left: scrollTo,
            behavior: 'smooth'
        });
    }
}

function actualizarVisibilidadScrollButtons() {
    const container = document.querySelector('.tab-scroll-container');
    const leftBtn = document.querySelector('.scroll-btn.left-btn');
    const rightBtn = document.querySelector('.scroll-btn.right-btn');

    if (!container || !leftBtn || !rightBtn) return;

    const maxScrollLeft = container.scrollWidth - container.clientWidth;

    // Mostrar u ocultar los botones
    if (container.scrollLeft <= 0) {
        leftBtn.style.display = 'none';
    } else {
        leftBtn.style.display = 'flex';
    }

    if (container.scrollLeft >= maxScrollLeft - 1) {
        rightBtn.style.display = 'none';
    } else {
        rightBtn.style.display = 'flex';
    }
}

function inicializarProcedimientos(data) {
    const arranqueContainer = document.getElementById('arranque-container');
    const paradaContainer = document.getElementById('parada-container');
    const inputArranque = document.getElementById('input-arranque');
    const inputParada = document.getElementById('input-parada');
    const section = document.getElementById('section3');

    function parseProcedimientoTexto(texto) {
        const lineas = texto.split(/\r?\n/).map(l => l.trim()).filter(Boolean);
        const resultado = [];
        let seccionActual = null;

        lineas.forEach(linea => {
            const esSeccion = /^\d*\.*\s*[^•o].*:\s*$/i.test(linea);
            const matchPaso = /^[•o]\s*(.+)/.exec(linea);

            if (esSeccion) {
                if (seccionActual) resultado.push(seccionActual);
                const titulo = linea.replace(/^\d*\.*\s*/, '');
                seccionActual = { titulo, pasos: [] };
            } else if (matchPaso && seccionActual) {
                seccionActual.pasos.push(matchPaso[1].trim());
            }
        });

        if (seccionActual) resultado.push(seccionActual);
        return resultado;
    }

    function crearBloqueProcedimiento(seccion, container, actualizarInput) {
        const bloque = document.createElement('div');
        bloque.className = 'bloque-procedimiento';

        // --- Cabecera: título + eliminar sección
        const contenedorCabecera = document.createElement('div');
        contenedorCabecera.style.display = 'flex';
        contenedorCabecera.style.justifyContent = 'space-between';
        contenedorCabecera.style.alignItems = 'center';

        const titulo = document.createElement('h6');
        titulo.className = 'titulo-seccion';
        titulo.textContent = seccion.titulo;

        const btnEliminarSeccion = document.createElement('button');
        btnEliminarSeccion.className = 'btn btn-link text-danger btn-sm';
        btnEliminarSeccion.innerHTML = '<i class="bi bi-x-circle"></i>';
        btnEliminarSeccion.title = 'Eliminar sección';
        btnEliminarSeccion.style.display = section.classList.contains('modo-edicion') ? 'inline-block' : 'none';

        btnEliminarSeccion.onclick = () => {
            Swal.fire({
                title: '¿Eliminar sección?',
                text: 'Esta acción eliminará la sección y todos sus pasos.',
                icon: 'warning',
                iconColor: '#b02a37',
                showCancelButton: true,
                confirmButtonColor: '#b02a37',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    container.removeChild(bloque);
                    actualizarInput();
                }
            });
        };

        contenedorCabecera.appendChild(titulo);
        contenedorCabecera.appendChild(btnEliminarSeccion);

        // --- Contenedor de pasos
        const pasosContainer = document.createElement('div');
        pasosContainer.className = 'pasos-seccion';
        pasosContainer.setAttribute('data-seccion', seccion.titulo);

        seccion.pasos.forEach(paso => {
            crearPasoElement(paso, pasosContainer, actualizarInput);
        });

        // --- Botón de añadir paso
        const botonPaso = document.createElement('button');
        botonPaso.className = 'btn btn-outline-secondary btn-sm mt-3';
        botonPaso.textContent = '+ Añadir paso';
        botonPaso.style.display = section.classList.contains('modo-edicion') ? 'block' : 'none';
        botonPaso.onclick = () => crearPasoElement('', pasosContainer, actualizarInput);

        // --- Armar bloque
        bloque.appendChild(contenedorCabecera);
        bloque.appendChild(pasosContainer);
        bloque.appendChild(botonPaso);
        container.appendChild(bloque);

        // --- Hacer bloque arrastrable
        bloque.addEventListener('mousedown', e => {
            const editando = section.classList.contains('modo-edicion');
            bloque.setAttribute('draggable', editando && !e.target.closest('.input-paso, .btn, .input'));
        });

        bloque.addEventListener('dragstart', e => {
            if (!section.classList.contains('modo-edicion')) {
                e.preventDefault();
                return;
            }
            bloque.classList.add('dragging-bloque');
            e.dataTransfer.effectAllowed = 'move';
        });

        bloque.addEventListener('dragend', () => {
            bloque.classList.remove('dragging-bloque');
            actualizarInput(); // Re-serializar
        });

        container.addEventListener('dragover', e => {
            if (!section.classList.contains('modo-edicion')) return;
            e.preventDefault();
            const dragging = container.querySelector('.dragging-bloque');
            const after = getBloqueAfterElement(container, e.clientY);
            if (after == null) {
                container.appendChild(dragging);
            } else {
                container.insertBefore(dragging, after);
            }
        });

        // --- Observer: ocultar botones si no es modo edición
        new MutationObserver(() => {
            const visible = section.classList.contains('modo-edicion');
            botonPaso.style.display = visible ? 'block' : 'none';
            btnEliminarSeccion.style.display = visible ? 'inline-block' : 'none';
        }).observe(section, { attributes: true });
    }


    function getBloqueAfterElement(container, y) {
        const elementos = [...container.querySelectorAll('.bloque-procedimiento:not(.dragging-bloque)')];
        return elementos.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }


    function crearPasoElement(valor, container, actualizarInput) {
        const paso = document.createElement('div');
        paso.className = 'paso-procedimiento';

        const numero = document.createElement('div');
        numero.className = 'numero-paso';
        numero.textContent = container.children.length + 1;

        const input = document.createElement('div');
        input.className = 'input-paso';
        input.contentEditable = section.classList.contains('modo-edicion');
        input.innerText = valor || '';
        input.addEventListener('input', actualizarInput);

        const btnEliminar = document.createElement('button');
        btnEliminar.type = 'button';
        btnEliminar.className = 'btn-eliminar-paso';
        btnEliminar.innerHTML = '<i class="bi bi-trash-fill"></i>';
        btnEliminar.onclick = function () {
            container.removeChild(paso);
            actualizarNumeros(container);
            actualizarInput();
        };

        paso.appendChild(numero);
        paso.appendChild(input);
        paso.appendChild(btnEliminar);
        container.appendChild(paso);

        paso.addEventListener('mousedown', e => {
            const editando = section.classList.contains('modo-edicion');
            paso.setAttribute('draggable', editando && !e.target.closest('.input-paso'));
        });

        paso.addEventListener('dragstart', e => {
            if (!section.classList.contains('modo-edicion') || e.target.closest('.input-paso')) {
                e.preventDefault(); return;
            }
            paso.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
        });

        paso.addEventListener('dragend', () => {
            paso.classList.remove('dragging');
            actualizarNumeros(container);
            actualizarInput();
        });

        paso.addEventListener('dragover', e => {
            if (!section.classList.contains('modo-edicion')) return;
            e.preventDefault();
            const dragging = container.querySelector('.dragging');
            const after = getDragAfterElement(container, e.clientY);
            if (after == null) container.appendChild(dragging);
            else container.insertBefore(dragging, after);
        });

        function aplicarModoVisual() {
            const editando = section.classList.contains('modo-edicion');
            input.contentEditable = editando;
            input.classList.toggle('readonly', !editando);
            btnEliminar.style.display = editando ? 'inline-block' : 'none';
            paso.setAttribute('draggable', editando ? 'true' : 'false');
        }

        aplicarModoVisual();
        new MutationObserver(aplicarModoVisual).observe(section, { attributes: true });
        actualizarInput();
    }

    function getDragAfterElement(container, y) {
        const elementos = [...container.querySelectorAll('.paso-procedimiento:not(.dragging)')];
        return elementos.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    function actualizarNumeros(container) {
        container.querySelectorAll('.paso-procedimiento').forEach((paso, i) => {
            paso.querySelector('.numero-paso').textContent = i + 1;
        });
    }

    function actualizarInputArranque() {
        inputArranque.value = serializarProcedimiento(arranqueContainer);
    }

    function actualizarInputParada() {
        inputParada.value = serializarProcedimiento(paradaContainer);
    }

    const seccionesArranque = parseProcedimientoTexto(data.procedimiento?.arranque || '');
    const seccionesParada = parseProcedimientoTexto(data.procedimiento?.parada || '');
    seccionesArranque.forEach(sec => crearBloqueProcedimiento(sec, arranqueContainer, actualizarInputArranque));
    seccionesParada.forEach(sec => crearBloqueProcedimiento(sec, paradaContainer, actualizarInputParada));

    const btnAddSeccionArranque = document.getElementById('btn-add-seccion-arranque');
    const btnAddSeccionParada = document.getElementById('btn-add-seccion-parada');

    btnAddSeccionArranque.onclick = () => {
        Swal.fire({
            title: 'Nueva sección',
            input: 'text',
            inputLabel: 'Título de la nueva sección',
            inputPlaceholder: 'Ej. Durante el arranque:',
            showCancelButton: true,
            confirmButtonColor: '#003366',
            inputValidator: value => {
                if (!value || !value.trim()) {
                    return 'El título no puede estar vacío';
                }
                return null;
            },customClass: {
                popup: 'swal-section-popup',
                title: 'swal-section-title'
            }
        }).then(result => {
           if (result.isConfirmed) {
                let titulo = result.value.trim();
                if (!titulo.endsWith(':')) titulo += ':';
                crearBloqueProcedimiento({ titulo, pasos: [] }, arranqueContainer, actualizarInputArranque);
            }
        });
    };

    btnAddSeccionParada.onclick = () => {
        Swal.fire({
            title: 'Nueva sección',
            input: 'text',
            inputLabel: 'Título de la nueva sección',
            inputPlaceholder: 'Ej. Durante la parada:',
            showCancelButton: true,
            inputValidator: value => {
                if (!value || !value.trim()) {
                    return 'El título no puede estar vacío';
                }
                return null;
            }, customClass: {
                popup: 'swal-section-popup',
                title: 'swal-section-title'
            }
        }).then(result => {
            if (result.isConfirmed) {
                let titulo = result.value.trim();
                if (!titulo.endsWith(':')) titulo += ':';
                crearBloqueProcedimiento({ titulo, pasos: [] }, paradaContainer, actualizarInputParada);
            }

        });
    };

    // Mostrar u ocultar botones dependiendo del modo edición
    function actualizarVisibilidadBotones() {
        const editando = section.classList.contains('modo-edicion');

        // Botones globales de añadir sección
        document.querySelectorAll('#btn-add-seccion-arranque, #btn-add-seccion-parada').forEach(btn => {
            btn.style.display = editando ? 'block' : 'none';
        });

        // Botones "Añadir paso" dentro de cada bloque
        document.querySelectorAll('.bloque-procedimiento .btn-outline-secondary').forEach(btn => {
            btn.style.display = editando ? 'block' : 'none';
        });

        // Iconos de eliminar paso
        document.querySelectorAll('.btn-eliminar-paso').forEach(btn => {
            btn.style.display = editando ? 'inline-block' : 'none';
        });

        // Campos editables (por si alguna clase extra es requerida)
        document.querySelectorAll('.input-paso').forEach(div => {
            div.contentEditable = editando;
            div.classList.toggle('readonly', !editando);
        });
    }

    // Ejecutar al cargar
    actualizarVisibilidadBotones();

    // Observar cambios en el modo edición
    new MutationObserver(actualizarVisibilidadBotones).observe(section, { attributes: true });
}

function serializarProcedimiento(container) {
    const bloques = [...container.querySelectorAll('.bloque-procedimiento')];
    const resultado = bloques.map(b => {
        const titulo = b.querySelector('.titulo-seccion').innerText.trim();
        const pasos = [...b.querySelectorAll('.input-paso')]
            .map(p => `• ${p.innerText.trim()}`);
        return `${titulo}\r\n${pasos.join('\r\n')}`;
    });
    return resultado.join('\r\n');
}

function recargarDetalleEquipoActual(seccionActivaId = null) {
    const idEquipo = localStorage.getItem('equipoSeleccionado');
    if (!idEquipo) return;

    // Si no se especificó, detectar la activa actual
    if (!seccionActivaId) {
        const activeSection = document.querySelector('.zone.section.active');
        seccionActivaId = activeSection?.id;
    }

    const btnActual = document.querySelector(`.equipo-item[data-id="${idEquipo}"]`);

    mostrarDetalleEquipo(idEquipo, btnActual || document.body, seccionActivaId);
}

function activarBotonesEdicion() {
    document.querySelectorAll('.btn-edicion[data-url]').forEach(btn => {
        btn.addEventListener('click', () => {
            const url = btn.getAttribute('data-url');
            if (url) {
                window.location.href = url;
            }
        });
    });
}

function inicializarClaveMoneda() {
    const currencyData = [
        { code: 'AED', name: 'Dirham de los Emiratos Árabes Unidos' },
        { code: 'AFN', name: 'Afghani afgano' },{ code: 'ALL', name: 'Lek albanés' },
        { code: 'AMD', name: 'Dram armenio' },{ code: 'ANG', name: 'Florín antillano neerlandés' },
        { code: 'AOA', name: 'Kwanza angoleño' },{ code: 'ARS', name: 'Peso argentino' },
        { code: 'AUD', name: 'Dólar australiano' },{ code: 'AWG', name: 'Florín arubeño' },
        { code: 'AZN', name: 'Manat azerbaiyano' },{ code: 'BAM', name: 'Marco convertible bosnioherzegovino' },
        { code: 'BBD', name: 'Dólar barbadense' },{ code: 'BDT', name: 'Taka bangladesí' },
        { code: 'BGN', name: 'Lev búlgaro' },{ code: 'BHD', name: 'Dinar bahreiní' },
        { code: 'BIF', name: 'Franco burundés' },{ code: 'BMD', name: 'Dólar bermudeño' },
        { code: 'BND', name: 'Dólar de Brunéi' },{ code: 'BOB', name: 'Boliviano' },
        { code: 'BRL', name: 'Real brasileño' },{ code: 'BSD', name: 'Dólar bahameño' },
        { code: 'BTN', name: 'Ngultrum butanés' },{ code: 'BWP', name: 'Pula botsuano' },
        { code: 'BYN', name: 'Rublo bielorruso' },{ code: 'BZD', name: 'Dólar beliceño' },
        { code: 'CAD', name: 'Dólar canadiense' },{ code: 'CDF', name: 'Franco congoleño' },
        { code: 'CHF', name: 'Franco suizo' },{ code: 'CLP', name: 'Peso chileno' },
        { code: 'CNY', name: 'Yuan chino' },{ code: 'COP', name: 'Peso colombiano' },
        { code: 'CRC', name: 'Colón costarricense' },{ code: 'CUC', name: 'Peso cubano convertible' },
        { code: 'CUP', name: 'Peso cubano' },{ code: 'CVE', name: 'Escudo caboverdiano' },
        { code: 'CZK', name: 'Corona checa' },{ code: 'DJF', name: 'Franco yibutiano' },
        { code: 'DKK', name: 'Corona danesa' },{ code: 'DOP', name: 'Peso dominicano' },
        { code: 'DZD', name: 'Dinar argelino' },{ code: 'EGP', name: 'Libra egipcia' },
        { code: 'ERN', name: 'Nakfa eritreo' },{ code: 'ETB', name: 'Birr etíope' },{ code: 'EUR', name: 'Euro' },
        { code: 'FJD', name: 'Dólar fiyiano' },{ code: 'FKP', name: 'Libra de las Islas Malvinas' },
        { code: 'FOK', name: 'Corona feroesa' },{ code: 'GBP', name: 'Libra esterlina' },
        { code: 'GEL', name: 'Lari georgiano' },{ code: 'GGP', name: 'Libra de Guernsey' },
        { code: 'GHS', name: 'Cedi ghanés' },{ code: 'GIP', name: 'Libra de Gibraltar' },
        { code: 'GMD', name: 'Dalasi gambiano' },{ code: 'GNF', name: 'Franco guineano' },
        { code: 'GTQ', name: 'Quetzal guatemalteco' },{ code: 'GYD', name: 'Dólar guyanés' },
        { code: 'HKD', name: 'Dólar de Hong Kong' },{ code: 'HNL', name: 'Lempira hondureño' },
        { code: 'HRK', name: 'Kuna croata' },{ code: 'HTG', name: 'Gourde haitiano' },
        { code: 'HUF', name: 'Florín húngaro' },{ code: 'IDR', name: 'Rupia indonesia' },
        { code: 'ILS', name: 'Nuevo séquel israelí' },{ code: 'IMP', name: 'Libra de la Isla de Man' },
        { code: 'INR', name: 'Rupia india' },{ code: 'IQD', name: 'Dinar iraquí' },{ code: 'IRR', name: 'Rial iraní' },
        { code: 'ISK', name: 'Corona islandesa' },{ code: 'JEP', name: 'Libra de Jersey' },
        { code: 'JMD', name: 'Dólar jamaiquino' },{ code: 'JOD', name: 'Dinar jordano' },
        { code: 'JPY', name: 'Yen japonés' },{ code: 'KES', name: 'Chelín keniano' },
        { code: 'KGS', name: 'Som kirguís' },{ code: 'KHR', name: 'Riel camboyano' },
        { code: 'KID', name: 'Dólar de Kiribati' },{ code: 'KMF', name: 'Franco comorense' },
        { code: 'KRW', name: 'Won surcoreano' },{ code: 'KWD', name: 'Dinar kuwaití' },
        { code: 'KYD', name: 'Dólar de las Islas Caimán' },{ code: 'KZT', name: 'Tenge kazajo' },
        { code: 'LAK', name: 'Kip laosiano' },{ code: 'LBP', name: 'Libra libanesa' },
        { code: 'LKR', name: 'Rupia de Sri Lanka' },{ code: 'LRD', name: 'Dólar liberiano' },
        { code: 'LSL', name: 'Loti lesotense' },{ code: 'LYD', name: 'Dinar libio' },
        { code: 'MAD', name: 'Dirham marroquí' },{ code: 'MDL', name: 'Leu moldavo' },
        { code: 'MGA', name: 'Ariary malgache' },{ code: 'MKD', name: 'Dinar macedonio' },
        { code: 'MMK', name: 'Kyat birmano' },{ code: 'MNT', name: 'Tugrik mongol' },
        { code: 'MOP', name: 'Pataca de Macao' },{ code: 'MRU', name: 'Ouguiya mauritano' },
        { code: 'MUR', name: 'Rupia mauriciana' },{ code: 'MVR', name: 'Rupia de Maldivas' },
        { code: 'MWK', name: 'Kwacha malauí' },{ code: 'MXN', name: 'Peso mexicano' },
        { code: 'MYR', name: 'Ringgit malayo' },{ code: 'MZN', name: 'Metical mozambiqueño' },
        { code: 'NAD', name: 'Dólar namibio' },{ code: 'NGN', name: 'Naira nigeriana' },
        { code: 'NIO', name: 'Córdoba nicaragüense' },{ code: 'NOK', name: 'Corona noruega' },
        { code: 'NPR', name: 'Rupia nepalí' },{ code: 'NZD', name: 'Dólar neozelandés' },
        { code: 'OMR', name: 'Rial omaní' },{ code: 'PAB', name: 'Balboa panameño' },
        { code: 'PEN', name: 'Sol peruano' },{ code: 'PGK', name: 'Kina papuana' },
        { code: 'PHP', name: 'Peso filipino' },{ code: 'PKR', name: 'Rupia pakistaní' },
        { code: 'PLN', name: 'Zloty polaco' },{ code: 'PYG', name: 'Guaraní paraguayo' },
        { code: 'QAR', name: 'Rial catarí' },{ code: 'RON', name: 'Leu rumano' },
        { code: 'RSD', name: 'Dinar serbio' },{ code: 'RUB', name: 'Rublo ruso' },
        { code: 'RWF', name: 'Franco ruandés' },{ code: 'SAR', name: 'Riyal saudí' },
        { code: 'SBD', name: 'Dólar de las Islas Salomón' },{ code: 'SCR', name: 'Rupia seychellense' },
        { code: 'SDG', name: 'Libra sudanesa' },{ code: 'SEK', name: 'Corona sueca' },
        { code: 'SGD', name: 'Dólar singapurense' },{ code: 'SHP', name: 'Libra de Santa Elena' },
        { code: 'SLE', name: 'Leone sierraleonés (nuevo)' },{ code: 'SLL', name: 'Leone sierraleonés (antiguo)' },
        { code: 'SOS', name: 'Chelín somalí' },{ code: 'SRD', name: 'Dólar surinamés' },
        { code: 'SSP', name: 'Libra sursudanesa' },{ code: 'STN', name: 'Dobra de Santo Tomé y Príncipe' },
        { code: 'SYP', name: 'Libra siria' },{ code: 'SZL', name: 'Lilangeni suazi' },
        { code: 'THB', name: 'Baht tailandés' },{ code: 'TJS', name: 'Somoni tayiko' },
        { code: 'TMT', name: 'Manat turcomano' },{ code: 'TND', name: 'Dinar tunecino' },
        { code: 'TOP', name: 'Paʻanga tongano' },{ code: 'TRY', name: 'Lira turca' },
        { code: 'TTD', name: 'Dólar de Trinidad y Tobago' },{ code: 'TVD', name: 'Dólar tuvaluano' },
        { code: 'TWD', name: 'Nuevo dólar taiwanés' },{ code: 'TZS', name: 'Chelín tanzano' },
        { code: 'UAH', name: 'Grivna ucraniana' },{ code: 'UGX', name: 'Chelín ugandés' },
        { code: 'USD', name: 'Dólar estadounidense' },{ code: 'UYU', name: 'Peso uruguayo' },
        { code: 'UZS', name: 'Som uzbeko' },{ code: 'VED', name: 'Bolívar digital' },
        { code: 'VES', name: 'Bolívar soberano' },{ code: 'VND', name: 'Dong vietnamita' },
        { code: 'VUV', name: 'Vatu vanuatuense' },{ code: 'WST', name: 'Tala samoano' },
        { code: 'XAF', name: 'Franco CFA BEAC' },{ code: 'XCD', name: 'Dólar del Caribe Oriental' },
        { code: 'XOF', name: 'Franco CFA BCEAO' },{ code: 'XPF', name: 'Franco CFP' },
        { code: 'YER', name: 'Rial yemení' },{ code: 'ZAR', name: 'Rand sudafricano' },
        { code: 'ZMW', name: 'Kwacha zambiano' },{ code: 'ZWL', name: 'Dólar zimbabuense' }
    ];

    $('#waers').select2({
        language: {
            inputTooShort: () => "Por favor, ingrese 1 o más caracteres",
            noResults: () => "No se encontraron resultados",
            searching: () => "Buscando..."
        },
        data: currencyData.map(m => ({
            id: m.code,
            text: `${m.code} - ${m.name}`
        })),
        placeholder: "Seleccione una moneda",
        allowClear: true,
        templateSelection: function (item) {
            return item.text || item.id;
        }
    });

    const valorGuardado = $('#waers').data('value');
    if (valorGuardado) {
        $('#waers').val(valorGuardado).trigger('change');
    }
}

function inicializarPaisFabricacion() {

    const countryCodes = [
        { code: 'AFG', name: 'Afganistán' },
        { code: 'ALB', name: 'Albania' },
        { code: 'DEU', name: 'Alemania' },
        { code: 'AND', name: 'Andorra' },
        { code: 'AGO', name: 'Angola' },
        { code: 'AIA', name: 'Anguila' },
        { code: 'ATA', name: 'Antártida' },
        { code: 'ATG', name: 'Antigua y Barbuda' },
        { code: 'SAU', name: 'Arabia Saudita' },
        { code: 'DZA', name: 'Argelia' },
        { code: 'ARG', name: 'Argentina' },
        { code: 'ARM', name: 'Armenia' },
        { code: 'ABW', name: 'Aruba' },
        { code: 'AUS', name: 'Australia' },
        { code: 'AUT', name: 'Austria' },
        { code: 'AZE', name: 'Azerbaiyán' },
        { code: 'BHS', name: 'Bahamas' },
        { code: 'BHR', name: 'Baréin' },
        { code: 'BGD', name: 'Bangladés' },
        { code: 'BRB', name: 'Barbados' },
        { code: 'BEL', name: 'Bélgica' },
        { code: 'BLZ', name: 'Belice' },
        { code: 'BEN', name: 'Benín' },
        { code: 'BMU', name: 'Bermudas' },
        { code: 'BLR', name: 'Bielorrusia' },
        { code: 'MMR', name: 'Birmania' },
        { code: 'BOL', name: 'Bolivia' },
        { code: 'BIH', name: 'Bosnia y Herzegovina' },
        { code: 'BWA', name: 'Botsuana' },
        { code: 'BRA', name: 'Brasil' },
        { code: 'BRN', name: 'Brunéi' },
        { code: 'BGR', name: 'Bulgaria' },
        { code: 'BFA', name: 'Burkina Faso' },
        { code: 'BDI', name: 'Burundi' },
        { code: 'BTN', name: 'Bután' },
        { code: 'CPV', name: 'Cabo Verde' },
        { code: 'KHM', name: 'Camboya' },
        { code: 'CMR', name: 'Camerún' },
        { code: 'CAN', name: 'Canadá' },
        { code: 'QAT', name: 'Catar' },
        { code: 'TCD', name: 'Chad' },
        { code: 'CHL', name: 'Chile' },
        { code: 'CHN', name: 'China' },
        { code: 'CYP', name: 'Chipre' },
        { code: 'COL', name: 'Colombia' },
        { code: 'COM', name: 'Comoras' },
        { code: 'PRK', name: 'Corea del Norte' },
        { code: 'KOR', name: 'Corea del Sur' },
        { code: 'CIV', name: 'Costa de Marfil' },
        { code: 'CRI', name: 'Costa Rica' },
        { code: 'HRV', name: 'Croacia' },
        { code: 'CUB', name: 'Cuba' },
        { code: 'DNK', name: 'Dinamarca' },
        { code: 'DMA', name: 'Dominica' },
        { code: 'ECU', name: 'Ecuador' },
        { code: 'EGY', name: 'Egipto' },
        { code: 'SLV', name: 'El Salvador' },
        { code: 'ARE', name: 'Emiratos Árabes Unidos' },
        { code: 'ERI', name: 'Eritrea' },
        { code: 'SVK', name: 'Eslovaquia' },
        { code: 'SVN', name: 'Eslovenia' },
        { code: 'ESP', name: 'España' },
        { code: 'USA', name: 'Estados Unidos' },
        { code: 'EST', name: 'Estonia' },
        { code: 'ETH', name: 'Etiopía' },
        { code: 'FJI', name: 'Fiyi' },
        { code: 'PHL', name: 'Filipinas' },
        { code: 'FIN', name: 'Finlandia' },
        { code: 'FRA', name: 'Francia' },
        { code: 'GAB', name: 'Gabón' },
        { code: 'GMB', name: 'Gambia' },
        { code: 'GEO', name: 'Georgia' },
        { code: 'GHA', name: 'Ghana' },
        { code: 'GRD', name: 'Granada' },
        { code: 'GRC', name: 'Grecia' },
        { code: 'GRL', name: 'Groenlandia' },
        { code: 'GLP', name: 'Guadalupe' },
        { code: 'GUM', name: 'Guam' },
        { code: 'GTM', name: 'Guatemala' },
        { code: 'GUY', name: 'Guyana' },
        { code: 'GIN', name: 'Guinea' },
        { code: 'GNQ', name: 'Guinea Ecuatorial' },
        { code: 'GNB', name: 'Guinea-Bisáu' },
        { code: 'HTI', name: 'Haití' },
        { code: 'HND', name: 'Honduras' },
        { code: 'HKG', name: 'Hong Kong' },
        { code: 'HUN', name: 'Hungría' },
        { code: 'IND', name: 'India' },
        { code: 'IDN', name: 'Indonesia' },
        { code: 'IRQ', name: 'Irak' },
        { code: 'IRN', name: 'Irán' },
        { code: 'IRL', name: 'Irlanda' },
        { code: 'ISL', name: 'Islandia' },
        { code: 'ISR', name: 'Israel' },
        { code: 'ITA', name: 'Italia' },
        { code: 'JAM', name: 'Jamaica' },
        { code: 'JPN', name: 'Japón' },
        { code: 'JOR', name: 'Jordania' },
        { code: 'KAZ', name: 'Kazajistán' },
        { code: 'KEN', name: 'Kenia' },
        { code: 'KGZ', name: 'Kirguistán' },
        { code: 'KIR', name: 'Kiribati' },
        { code: 'KWT', name: 'Kuwait' },
        { code: 'LAO', name: 'Laos' },
        { code: 'LVA', name: 'Letonia' },
        { code: 'LBN', name: 'Líbano' },
        { code: 'LBR', name: 'Liberia' },
        { code: 'LBY', name: 'Libia' },
        { code: 'LIE', name: 'Liechtenstein' },
        { code: 'LTU', name: 'Lituania' },
        { code: 'LUX', name: 'Luxemburgo' },
        { code: 'MAC', name: 'Macao' },
        { code: 'MDG', name: 'Madagascar' },
        { code: 'MYS', name: 'Malasia' },
        { code: 'MWI', name: 'Malaui' },
        { code: 'MDV', name: 'Maldivas' },
        { code: 'MLI', name: 'Malí' },
        { code: 'MLT', name: 'Malta' },
        { code: 'MAR', name: 'Marruecos' },
        { code: 'MTQ', name: 'Martinica' },
        { code: 'MUS', name: 'Mauricio' },
        { code: 'MRT', name: 'Mauritania' },
        { code: 'MYT', name: 'Mayotte' },
        { code: 'MEX', name: 'México' },
        { code: 'FSM', name: 'Micronesia' },
        { code: 'MDA', name: 'Moldavia' },
        { code: 'MCO', name: 'Mónaco' },
        { code: 'MNG', name: 'Mongolia' },
        { code: 'MNE', name: 'Montenegro' },
        { code: 'MSR', name: 'Montserrat' },
        { code: 'MOZ', name: 'Mozambique' },
        { code: 'MMR', name: 'Birmania' },
        { code: 'NAM', name: 'Namibia' },
        { code: 'NRU', name: 'Nauru' },
        { code: 'NPL', name: 'Nepal' },
        { code: 'NIC', name: 'Nicaragua' },
        { code: 'NER', name: 'Níger' },
        { code: 'NGA', name: 'Nigeria' },
        { code: 'NIU', name: 'Niue' },
        { code: 'NFK', name: 'Isla Norfolk' },
        { code: 'NOR', name: 'Noruega' },
        { code: 'NCL', name: 'Nueva Caledonia' },
        { code: 'NZL', name: 'Nueva Zelanda' },
        { code: 'OMN', name: 'Omán' },
        { code: 'NLD', name: 'Países Bajos' },
        { code: 'PAK', name: 'Pakistán' },
        { code: 'PLW', name: 'Palaos' },
        { code: 'PSE', name: 'Palestina' },
        { code: 'PAN', name: 'Panamá' },
        { code: 'PNG', name: 'Papúa Nueva Guinea' },
        { code: 'PRY', name: 'Paraguay' },
        { code: 'PER', name: 'Perú' },
        { code: 'PCN', name: 'Islas Pitcairn' },
        { code: 'PYF', name: 'Polinesia Francesa' },
        { code: 'POL', name: 'Polonia' },
        { code: 'PRT', name: 'Portugal' },
        { code: 'PRI', name: 'Puerto Rico' },
        { code: 'QAT', name: 'Catar' },
        { code: 'GBR', name: 'Reino Unido' },
        { code: 'CAF', name: 'República Centroafricana' },
        { code: 'CZE', name: 'República Checa' },
        { code: 'DOM', name: 'República Dominicana' },
        { code: 'COD', name: 'República Democrática del Congo' },
        { code: 'REU', name: 'Reunión' },
        { code: 'ROU', name: 'Rumania' },
        { code: 'RUS', name: 'Rusia' },
        { code: 'RWA', name: 'Ruanda' },
        { code: 'ESH', name: 'Sahara Occidental' },
        { code: 'BLM', name: 'San Bartolomé' },
        { code: 'KNA', name: 'San Cristóbal y Nieves' },
        { code: 'MAF', name: 'San Martín (Francia)' },
        { code: 'SPM', name: 'San Pedro y Miquelón' },
        { code: 'SMR', name: 'San Marino' },
        { code: 'VCT', name: 'San Vicente y las Granadinas' },
        { code: 'SHN', name: 'Santa Elena, Ascensión y Tristán de Acuña' },
        { code: 'LCA', name: 'Santa Lucía' },
        { code: 'STP', name: 'Santo Tomé y Príncipe' },
        { code: 'SEN', name: 'Senegal' },
        { code: 'SRB', name: 'Serbia' },
        { code: 'SYC', name: 'Seychelles' },
        { code: 'SLE', name: 'Sierra Leona' },
        { code: 'SGP', name: 'Singapur' },
        { code: 'SXM', name: 'Sint Maarten' },
        { code: 'SYR', name: 'Siria' },
        { code: 'SOM', name: 'Somalia' },
        { code: 'LKA', name: 'Sri Lanka' },
        { code: 'SWZ', name: 'Esuatini (Suazilandia)' },
        { code: 'ZAF', name: 'Sudáfrica' },
        { code: 'SDN', name: 'Sudán' },
        { code: 'SSD', name: 'Sudán del Sur' },
        { code: 'SWE', name: 'Suecia' },
        { code: 'CHE', name: 'Suiza' },
        { code: 'SUR', name: 'Surinam' },
        { code: 'SJM', name: 'Svalbard y Jan Mayen' },
        { code: 'THA', name: 'Tailandia' },
        { code: 'TWN', name: 'Taiwán' },
        { code: 'TZA', name: 'Tanzania' },
        { code: 'TJK', name: 'Tayikistán' },
        { code: 'IOT', name: 'Territorio Británico del Océano Índico' },
        { code: 'ATF', name: 'Territorios Australes Franceses' },
        { code: 'TLS', name: 'Timor Oriental' },
        { code: 'TGO', name: 'Togo' },
        { code: 'TKL', name: 'Tokelau' },
        { code: 'TON', name: 'Tonga' },
        { code: 'TTO', name: 'Trinidad y Tobago' },
        { code: 'TUN', name: 'Túnez' },
        { code: 'TKM', name: 'Turkmenistán' },
        { code: 'TUR', name: 'Turquía' },
        { code: 'TCA', name: 'Islas Turcas y Caicos' },
        { code: 'TUV', name: 'Tuvalu' },
        { code: 'UKR', name: 'Ucrania' },
        { code: 'UGA', name: 'Uganda' },
        { code: 'URY', name: 'Uruguay' },
        { code: 'USA', name: 'Estados Unidos' },
        { code: 'UZB', name: 'Uzbekistán' },
        { code: 'VUT', name: 'Vanuatu' },
        { code: 'VAT', name: 'Ciudad del Vaticano' },
        { code: 'VEN', name: 'Venezuela' },
        { code: 'VNM', name: 'Vietnam' },
        { code: 'WLF', name: 'Wallis y Futuna' },
        { code: 'ESH', name: 'Sahara Occidental' },
        { code: 'YEM', name: 'Yemen' },
        { code: 'ZMB', name: 'Zambia' },
        { code: 'ZWE', name: 'Zimbabue' }
    ];

    $('#herld').select2({
        language: {
            inputTooShort: () => "Por favor, ingrese 1 o más caracteres",
            noResults: () => "No se encontraron resultados",
            searching: () => "Buscando..."
        },
        data: countryCodes.map(pais => ({
            id: pais.code,
            text: `${pais.code} - ${pais.name}`
        })),
        placeholder: "Seleccione un país de fabricación",
        allowClear: true,
        templateResult: function(item) {
            if (!item.id) return item.text;
            return `<span><strong>${item.id}</strong> - ${item.text.split(' - ')[1]}</span>`;
        },
        templateSelection: function(item) {
            return item.id || item.text;
        },
        escapeMarkup: function (m) { return m; } // 🔐 para permitir HTML en templateResult
    });

    const valorGuardado = $('#herld').data('value');
    if (valorGuardado) {
        $('#herld').val(valorGuardado).trigger('change');
    }

}

function formatFecha(fecha) {
    if (!fecha) return '';
    const d = new Date(fecha);
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function inicializarMesConstruccion() {
    const baumm = document.getElementById('baumm');
    if (!baumm) return;

    const meses = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];

    baumm.innerHTML = '<option value="">Seleccione un mes</option>'; // limpiar

    meses.forEach((mes, index) => {
        const mesValue = String(index + 1).padStart(2, '0'); // "01", "02", ..., "12"
        const option = new Option(mes, mesValue);
        baumm.add(option);
    });

    const valorSeleccionado = baumm.dataset.value;
    if (valorSeleccionado) {
        baumm.value = valorSeleccionado;
    }
}

function actualizarUbicacionTecnica(numero_casco) {
    const grupo = document.getElementById('grupo_constructivo');
    const subgrupo = document.getElementById('subgrupo_constructivo');
    const sistema = document.getElementById('sistema');
    const subsistema = document.getElementById('subsistema');
    const tplnrInput = document.getElementById('tplnr');

    const getNumero = (selectElement) => {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        if (!selectedOption || !selectedOption.textContent.includes(' - ')) return '';
        return selectedOption.textContent.split(' - ')[0].trim();
    };

    // Asegurar que el número de casco es string y quitar espacios
    const prefijo = `ARC${String(numero_casco || '').replace(/\s+/g, '')}`;

    const partes = [
        getNumero(grupo),
        getNumero(subgrupo),
        getNumero(sistema),
        getNumero(subsistema)
    ].filter(p => p !== '');

    tplnrInput.value = [prefijo, ...partes].join('-');
}

function cargarClases(caracteristicasJSON = null) {
    const classSelect = document.getElementById("class");
    if (!classSelect) return;

    classSelect.innerHTML = '<option value="">Seleccione una clase</option>';

    clases.forEach(clase => {
        const option = document.createElement("option");
        option.value = clase;
        option.textContent = clase;
        classSelect.appendChild(option);
    });

    // Asignar valor preseleccionado desde atributo data-value
    const clasePreseleccionada = classSelect.getAttribute('data-value');
    if (clasePreseleccionada) {
        console.log("hay clase preseleccionada:", clasePreseleccionada)
        classSelect.value = clasePreseleccionada;

        // Cargar campos dinámicos si ya hay clase
        cargarCamposYDatosDinamicos(clasePreseleccionada, caracteristicasJSON);
    }
}


function inicializarClaseSeleccionada() {
    const classSelect = document.getElementById("class");
    if (!classSelect) return;

    classSelect.addEventListener("change", (event) => {
        const claseSeleccionada = event.target.value;
        if (claseSeleccionada) {
            cargarCamposYDatosDinamicos(claseSeleccionada);
        } else {
            limpiarCamposDinamicos();
        }
    });
}


function cargarCamposYDatosDinamicos(clase, caracteristicasJSON = null) {
    console.log("entramos a la funcion cargardatos dinamicos con clase ", clase, "y caracteristicas", caracteristicasJSON)
    let caracteristicas = {};

    // 👉 Solo hacer JSON.parse si es un string
    if (caracteristicasJSON) {
        if (typeof caracteristicasJSON === 'string') {
            try {
                caracteristicas = JSON.parse(caracteristicasJSON);
            } catch (e) {
                console.warn("❌ Error al parsear características:", e);
                return;
            }
        } else if (typeof caracteristicasJSON === 'object') {
            caracteristicas = caracteristicasJSON;
        } else {
            console.warn("⚠️ Tipo de datos no válido para características:", typeof caracteristicasJSON);
        }
    }

    // Normaliza las claves del JSON de características
    const caracteristicasNormalizadas = {};
    for (let clave in caracteristicas) {
        const claveNormalizada = normalizarClave(clave);
        caracteristicasNormalizadas[claveNormalizada] = caracteristicas[clave];
    }

    fetch(`/clases/${clase}`)
        .then(response => {
            if (!response.ok) throw new Error('Error al cargar los campos dinámicos');
            return response.json();
        })
        .then(campos => {
            const contenedor = document.getElementById("campos-dinamicos");
            limpiarCamposDinamicos();

            const clavesCaracteristicas = Object.keys(caracteristicasNormalizadas);

            if (campos.length === 0) {
                const mensaje = document.createElement("p");
                mensaje.textContent = `No hay características para este número de clase: ${clase}`;
                mensaje.className = "text-center text-muted my-4";
                contenedor.appendChild(mensaje);
                return;
            }

            campos.forEach(campo => {
                const claveNormalizadaCampo = normalizarClave(campo.caracteristica);
                const claveEncontrada = buscarClaveAproximada(claveNormalizadaCampo, clavesCaracteristicas);
                const valor = claveEncontrada ? caracteristicasNormalizadas[claveEncontrada] : '';

                const div = document.createElement("div");
                div.className = campo.unidad_unica || campo.tipo_entrada === "SELECT" ? 
                    "col-md-6 mb-3 form-floating withUnid" : 
                    "col-md-6 mb-3 form-floating";

                if (campo.tipo_entrada === "SELECT") {
                    const select = document.createElement("select");
                    select.id = campo.caracteristica;
                    select.name = campo.caracteristica;
                    select.className = "form-control select2";

                    const defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.textContent = "Seleccione una opción";
                    defaultOption.selected = true;
                    select.appendChild(defaultOption);

                    fetch(`/clase_valores/${campo.id}`)
                        .then(response => response.json())
                        .then(valores => {
                            valores.forEach(valorItem => {
                                let option = document.createElement("option");
                                option.value = valorItem.valor;
                                option.textContent = valorItem.valor;
                                select.appendChild(option);
                            });

                            if (valor) {
                                select.value = valor;
                            }
                        });

                    div.appendChild(select);

                } else {
                    const input = document.createElement("input");
                    input.type = obtenerTipoInput(campo.tipo_campo);
                    input.id = campo.caracteristica;
                    input.name = campo.caracteristica;
                    input.className = "form-control edicion";
                    input.maxLength = campo.ctd_posiciones;
                    input.value = formatearValorParaInput(input.type, valor);
                    input.placeholder = campo.unidad_unica ? "" : " ";

                    div.appendChild(input);

                    if (campo.unidad_unica) {
                        const unidadSpan = document.createElement("span");
                        unidadSpan.className = "input-group-text";
                        unidadSpan.textContent = campo.unidad_unica;
                        div.appendChild(unidadSpan);
                    }

                    if (campo.tipo_entrada === "CONDICION") {
                        fetch(`/clase_valores/${campo.id}`)
                            .then(response => response.json())
                            .then(valores => {
                                if (valores.length > 0 && valores[0].valor) {
                                    const ayudaCondicion = document.createElement("small");
                                    ayudaCondicion.className = "text-muted d-block mt-1";
                                    ayudaCondicion.textContent = `Condición esperada: ${valores[0].valor}`;
                                    div.appendChild(ayudaCondicion);
                                }
                            });
                    }
                }

                const label = document.createElement("label");
                label.htmlFor = campo.caracteristica;
                label.textContent = capitalizarPrimeraLetra(campo.denominacion);
                div.appendChild(label);

                contenedor.appendChild(div);
            });

        })
        .catch(error => console.error("Error al cargar los campos dinámicos:", error));

}

// Función para limpiar los campos dinámicos
function limpiarCamposDinamicos() {
    const camposDinamicos = document.getElementById("campos-dinamicos");
    camposDinamicos.innerHTML = "";
}

function normalizarClave(clave) {
    // Convierte la clave a mayúsculas y elimina unidades adicionales como "(A)", "(mm)", etc.
    return clave
        .toUpperCase()
        .replace(/\(.*?\)/g, "") // Elimina cualquier texto entre paréntesis
        .replace(/\s+/g, "_")    // Reemplaza espacios por "_"
        .replace(/[ÁÀÂÄ]/g, "A") // Normaliza vocales con tilde
        .replace(/[ÉÈÊË]/g, "E")
        .replace(/[ÍÌÎÏ]/g, "I")
        .replace(/[ÓÒÔÖ]/g, "O")
        .replace(/[ÚÙÛÜ]/g, "U")
        .replace(/Ñ/g, "N")
        .trim();                // Elimina espacios al inicio o final
}

function buscarClaveAproximada(claveBuscada, claves) {
    // Busca si alguna clave incluye la clave buscada (búsqueda aproximada)
    return claves.find(clave => clave.includes(claveBuscada)) || null;
}

function formatearValorParaInput(tipo, valor) {
    if (tipo === 'number') {
        const numero = parseFloat(valor);
        return isNaN(numero) ? '' : numero; // Si no es número, devolver cadena vacía
    }
    return valor; // Retorna el valor sin modificar para otros tipos
}

function capitalizarPrimeraLetra(texto) {
    return texto.charAt(0).toUpperCase() + texto.slice(1).toLowerCase();
}

function obtenerTipoInput(tipoCampo) {
    switch (tipoCampo) {
        case "NUM":
            return "number";
        case "CHAR":
            return "text";
        case "DATE":
            return "date";
        default:
            return "text"; // Tipo predeterminado
    }
}

function obtenerDatosDinamicos() {
    const camposDinamicos = document.getElementById("campos-dinamicos");
    const inputs = camposDinamicos.querySelectorAll("input, select, textarea");
    const formDinamicData = {};

    inputs.forEach(input => {
        const caracteristica = input.name; // Usar el atributo `name` como clave
        const valor = input.value.trim(); // Obtener el valor ingresado
        if (caracteristica) {
            formDinamicData[caracteristica] = valor || null; // Guardar el valor, usar `null` si está vacío
        }
    });

    return formDinamicData; // Devolver el diccionario
}

document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('toggle-fullscreen');
    const icon = toggleBtn.querySelector('i');
    const navbar = document.querySelector('.navbar');
    const header = document.querySelector('.equipos-header');
    const detalle = document.getElementById('detalle-equipo-container');

    let expandido = false;

    const ajustarAlturaDetalle = () => {
        const detalle = document.getElementById('detalle-equipo-container');
        const navbar = document.querySelector('.navbar');
        const header = document.querySelector('.equipos-header');
        if (!detalle) return;

        const margenInferior = 50; // ~2rem

        const ajusteManualNavbar = 20;   // puedes dejar en 0 si no hay padding extra
        const ajusteManualHeader = 0;

        let altoNavbar = 0;
        let altoHeader = 0;

        if (navbar && navbar.offsetParent !== null) {
            altoNavbar = navbar.offsetHeight + ajusteManualNavbar;
        }
        if (header && header.offsetParent !== null) {
            altoHeader = header.offsetHeight + ajusteManualHeader;
        }

        const altoVentana = window.innerHeight;
        const espacioDisponible = altoVentana - altoNavbar - altoHeader - margenInferior;

        detalle.style.maxHeight = `${espacioDisponible}px`;
    };

    const fadeOut = (el, callback) => {
        el.classList.remove('fade-visible');
        el.classList.add('fade-hidden');
        setTimeout(() => {
            el.style.display = 'none';
            if (callback) callback();
        }, 300);
    };

    const fadeIn = (el, callback) => {
        el.style.display = '';
        el.style.height = 'auto';
        void el.offsetWidth; // forzar reflow
        el.classList.remove('fade-hidden');
        el.classList.add('fade-visible');
        if (callback) setTimeout(callback, 300);
    };

    toggleBtn.addEventListener('click', () => {
        expandido = !expandido;

        if (expandido) {
            fadeOut(navbar);
            fadeOut(header, ajustarAlturaDetalle);
            icon.classList.replace('bi-arrows-fullscreen', 'bi-fullscreen-exit');
            toggleBtn.title = 'Salir de modo expandido';
        } else {
            fadeIn(navbar);
            fadeIn(header, ajustarAlturaDetalle);
            icon.classList.replace('bi-fullscreen-exit', 'bi-arrows-fullscreen');
            toggleBtn.title = 'Expandir vista';
        }
    });

    // Inicializar clases y altura al cargar
    [navbar, header].forEach(el => {
        el.classList.remove('fade'); // evitar conflicto Bootstrap
        el.classList.add('fade-transition', 'fade-visible');
    });

    ajustarAlturaDetalle();
    window.addEventListener('resize', ajustarAlturaDetalle);
});

function inicializarBotonEliminarEquipo() {
    const eliminarButton = document.getElementById('btn-eliminar-equipo');

    if (!eliminarButton) return;

    eliminarButton.addEventListener('click', () => {
        const equipoId = eliminarButton.getAttribute('data-equipo-id');
        let rawNombre = document.getElementById("nombreEquipo")?.innerText || "Equipo desconocido";
        const nombreEquipo = rawNombre.replace("Nombre de equipo:", "").trim();
        const cjEquipo = document.querySelector("span[style*='font-weight: bold'][style*='font-size: 18px']")?.innerText || "";

        const tituloEquipo = cjEquipo
            ? `${nombreEquipo} (CJ: ${cjEquipo})`
            : nombreEquipo;

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
            customClass: {
                title: 'boton-eliminar-titulo',
            },
            preConfirm: () => {
                const inputNombre = document.getElementById('confirmacion-nombre').value.trim();
                if (inputNombre !== nombreEquipo) {
                    Swal.showValidationMessage('El nombre no coincide. Escribe el nombre exacto del equipo.');
                }
                return inputNombre;
            }
        }).then((result) => {
            if (result.isConfirmed && result.value === nombreEquipo) {
                fetch('/LSA/eliminar-equipo', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id_equipo_info: equipoId })
                })
                .then(response => {
                    if (!response.ok) throw new Error("Error en el servidor");
                    return response.json();
                })
                .then(data => {
                    if (data.message) {
                        Swal.fire({
                            title: 'Eliminado',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#003366',
                        }).then(() => {
                            // Quitar del DOM
                            document.querySelector(`.equipo-item[data-id="${equipoId}"]`)?.remove();

                            // Reset de detalle
                            const detalleContainer = document.getElementById('detalle-equipo-container');
                            if (detalleContainer) {
                                detalleContainer.innerHTML = `
                                    <div class="mensaje-seleccion-equipo p-5">
                                        <div class="card-seleccion">
                                            <i class="bi bi-info-circle-fill" style="font-size: 28px; color: #003366;"></i>
                                            <p class="mt-3 mb-0">Seleccione un equipo</p>
                                        </div>
                                    </div>`;
                                detalleContainer.classList.remove('detalle-visible');
                            }

                            // Limpiar selección actual
                            localStorage.removeItem('equipoSeleccionado');
                        });
                    } else {
                        Swal.fire('Error', 'No se pudo eliminar el equipo', 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error', 'Ocurrió un error al eliminar el equipo', 'error');
                });
            }
        });
    });
}

function subirArchivoCAD(equipoId, file) {
    console.log('🔄 Función subirArchivoCAD llamada con:', { equipoId, file });
    
    if (!file) {
        console.error('❌ No se proporcionó archivo');
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se seleccionó ningún archivo'
        });
        return;
    }

    if (!equipoId) {
        console.error('❌ No se proporcionó ID de equipo');
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'ID de equipo no válido'
        });
        return;
    }

    // Validar formato de archivo
    const formatosPermitidos = ['step', 'stp', 'iges', 'igs', 'stl', 'obj', 'ply', 'glb', 'gltf'];
    const extension = file.name.split('.').pop().toLowerCase();
    
    if (!formatosPermitidos.includes(extension)) {
        console.error('❌ Formato de archivo no válido:', extension);
        Swal.fire({
            icon: 'error',
            title: 'Formato no válido',
            text: `El archivo debe ser de uno de estos formatos: ${formatosPermitidos.join(', ')}`
        });
        return;
    }

    // Validar tamaño (100MB máximo - igual que el backend)
    const maxSize = 150 * 1024 * 1024; // 100MB
    if (file.size > maxSize) {
        console.error('❌ Archivo demasiado grande:', file.size);
        Swal.fire({
            icon: 'error',
            title: 'Archivo demasiado grande',
            text: 'El archivo no puede ser mayor a 150MB'
        });
        return;
    }

    console.log('✅ Validaciones pasadas. Iniciando subida...');
    console.log('📁 Archivo:', file.name, 'Tamaño:', (file.size / 1024 / 1024).toFixed(2), 'MB');

    // Mostrar progreso
    Swal.fire({
        title: 'Subiendo archivo CAD',
        text: `Subiendo ${file.name}...`,
        icon: 'info',
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Crear FormData
    const formData = new FormData();
    formData.append('archivo_cad', file);
    formData.append('equipo_id', equipoId);

    console.log('📤 Enviando a:', '/LSA/upload-cad');
    console.log('📋 FormData contenido:', { equipo_id: equipoId, archivo_nombre: file.name });

    // Realizar petición
    fetch('/LSA/upload-cad', {
        method: 'POST',
        headers: {
            'X-From-Laravel': 'true'
        },
        body: formData
    })
    .then(response => {
        console.log('📥 Respuesta recibida, status:', response.status);
        
        // Manejar conflicto (archivo existente)
        if (response.status === 409) {
            return response.json().then(data => {
                // Mostrar confirmación de sobrescritura
                return Swal.fire({
                    title: '⚠️ Archivo CAD Existente',
                    html: `
                        <p>Ya existe un archivo CAD para este equipo:</p>
                        <p><strong>${data.archivo_existente}</strong></p>
                        <p>¿Deseas reemplazarlo con el nuevo archivo?</p>
                        <p class="text-muted mt-3">
                            <strong>Nuevo:</strong> ${file.name}<br>
                            <strong>Tamaño:</strong> ${(file.size / 1024 / 1024).toFixed(2)} MB
                        </p>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '✅ Sí, reemplazar',
                    cancelButtonText: '❌ Cancelar',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Reenviar con forzar_reemplazo=true
                        const formDataReemplazo = new FormData();
                        formDataReemplazo.append('archivo_cad', file);
                        formDataReemplazo.append('equipo_id', equipoId);
                        formDataReemplazo.append('forzar_reemplazo', 'true');
                        
                        console.log('🔄 Reenviando con forzar_reemplazo=true');
                        
                        return fetch('/LSA/upload-cad', {
                            method: 'POST',
                            headers: {
                                'X-From-Laravel': 'true'
                            },
                            body: formDataReemplazo
                        }).then(response => response.json());
                    } else {
                        // Usuario canceló
                        throw new Error('cancelled');
                    }
                });
            });
        }
        
        return response.json();
    })
    .then(data => {
        console.log('📊 Datos de respuesta:', data);
        
        if (data.success) {
            console.log('✅ Archivo subido exitosamente');
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'El archivo CAD se ha subido correctamente',
                showConfirmButton: true,
                confirmButtonText: 'Continuar'
            }).then(() => {
                // Actualizar la vista sin recargar la página
                actualizarVistaEquipoDespuesDeSubirCAD(equipoId);
                
                // *** VERIFICACIÓN ADICIONAL: Forzar carga del CAD después de un delay ***
                setTimeout(() => {
                    const seccionCADActiva = document.querySelector('#section13:not(.d-none)');
                    if (seccionCADActiva && typeof window.cargarVisorCAD === 'function') {
                        console.log('🔄 Verificación adicional: Forzando carga del visor CAD...');
                        window.cargarVisorCAD(equipoId);
                    }
                }, 1500);
            });
        } else {
            console.error('❌ Error en la respuesta:', data.error);
            throw new Error(data.error || 'Error desconocido en el servidor');
        }
    })
    .catch(error => {
        console.error('❌ Error en la subida:', error);
        
        // No mostrar error si el usuario canceló la operación
        if (error.message === 'cancelled') {
            console.log('ℹ️ Operación cancelada por el usuario');
            return;
        }
        
        Swal.fire({
            icon: 'error',
            title: 'Error al subir archivo',
            text: error.message || 'Ocurrió un error inesperado al subir el archivo'
        });
    });
}

// Exponer la función globalmente para que esté disponible desde cualquier lugar
window.subirArchivoCAD = subirArchivoCAD;

// ==========================================
// FUNCIONES PARA ACTUALIZACIÓN DINÁMICA SIN RECARGA
// ==========================================

async function actualizarVistaEquipoDespuesDeSubirCAD(equipoId) {
    try {
        console.log('🔄 Actualizando vista después de subir CAD para equipo:', equipoId);
        
        // Obtener el botón activo del equipo
        const botonActivo = document.querySelector('.btn-outline-primary.active') || 
                           document.querySelector(`[onclick*="mostrarDetalleEquipo('${equipoId}'"]`);
        
        // FORZAR cambio a la sección CAD después de subir archivo
        console.log('🎯 Cambiando automáticamente a la sección CAD...');
        
        // Recargar los detalles del equipo FORZANDO la sección CAD (section13)
        await mostrarDetalleEquipo(equipoId, botonActivo, 'section13');
        
        // FORZAR la creación del contenedor CAD si no existe
        setTimeout(() => {
            console.log('🔍 DEPURACIÓN: Verificando estado del DOM...');
            
            const seccionCAD = document.getElementById('section13');
            console.log('🔍 section13 encontrado:', !!seccionCAD);
            console.log('🔍 section13 clases:', seccionCAD ? seccionCAD.className : 'NO ENCONTRADO');
            
            let contenedorVisor = document.getElementById('cad-viewer-container');
            console.log('🔍 cad-viewer-container encontrado:', !!contenedorVisor);
            
            // Si la sección CAD existe pero no tiene el contenedor, CREARLO MANUALMENTE
            if (seccionCAD && !contenedorVisor) {
                console.log('� CREANDO contenedor CAD manualmente después de upload...');
                
                // Buscar la zona de contenido donde debería estar el contenedor
                const rowPt3 = seccionCAD.querySelector('.row.pt-3');
                if (rowPt3) {
                    // Reemplazar el contenido con el visor CAD
                    rowPt3.innerHTML = `
                        <div class="col-12">
                            <!-- Visor CAD - Ocupa todo el ancho disponible -->
                            <div class="w-100" style="background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                                <div id="cad-viewer-container" style="width: 100%; height: 70vh; min-height: 600px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); display: flex; align-items: center; justify-content: center; position: relative;">
                                    <div class="text-center">
                                        <i class="bi bi-box-seam text-primary" style="font-size: 48px; margin-bottom: 16px;"></i>
                                        <p class="mt-2 mb-2 text-muted" style="font-size: 18px; font-weight: 500;">Visor CAD 3D</p>
                                        <p class="mb-3 text-muted" style="font-size: 14px;">Modelo cargado exitosamente</p>
                                        <button id="btn-ver-cad" class="btn btn-primary btn-lg mt-2" 
                                                onclick="window.cargarVisorCAD('${equipoId}')"
                                                data-equipo-id="${equipoId}">
                                            <i class="bi bi-play-circle me-2"></i> Ver CAD
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    console.log('✅ Contenedor CAD creado manualmente');
                    contenedorVisor = document.getElementById('cad-viewer-container');
                }
            }
            
            // Verificar que el contenedor ahora exista y cargar el visor
            if (contenedorVisor) {
                console.log('✅ Contenedor del visor CAD encontrado/creado, cargando automáticamente...');
                
                // Auto-cargar el visor CAD
                if (typeof window.cargarVisorCAD === 'function') {
                    console.log('� Iniciando carga automática del visor CAD...');
                    window.cargarVisorCAD(equipoId);
                } else {
                    console.error('❌ window.cargarVisorCAD no está disponible');
                }
            } else {
                console.error('❌ No se pudo crear/encontrar el contenedor del visor CAD');
                
                // Último recurso: recargar la página
                setTimeout(() => {
                    console.log('🔄 Último recurso: recargando página...');
                    window.location.reload();
                }, 2000);
            }
        }, 1500);
        
        console.log('✅ Vista actualizada exitosamente después de subir CAD');
        
    } catch (error) {
        console.error('❌ Error actualizando vista después de subir CAD:', error);
        // Fallback: recargar la página si hay error
        window.location.reload();
    }
}

async function actualizarVistaEquipoDespuesDeEliminarCAD(equipoId) {
    try {
        console.log('🔄 Actualizando vista después de eliminar CAD para equipo:', equipoId);
        
        // Obtener la pestaña activa actual
        const tabActive = document.querySelector('.nav-pills .nav-link.active');
        const seccionActiva = tabActive ? tabActive.getAttribute('href').substring(1) : 'generalidades';
        
        // Obtener el botón activo del equipo
        const botonActivo = document.querySelector('.btn-outline-primary.active') || 
                           document.querySelector(`[onclick*="mostrarDetalleEquipo('${equipoId}'"]`);
        
        // Recargar los detalles del equipo manteniendo la pestaña activa
        await mostrarDetalleEquipo(equipoId, botonActivo, seccionActiva);
        
        console.log('✅ Vista actualizada exitosamente después de eliminar CAD');
        
    } catch (error) {
        console.error('❌ Error actualizando vista después de eliminar CAD:', error);
        // Fallback: recargar la página si hay error
        window.location.reload();
    }
}

// Exponer las funciones globalmente
window.actualizarVistaEquipoDespuesDeSubirCAD = actualizarVistaEquipoDespuesDeSubirCAD;
window.actualizarVistaEquipoDespuesDeEliminarCAD = actualizarVistaEquipoDespuesDeEliminarCAD;

// ==========================================
// FUNCIÓN PARA MANTENER PESTAÑA ACTIVA AL CAMBIAR DE EQUIPO
// ==========================================

function mostrarDetalleEquipoConPestanaActiva(equipoId, boton) {
    // Obtener la pestaña activa actual
    const tabActive = document.querySelector('.nav-pills .nav-link.active');
    const seccionActiva = tabActive ? tabActive.getAttribute('href').substring(1) : null;
    
    console.log('🔄 Cambiando a equipo:', equipoId, 'manteniendo pestaña:', seccionActiva);
    
    // Llamar a la función original pasando la sección activa
    mostrarDetalleEquipo(equipoId, boton, seccionActiva);
}

// Exponer la función globalmente
window.mostrarDetalleEquipoConPestanaActiva = mostrarDetalleEquipoConPestanaActiva;

