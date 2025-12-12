// Función para exportar el GRES de equipos a PDF (ACTUALIZADA)
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
        messageElement.style.opacity = '0';
        messageElement.style.transform = 'translateX(20px)';
        setTimeout(() => {
            messageElement.textContent = loadingMessages[currentMessageIndex];
            messageElement.style.transform = 'translateX(-20px)';
            messageElement.offsetHeight;
            messageElement.style.opacity = '1';
            messageElement.style.transform = 'translateX(0)';
            currentMessageIndex = (currentMessageIndex + 1) % loadingMessages.length;
        }, 500);
    }

    Swal.fire({
        title: 'Generando PDF de Equipos',
        html: swalContent,
        didOpen: () => {
            Swal.showLoading();
            updateLoadingMessage();
            messageInterval = setInterval(updateLoadingMessage, 10000);
        },
        willClose: () => clearInterval(messageInterval),
        allowOutsideClick: false
    });

    // 1) Construir catálogo desde la tabla renderizada (lo que ve el usuario)
    const rows = Array.from(document.querySelectorAll('#equipos-table-body tr[id^="equipo-row-"]'));
    const catalogo = rows.map(row => {
        const idStr = row.id.replace('equipo-row-', '').trim();
        const id = parseInt(idStr, 10);

        const tds = row.querySelectorAll('td');
        const codigo = (tds[0]?.textContent || '').trim();
        const nombre = (tds[1]?.textContent || '').trim();
        return { id, codigo, nombre };
    });

    // 2) Obtener colaboradores y postear todo al endpoint del PDF
    fetch(`/gres/colaboradores/${buqueId}`)
        .then(res => {
            if (!res.ok) throw new Error(`Error al obtener colaboradores: ${res.status}`);
            return res.json();
        })
        .then(colaboradoresData => {
            const formData = new FormData();
            formData.append('colaboradores', JSON.stringify(colaboradoresData.colaboradores || []));
            formData.append('buque_id', buqueId);
            formData.append('equipos_catalogo', JSON.stringify(catalogo)); // ⬅️ NUEVO: enviamos catálogo

            return fetch('/gres/equipos/export-pdf', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Error al generar el PDF');
                });
            }
            return response.blob();
        })
        .then(blob => {
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

// Event listener para el botón de exportación (sin cambios)
document.addEventListener('DOMContentLoaded', function() {
    const exportPdfBtn = document.getElementById('export-equipos-pdf-btn');
    if (exportPdfBtn) {
        exportPdfBtn.addEventListener('click', function() {
            if (window.buqueId) exportGresEquiposPdf(window.buqueId);
            else Swal.fire({ icon: 'error', title: 'Error', text: 'No se encontró el ID del buque' });
        });
    }
});
