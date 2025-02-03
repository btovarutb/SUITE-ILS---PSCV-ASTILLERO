document.getElementById("botonPDF").addEventListener("click", async function (event) {
    event.preventDefault();

    Swal.fire({
        title: '¿Deseas descargar el PDF?',
        text: "Puedes visualizarlo antes o descargarlo directamente.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, descargar',
        cancelButtonText: 'Solo visualizar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Generando PDF...',
                text: 'Por favor espera mientras se genera el documento.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading(); // Muestra el indicador de carga
                }
            });
            const pdfBlob1 = await generatePDF("section", false); // Genera el primer PDF
            const pdfBlob2 = await generateSpecialPDF("special", false); // Genera el segundo PDF
            if (pdfBlob1 && pdfBlob2) {
                const combinedPdfBlob = await combinePDFs(pdfBlob1, pdfBlob2);
                Swal.close(); // Cierra el aviso de carga
                downloadOrOpenPDF(combinedPdfBlob, true); // Descargar el PDF combinado
            }
        } else {
            Swal.fire({
                title: 'Generando PDF...',
                text: 'Por favor espera mientras se genera el documento.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading(); // Muestra el indicador de carga
                }
            });
            const pdfBlob1 = await generatePDF("section", false); // Genera el primer PDF
            const pdfBlob2 = await generateSpecialPDF("special", false); // Genera el segundo PDF
            if (pdfBlob1 && pdfBlob2) {
                const combinedPdfBlob = await combinePDFs(pdfBlob1, pdfBlob2);
                Swal.close(); // Cierra el aviso de carga
                downloadOrOpenPDF(combinedPdfBlob, false); // Descargar el PDF combinado
            }
        }
    });
});

function addNumberingToTitles(container, initialH2Counter = 1) {
    const titleSelectors = ['h2', 'h3']; // Niveles de encabezado a numerar
    let h2Counter = initialH2Counter - 1; // Configura el valor inicial para <h2>
    let h3Counter = 0; // Contador para <h3>

    // Itera por los encabezados en el orden en que aparecen
    const titles = container.querySelectorAll(titleSelectors.join(','));
    titles.forEach(title => {
        if (title.tagName.toLowerCase() === 'h2') {
            // Incrementa el contador de <h2> y reinicia el de <h3>
            h2Counter++;
            h3Counter = 0;
            title.textContent = `${h2Counter}. ${title.textContent}`; // Numeración para <h2>
        } else if (title.tagName.toLowerCase() === 'h3') {
            // Incrementa el contador de <h3>
            h3Counter++;
            title.textContent = `${h2Counter}.${h3Counter} ${title.textContent}`; // Numeración para <h3>
        }
    });
}

