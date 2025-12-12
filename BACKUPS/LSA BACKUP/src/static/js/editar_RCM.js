document.addEventListener('DOMContentLoaded', function () {
    // Manejo del botón Editar RCM
    const editButtonsRCM = document.querySelectorAll('.btn-editar-rcm');
    editButtonsRCM.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const url = this.querySelector('a').href;

            Swal.fire({
                title: '¿Deseas editar este RCM?',
                text: "Serás redirigido a la página de edición.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, editar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });

    // Manejo del botón Eliminar RCM
    const deleteButtonsRCM = document.querySelectorAll('.btn-danger a');
    deleteButtonsRCM.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const url = this.href;

            // Confirmación con SweetAlert2 antes de eliminar
            Swal.fire({
                title: '¿Estás seguro de que deseas eliminar este RCM?',
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

        // Manejo del botón Editar o Crear MTA
        const mtaButtons = document.querySelectorAll('.btn-editar-mta, .btn-crear-mta');
        mtaButtons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const url = this.querySelector('a').href;
                const actionText = this.classList.contains('btn-editar-mta') ? 'editar' : 'crear';
    
                Swal.fire({
                    title: `¿Deseas ${actionText} este MTA?`,
                    text: "Serás redirigido a la página correspondiente.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: `Sí, ${actionText}`,
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    });