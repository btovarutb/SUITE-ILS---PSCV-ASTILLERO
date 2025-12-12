document.addEventListener('DOMContentLoaded', function () {
    const openPopupBtn = document.getElementById('openPopupBtn');
    const closePopupBtn = document.getElementById('closePopupBtn');
    const popup = document.getElementById('popup');
    const popupTitle = document.getElementById('popup-title');
    const popupMessage = document.getElementById('popup-message');

    // Abrir el popup y obtener datos desde el servidor
    openPopupBtn.addEventListener('click', function () {
        popup.style.display = 'flex'; // Mostrar el popup

        // Hacer fetch a la API para obtener datos
        fetch('/api/popup-data')
            .then(response => response.json())
            .then(data => {
                // Mostrar los datos en el popup
                popupTitle.innerText = data.titulo;
                popupMessage.innerText = data.mensaje;
            })
            .catch(error => console.error('Error al obtener los datos:', error));
    });

    // Cerrar el popup
    closePopupBtn.addEventListener('click', function () {
        popup.style.display = 'none'; // Ocultar el popup
    });

    // Cerrar el popup si se hace clic fuera de él
    window.addEventListener('click', function (event) {
        if (event.target === popup) {
            popup.style.display = 'none';
        }
    });
});