async function createCoverPage() {
    const header = document.getElementById("header");
    const nombre = header.querySelector("p").innerText;
    const marca = document.getElementById("botonPDF").getAttribute("data-marca-equipo") || "N/A";
    const modelo = document.getElementById("botonPDF").getAttribute("data-modelo-equipo") || "N/A";

    // Crear documento PDF con tamaño carta
    const pdfDoc = await PDFLib.PDFDocument.create();
    const letterWidth = 612; // Tamaño carta
    const letterHeight = 792;
    let page = pdfDoc.addPage([letterWidth, letterHeight]);

    // Cargar la imagen de portada
    const imageBytes = await fetch('/static/img/portada.png').then(res => res.arrayBuffer());
    const coverImage = await pdfDoc.embedPng(imageBytes);

    // Dibujar la imagen en toda la página
    page.drawImage(coverImage, {
        x: 0,
        y: 0,
        width: letterWidth,
        height: letterHeight,
    });

    // Configuración de texto
    const font = await pdfDoc.embedFont(PDFLib.StandardFonts.HelveticaBold);
    const titleFontSize = 20; // Tamaño para el título principal
    const textFontSize = 15; // Tamaño para el resto del texto
    const textColor = PDFLib.rgb(0 / 255, 74 / 255, 173 / 255); 

    // Coordenadas iniciales y límites
    const startX = 56; // Margen izquierdo
    let startY = 260; // Altura inicial del texto
    const bottomLimit = 50; // Límite inferior para el salto de página

    // Función para dibujar texto con verificación de salto de página
    function drawTextWithPageCheck(text, offsetY, size = textFontSize) {
        if (startY - offsetY < bottomLimit) {
            // Crear nueva página si el límite inferior se alcanza
            page = pdfDoc.addPage([letterWidth, letterHeight]);
            startY = letterHeight - 50; // Reiniciar posición de inicio en la nueva página
        }
        page.drawText(text, { x: startX, y: startY - offsetY, size, font, color: textColor });
    }

    // Dibujar textos dinámicos
    drawTextWithPageCheck("INFORME DE ANÁLISIS", 0, titleFontSize); // Tamaño 20
    drawTextWithPageCheck("DE SOPORTE LOGÍSTICO (LSA)", 20, titleFontSize); // Tamaño 20
    drawTextWithPageCheck(`Nombre: ${nombre}`, 50); // Tamaño 15
    drawTextWithPageCheck(`Marca: ${marca}`, 70); // Tamaño 15
    drawTextWithPageCheck(`Modelo: ${modelo}`, 90); // Tamaño 15

    // Exportar el PDF como Blob
    return new Blob([await pdfDoc.save()], { type: "application/pdf" });
}


async function generatePDF(className, shouldDownload) {
    return new Promise((resolve, reject) => {
        const elements = document.querySelectorAll(`.${className}`);
        if (elements.length === 0) {
            Swal.fire("Error", "No se encontraron elementos para generar el PDF.", "error");
            reject(null);
        }

        const container = document.createElement("div");

        // Iterar por todas las secciones (activas e inactivas)
        document.querySelectorAll(".section").forEach(section => {
            const clone = section.cloneNode(true);

            // Asegurar que las secciones inactivas sean visibles
            clone.style.display = "block";

            // Escalado dinámico para imágenes
            const images = clone.querySelectorAll("img");
            images.forEach(img => {
                if (img.id === "imagenEquipo") {
                    // Ajustar al 50% del ancho
                    img.style.width = "50%";
                    img.style.height = "auto";
                    img.style.display = "block"; // Centrar
                    img.style.margin = "0 auto";
                    img.style.marginTop = "30px";
                } else {
                    // Aplicar estilos generales para otras imágenes
                    img.style.maxWidth = "100%";
                    img.style.height = "auto";
                }
            });

            // Asegurar que los títulos y contenidos estén juntos
            const sections = clone.querySelectorAll("h3"); // Selecciona todos los títulos
            sections.forEach(section => {
                // Encuentra el contenido relacionado con el título
                const nextSibling = section.nextElementSibling;
                if (nextSibling) {
                    // Crear un contenedor para el título y su contenido
                    const wrapper = document.createElement("div");
                    wrapper.style.pageBreakInside = "avoid"; // Evitar saltos de página dentro del contenedor
                    wrapper.style.marginBottom = "20px"; // Espaciado entre secciones

                    // Mover el título y el contenido al contenedor
                    section.parentNode.insertBefore(wrapper, section);
                    wrapper.appendChild(section);
                    wrapper.appendChild(nextSibling);
                }
            });

            // Ocultar los botones de acción
            const buttons = clone.querySelectorAll(".btn, .no-print");
            buttons.forEach(button => {
                button.style.display = "none"; // Ocultar los botones en el PDF
            });

            // Alinear los títulos en "Generalidades" a la izquierda
            const labels = clone.querySelectorAll(".row label");
            labels.forEach(label => {
                label.style.textAlign = "left"; // Alinear texto a la izquierda
                label.style.display = "block"; // Asegurar que cada título ocupe toda la línea
                label.style.marginBottom = "5px"; // Espaciado inferior
            });

            clone.style.backgroundColor = "transparent";
            clone.style.border = "none";
            container.appendChild(clone);
        });

        addNumberingToTitles(container);
        document.body.appendChild(container);

        const options = {
            filename: "standard.pdf",
            image: { type: "jpeg", quality: 1 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: "pt", format: "letter", orientation: "portrait" },
            margin: [40, 40, 40, 40],
        };

        html2pdf().set(options).from(container).outputPdf("blob").then((pdfBlob) => {
            resolve(pdfBlob);
        }).catch((error) => {
            console.error("Error al generar el PDF:", error);
            reject(null);
        }).finally(() => {
            document.body.removeChild(container);
        });
    });
}


