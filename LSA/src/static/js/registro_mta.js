document.addEventListener('DOMContentLoaded', function () {
    // Función para seleccionar o deseleccionar todas las herramientas de seguridad
    document.getElementById('select-all-seguridad').addEventListener('change', function () {
        let checkboxes = document.querySelectorAll('#seguridad .form-check-input');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Función para seleccionar o deseleccionar todas las herramientas de soporte
    document.getElementById('select-all-soporte').addEventListener('change', function () {
        let checkboxes = document.querySelectorAll('#soporte .form-check-input');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Función para seleccionar o deseleccionar todas las herramientas generales
    document.getElementById('select-all-generales').addEventListener('change', function () {
        let checkboxes = document.querySelectorAll('#generales .form-check-input');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
});

