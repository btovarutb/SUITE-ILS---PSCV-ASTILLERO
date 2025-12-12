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
        Swal.fire({
            title: 'Generando PDF...',
            text: 'Por favor espera mientras se genera el documento.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        try {
            const { jsPDF } = window.jspdf;
            
            //  Generar PDFs por separado
            const pdfBlob1 = await generatePDF("zone", jsPDF); //  Secciones 1-5 (Portrait)
            const pdfBlob2 = await generateSpecialPDF("special", jsPDF); //  Secciones 6+ (Landscape)

            if (pdfBlob1 && pdfBlob2) {
                const combinedPdfBlob = await combinePDFs(pdfBlob1, pdfBlob2); //  Fusionar ambos PDFs
                Swal.close();
                downloadOrOpenPDF(combinedPdfBlob, result.isConfirmed);
            } else {
                throw new Error("Error generando el PDF.");
            }
        } catch (error) {
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema generando el PDF. Inténtalo de nuevo.',
                icon: 'error'
            });
            console.error("Error generando el PDF:", error);
        }
    });
});


async function addCoverPage(doc) {
    const header = document.getElementById("header");
    const nombre = document.getElementById("nombreEquipo")?.innerText || "Desconocido";
    const marca = document.getElementById("botonPDF").getAttribute("data-marca-equipo") || "N/A";
    const modelo = document.getElementById("botonPDF").getAttribute("data-modelo-equipo") || "N/A";

    const letterWidth = doc.internal.pageSize.width;
    const letterHeight = doc.internal.pageSize.height;

    //  Cargar imagen de portada
    const imageUrl = "/static/img/portada.png";
    const image = new Image();
    image.src = imageUrl;
    await new Promise((resolve) => (image.onload = resolve));

    doc.addImage(image, "PNG", 0, 0, letterWidth, letterHeight);

    //  Configuración de texto
    doc.setFont("helvetica", "bold");
    doc.setTextColor(0, 74, 173);
    let currentY = 184;
    const marginLeft = 19;

    const drawText = (text, offsetY, size = 15) => {
        doc.setFontSize(size);
        currentY = currentY + offsetY;
        doc.text(text, marginLeft, currentY);
    };

    //  Títulos y detalles
    drawText("INFORME DE ANÁLISIS", 10, 24);
    drawText("DE SOPORTE LOGÍSTICO (LSA)", 10, 20);
    drawText(`Nombre: ${nombre}`, 10, 14);
    drawText(`Marca: ${marca}`, 10, 14);
    drawText(`Modelo: ${modelo}`, 10, 14);

    doc.addPage(); //  Agregar nueva página después de la portada
}

async function generatePDF(className, jsPDF) {
    let doc = new jsPDF({
        unit: "mm",
        format: "letter",
        orientation: "portrait"
    });

    let y = 20;
    const pageHeight = doc.internal.pageSize.height - 20; 

    //  1️⃣ Generar portada directamente en el PDF (NO es necesario combinar luego)
    await addCoverPage(doc);

    //  2️⃣ Generar las secciones en orientación vertical
    document.querySelectorAll(`.${className}`).forEach((section) => {
        if (parseInt(section.id.replace("section", "")) >= 6) return;

        if (section.id === "section1") y = addGeneralidades(section, doc, y, pageHeight);
        else if (section.id === "section2") y = addDetallesEquipo(section, doc, y, pageHeight);
        else if (section.id === "section3") y = addProcedimientos(section, doc, y, pageHeight);
        else if (section.id === "section4") y = addEsquematicas(section, doc, y, pageHeight);
        else if (section.id === "section5") y = addFiabilidad(section, doc, y, pageHeight);

        y += 10;
    });

    return doc.output("blob");
}

async function generateSpecialPDF(className, jsPDF) {

    let doc = new jsPDF({
        unit: "mm",
        format: "letter",
        orientation: "landscape"
    });

    let y = 20;
    const pageHeight = doc.internal.pageSize.height - 20;

    const secciones = document.querySelectorAll(`.${className}`);

    secciones.forEach((section, index) => {
        const sectionId = section.id || "(sin id)";
        const sectionNumber = parseInt(sectionId.replace("section", ""), 10);

        if (isNaN(sectionNumber)) {
            console.warn(`[WARN] Sección ignorada por ID no numérico: ${sectionId}`);
            return;
        }

        if (sectionNumber < 6 || sectionNumber > 11) {
            return;
        }

        if (index !== 0) {
            doc.addPage();
            y = 20;
        }

        switch (sectionId) {
            case "section6":
                y = addAnalisisFuncional(section, doc, y, pageHeight);
                break;
            case "section7":
                y = addHerramientas(section, doc, y, pageHeight);
                break;
            case "section8":
                y = addRepuesto(section, doc, y, pageHeight);
                break;
            case "section9":
                y = addFMEA(section, doc, y, pageHeight);
                break;
            case "section10":
                y = addRCM(section, doc, y, pageHeight);
                break;
            case "section11":
                y = addMTA(section, doc, y, pageHeight);
                break;
            default:
                console.log(`[DEBUG] Sección ${sectionId} no tiene función asignada.`);
        }

        y += 10;
    });

    return doc.output("blob");
}

