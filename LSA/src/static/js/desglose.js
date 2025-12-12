document.addEventListener('DOMContentLoaded', function () {
    const searchbox = document.getElementById('searchbox');
    const buscarBtnBuque = document.getElementById('buscarBtnBuque');
    const buscarBtnGeneral = document.getElementById('buscarBtnGeneral');
    const resultados = document.getElementById('resultados');
    const volverBtn = document.getElementById('volverBtn');
    const viewIdentifier = document.getElementById('viewIdentifier'); 
    
    // Identificar el contexto actual
    const currentViewName = viewIdentifier?.getAttribute('data-view');
    const isDetailedContext = currentViewName === 'index'; // Ajusta según tu `data-view`

    // Variables generales
    let currentView = 'grupo';
    let currentGroupId = null;
    let currentSubgroupId = null;
    let currentSystemId = null;
    let navigationStack = []; 

    const currentBuqueId = document.getElementById('currentBuqueId')?.getAttribute('data-value');
    console.log(currentBuqueId);
    const currentSistemaId = document.getElementById('currentSistemaId')?.value;
    const codigo = document.getElementById('codigo')?.value;

    // Actualizar el placeholder inicialmente
    actualizarPlaceholder();

    // Función de búsqueda reutilizable
    function realizarBusqueda(apiBaseUrl) {
        let query = searchbox.value.trim();
        if (query === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Campo vacío',
                text: 'Por favor, ingrese un término de búsqueda.',
                confirmButtonText: 'OK'
            });
            return;
        }
    
        // ✅ Guardar el estado actual antes de buscar
        navigationStack.push({
            view: currentView,
            groupId: currentGroupId,
            subgroupId: currentSubgroupId,
            systemId: currentSystemId
        });
    
        let apiUrl = '';
        let type = '';
    
        if (currentView === 'grupo') {
            apiUrl = `${apiBaseUrl}?busqueda=${encodeURIComponent(query)}`;
            type = 'equipo';
        } else if (currentView === 'subgrupo') {
            if (!currentGroupId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin grupo seleccionado',
                    text: 'Por favor, seleccione un grupo constructivo.',
                    confirmButtonText: 'OK'
                });
                return;
            }
            apiUrl = `/api/buscar_subgrupos?busqueda=${encodeURIComponent(query)}&id_grupo=${currentGroupId}`;
            type = 'subgrupo';  // ✅ mantiene el estilo correcto
        } else if (currentView === 'sistema') {
            if (!currentSubgroupId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin subgrupo seleccionado',
                    text: 'Por favor, seleccione un subgrupo.',
                    confirmButtonText: 'OK'
                });
                return;
            }
            apiUrl = `/api/buscar_sistemas?busqueda=${encodeURIComponent(query)}&id_subgrupo=${currentSubgroupId}`;
            type = 'sistema';  // ✅ mantiene el estilo correcto
        } else if (currentView === 'equipo') {
            if (isDetailedContext && !currentSystemId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin sistema seleccionado',
                    text: 'Por favor, seleccione un sistema.',
                    confirmButtonText: 'OK'
                });
                return;
            }
            apiUrl = isDetailedContext
                ? `${apiBaseUrl}?busqueda=${encodeURIComponent(query)}&id_sistema=${currentSystemId}`
                : `${apiBaseUrl}?busqueda=${encodeURIComponent(query)}`;
            type = 'equipo';
        }
    
        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                resultados.innerHTML = '';
                if (data.length === 0) {
                    resultados.innerHTML = '<p>No se encontraron resultados.</p>';
                } else {
                    data.forEach(item => {
                        let card = document.createElement('div');
                        card.classList.add('card', 'dynamic-card');
                        card.setAttribute('data-id', item.id);
                        card.setAttribute('data-type', type);
                    
                        if (type === 'subgrupo' || type === 'sistema') {
                            card.innerHTML = `<h1>${item.numeracion}</h1><p class="grupo subgrupo-style">${item.nombre}</p>`;
                        } else if (type === 'equipo') {
                            card.classList.add('centered-content');
                            const nombreEquipo = item.nombre_equipo || item.nombre || item.equipo || 'Nombre no disponible';
                            card.innerHTML = `<p>${nombreEquipo}</p>`;
                        } else {
                            card.innerHTML = `<p>${item.nombre || 'Nombre no disponible'}</p>`;
                        }
                    
                        resultados.appendChild(card);
                    });                    
                }
                volverBtn.classList.remove('d-none'); // ✅ Mostrar botón volver tras búsqueda
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en la búsqueda',
                    text: 'Hubo un error al realizar la búsqueda. Inténtalo de nuevo más tarde.',
                    confirmButtonText: 'OK'
                });
                console.error('Error en la búsqueda:', error);
            });
    }

    if (isDetailedContext) {
        const tarjetas = resultados.querySelectorAll('.card_equipos');

        searchbox.addEventListener('input', function () {
            const filtro = searchbox.value.trim().toLowerCase();
            let hayResultados = false;

            tarjetas.forEach(card => {
                const texto = card.textContent.toLowerCase();
                const coincide = texto.includes(filtro);
                card.style.display = coincide ? 'block' : 'none';
                if (coincide) hayResultados = true;
            });

            const mensajeNoResultados = document.getElementById('mensaje-no-resultados');
            if (!hayResultados && filtro.length > 0) {
                if (!mensajeNoResultados) {
                    const p = document.createElement('p');
                    p.id = 'mensaje-no-resultados';
                    p.textContent = 'No se encontraron resultados.';
                    resultados.appendChild(p);
                }
            } else {
                const p = document.getElementById('mensaje-no-resultados');
                if (p) p.remove();
            }

            // Si el input está vacío, mostrar todos
            if (filtro === '') {
                tarjetas.forEach(card => card.style.display = 'block');
            }
        });
    }


    // Asignación de eventos condicionalmente
    if (buscarBtnBuque) {
        buscarBtnBuque.addEventListener('click', function () {
            realizarBusqueda('/api/buscar_equipos_buque');
        });
    }

    if (buscarBtnGeneral) {
        buscarBtnGeneral.addEventListener('click', function () {
            realizarBusqueda('/api/buscar_equipos');
        });
    }


    // Lógica para manejar el click en los cuadros
    document.addEventListener('click', function (event) {
        if (event.target.closest('.card')) {
            const card = event.target.closest('.card');
            const id = card.getAttribute('data-id');
            const type = card.getAttribute('data-type');

            if (type === 'grupo') {
                currentGroupId = id;
                currentSubgroupId = null;
                currentSystemId = null;

                fetch(`/api/subgrupos/${id}`)
                    .then(response => response.json())
                    .then(data => mostrarTarjetas(data, 'subgrupo'))
                    .catch(error => console.error('Error:', error));
            } else if (type === 'subgrupo') {
                currentSubgroupId = id;
                currentSystemId = null;

                fetch(`/api/sistemas/${id}`)
                    .then(response => response.json())
                    .then(data => mostrarTarjetas(data, 'sistema'))
                    .catch(error => console.error('Error:', error));
            } else if (type === 'sistema') {
                currentSystemId = id;

                let url = `/api/equipos/${id}?id_sistema_ils=${currentSistemaId}`;
                if (currentBuqueId) {
                    url += `&id_buque=${currentBuqueId}`;
                }
                
                fetch(url)
                    .then(response => response.json())
                    .then(data => mostrarTarjetas(data, 'equipo'))
                    .catch(error => console.error('Error:', error));
                    
            } else if (type === 'equipo') {
                const textElement = card.querySelector('h1') || card.querySelector('p');
                
                if (textElement) {
                    const nombre_equipo = textElement.textContent.trim(); // 🔥 ESTO FALTABA 🔥
            
                    fetch('/LSA/mostrar-general', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ nombre_equipo: nombre_equipo }) // ahora sí existe
                    })
                    .then(response => {
                        if (response.redirected) {
                            window.location.href = response.url;
                        } else {
                            console.error('Error en la redirección');
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en la redirección',
                            text: 'Hubo un error al procesar la redirección. Inténtalo de nuevo más tarde.',
                            confirmButtonText: 'OK'
                        });
                        console.error('Error en la petición POST:', error);
                    });
            
                } else {
                    console.error('No se encontró el <h1> ni el <p> dentro de la tarjeta de equipo.');
                }
            }
        }
    });

