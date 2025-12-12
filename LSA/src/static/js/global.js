document.addEventListener('DOMContentLoaded', function () {
    const loadingScreen = document.getElementById('loadingScreen');

    function showLoading() {
        loadingScreen.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function hideLoading() {
        loadingScreen.classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    // Mostrar el spinner cuando se hace una solicitud Fetch
    const originalFetch = window.fetch;
    window.fetch = async function (...args) {
        try {
            showLoading();
            const response = await originalFetch(...args);
            hideLoading();
            return response;
        } catch (error) {
            hideLoading();
            throw error;
        }
    };

    // Mostrar el spinner al hacer clic en enlaces
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function (event) {
            const href = this.getAttribute('href');
            if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
                showLoading();
            }
        });
    });

    // Ocultar el spinner cuando la página cargue completamente
    window.addEventListener('load', function () {
        hideLoading();
    });

    // ✅ NUEVO: Ocultar spinner si el usuario navega con el botón "atrás"
    window.addEventListener('pageshow', function (event) {
        hideLoading();
    });
});