async function generateSpecialPDF(className, shouldDownload) {
    return new Promise((resolve, reject) => {
        const elements = document.querySelectorAll(`.${className}`);
        if (elements.length === 0) {
            Swal.fire("Error", "No se encontraron elementos para generar el PDF especial.", "error");
            reject(null);
        }

        const container = document.createElement("div");

        document.querySelectorAll(".special").forEach((section, index) => {
            const clone = section.cloneNode(true);
            clone.style.display = "block";

            const sectionTitle = clone.querySelector("h2");
            const sectionName = sectionTitle ? sectionTitle.innerText.trim() : `Sección ${index + 1}`;
            
            const sectionWrapper = document.createElement("div");
            if (index > 0) {
                sectionWrapper.style.pageBreakBefore = "always";
            }

            const tables = clone.querySelectorAll("table");
            tables.forEach((table, tableIndex) => {
                const tableClone = table.cloneNode(true);
                const headerRow = tableClone.querySelector("thead");
                
                if (!headerRow) {
                    console.warn(`La tabla en ${sectionName} no tiene un <thead>. Se omitirá la división por columnas.`);
                    return;
                }
                
                const clonedHeaderRow = headerRow.cloneNode(true);
                const rows = Array.from(tableClone.querySelector("tbody").rows);
                const totalRows = rows.length;
                const totalCols = clonedHeaderRow.rows[0].cells.length;

                const maxRowsPerPage = 15;
                const maxColsPerPage = 5;

                let pageIndex = 0;
                for (let rowStart = 0; rowStart < totalRows; rowStart += maxRowsPerPage) {
                    for (let colStart = 0; colStart < totalCols; colStart += maxColsPerPage) {
                        const subTable = document.createElement("table");
                        subTable.style.borderCollapse = "collapse";
                        subTable.style.width = "100%";
                        subTable.style.tableLayout = "auto";
                        
                        const subThead = document.createElement("thead");
                        const newHeaderRow = document.createElement("tr");
                        Array.from(clonedHeaderRow.rows[0].cells).slice(colStart, colStart + maxColsPerPage).forEach(cell => {
                            newHeaderRow.appendChild(cell.cloneNode(true));
                        });
                        subThead.appendChild(newHeaderRow);
                        subTable.appendChild(subThead);
                        
                        const subTbody = document.createElement("tbody");
                        rows.slice(rowStart, rowStart + maxRowsPerPage).forEach(row => {
                            const newRow = document.createElement("tr");
                            Array.from(row.cells).slice(colStart, colStart + maxColsPerPage).forEach(cell => {
                                newRow.appendChild(cell.cloneNode(true));
                            });
                            subTbody.appendChild(newRow);
                        });
                        subTable.appendChild(subTbody);

                        const subTableWrapper = document.createElement("div");
                        subTableWrapper.style.pageBreakBefore = pageIndex > 0 ? "always" : "auto";
                        subTableWrapper.innerHTML = `<h3>${sectionName} (Parte ${pageIndex + 1})</h3>`;
                        subTableWrapper.appendChild(subTable);
                        sectionWrapper.appendChild(subTableWrapper);
                        pageIndex++;
                    }
                }

                table.remove();
            });

            clone.querySelectorAll(".btn, .no-print").forEach(button => {
                button.style.display = "none";
            });

            sectionWrapper.appendChild(clone);
            container.appendChild(sectionWrapper);
        });

        addNumberingToTitles(container);

        document.body.appendChild(container);

        const options = {
            filename: "special.pdf",
            image: { type: "jpeg", quality: 1 },
            html2canvas: { scale: 2, scrollX: 0, scrollY: 0 },
            jsPDF: { unit: "pt", format: "letter", orientation: "landscape" },
            margin: [40, 40, 40, 40],
        };

        html2pdf().set(options).from(container).outputPdf("blob").then((pdfBlob) => {
            resolve(pdfBlob);
        }).catch((error) => {
            console.error("Error al generar el PDF especial:", error);
            reject(null);
        }).finally(() => {
            document.body.removeChild(container);
        });
    });
}







