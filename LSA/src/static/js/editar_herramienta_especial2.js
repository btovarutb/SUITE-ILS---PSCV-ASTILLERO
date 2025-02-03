document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editar-herramienta-form');
    const herramientaId = form.getAttribute('data-herramienta-id');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch('/api/herramientas-especiales/' + herramientaId, {
            method: 'PUT',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.message) {
                alert(result.message);
                window.location.href = '/LSA/mostrar-herramientas-especiales';
            } else {
                alert('Error al actualizar herramienta');
            }
        })
        .catch(error => {
            console.error('Error al actualizar herramienta:', error);
            alert('Error al actualizar herramienta: ' + error.message);
        });
    });
});
