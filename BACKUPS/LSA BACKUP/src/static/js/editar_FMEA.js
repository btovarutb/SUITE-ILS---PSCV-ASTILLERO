document.addEventListener('DOMContentLoaded', function() {
    // Manejo del botón Editar
    const editButtons = document.querySelectorAll('.btn-editar');
    editButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const url = this.href;

            // Confirmación con SweetAlert2 antes de editar
            Swal.fire({
                title: '¿Deseas editar este FMEA?',
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

    // Manejo del botón Eliminar
    const deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const form = this.closest('form');

            // Confirmación con SweetAlert2 antes de eliminar
            Swal.fire({
                title: '¿Estás seguro de que deseas eliminar este FMEA?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar el formulario si el usuario confirma
                    form.submit();
                }
            });
        });
    });

    // Manejo del botón Crear/Editar RCM
    const rcmButtons = document.querySelectorAll('.btn-warning, .btn-success');
    rcmButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const url = this.querySelector('a').href;
            const actionText = this.classList.contains('btn-warning') ? 'editar' : 'crear';

            // Confirmación con SweetAlert2 antes de crear/editar RCM
            Swal.fire({
                title: `¿Deseas ${actionText} este RCM?`,
                text: "Serás redirigido a la página correspondiente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: `Sí, ${actionText}`,
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
});