/* async function generateSpecialPDF(className, shouldDownload) {
    return new Promise((resolve, reject) => {
        const elements = document.querySelectorAll(`.${className}`);
        if (elements.length === 0) {
            Swal.fire("Error", "No se encontraron elementos para generar el PDF especial.", "error");
            reject(null);
        }

        const container = document.createElement("div");

        // Iterar por las secciones especiales
        document.querySelectorAll(".special").forEach((section, index) => {
            const clone = section.cloneNode(true);

            // Asegurar que las secciones inactivas sean visibles
            clone.style.display = "block";

            // Omitir el elemento con ID "myTab"
            const myTabElement = clone.querySelector("#myTab");
            if (myTabElement) {
                myTabElement.remove(); // Eliminar el elemento del clon
            }

            // Verificar si estamos en el módulo de herramientas
            if (section.id === "section3") {
                // Forzar que ambas pestañas sean visibles
                const tabContent = clone.querySelectorAll(".tab-pane");
                tabContent.forEach(tab => {
                    tab.classList.add("show", "active");
                });
            }

            // Crear un contenedor para cada sección con salto de página
            const sectionWrapper = document.createElement("div");
            if (index > 0) {
                sectionWrapper.style.pageBreakBefore = "always"; // Agregar salto de página antes de cada sección excepto la primera
            }

            // Agrupar títulos (h2) con sus contenidos para que no se separen en páginas
            const titles = clone.querySelectorAll("h2");
            titles.forEach((title) => {
                const wrapper = document.createElement("div");
                wrapper.style.pageBreakInside = "avoid"; // Evitar saltos de página dentro del contenedor
                wrapper.style.marginBottom = "20px"; // Espaciado entre zonas

                const nextSiblings = [];
                let sibling = title.nextElementSibling;

                // Agrupar todo lo que pertenezca a esta sección
                while (sibling && sibling.tagName !== "H2") {
                    nextSiblings.push(sibling);
                    sibling = sibling.nextElementSibling;
                }

                title.parentNode.insertBefore(wrapper, title);
                wrapper.appendChild(title);

                nextSiblings.forEach(sibling => {
                    wrapper.appendChild(sibling);
                });
            });

            
            // Ajustar las tablas específicamente en FMEA, RCM y LORA
            if (section.id === "section5" || section.id === "section6" || section.id === "section7") {
                const tables = clone.querySelectorAll("table");
                tables.forEach((table) => {
                    table.style.transform = "scale(0.5)"; // Escalar para ajustar el tamaño
                    table.style.transformOrigin = "top left"; // Ajustar el origen de la escala
                    table.style.margin = "0 auto";
                    table.style.borderCollapse = "collapse";
                    table.style.textAlign = "center";
                    table.style.marginBottom = "20px";

                    const cells = table.querySelectorAll("td, th");
                    cells.forEach(cell => {
                        cell.style.wordWrap = "break-word";
                        cell.style.whiteSpace = "normal";
                        cell.style.fontSize = "10px";
                        cell.style.padding = "5px";
                    });
                });
            }

            // Ocultar botones no imprimibles
            const buttons = clone.querySelectorAll(".btn, .no-print");
            buttons.forEach(button => {
                button.style.display = "none";
            });

            // Añadir el clon al contenedor con salto de página
            sectionWrapper.appendChild(clone);
            container.appendChild(sectionWrapper);
        });

        addNumberingToTitles(container);

        document.body.appendChild(container);

        const options = {
            filename: "special.pdf",
            image: { type: "jpeg", quality: 1 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: "pt", format: "letter", orientation: "landscape" }, // Horizontal
            margin: [40, 40, 40, 40],
        };

        html2pdf().set(options).from(container).outputPdf("blob").then((pdfBlob) => {
            resolve(pdfBlob);
        }).catch((error) => {
            console.error("Error al generar el PDF especial:", error);
            reject(null);
        }).finally(() => {
            document.body.removeChild(container);
        });
    });
} */