// Generalidades
function addGeneralidades(section, doc, y, pageHeight) {
    const marginLeft = 15;
    const valueOffset = 60;
    const textWidth = 150;
    const imageX = 55, imageWidth = 100, imageHeight = 60;

    // 🏷️ 1️⃣ Título de la sección
    const titulo = "1. Generalidades";
    if (y + 10 > pageHeight) {
        doc.addPage();
        y = 20;
    }
    doc.setFontSize(16);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(1, 56, 130);
    doc.text(titulo, marginLeft, y);
    y += 10;

    // 2️⃣ Imagen
    const img = section.querySelector("#imagenEquipo");
    if (img) {
        y = checkPageBreak(doc, y, pageHeight);
        const imgData = getImageData(img);
        doc.addImage(imgData, "JPEG", imageX, y, imageWidth, imageHeight);
        y += imageHeight + 10;
    }

    // 3️⃣ Datos del equipo
    doc.setFontSize(12);
    doc.setTextColor(50, 50, 50);

    section.querySelectorAll("p, div.mb-3:not(#descripcionEquipo)").forEach(item => {
        const label = item.querySelector("strong, label")?.innerText || "";
        const value = item.querySelector("span")?.innerText || item.innerText.replace(label, "").trim();

        y = checkPageBreak(doc, y, pageHeight);

        if (label) {
            doc.setFont("helvetica", "bold");
            doc.text(label, marginLeft, y);
        }

        if (value) {
            doc.setFont("helvetica", "normal");
            const splitText = doc.splitTextToSize(value, textWidth);
            doc.text(splitText, marginLeft + valueOffset, y);
            y += splitText.length * 6;
        }
    });

    y += 10;

    // 4️⃣ Descripción del equipo
    const descriptionElement = section.querySelector("#descripcionEquipo span");
    if (descriptionElement) {
        y = checkPageBreak(doc, y, pageHeight);

        doc.setFontSize(12);
        doc.setFont("helvetica", "bold");
        doc.text("Descripción del Equipo:", marginLeft, y);
        y += 6;

        doc.setFont("helvetica", "normal");
        doc.setTextColor(50, 50, 50);

        const description = descriptionElement.innerText.trim();
        const splitText = doc.splitTextToSize(description, 180);

        splitText.forEach(line => {
            y = checkPageBreak(doc, y, pageHeight);
            doc.text(line, marginLeft, y);
            y += 6;
        });
    }

    return y + 10;
}

// Detalles del Equipo
function addDetallesEquipo(section, doc, y, pageHeight) {
    const marginLeft = 15;
    const column1X = 40;
    const column2X = 135;
    let yOffset = 6;

    const titulo = "2. Detalles del Equipo";
    const column1 = [];
    const column2 = [];

    // Recolectar contenido antes de dibujar
    section.querySelectorAll("div.mb-3").forEach((item, index) => {
        const strongText = item.querySelector("strong")?.innerText || "";
        const pText = item.querySelector("p")?.innerText || "";

        if (index % 2 === 0) {
            column1.push({ label: strongText, value: pText });
        } else {
            column2.push({ label: strongText, value: pText });
        }
    });

    const maxRows = Math.max(column1.length, column2.length);

    // Estimación de altura total requerida
    const estimatedHeight = 10 + maxRows * (yOffset * 3);

    // Si no cabe el título + contenido, saltamos la página
    if (y + estimatedHeight > pageHeight) {
        doc.addPage();
        y = 20;
    }

    // Título
    doc.setFontSize(16);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(1, 56, 130);
    doc.text(titulo, marginLeft, y);
    y += 10;

    doc.setTextColor(50, 50, 50);
    // Dibujar las dos columnas
    for (let i = 0; i < maxRows; i++) {
        y = checkPageBreak(doc, y, pageHeight);

        if (column1[i]) {
            doc.setFontSize(12);
            doc.setFont("helvetica", "bold");
            doc.text(column1[i].label, column1X, y);
            doc.setFont("helvetica", "normal");
            const splitText = doc.splitTextToSize(column1[i].value, 80);
            doc.text(splitText, column1X, y + yOffset);
        }

        if (column2[i]) {
            doc.setFontSize(12);
            doc.setFont("helvetica", "bold");
            doc.text(column2[i].label, column2X, y);
            doc.setFont("helvetica", "normal");
            const splitText = doc.splitTextToSize(column2[i].value, 80);
            doc.text(splitText, column2X, y + yOffset);
        }

        y += yOffset * 3;
    }

    return y;
}

