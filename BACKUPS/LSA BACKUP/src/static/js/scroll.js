document.addEventListener('DOMContentLoaded', () => {
    // Selecciona todos los contenedores de scroll y configura el scroll para cada uno
    const scrollContainers = document.querySelectorAll('.scroll-container-horizontal');

    scrollContainers.forEach((scrollContainer) => {
        // Encuentra los botones de desplazamiento asociados al contenedor actual
        const scrollLeftButton = scrollContainer.parentElement.querySelector('.scroll-button.left');
        const scrollRightButton = scrollContainer.parentElement.querySelector('.scroll-button.right');

        // Define el incremento del desplazamiento
        const scrollAmount = 10;
        let scrollInterval;

        // Función para actualizar la visibilidad de los botones
        function updateButtonVisibility() {
            const scrollLeft = scrollContainer.scrollLeft;
            const maxScrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;

            scrollLeftButton.classList.toggle('hidden', scrollLeft === 0);
            scrollRightButton.classList.toggle('hidden', scrollLeft >= maxScrollLeft);
        }

        // Función para iniciar el desplazamiento
        function startScrolling(direction) {
            stopScrolling(); // Detener cualquier scroll previo
            scrollInterval = setInterval(() => {
                scrollContainer.scrollBy({ left: direction * scrollAmount });
            }, 10); // Scroll continuo cada 10ms
        }

        // Función para detener el desplazamiento
        function stopScrolling() {
            clearInterval(scrollInterval);
        }

        // Agregar eventos a los botones de desplazamiento
        scrollLeftButton.addEventListener('mousedown', () => startScrolling(-1));
        scrollLeftButton.addEventListener('mouseup', stopScrolling);
        scrollLeftButton.addEventListener('mouseleave', stopScrolling);

        scrollRightButton.addEventListener('mousedown', () => startScrolling(1));
        scrollRightButton.addEventListener('mouseup', stopScrolling);
        scrollRightButton.addEventListener('mouseleave', stopScrolling);

        // Agregar evento de scroll al contenedor
        scrollContainer.addEventListener('scroll', updateButtonVisibility);

        // Actualizar la visibilidad de los botones al cargar
    });
});