async function combinePDFs(blob1, blob2) {
    const pdfDoc = await PDFLib.PDFDocument.create();
    const coverPageBlob = await createCoverPage();
    const coverPagePdf = await PDFLib.PDFDocument.load(await coverPageBlob.arrayBuffer());
    const coverPage = await pdfDoc.copyPages(coverPagePdf, [0]);
    const pdf1 = await PDFLib.PDFDocument.load(await blob1.arrayBuffer());
    const pdf2 = await PDFLib.PDFDocument.load(await blob2.arrayBuffer());

    pdfDoc.addPage(coverPage[0]);
    const pages1 = await pdfDoc.copyPages(pdf1, pdf1.getPageIndices());
    pages1.forEach(page => pdfDoc.addPage(page));
    const pages2 = await pdfDoc.copyPages(pdf2, pdf2.getPageIndices());
    pages2.forEach(page => pdfDoc.addPage(page));

    return new Blob([await pdfDoc.save()], { type: 'application/pdf' });
}


function downloadOrOpenPDF(blob, shouldDownload) {
    const nombreEquipo = document.getElementById("botonPDF").getAttribute("data-nombre-equipo") || "Informe";
    const url = URL.createObjectURL(blob);
    if (shouldDownload) {
        const link = document.createElement('a');
        link.href = url;
        link.download = `informe_${nombreEquipo}.pdf`;
        link.click();
    } else {
        window.open(url, '_blank');
    }
}


document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', () => {
        // Quitar la clase activa de todos los botones
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        // Agregar la clase activa al botón actual
        button.classList.add('active');

        // Ocultar todas las secciones
        document.querySelectorAll('.zone').forEach(content => content.classList.remove('active'));
        // Mostrar la sección correspondiente
        const target = button.getAttribute('data-target');
        document.getElementById(target).classList.add('active');
    });
});

document.addEventListener('DOMContentLoaded', () => {
    // Verificar si la tabla de FMEA está vacía
    const fmeaTable = document.querySelector('#section9 table tbody');
    const rcmTable = document.querySelector('#section10 table tbody');

    // Botones de las secciones 10 (RCM) y 11 (MTA)
    const rcmTabButton = document.getElementById('rcmTabButton');
    const mtaTabButton = document.getElementById('mtaTabButton');

    if (fmeaTable && fmeaTable.children.length === 0) {
        // Deshabilitar botón de RCM si FMEA está vacío
        rcmTabButton.disabled = true;
    } else {
        rcmTabButton.disabled = false;
    }

    if (rcmTable && rcmTable.children.length === 0) {
        // Deshabilitar botón de MTA si RCM está vacío
        mtaTabButton.disabled = true;
    } else {
        mtaTabButton.disabled = false;
    }

    // Agregar funcionalidad para activar/desactivar botones si las tablas cambian dinámicamente
    const observer = new MutationObserver(() => {
        if (fmeaTable.children.length > 0) {
            rcmTabButton.disabled = false;
        } else {
            rcmTabButton.disabled = true;
        }

        if (rcmTable.children.length > 0) {
            mtaTabButton.disabled = false;
        } else {
            mtaTabButton.disabled = true;
        }
    });

    // Observar cambios en ambas tablas
    if (fmeaTable) observer.observe(fmeaTable, { childList: true });
    if (rcmTable) observer.observe(rcmTable, { childList: true });
});