function addProcedimientos(section, doc, y, pageHeight) {
    const marginLeft = 15;
    const indentLevel1 = marginLeft + 10;
    const textWidth = 180;
    doc.setTextColor(50, 50, 50);

    let currentIndent = marginLeft;

    // 🏷️ 1️⃣ Título principal de sección
    const titulo = "3. Procedimientos";
    const estimatedHeightTitle = 10 + 18; // Título + espacio mínimo inicial

    if (y + estimatedHeightTitle > pageHeight) {
        doc.addPage();
        y = 20;
    }

    doc.setFontSize(16);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(1, 56, 130);
    doc.text(titulo, marginLeft, y);
    y += 10;

    doc.setTextColor(50, 50, 50);
    section.querySelectorAll("p").forEach(paragraph => {
        y = checkPageBreak(doc, y, pageHeight);

        const strongText = paragraph.querySelector("strong")?.innerText || "";
        const text = paragraph.innerText.replace(strongText, "").trim();

        // Subtítulo de procedimiento
        if (strongText) {
            doc.setFontSize(13);
            doc.setFont("helvetica", "bold");

            // Salto anticipado si no cabe subtítulo y líneas iniciales
            if (y + 20 > pageHeight) {
                doc.addPage();
                y = 20;
            }

            y += 5;
            doc.text(strongText, marginLeft, y);
            y += 8;
        }

        if (text) {
            doc.setFontSize(12);
            const lines = text.split(/\n+/);

            lines.forEach((line) => {
                y = checkPageBreak(doc, y, pageHeight);
                line = line.trim();

                if (/^\d+\..*?:$/.test(line)) {
                    doc.setFont("helvetica", "bold");

                    if (y + 12 > pageHeight) {
                        doc.addPage();
                        y = 20;
                    }

                    y += 5;
                    doc.text(line, marginLeft, y);
                    y += 6;
                    currentIndent = indentLevel1;
                } else {
                    doc.setFont("helvetica", "normal");
                    const splitText = doc.splitTextToSize(line, textWidth - (currentIndent - marginLeft));

                    splitText.forEach((part) => {
                        y = checkPageBreak(doc, y, pageHeight);
                        doc.text(part, currentIndent, y);
                        y += 6;
                    });
                }
            });
        }

        y += 6;
    });

    return y;
}

// Representaciones Esquemáticas
function addEsquematicas(section, doc, y, pageHeight) {
    const marginLeft = 15;
    const imageWidth = 140;
    const imageHeight = 90;
    const centerX = (doc.internal.pageSize.width - imageWidth) / 2;

    // 🏷️ Título de sección
    const titulo = "4. Representaciones Esquemáticas";
    if (y + 20 > pageHeight) {
        doc.addPage();
        y = 20;
    }

    doc.setFontSize(16);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(1, 56, 130);
    doc.text(titulo, marginLeft, y);
    y += 10;

    section.querySelectorAll(".diagrama").forEach(diagrama => {
        const title = diagrama.querySelector("h4")?.innerText || "";
        const img = diagrama.querySelector("img");

        // Verifica si caben título e imagen juntos
        if (y + imageHeight + 15 > pageHeight) {
            doc.addPage();
            y = 20;
        }

        if (title) {
            doc.setFontSize(13);
            doc.setFont("helvetica", "bold");
            doc.setTextColor(50, 50, 50);
            doc.text(title, marginLeft, y);
            y += 10;
        }

        if (img) {
            if (y + imageHeight > pageHeight) {
                doc.addPage();
                y = 20;
            }

            const imgData = getImageData(img);
            doc.addImage(imgData, "JPEG", centerX, y, imageWidth, imageHeight);
            y += imageHeight + 10;
        }
    });

    return y;
}

// Datos de Fiabilidad
function addFiabilidad(section, doc, y, pageHeight) {
    doc.setTextColor(50, 50, 50);
    const marginLeft = 15;
    const textWidth = 180;

    // 🏷️ 1️⃣ Título de la sección
    const titulo = "5. Datos de Fiabilidad";
    const estimatedFirstBlockHeight = 24; // Estimación de un bloque inicial (título + valor + desc.)
    if (y + estimatedFirstBlockHeight > pageHeight) {
        doc.addPage();
        y = 20;
    }

    doc.setFontSize(16);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(1, 56, 130);
    doc.text(titulo, marginLeft, y);
    y += 10;

    // 2️⃣ Extraer bloques de contenido
    let contentBlocks = [];
    let paragraphs = Array.from(section.querySelectorAll(".col-6 p"));

    for (let i = 0; i < paragraphs.length; i++) {
        let p = paragraphs[i];
        const strongText = p.querySelector("strong")?.innerText || "";
        const value = p.innerText.replace(strongText, "").trim();

        // Buscar descripción
        let description = "";
        if (i + 1 < paragraphs.length && paragraphs[i + 1].classList.contains("text-muted")) {
            description = paragraphs[i + 1].innerText.trim();
            i++;
        }

        contentBlocks.push({ title: strongText, value, description });
    }

    // 3️⃣ Dibujar cada bloque con protección contra corte de página
    contentBlocks.forEach(({ title, value, description }) => {
        let estimatedHeight = 12;

        if (description) {
            const splitText = doc.splitTextToSize(description, textWidth);
            estimatedHeight += splitText.length * 6;
        }

        if (y + estimatedHeight > pageHeight) {
            doc.addPage();
            y = 20;
        }

        // Subtítulo
        doc.setFontSize(12);
        doc.setFont("helvetica", "bold");
        doc.setTextColor(1, 56, 130);
        doc.text(title, marginLeft, y);

        // Valor
        doc.setFont("helvetica", "normal");
        doc.setTextColor(50, 50, 50);
        doc.text(` ${value}`, marginLeft + doc.getTextWidth(title) + 4, y);
        y += 6;

        // Descripción
        if (description) {
            const splitText = doc.splitTextToSize(description, textWidth);
            splitText.forEach(line => {
                y = checkPageBreak(doc, y, pageHeight);
                doc.text(line, marginLeft, y);
                y += 6;
            });
        }

        y += 4;
    });

    return y;
}