function mostrarTarjetas(data, type) {
    resultados.innerHTML = '';

    // Guardar el nivel actual en la pila si está cambiando a uno nuevo
    if (currentView !== type) {
        navigationStack.push({
            view: currentView,
            groupId: currentGroupId,
            subgroupId: currentSubgroupId,
            systemId: currentSystemId
        });
    }

    data.forEach(item => {
        let card = document.createElement('div');
        card.classList.add('card');
        card.setAttribute('data-id', item.id);
        card.setAttribute('data-type', type);

        if (type === 'grupo') {
            let imageSrc = 'img/8.png';
            let altText = 'Imagen por defecto';
            switch (item.numeracion) {
                case 100: imageSrc = 'img/1.png'; altText = 'Planta Eléctrica'; break;
                case 200: imageSrc = 'img/2.png'; altText = 'Planta de Propulsión'; break;
                case 300: imageSrc = 'img/3.png'; altText = 'Planta Eléctrica'; break;
                case 400: imageSrc = 'img/4.png'; altText = 'Sistemas Auxiliares'; break;
                case 500: imageSrc = 'img/5.png'; altText = 'Sistemas de Navegación'; break;
                case 600: imageSrc = 'img/6.png'; altText = 'Sistemas de Armamento'; break;
                case 700: imageSrc = 'img/7.png'; altText = 'Sistemas de Armamento'; break;
            }

            card.innerHTML = `
                <img src="/static/${imageSrc}" alt="${altText}">
                <div class="overlay-text">${item.numeracion}</div>
                <p class="grupo">${item.nombre}</p>
            `;
        } else if (type === 'subgrupo' || type === 'sistema') {
            card.classList.add('dynamic-card');
            card.innerHTML = `<h1>${item.numeracion}</h1><p class="grupo subgrupo-style">${item.nombre}</p>`;
        } else if (type === 'equipo') {
            card.classList.add('dynamic-card', 'centered-content');
            const nombreEquipo = item.nombre_equipo || item.nombre || item.equipo || 'Nombre no disponible';
            card.innerHTML = `<p>${nombreEquipo}</p>`;
        }

        resultados.appendChild(card);
    });

    currentView = type;
    actualizarPlaceholder();
    volverBtn.classList.toggle('d-none', currentView === 'grupo');
}

    

    // Función para actualizar el placeholder del buscador
    function actualizarPlaceholder() {
        if (currentView === 'grupo') {
            searchbox.placeholder = 'Buscar equipos';
        } else if (currentView === 'subgrupo') {
            searchbox.placeholder = 'Buscar subgrupos';
        } else if (currentView === 'sistema') {
            searchbox.placeholder = 'Buscar sistemas';
        } else if (currentView === 'equipo') {
            searchbox.placeholder = 'Buscar equipos';
        }
    }

    // Manejar el botón de volver
    volverBtn.addEventListener('click', function () {
        if (navigationStack.length > 0) {
            const lastState = navigationStack.pop();
    
            currentView = lastState.view;
            currentGroupId = lastState.groupId;
            currentSubgroupId = lastState.subgroupId;
            currentSystemId = lastState.systemId;
    
            let url = '';
            let type = '';
    
            if (currentView === 'grupo') {
                url = `/api/grupos`;
                type = 'grupo';
            } else if (currentView === 'subgrupo') {
                url = `/api/subgrupos/${currentGroupId}`;
                type = 'subgrupo';
            } else if (currentView === 'sistema') {
                url = `/api/sistemas/${currentSubgroupId}`;
                type = 'sistema';
            } else if (currentView === 'equipo') {
                url = `/api/equipos/${currentSystemId}`;
                type = 'equipo';
            }
    
            fetch(url)
                .then(response => response.json())
                .then(data => mostrarTarjetas(data, type))
                .catch(error => console.error('Error:', error));
        } else {
            volverBtn.classList.add('d-none');
        }
    
        searchbox.value = ''; // ✅ Limpiar el input de búsqueda
    });
    
    
});


