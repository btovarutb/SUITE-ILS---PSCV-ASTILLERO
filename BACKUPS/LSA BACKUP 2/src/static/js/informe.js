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
            const pdfBlob2 = await generateSpecialPDF("special", jsPDF, 6); //  Secciones 6+ (Landscape)

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
    const nombre = header.querySelector("p")?.innerText || "Desconocido";
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
    let sectionCount = 1; //  Contador de secciones

    //  1️⃣ Generar portada directamente en el PDF (NO es necesario combinar luego)
    await addCoverPage(doc);

    //  2️⃣ Generar las secciones en orientación vertical
    document.querySelectorAll(`.${className}`).forEach((section) => {
        if (parseInt(section.id.replace("section", "")) >= 6) return;

        const title = section.querySelector("h3");
        if (title) {
            if (y + 10 > pageHeight) {
                doc.addPage();
                y = 20;
            }
            doc.setFontSize(16);
            doc.setFont("helvetica", "bold");
            doc.setTextColor(1, 56, 130);
            doc.text(`${sectionCount}. ${title.innerText}`, 10, y);
            y += 10;
        }

        if (section.id === "section1") y = addGeneralidades(section, doc, y, pageHeight);
        else if (section.id === "section2") y = addDetallesEquipo(section, doc, y, pageHeight);
        else if (section.id === "section3") y = addProcedimientos(section, doc, y, pageHeight);
        else if (section.id === "section4") y = addEsquematicas(section, doc, y, pageHeight);
        else if (section.id === "section5") y = addFiabilidad(section, doc, y, pageHeight);

        sectionCount++; //  Incrementar el contador de secciones
        y += 10;
    });

    return doc.output("blob");
}

async function generateSpecialPDF(className, jsPDF, startCount) {
    let doc = new jsPDF({
        unit: "mm",
        format: "letter",
        orientation: "landscape"
    });

    let y = 20;
    const pageHeight = doc.internal.pageSize.height - 20;
    let sectionCount = startCount;

    document.querySelectorAll(`.${className}`).forEach((section, index) => {
        const sectionNumber = parseInt(section.id.replace("section", ""), 10);
        if (sectionNumber < 6 || sectionNumber > 11) return;
    
        const title = section.querySelector("h2");
        if (!title) {
            console.warn(`Sección ${sectionNumber} no tiene título`);
            return;
        }
    
        // Aplicar el salto de página solo si NO es la primera sección
        if (index !== 0) {
            doc.addPage();
            y = 20;
        }
    
        // Dibujar título de la sección
        doc.setFontSize(16);
        doc.setFont("helvetica", "bold");
        doc.setTextColor(1, 56, 130);
        doc.text(`${sectionCount}. ${title.innerText}`, 10, y);
        y += 10;
    
        // Generar el contenido correspondiente
        if (section.id === "section6") y = addAnalisisFuncional(section, doc, y, pageHeight);
        else if (section.id === "section7") y = addHerramientas(section, doc, y, pageHeight);
        else if (section.id === "section8") y = addRepuesto(section, doc, y, pageHeight);
        else if (section.id === "section9") y = addFMEA(section, doc, y, pageHeight);
        else if (section.id === "section10") y = addRCM(section, doc, y, pageHeight);
        else if (section.id === "section11") y = addMTA(section, doc, y, pageHeight);
        
        sectionCount++;
        y += 10;
    });
    

    return doc.output("blob");
}