function addAnalisisFuncional(section, doc, y, pageHeight) {
    const marginLeft = 15;
    const tableColumnWidths = [50, 50, 40, 50, 60];
    const componentColumnWidths = [80, 60, 90];

    const titulo = "6. Análisis Funcional";
    if (y + 20 > pageHeight) {
        doc.addPage();
        y = 20;
    }

    doc.setFontSize(16);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(1, 56, 130);
    doc.text(titulo, marginLeft, y);
    y += 10;

    // 1️⃣ Tabla principal
    const mainTable = section.querySelector("table.table-bordered:not(.componentes)");

    if (mainTable) {
        const headers = [];
        const tableData = [];

        const headerRow = mainTable.querySelector("thead tr:last-child");
        if (headerRow) {
            headerRow.querySelectorAll("th").forEach(th => {
                headers.push(th.innerText.trim());
            });
        }

        mainTable.querySelectorAll("tbody tr").forEach(tr => {
            const row = Array.from(tr.querySelectorAll("td")).map(td => td.innerText.trim());
            tableData.push(row);
        });

        if (headers.length && tableData.length) {
            const estimatedHeight = 10 + tableData.length * 8;
            if (y + estimatedHeight > pageHeight) {
                doc.addPage();
                y = 20;
            }

            doc.autoTable({
                startY: y,
                head: [headers],
                body: tableData,
                margin: { left: marginLeft },
                theme: "grid",
                styles: { fontSize: 9 },
                columnWidths: tableColumnWidths,
                headStyles: {
                    fillColor: [1, 56, 130],
                    textColor: [255, 255, 255],
                    fontStyle: "bold",
                    halign: "center"
                }
            });

            y = doc.autoTable.previous.finalY + 10;
        }
    }

    // 2️⃣ Tablas de componentes
    const componentesTables = section.querySelectorAll("table.componentes");

    componentesTables.forEach((table, idx) => {
        let componentHeaders = [];
        let componentData = [];

        const titleCell = table.querySelector("thead tr:first-child th[colspan]");
        const tableTitle = titleCell ? titleCell.innerText.trim() : null;

        let headerRow = table.querySelector("thead tr:nth-child(2)");
        if (!headerRow || headerRow.querySelectorAll("th").length < 2) {
            headerRow = table.querySelector("thead tr:last-child");
        }

        if (headerRow) {
            headerRow.querySelectorAll("th").forEach(th => {
                componentHeaders.push(th.innerText.trim());
            });
        }

        table.querySelectorAll("tbody tr").forEach(tr => {
            const row = Array.from(tr.querySelectorAll("td")).map(td => td.innerText.trim());
            componentData.push(row);
        });

        if (componentData.length > 0) {
            const estimatedHeight = 10 + componentData.length * 8;
            if (y + estimatedHeight > pageHeight) {
                doc.addPage();
                y = 20;
            }

            if (tableTitle) {
                doc.setFontSize(11);
                doc.setFont("helvetica", "bold");
                doc.setTextColor(1, 56, 130);
                doc.text(tableTitle, marginLeft, y);
                y += 8;
            }

            doc.autoTable({
                startY: y,
                head: [componentHeaders],
                body: componentData,
                margin: { left: marginLeft },
                theme: "striped",
                styles: { fontSize: 9 },
                columnWidths: componentColumnWidths,
                headStyles: {
                    fillColor: [1, 56, 130],
                    textColor: [255, 255, 255],
                    fontStyle: "bold",
                    halign: "center"
                }
            });

            y = doc.autoTable.previous.finalY + 10;
        }
    });

    return y;
}

