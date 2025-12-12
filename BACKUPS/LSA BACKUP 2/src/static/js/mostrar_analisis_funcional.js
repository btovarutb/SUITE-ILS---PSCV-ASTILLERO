function get_id(id) {
    // Seleccionar todos los elementos con la clase 'componentes'
    let componentes = document.querySelectorAll('.componentes');
    let table_comp = document.querySelector(`.comp_${id}`);

    // Ocultar todos los elementos menos el seleccionado
    componentes.forEach(element => {
        element.hidden = (element !== table_comp);
    });

    // Alternar visibilidad del elemento específico
    table_comp.hidden = !table_comp.hidden;
}



// Función para confirmar la eliminación utilizando SweetAlert2 y `fetch`
function confirmarEliminacion(event) {
    event.preventDefault(); // Prevenir el envío del formulario

    const eliminarButton = event.currentTarget;
    const idAnalisis = eliminarButton.getAttribute('data-id');

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar la petición DELETE con Fetch API
            fetch(`/analisis_funcional/eliminar/${idAnalisis}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Error al eliminar el análisis funcional');
                }
            })
            .then(data => {
                Swal.fire({
                    title: 'Eliminado',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Remover la fila de la tabla si la eliminación fue exitosa
                    eliminarButton.closest('tr').remove();
                });
            })
            .catch(error => {
                console.error('Error al eliminar:', error);
                Swal.fire('Error', 'No se pudo eliminar el análisis funcional', 'error');
            });
        }
    });
}

// Función para confirmar la edición utilizando SweetAlert2
function confirmarEdicion(event) {
    event.preventDefault();

    const enlace = event.currentTarget.closest('a');
    const url = enlace.getAttribute('href');

    Swal.fire({
        title: '¿Deseas editar este análisis?',
        text: "Se guardarán los cambios realizados.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.assign(url);
        }
    });
}

// Agregar los event listeners
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-eliminar').forEach(boton => {
        boton.addEventListener('click', confirmarEliminacion);
    });

    document.querySelectorAll('a.boton').forEach(boton => {
        boton.addEventListener('click', confirmarEdicion);
    });
});
