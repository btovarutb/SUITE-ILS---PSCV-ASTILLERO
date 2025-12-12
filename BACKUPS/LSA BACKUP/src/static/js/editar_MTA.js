function confirmarFinalizarRegistro(nombreEquipo) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Deseas finalizar el registro del equipo?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, finalizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirige y muestra mensaje de éxito
            Swal.fire({
                title: '¡Registro Exitoso!',
                text: `${nombreEquipo} se ha registrado exitosamente.`,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                // Redirige al index después de mostrar el mensaje de éxito
                window.location.href = "/LSA";
            });
        }
    });
}
document.addEventListener('DOMContentLoaded', function () {
    // Manejo del botón Editar MTA
    const editButtonsMTA = document.querySelectorAll('.btn-warning a');
    editButtonsMTA.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const url = this.href;

            // Confirmación con SweetAlert2 antes de editar
            Swal.fire({
                title: '¿Deseas editar este MTA?',
                text: "Serás redirigido a la página de edición.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, editar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirigir si el usuario confirma
                    window.location.href = url;
                }
            });
        });
    });

    // Manejo del botón Eliminar MTA
    const deleteButtonsMTA = document.querySelectorAll('.btn-danger a');
    deleteButtonsMTA.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const url = this.href;

            // Confirmación con SweetAlert2 antes de eliminar
            Swal.fire({
                title: '¿Estás seguro de que deseas eliminar este MTA?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirigir si el usuario confirma
                    window.location.href = url;
                }
            });
        });
    });
});