function addHerramientas(section, doc, y, pageHeight) {
    const marginLeft = 15;
    const tableColumnWidthsGenerales = [60, 40, 50, 25, 30];
    const tableColumnWidthsEspeciales = [50, 40, 50, 20, 30, 50];

    // 🏷️ Título general de sección
    const titulo = "7. Herramientas";
    if (y + 20 > pageHeight) {
        doc.addPage();
        y = 20;
    }
    doc.setFontSize(16);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(1, 56, 130);
    doc.text(titulo, marginLeft, y);
    y += 10;

    // 🔹 Obtener ambas tablas desde sus contenedores
    const tablaGenerales = section.querySelector("#home table") || section.querySelector("#tab-generales table");
    const tablaEspeciales = section.querySelector("#profile table")|| section.querySelector("#tab-especiales table");

    let imagesData = [];
    let imageCounter = 1;

    const procesarTabla = (table, title, colWidths, imgColIndex) => {
        if (!table) return;

        let headers = [];
        let tableData = [];

        // Obtener headers
        table.querySelectorAll("thead tr th").forEach(th => {
            headers.push(th.innerText.trim());
        });

        // Procesar filas
        table.querySelectorAll("tbody tr").forEach(tr => {
            let rowData = [];
            let herramienta = "";
            let imgLabel = "No disponible";

            // Primero obtener el nombre de la herramienta
            const herramientaCell = tr.querySelector("td:nth-child(1)");
            if (herramientaCell) {
                herramienta = herramientaCell.innerText.trim();
            }

            // Procesar cada celda
            tr.querySelectorAll("td").forEach((td, index) => {
                if (index === imgColIndex) {
                    // Buscar cualquier elemento con la clase open-modal y data-img
                    const imgElement = td.querySelector(".open-modal[data-img]");
                    if (imgElement) {
                        const imgData = imgElement.getAttribute("data-img");
                        if (imgData) {
                            imagesData.push({ 
                                imgNumber: imageCounter, 
                                herramienta, 
                                imgData 
                            });
                            imgLabel = `Ver en anexo\nImagen (${imageCounter})`;
                            imageCounter++;
                        }
                    }
                    rowData.push(imgLabel);
                } else {
                    rowData.push(td.innerText.trim());
                }
            });

            tableData.push(rowData);
        });

        // Saltar de página si no cabe el bloque
        const estimatedRowHeight = 8;
        const minRows = 5;
        if (y + 10 + minRows * estimatedRowHeight > pageHeight) {
            doc.addPage();
            y = 20;
        }

        doc.setFontSize(14);
        doc.setFont("helvetica", "bold");
        doc.setTextColor(1, 56, 130);
        doc.text(title, marginLeft, y);
        y += 8;

        doc.autoTable({
            startY: y,
            head: [headers],
            body: tableData,
            margin: { left: marginLeft },
            theme: "grid",
            styles: { fontSize: 9 },
            columnWidths: colWidths,
            headStyles: {
                fillColor: [1, 56, 130],
                textColor: [255, 255, 255],
                fontStyle: "bold",
                halign: "center"
            }
        });

        y = doc.autoTable.previous.finalY + 10;
    };

    // Procesar ambas tablas
    procesarTabla(tablaGenerales, "Herramientas Generales", tableColumnWidthsGenerales, 2);
    procesarTabla(tablaEspeciales, "Herramientas Especiales", tableColumnWidthsEspeciales, 2);

    // 7.1 Anexo de Imágenes
    if (imagesData.length > 0) {
        doc.addPage();
        y = 20;
        doc.setFontSize(14);
        doc.setFont("helvetica", "bold");
        doc.text("7.1 Anexo Dibujos de Sección Transversal", marginLeft, y);
        y += 10;

        const imgWidth = 50, imgHeight = 50, imagesPerRow = 3;
        let imagesCount = 0;

        imagesData.forEach(({ imgData, herramienta, imgNumber }) => {
            const x = marginLeft + (imagesCount % imagesPerRow) * (imgWidth + 30);
            let imgY = y + Math.floor(imagesCount / imagesPerRow) * (imgHeight + 30);

            if (imgY + imgHeight > pageHeight - 20) {
                doc.addPage();
                y = 20;
                doc.text("7.1 Anexo Dibujos de Sección Transversal", marginLeft, y);
                imgY = y + 10;
                imagesCount = 0;
            }

            doc.addImage(imgData, 'JPEG', x, imgY, imgWidth, imgHeight);

            doc.setFontSize(10);
            doc.setFont("helvetica", "normal");
            const label = `Imagen (${imgNumber}): Dibujo de Sección Transversal\npara Herramienta: ${herramienta}`;
            doc.text(label, x + imgWidth / 2, imgY + imgHeight + 5, { align: "center" });

            imagesCount++;
        });

        y += Math.ceil(imagesCount / imagesPerRow) * (imgHeight + 30);
    }

    return y;
}