// Generalidades
function addGeneralidades(section, doc, y, pageHeight) {
    const marginLeft = 15;
    const valueOffset = 60; // Espaciado entre la etiqueta y el valor
    const textWidth = 150; // Ancho máximo para los textos
    const imageX = 55, imageWidth = 100, imageHeight = 60; // Posición y tamaño de imagen

    //  1️⃣ Imagen en la parte superior
    const img = section.querySelector("#imagenEquipo");
    if (img) {
        y = checkPageBreak(doc, y, pageHeight);
        const imgData = getImageData(img);
        doc.addImage(imgData, "JPEG", imageX, y, imageWidth, imageHeight);
        y += imageHeight + 10; // Espaciado después de la imagen
    }

    //  2️⃣ Datos del equipo debajo de la imagen
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

    y += 10; // Espaciado antes de la descripción

    //  3️⃣ Descripción del equipo (OCUPA TODO EL ANCHO)
    const descriptionElement = section.querySelector("#descripcionEquipo span");
    if (descriptionElement) {
        y = checkPageBreak(doc, y, pageHeight);

        //  Título de la descripción
        doc.setFontSize(12);
        doc.setFont("helvetica", "bold");
        doc.text("Descripción del Equipo:", marginLeft, y);
        y += 6;

        //  Texto de la descripción con TODO el ancho del documento
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
    doc.setTextColor(50, 50, 50);
    const marginLeft = 15;
    const column1X = 40; // Posición para la primera columna
    const column2X = 135; // Posición para la segunda columna
    let yOffset = 6;

    //  Dividimos la información en dos columnas
    const column1 = [];
    const column2 = [];

    section.querySelectorAll("div.mb-3").forEach((item, index) => {
        const strongText = item.querySelector("strong")?.innerText || "";
        const pText = item.querySelector("p")?.innerText || "";

        if (index % 2 === 0) {
            column1.push({ label: strongText, value: pText });
        } else {
            column2.push({ label: strongText, value: pText });
        }
    });

    //  Dibujamos ambas columnas en paralelo
    const maxRows = Math.max(column1.length, column2.length);
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
    const indentLevel1 = marginLeft + 10; // Sangría después de subtítulo
    const textWidth = 180; // Ancho máximo del texto
    doc.setTextColor(50, 50, 50);

    let currentIndent = marginLeft; // Controla la sangría actual
    let tempY = y; // Variable temporal para verificar el espacio disponible

    section.querySelectorAll("p").forEach(paragraph => {
        y = checkPageBreak(doc, y, pageHeight);
        const strongText = paragraph.querySelector("strong")?.innerText || "";
        const text = paragraph.innerText.replace(strongText, "").trim();

        //  Títulos de procedimientos (Ej: "Procedimiento de Arranque:")
        if (strongText) {
            y += 5; //  Espaciado antes de un subtítulo
            doc.setFontSize(13);
            doc.setFont("helvetica", "bold");

            tempY = y + 8; // Simulamos el espacio necesario para subtítulo + primera línea de contenido

            //  Si el subtítulo no cabe junto con al menos 2 líneas de texto, saltamos la página
            if (tempY + 12 > pageHeight) {
                doc.addPage();
                y = 20;
            }

            doc.text(strongText, marginLeft, y);
            y += 8;
        }

        if (text) {
            doc.setFontSize(12);

            //  Divide el procedimiento por líneas
            const lines = text.split(/\n+/);

            lines.forEach((line) => {
                y = checkPageBreak(doc, y, pageHeight);
                line = line.trim();

                //  Si la línea comienza con un subtítulo ("1. Algo:")
                if (/^\d+\..*?:$/.test(line)) {
                    y += 5; //  Espaciado antes de un nuevo subtítulo
                    doc.setFont("helvetica", "bold");

                    tempY = y + 12; // Simulamos espacio necesario para subtítulo y contenido

                    //  Si el subtítulo no cabe con su contenido, saltamos la página
                    if (tempY + 12 > pageHeight) {
                        doc.addPage();
                        y = 20;
                    }

                    doc.text(line, marginLeft, y);
                    y += 6;
                    currentIndent = indentLevel1; // ✅ TODO lo que sigue tendrá sangría
                } else {
                    doc.setFont("helvetica", "normal");
                    //  Aplica la sangría para TODO lo que sigue del subtítulo
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
    const centerX = (doc.internal.pageSize.width - imageWidth) / 2; // Centrar imagen

    section.querySelectorAll(".diagrama").forEach(diagrama => {
        const title = diagrama.querySelector("h4")?.innerText || "";
        const img = diagrama.querySelector("img");

        if (title) {
            //  Verificamos si tanto el título como la imagen caben en la página
            if (y + imageHeight + 15 > pageHeight) {
                doc.addPage();
                y = 20; // Reiniciamos la posición en la nueva página
            }

            y += 5; // Espacio antes del título
            doc.setFontSize(13);
            doc.setFont("helvetica", "bold");
            doc.setTextColor(50, 50, 50);
            doc.text(title, marginLeft, y);
            y += 10;
        }

        if (img) {
            //  Verificamos nuevamente por si el título quedó al final de la página
            if (y + imageHeight > pageHeight) {
                doc.addPage();
                y = 20; // Reiniciamos la posición en la nueva página
            }

            const imgData = getImageData(img);
            doc.addImage(imgData, "JPEG", centerX, y, imageWidth, imageHeight);
            y += imageHeight + 10; // Espacio después de la imagen
        }
    });

    return y;
}

// Datos de Fiabilidad
function addFiabilidad(section, doc, y, pageHeight) {
    doc.setTextColor(50, 50, 50);
    const marginLeft = 15;
    const textWidth = 180;
    
    let contentBlocks = [];
    let paragraphs = Array.from(section.querySelectorAll(".col-6 p"));

    for (let i = 0; i < paragraphs.length; i++) {
        let p = paragraphs[i];
        const strongText = p.querySelector("strong")?.innerText || "";
        const value = p.innerText.replace(strongText, "").trim();

        //  Verificar si el siguiente párrafo es una descripción
        let description = "";
        if (i + 1 < paragraphs.length && paragraphs[i + 1].classList.contains("text-muted")) {
            description = paragraphs[i + 1].innerText.trim();
            i++; // Saltamos al siguiente elemento ya que ya lo capturamos
        }

        contentBlocks.push({ title: strongText, value, description });
    }

    //  Recorremos cada bloque asegurando que no quede cortado entre páginas
    contentBlocks.forEach(({ title, value, description }) => {
        let estimatedHeight = 12; //  Espaciado base más compacto

        if (description) {
            const splitText = doc.splitTextToSize(description, textWidth);
            estimatedHeight += splitText.length * 6;
        }

        if (y + estimatedHeight > pageHeight) {
            doc.addPage();
            y = 20;
        }

        //  Subtítulo en negrita y azul
        doc.setFontSize(12);
        doc.setFont("helvetica", "bold");
        doc.text(title, marginLeft, y);

        //  Valor en la misma línea
        doc.setFont("helvetica", "normal");
        doc.text(` ${value}`, marginLeft + doc.getTextWidth(title) + 4, y);
        y += 6;

        //  Descripción alineada con saltos de línea si es necesario
        if (description) {
            const splitText = doc.splitTextToSize(description, textWidth);
            splitText.forEach(line => {
                y = checkPageBreak(doc, y, pageHeight);
                doc.text(line, marginLeft, y);
                y += 6;
            });
        }

        y += 4; //  Espacio entre bloques reducido
    });

    return y;
}

function addAnalisisFuncional(section, doc, y, pageHeight) {
    const marginLeft = 15;
    const tableColumnWidths = [50, 50, 40, 50, 60]; //  Ancho correcto para la tabla principal
    const componentColumnWidths = [80, 60, 90]; //  Ancho correcto para las tablas de componentes

    //  1️⃣ Extraer la **tabla principal**
    let headers = [];
    let tableData = [];

    const mainTable = section.querySelector("table.table-bordered");

    if (mainTable) {
        //  Extraer encabezados de la tabla principal (5 columnas)
        mainTable.querySelectorAll("thead tr th").forEach(th => {
            headers.push(th.innerText.trim());
        });

        //  Extraer datos de la tabla principal
        mainTable.querySelectorAll("tbody tr").forEach(tr => {
            let rowData = [];
            tr.querySelectorAll("td").forEach(td => {
                rowData.push(td.innerText.trim());
            });
            tableData.push(rowData);
        });

        //  Si la tabla no cabe, agregar nueva página
        if (y + tableData.length * 8 > pageHeight) {
            doc.addPage();
            y = 20;
        }

        //  Dibujar la tabla principal
        doc.autoTable({
            startY: y,
            head: [headers],
            body: tableData,
            margin: { left: marginLeft },
            theme: "grid",
            styles: { fontSize: 9 },
            columnWidths: tableColumnWidths,
            headStyles: {
                fillColor: [1, 56, 130], //  Color azul para los encabezados
                textColor: [255, 255, 255], //  Texto en blanco
                fontStyle: "bold",
                halign: "center" //  Centrar texto en encabezados
            }
        });

        y = doc.autoTable.previous.finalY + 10; //  Ajustar Y después de la tabla
    }

    //  2️⃣ Extraer y Dibujar **Tablas de Componentes**
    section.querySelectorAll(".componentes").forEach((table) => {
        let componentHeaders = [];
        let componentData = [];
        let tableTitle = ""; //  Título de la tabla de componentes

        //  Extraer el título de la tabla de componentes
        const titleRow = table.querySelector("thead tr:first-child th[colspan='3']");
        if (titleRow) {
            tableTitle = titleRow.innerText.trim();
        }

        //  Extraer encabezados de las tablas de componentes (debe ser "Nombre | Verbo | Acción")
        table.querySelectorAll("thead tr:nth-child(2) th").forEach(th => {
            componentHeaders.push(th.innerText.trim());
        });

        //  Extraer datos de las tablas de componentes
        table.querySelectorAll("tbody tr").forEach(tr => {
            let rowData = [];
            tr.querySelectorAll("td").forEach(td => {
                rowData.push(td.innerText.trim());
            });
            componentData.push(rowData);
        });

        //  Si la tabla no cabe, agregar nueva página
        if (y + componentData.length * 8 + 12 > pageHeight) {
            doc.addPage();
            y = 20;
        }

        //  Dibujar el título de la tabla (como en el HTML)
        if (tableTitle) {
            doc.setFontSize(11);
            doc.setFont("helvetica", "bold");
            doc.text(tableTitle, marginLeft, y);
            y += 8;
        }

        //  Dibujar la tabla de componentes
        doc.autoTable({
            startY: y,
            head: [componentHeaders],
            body: componentData,
            margin: { left: marginLeft },
            theme: "striped",
            styles: { fontSize: 9 },
            columnWidths: componentColumnWidths,
            headStyles: {
                fillColor: [1, 56, 130], //  Color azul para los encabezados
                textColor: [255, 255, 255], //  Texto en blanco
                fontStyle: "bold",
                halign: "center" //  Centrar texto en encabezados
            }
        });

        y = doc.autoTable.previous.finalY + 10; //  Ajuste final de posición
    });

    return y;
}

function addHerramientas(section, doc, y, pageHeight) {
    const marginLeft = 15;
    const tableColumnWidthsGenerales = [60, 40, 50, 25, 30]; // Ancho de columnas herramientas generales
    const tableColumnWidthsEspeciales = [50, 40, 50, 20, 30, 50]; // Ancho herramientas especiales

    let tables = section.querySelectorAll("table.table-bordered");

    tables.forEach((table, index) => {
        let headers = [];
        let tableData = [];

        //  Extraer encabezados de la tabla
        table.querySelectorAll("thead tr th").forEach(th => {
            headers.push(th.innerText.trim());
        });

        //  Extraer datos de la tabla
        table.querySelectorAll("tbody tr").forEach(tr => {
            let rowData = [];
            tr.querySelectorAll("td").forEach((td, columnIndex) => {
                if (columnIndex === 2) { 
                    //  Si hay imagen, agregar marcador
                    const img = td.querySelector("img");
                    rowData.push(img ? "[Dibujo]" : ""); 
                } else {
                    rowData.push(td.innerText.trim());
                }
            });
            tableData.push(rowData);
        });

        //  Título de la tabla antes de imprimirla
        const title = index === 0 ? "Herramientas Generales" : "Herramientas Especiales";

        const estimatedRowHeight = 8;
        const minRowsOnCurrentPage = 5; // Al menos 5 filas deben caber antes de hacer el salto
        
        if (y + 10 + (minRowsOnCurrentPage * estimatedRowHeight) > pageHeight) {
            doc.addPage();
            y = 20;
        }

        //  Agregar título de la tabla
        doc.setFontSize(14);
        doc.setFont("helvetica", "bold");
        doc.setTextColor(1, 56, 130);
        doc.text(title, marginLeft, y);
        y += 8;

        //  Dibujar la tabla con formato adecuado
        doc.autoTable({
            startY: y,
            head: [headers],
            body: tableData,
            margin: { left: marginLeft },
            theme: "grid",
            styles: { fontSize: 9 },
            columnWidths: index === 0 ? tableColumnWidthsGenerales : tableColumnWidthsEspeciales,
            headStyles: {
                fillColor: [1, 56, 130], 
                textColor: [255, 255, 255], 
                fontStyle: "bold",
                halign: "center"
            }
        });

        y = doc.autoTable.previous.finalY + 10;

        //  Insertar imágenes en la tabla en la posición correcta
        let rowIndex = 0;
        table.querySelectorAll("tbody tr").forEach(tr => {
            const imgCell = tr.cells[2]; //  Columna de imágenes
            const imgElement = imgCell.querySelector("img");

            if (imgElement) {
                const imgData = getImageData(imgElement);
                if (imgData) {
                    const imgX = marginLeft + tableColumnWidthsGenerales.slice(0, 2).reduce((a, b) => a + b, 0) + 5;
                    const imgY = doc.autoTable.previous.finalY - (tableData.length - rowIndex) * 8;

                    doc.addImage(imgData, "JPEG", imgX, imgY, 20, 20);
                }
            }
            rowIndex++;
        });
    });

    return y;
}

function addRepuesto(section, doc, y, pageHeight) {
    const marginLeft = 15;
    const tableColumnWidths = [50, 30, 40, 30, 40, 60]; //  Ancho de columnas

    //  1️⃣ Extraer la tabla de repuestos
    let headers = [];
    let tableData = [];

    const mainTable = section.querySelector("table.table-bordered");

    if (mainTable) {
        //  Extraer encabezados de la tabla
        mainTable.querySelectorAll("thead tr th").forEach(th => {
            headers.push(th.innerText.trim());
        });

        //  Extraer datos de la tabla
        mainTable.querySelectorAll("tbody tr").forEach(tr => {
            let rowData = [];
            tr.querySelectorAll("td").forEach((td, index) => {
                if (index === 2) { 
                    //  Si hay imagen, agregar un marcador
                    const img = td.querySelector("img");
                    rowData.push(img ? "[Dibujo]" : ""); 
                } else {
                    rowData.push(td.innerText.trim());
                }
            });
            tableData.push(rowData);
        });

        //  Verificar si hay espacio suficiente para la tabla, si no, hacer un salto de página
        const estimatedRowHeight = 8;
        const minRowsOnCurrentPage = 5; // Al menos 5 filas deben caber antes de hacer el salto
        if (y + 10 + (minRowsOnCurrentPage * estimatedRowHeight) > pageHeight) {
            doc.addPage();
            y = 20;
        }

        //  Dibujar la tabla con color en encabezados
        doc.autoTable({
            startY: y,
            head: [headers],
            body: tableData,
            margin: { left: marginLeft },
            theme: "grid",
            styles: { fontSize: 9 },
            columnWidths: tableColumnWidths,
            headStyles: {
                fillColor: [1, 56, 130], //  Color azul para los encabezados
                textColor: [255, 255, 255], //  Texto en blanco
                fontStyle: "bold",
                halign: "center" //  Centrar texto en encabezados
            }
        });

        y = doc.autoTable.previous.finalY + 10; //  Ajustar Y después de la tabla

        //  2️⃣ Insertar imágenes en la tabla en la posición correcta
        let rowIndex = 0;
        mainTable.querySelectorAll("tbody tr").forEach(tr => {
            const imgCell = tr.cells[2]; //  Columna de imágenes
            const imgElement = imgCell.querySelector("img");
            
            if (imgElement) {
                const imgData = getImageData(imgElement);
                if (imgData) {
                    const imgX = marginLeft + tableColumnWidths.slice(0, 2).reduce((a, b) => a + b, 0) + 5;
                    const imgY = doc.autoTable.previous.finalY - (tableData.length - rowIndex) * 8;

                    doc.addImage(imgData, "JPEG", imgX, imgY, 20, 20); //  Insertar imagen
                }
            }
            rowIndex++;
        });
    }

    return y;
}

function addFMEA(section, doc, y, pageHeight) {
    const marginLeft = 15;

    // Nueva estructura con solo dos grupos de columnas
    const columnGroups = [
        // Primera parte: Mantiene el título y parte inicial de la tabla en la misma página
        [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],  

        // Segunda parte: Salto de página y el resto de las columnas
        [0, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25]  
    ];

    const mainTable = section.querySelector("table.table-bordered");

    if (mainTable) {
        // Extraer encabezados y datos de la tabla
        let headers = [];
        let tableData = [];
        
        mainTable.querySelectorAll("thead tr th").forEach(th => {
            headers.push(th.innerText.trim());
        });

        mainTable.querySelectorAll("tbody tr").forEach(tr => {
            let rowData = [];
            tr.querySelectorAll("td").forEach(td => {
                rowData.push(td.innerText.trim());
            });
            tableData.push(rowData);
        });

        // Generar las dos tablas con subconjuntos de columnas
        columnGroups.forEach((columns, index) => {
            // Si no es la primera parte, forzar salto de página antes de imprimir
            if (index === 1) {
                doc.addPage();
                y = 20;  // Reiniciar la posición Y en la nueva página
            }

            let subHeaders = columns.map(colIndex => headers[colIndex]);
            let subTableData = tableData.map(row => columns.map(colIndex => row[colIndex]));

            // Agregar título de cada parte
            doc.setFontSize(12);
            doc.text(`FMEA - Parte ${index + 1}`, marginLeft, y);
            y += 6;

            // Dibujar la tabla con los subconjuntos de columnas
            doc.autoTable({
                startY: y,
                head: [subHeaders],
                body: subTableData,
                margin: { left: marginLeft },
                theme: "grid",
                styles: { fontSize: 8 },
                headStyles: {
                    fillColor: [1, 56, 130], // Color azul en encabezados
                    textColor: [255, 255, 255], // Texto en blanco
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

    // Definir los grupos de columnas a mostrar en cada parte
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

        mainTable.querySelectorAll("thead tr th").forEach((th, index) => {
            let text = th.innerText.trim();
            if (text === "Patrón de falla") {
                patronFallaIndex = index;  
            }
            headers.push(text);
        });

        mainTable.querySelectorAll("tbody tr").forEach(tr => {
            let rowData = [];
            let noModoFalla = "";
            let patronFalla = null;
            let imgLabel = "No disponible";  

            tr.querySelectorAll("td").forEach((td, index) => {
                let text = td.innerText.trim();

                if (headers[index] === "No. Modo de falla (MF)") {
                    noModoFalla = text;
                }

                if (index === patronFallaIndex) {
                    let imgLink = td.querySelector("a");
                    if (imgLink && imgLink.hasAttribute("data-img")) {
                        patronFalla = imgLink.getAttribute("data-img");
                        imgLabel = `Ver en anexo\nFotos de Patrón de Falla\nImagen (${imageCounter})`;
                    }
                }

                rowData.push(index === patronFallaIndex ? imgLabel : text);
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

            let subHeaders = columns.map(colIndex => headers[colIndex]);
            let subTableData = tableData.map(row => columns.map(colIndex => row[colIndex]));

            doc.setFontSize(12);
            doc.text(`RCM - Parte ${index + 1}`, marginLeft, y);
            y += 6;

            doc.autoTable({
                startY: y,
                head: [subHeaders],
                body: subTableData,
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

        if (imagesData.length > 0) {
            doc.addPage();
            y = 20;
            doc.setFontSize(14);
            doc.setFont("helvetica", "bold");
            doc.text("10.1 Anexo Fotos de Patrón de Falla", marginLeft, y);
            y += 10;

            let imgWidth = 50;
            let imgHeight = 50;
            let imagesPerRow = 4;
            let imagesCount = 0;

            imagesData.forEach((imgData, index) => {
                let x = marginLeft + (imagesCount % imagesPerRow) * (imgWidth + 30);  
                let imgY = y + Math.floor(imagesCount / imagesPerRow) * (imgHeight + 30);  

                if (imgY + imgHeight > pageHeight - 20) {
                    doc.addPage();
                    y = 20;
                    doc.text("10.1 Anexo Fotos de Patrón de Falla", marginLeft, y);
                    imgY = y + 10;
                    imagesCount = 0;
                }

                doc.addImage(imgData.patronFalla, 'JPEG', x, imgY, imgWidth, imgHeight);

                doc.setFontSize(10);
                doc.setFont("helvetica", "normal");
                let labelText = `Imagen (${imgData.imgNumber}): Patrón de Falla\npara No. Modo de Falla (${imgData.noModoFalla})`;

                let textX = x + (imgWidth / 2);  
                doc.text(labelText, textX, imgY + imgHeight + 5, { align: "center" });

                imagesCount++;
            });

            y += Math.ceil(imagesCount / imagesPerRow) * (imgHeight + 30);
        }
    }

    return y;
}






function addMTA(section, doc, y, pageHeight) {
    const marginLeft = 15;

    // Definir los grupos de columnas a mostrar en cada parte
    const columnGroups = [
        [0, 1, 2, 3, 4, 5, 6, 7],  // Primer grupo de columnas
        [0, 8, 9, 10, 11, 12, 13, 14],  // Segundo grupo
        [0, 15, 16, 17]  // Último grupo (Nivel, Actividades, Operario)
    ];

    const mainTable = section.querySelector("table.table-bordered");

    if (mainTable) {
        // Extraer encabezados y datos de la tabla
        let headers = [];
        let tableData = [];
        
        mainTable.querySelectorAll("thead tr th").forEach(th => {
            headers.push(th.innerText.trim());
        });

        mainTable.querySelectorAll("tbody tr").forEach(tr => {
            let rowData = [];
            tr.querySelectorAll("td").forEach(td => {
                rowData.push(td.innerText.trim());
            });
            tableData.push(rowData);
        });

        // Generar múltiples tablas con distintos conjuntos de columnas
        columnGroups.forEach((columns, index) => {
            // Si no es la primera parte, forzar salto de página antes de imprimir
            if (index > 0) {
                doc.addPage();
                y = 20;  // Reiniciar la posición Y en la nueva página
            }

            let subHeaders = columns.map(colIndex => headers[colIndex]);
            let subTableData = tableData.map(row => columns.map(colIndex => row[colIndex]));

            // Agregar título de cada parte
            doc.setFontSize(12);
            doc.text(`MTA - Parte ${index + 1}`, marginLeft, y);
            y += 6;

            // Dibujar la tabla con los subconjuntos de columnas
            doc.autoTable({
                startY: y,
                head: [subHeaders],
                body: subTableData,
                margin: { left: marginLeft },
                theme: "grid",
                styles: { fontSize: 8 },
                headStyles: {
                    fillColor: [1, 56, 130], // Color azul en encabezados
                    textColor: [255, 255, 255], // Texto en blanco
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
