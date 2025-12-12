// Función para exportar el GRES de equipos a PDF
window.exportGresEquiposPdf = function(buqueId) {
    console.log('Función exportGresEquiposPdf llamada con buqueId:', buqueId);
    
    const loadingMessages = [
        "Preparando datos de equipos",
        "Procesando diagramas de decisión",
        "Organizando observaciones",
        "Generando documento final"
    ];

    let currentMessageIndex = 0;
    let messageInterval;

    const swalContent = document.createElement('div');
    swalContent.innerHTML = `
        <div class="loading-container">
            <div id="loading-message"
                 style="opacity: 0;
                        transition: opacity 0.5s, transform 0.5s;
                        transform: translateX(-20px);
                        margin-top: 10px;">
            </div>
        </div>
    `;

    function updateLoadingMessage() {
        const messageElement = document.getElementById('loading-message');
        if (!messageElement) return;

        // Fade out
        messageElement.style.opacity = '0';
        messageElement.style.transform = 'translateX(20px)';

        setTimeout(() => {
            // Update text and prepare for fade in
            messageElement.textContent = loadingMessages[currentMessageIndex];
            messageElement.style.transform = 'translateX(-20px)';

            // Trigger reflow
            messageElement.offsetHeight;

            // Fade in
            messageElement.style.opacity = '1';
            messageElement.style.transform = 'translateX(0)';

            currentMessageIndex = (currentMessageIndex + 1) % loadingMessages.length;
        }, 500);
    }

    console.log('Mostrando SweetAlert...');
    Swal.fire({
        title: 'Generando PDF de Equipos',
        html: swalContent,
        didOpen: () => {
            console.log('SweetAlert abierto');
            Swal.showLoading();
            updateLoadingMessage();
            messageInterval = setInterval(updateLoadingMessage, 10000);
        },
        willClose: () => {
            console.log('SweetAlert cerrado');
            clearInterval(messageInterval);
        },
        allowOutsideClick: false
    });

    console.log('Iniciando fetch de colaboradores...');
    // Obtener colaboradores y enviar buque_id
    fetch(`/gres/colaboradores/${buqueId}`)
        .then(res => {
            console.log('Respuesta de colaboradores recibida:', res);
            if (!res.ok) {
                throw new Error(`Error al obtener colaboradores: ${res.status}`);
            }
            return res.json();
        })
        .then(colaboradoresData => {
            console.log('Datos de colaboradores:', colaboradoresData);
            const formData = new FormData();
            formData.append('colaboradores', JSON.stringify(colaboradoresData.colaboradores));
            formData.append('buque_id', buqueId);

            console.log('Enviando solicitud de PDF...');
            return fetch('/gres/equipos/export-pdf', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });
        })
        .then(response => {
            console.log('Respuesta de PDF recibida:', response);
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Error al generar el PDF');
                });
            }
            return response.blob();
        })
        .then(blob => {
            console.log('Blob recibido, abriendo PDF...');
            Swal.close();
            const pdfUrl = URL.createObjectURL(blob);
            window.open(pdfUrl, '_blank');
        })
        .catch(error => {
            console.error('Error en el proceso:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Ocurrió un error al generar el PDF. Por favor, intente nuevamente.'
            });
        });
};

// Event listener para el botón de exportación
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded ejecutado');
    
    const exportPdfBtn = document.getElementById('export-equipos-pdf-btn');
    console.log('Botón encontrado:', exportPdfBtn);
    
    if (exportPdfBtn) {
        exportPdfBtn.addEventListener('click', function() {
            console.log('Click en el botón detectado');
            console.log('window.buqueId:', window.buqueId);
            
            if (window.buqueId) {
                console.log('Intentando exportar PDF...');
                exportGresEquiposPdf(window.buqueId);
            } else {
                console.log('Error: No se encontró window.buqueId');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontró el ID del buque'
                });
            }
        });
    } else {
        console.log('Error: No se encontró el botón con id export-equipos-pdf-btn');
    }
}); 