function addRepuesto(section, doc, y, pageHeight) {
    const marginLeft = 15;
    const tableColumnWidths = [50, 30, 40, 30, 40, 60];

    // 🏷️ Título de la sección
    const titulo = "8. Repuestos";
    if (y + 20 > pageHeight) {
        doc.addPage();
        y = 20;
    }
    doc.setFontSize(16);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(1, 56, 130);
    doc.text(titulo, marginLeft, y);
    y += 10;

    const mainTable = section.querySelector("table.table-bordered");

    if (mainTable) {
        const headers = [];
        const tableData = [];

        mainTable.querySelectorAll("thead tr th").forEach(th => {
            headers.push(th.innerText.trim());
        });

        mainTable.querySelectorAll("tbody tr").forEach(tr => {
            const rowData = [];
            tr.querySelectorAll("td").forEach((td, index) => {
                if (index === 2) {
                    const img = td.querySelector("img");
                    rowData.push(img ? "[Dibujo]" : "");
                } else {
                    rowData.push(td.innerText.trim());
                }
            });
            tableData.push(rowData);
        });

        const estimatedRowHeight = 8;
        const minRowsOnCurrentPage = 5;
        if (y + 10 + (minRowsOnCurrentPage * estimatedRowHeight) > pageHeight) {
            doc.addPage();
            y = 20;
        }

        doc.autoTable({
            startY: y,
            head: [headers],
            body: tableData,
            margin: { left: marginLeft },
            theme: "grid",
            styles: { fontSize: 9 },
            columnWidths: tableColumnWidths,
            headStyles: {
                fillColor: [1, 56, 130],
                textColor: [255, 255, 255],
                fontStyle: "bold",
                halign: "center"
            }
        });

        y = doc.autoTable.previous.finalY + 10;

        let rowIndex = 0;
        mainTable.querySelectorAll("tbody tr").forEach(tr => {
            const imgCell = tr.cells[2];
            const imgElement = imgCell.querySelector("img");

            if (imgElement) {
                const imgData = getImageData(imgElement);
                if (imgData) {
                    const imgX = marginLeft + tableColumnWidths.slice(0, 2).reduce((a, b) => a + b, 0) + 5;
                    const imgY = doc.autoTable.previous.finalY - (tableData.length - rowIndex) * 8;

                    doc.addImage(imgData, "JPEG", imgX, imgY, 20, 20);
                }
            }
            rowIndex++;
        });
    }

    return y;
}

function addFMEA(section, doc, y, pageHeight) {
    const marginLeft = 15;

    const titulo = "9. Análisis de Modos y Efectos de Falla (FMEA)";
    if (y + 20 > pageHeight) {
        doc.addPage();
        y = 20;
    }
    doc.setFontSize(16);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(1, 56, 130);
    doc.text(titulo, marginLeft, y);
    y += 10;

    const columnGroups = [
        [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
        [0, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25]
    ];

    const mainTable = section.querySelector("table.table-bordered");

    if (mainTable) {
        let headers = [];
        let tableData = [];

        mainTable.querySelectorAll("thead tr th").forEach(th => {
            headers.push(th.innerText.trim());
        });

        mainTable.querySelectorAll("tbody tr").forEach(tr => {
            const row = Array.from(tr.querySelectorAll("td")).map(td => td.innerText.trim());
            tableData.push(row);
        });

        columnGroups.forEach((columns, index) => {
            if (index > 0) {
                doc.addPage();
                y = 20;
            }

            const subHeaders = columns.map(i => headers[i]);
            const subBody = tableData.map(row => columns.map(i => row[i]));

            doc.setFontSize(12);
            doc.setTextColor(1, 56, 130);
            doc.text(`FMEA - Parte ${index + 1}`, marginLeft, y);
            y += 6;

            doc.autoTable({
                startY: y,
                head: [subHeaders],
                body: subBody,
                margin: { left: marginLeft },
                theme: "grid",
                styles: { fontSize: 8 },
                headStyles: {
                    fillColor: [1, 56, 130],
                    textColor: [255, 255, 255],
                    fontStyle: "bold",
                    halign: "center"
                }
            });

            y = doc.autoTable.previous.finalY + 10;
        });
    }

    return y;
}

function addRCM(section, doc, y, pageHeight) {
    const marginLeft = 15;

    const titulo = "10. Formato de Cuadro de Decisiones (RCM)";
    if (y + 20 > pageHeight) {
        doc.addPage();
        y = 20;
    }
    doc.setFontSize(16);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(1, 56, 130);
    doc.text(titulo, marginLeft, y);
    y += 10;

    const columnGroups = [
        [0, 1, 2, 3, 4, 5, 6, 7, 8],
        [0, 9, 10, 11, 12, 13, 14, 15, 16, 17],
        [0, 18, 19, 20, 21, 22, 23, 24]
    ];

    const mainTable = section.querySelector("table.table-bordered");
    let imagesData = [];
    let imageCounter = 1;

    if (mainTable) {
        let headers = [];
        let tableData = [];
        let patronFallaIndex = -1;

        mainTable.querySelectorAll("thead tr th").forEach((th, i) => {
            const text = th.innerText.trim();
            if (text === "Patrón de falla") patronFallaIndex = i;
            headers.push(text);
        });

        mainTable.querySelectorAll("tbody tr").forEach(tr => {
            let rowData = [];
            let noModoFalla = "";
            let patronFalla = null;
            let imgLabel = "No disponible";

            tr.querySelectorAll("td").forEach((td, i) => {
                const text = td.innerText.trim();
                if (headers[i] === "No. Modo de falla (MF)") noModoFalla = text;

                if (i === patronFallaIndex) {
                    // Buscar cualquier elemento con la clase open-modal y data-img
                    const imgElement = td.querySelector(".open-modal[data-img]");
                    if (imgElement) {
                        patronFalla = imgElement.getAttribute("data-img");
                        imgLabel = `Ver en anexo\nImagen (${imageCounter})`;
                    }
                }

                rowData.push(i === patronFallaIndex ? imgLabel : text);
            });

            tableData.push(rowData);

            if (patronFalla && noModoFalla) {
                imagesData.push({ imgNumber: imageCounter, noModoFalla, patronFalla });
                imageCounter++;
            }
        });

        columnGroups.forEach((columns, index) => {
            if (index > 0) {
                doc.addPage();
                y = 20;
            }

            const subHeaders = columns.map(i => headers[i]);
            const subBody = tableData.map(row => columns.map(i => row[i]));

            doc.setFontSize(12);
            doc.text(`RCM - Parte ${index + 1}`, marginLeft, y);
            y += 6;

            doc.autoTable({
                startY: y,
                head: [subHeaders],
                body: subBody,
                margin: { left: marginLeft },
                theme: "grid",
                styles: { fontSize: 8 },
                headStyles: {
                    fillColor: [1, 56, 130],
                    textColor: [255, 255, 255],
                    fontStyle: "bold",
                    halign: "center"
                }
            });

            y = doc.autoTable.previous.finalY + 10;
        });

        // 10.1 Anexo de Imágenes
        if (imagesData.length > 0) {
            doc.addPage();
            y = 20;
            doc.setFontSize(14);
            doc.setFont("helvetica", "bold");
            doc.text("10.1 Anexo Fotos de Patrón de Falla", marginLeft, y);
            y += 10;

            const imgWidth = 50, imgHeight = 50, imagesPerRow = 3;
            let imagesCount = 0;

            imagesData.forEach(({ patronFalla, noModoFalla, imgNumber }) => {
                const x = marginLeft + (imagesCount % imagesPerRow) * (imgWidth + 30);
                let imgY = y + Math.floor(imagesCount / imagesPerRow) * (imgHeight + 30);

                if (imgY + imgHeight > pageHeight - 20) {
                    doc.addPage();
                    y = 20;
                    doc.text("10.1 Anexo Fotos de Patrón de Falla", marginLeft, y);
                    imgY = y + 10;
                    imagesCount = 0;
                }

                doc.addImage(patronFalla, 'JPEG', x, imgY, imgWidth, imgHeight);

                doc.setFontSize(10);
                doc.setFont("helvetica", "normal");
                const label = `Imagen (${imgNumber}): Patrón de Falla\npara No. Modo de Falla (${noModoFalla})`;
                doc.text(label, x + imgWidth / 2, imgY + imgHeight + 5, { align: "center" });

                imagesCount++;
            });

            y += Math.ceil(imagesCount / imagesPerRow) * (imgHeight + 30);
        }
    }

    return y;
}

function addMTA(section, doc, y, pageHeight) {
    const marginLeft = 15;

    const titulo = "11. Maintenance Task Analysis (MTA) & Level of Repair Analysis (LORA)";
    if (y + 20 > pageHeight) {
        doc.addPage();
        y = 20;
    }
    doc.setFontSize(16);
    doc.setFont("helvetica", "bold");
    doc.setTextColor(1, 56, 130);
    doc.text(titulo, marginLeft, y);
    y += 10;

    const columnGroups = [
        [0, 1, 2, 3, 4, 5, 6, 7],
        [0, 8, 9, 10, 11, 12, 13, 14],
        [0, 15, 16, 17]
    ];

    const mainTable = section.querySelector("table.table-bordered");

    if (mainTable) {
        let headers = [];
        let tableData = [];

        mainTable.querySelectorAll("thead tr th").forEach(th => {
            headers.push(th.innerText.trim());
        });

        mainTable.querySelectorAll("tbody tr").forEach(tr => {
            const row = Array.from(tr.querySelectorAll("td")).map(td => td.innerText.trim());
            tableData.push(row);
        });

        columnGroups.forEach((columns, index) => {
            if (index > 0) {
                doc.addPage();
                y = 20;
            }

            const subHeaders = columns.map(i => headers[i]);
            const subBody = tableData.map(row => columns.map(i => row[i]));

            doc.setFontSize(12);
            doc.setTextColor(1, 56, 130);
            doc.text(`MTA - Parte ${index + 1}`, marginLeft, y);
            y += 6;

            doc.autoTable({
                startY: y,
                head: [subHeaders],
                body: subBody,
                margin: { left: marginLeft },
                theme: "grid",
                styles: { fontSize: 8 },
                headStyles: {
                    fillColor: [1, 56, 130],
                    textColor: [255, 255, 255],
                    fontStyle: "bold",
                    halign: "center"
                }
            });

            y = doc.autoTable.previous.finalY + 10;
        });
    }

    return y;
}





//  Combinar PDF en portrait y landscape sin duplicar la portada
async function combinePDFs(blob1, blob2) {
    const pdfDoc = await PDFLib.PDFDocument.create();

    const pdf1 = await PDFLib.PDFDocument.load(await blob1.arrayBuffer());
    const pdf2 = await PDFLib.PDFDocument.load(await blob2.arrayBuffer());

    //  Copiar todas las páginas del primer PDF (vertical)
    const copiedPages1 = await pdfDoc.copyPages(pdf1, pdf1.getPageIndices());
    copiedPages1.forEach(page => pdfDoc.addPage(page));

    //  Copiar todas las páginas del segundo PDF (horizontal)
    const copiedPages2 = await pdfDoc.copyPages(pdf2, pdf2.getPageIndices());
    copiedPages2.forEach(page => pdfDoc.addPage(page));

    return new Blob([await pdfDoc.save()], { type: "application/pdf" });
}



// Descargar o abrir PDF
function downloadOrOpenPDF(blob, shouldDownload) {
    const url = URL.createObjectURL(blob);
    if (shouldDownload) {
        const link = document.createElement('a');
        link.href = url;
        link.download = `informe.pdf`;
        link.click();
    } else {
        window.open(url, '_blank');
    }
}


// Función para manejar los saltos de página
function checkPageBreak(doc, y, pageHeight) {
    if (y > pageHeight) {
        doc.addPage();
        return 20; // Reiniciar Y en la nueva página
    }
    return y;
}


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


// Extraer imagen correctamente
function getImageData(img) {
    const canvas = document.createElement("canvas");
    const ctx = canvas.getContext("2d");
    canvas.width = img.width;
    canvas.height = img.height;
    ctx.drawImage(img, 0, 0, img.width, img.height);
    return canvas.toDataURL("image/jpeg");
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

/* backup 2 async function generateSpecialPDF(className, shouldDownload) {
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

            // Extraer el título H2
            let tituloH2 = clone.querySelector("h2");
            let sectionWrapper = document.createElement("div");
            if (index > 0) {
                sectionWrapper.style.pageBreakBefore = "always";
            }

            // Agregar el título antes de cualquier contenido
            if (tituloH2) {
                sectionWrapper.appendChild(tituloH2);
            }

            // Procesar las tablas
            const tables = clone.querySelectorAll("table");
            tables.forEach((table, tableIndex) => {
                const tableClone = table.cloneNode(true);
                const headerRow = tableClone.querySelector("thead");

                if (!headerRow) {
                    console.warn(`La tabla en "${tituloH2 ? tituloH2.innerText : 'Sin título'}" no tiene <thead>.`);
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
                        subTable.style.border = "1px solid black"; // Agrega bordes

                        const subThead = document.createElement("thead");
                        const newHeaderRow = document.createElement("tr");

                        // Si se están dividiendo las columnas, asegurarse de que la primera columna sea el índice "#"
                        if (colStart > 0) {
                            const firstHeaderCell = document.createElement("th");
                            firstHeaderCell.textContent = "#";
                            firstHeaderCell.style.border = "1px solid black";
                            newHeaderRow.appendChild(firstHeaderCell);
                        }

                        Array.from(clonedHeaderRow.rows[0].cells).slice(colStart, colStart + maxColsPerPage).forEach(cell => {
                            const clonedCell = cell.cloneNode(true);
                            clonedCell.style.border = "1px solid black";
                            newHeaderRow.appendChild(clonedCell);
                        });

                        subThead.appendChild(newHeaderRow);
                        subTable.appendChild(subThead);

                        const subTbody = document.createElement("tbody");
                        rows.slice(rowStart, rowStart + maxRowsPerPage).forEach((row, rowIndex) => {
                            const newRow = document.createElement("tr");

                            // Agregar el índice "#" solo si las columnas están siendo divididas
                            if (colStart > 0) {
                                const indexCell = document.createElement("td");
                                indexCell.textContent = rowStart + rowIndex + 1;
                                indexCell.style.border = "1px solid black";
                                newRow.appendChild(indexCell);
                            }

                            Array.from(row.cells).slice(colStart, colStart + maxColsPerPage).forEach(cell => {
                                const clonedCell = cell.cloneNode(true);
                                clonedCell.style.border = "1px solid black";
                                newRow.appendChild(clonedCell);
                            });
                            subTbody.appendChild(newRow);
                        });

                        subTable.appendChild(subTbody);

                        const subTableWrapper = document.createElement("div");
                        subTableWrapper.style.pageBreakBefore = pageIndex > 0 ? "always" : "auto";

                        // Solo agregar el subtítulo "(Parte X)" si las columnas están siendo divididas
                        if (colStart > 0) {
                            subTableWrapper.innerHTML = `<h3>${tituloH2 ? tituloH2.innerText : "Sección"} (Parte ${pageIndex + 1})</h3>`;
                        }

                        subTableWrapper.appendChild(subTable);
                        sectionWrapper.appendChild(subTableWrapper);
                        pageIndex++;
                    }
                }

                table.remove(); // Remover tabla original para evitar duplicados
            });

            // Ocultar botones
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
}*/

/* backup 1 async function generateSpecialPDF(className, shouldDownload) {
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
