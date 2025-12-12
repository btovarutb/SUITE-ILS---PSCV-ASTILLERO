async function addCoverPage() {
  const section1 = document.getElementById("section1");
  let nombre = "Desconocido";

  if (section1) {
    const labels = section1.querySelectorAll("label");
    labels.forEach(label => {
      if (label.textContent.trim().includes("Nombre de equipo")) {
        const span = label.parentElement.querySelector("span.vista");
        if (span && span.textContent.trim()) {
          nombre = span.textContent.trim();
        }
      }
    });
  }

  const marca = document.getElementById("botonPDF")?.getAttribute("data-marca-equipo") || "N/A";
  const modelo = document.getElementById("botonPDF")?.getAttribute("data-modelo-equipo") || "N/A";

  // Cargar imagen y convertirla a base64
  const image = new Image();
  image.src = "/static/img/portada.png";
  await new Promise((resolve) => (image.onload = resolve));
  const imageData = getImageData(image);

  // Contenido de la portada (texto sobre imagen)
  const content = [
  {
    stack: [
      {
        text: 'INFORME DE ANÁLISIS',
        fontSize: 24,
        bold: true,
        color: '#004AAD',
        margin: [0, 0, 0, 2]
      },
      {
        text: 'DE SOPORTE LOGÍSTICO (LSA)',
        fontSize: 20,
        bold: true,
        color: '#004AAD',
        margin: [0, 0, 0, 20]
      },
      {
        text: `Nombre de equipo: ${nombre}`,
        fontSize: 14,
        color: '#004AAD'
      },
      {
        text: `Marca: ${marca}`,
        fontSize: 14,
        color: '#004AAD'
      },
      {
        text: `Modelo: ${modelo}`,
        fontSize: 14,
        color: '#004AAD'
      }
    ],
    absolutePosition: { x: 50, y: 526 } // ⬅️ Ajusta aquí para bajar todo el bloque
  },
  { text: '', pageBreak: 'after' }
];


  // Imagen para el background
  const images = {
    portadaImage: imageData
  };

    // 👇 Background solo en la primera página
    const background = function(currentPage, pageSize) {
        if (currentPage === 1) {
            return {
            image: 'portadaImage',
            width: pageSize.width,
            height: pageSize.height
            };
        }
    };


  return { content, images, background };
}





function loadImageAsBase64(url) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.crossOrigin = "Anonymous";
        img.onload = function () {
            const canvas = document.createElement("canvas");
            canvas.width = img.width;
            canvas.height = img.height;
            const ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0);
            resolve(canvas.toDataURL("image/png"));
        };
        img.onerror = function (e) {
            reject(e);
        };
        img.src = url;
    });
}

// Utilidad: convertir docDefinition en Blob usando getBlob
function createPdfBlob(docDefinition) {
    return new Promise((resolve, reject) => {
        try {
            pdfMake.createPdf(docDefinition).getBlob((blob) => {
                resolve(blob);
            });
        } catch (err) {
            reject(err);
        }
    });
}

async function generatePDF(className, seccionesPermitidas = []) {
  const portada = await addCoverPage(); // contiene content, images, background

  // Cargar fondo general para todas las páginas excepto portada
  const backgroundImg = await loadImageAsBase64("/static/img/BackgroundPDF.png");
  portada.images.backgroundGeneral = backgroundImg;

  const content = [...portada.content];

  const sections = document.querySelectorAll(`.${className}`);

  // Filtrar y mantener solo secciones permitidas
  const seccionesValidas = Array.from(sections).filter(section =>
    seccionesPermitidas.includes(section.id)
  );

  for (let i = 0; i < seccionesValidas.length; i++) {
    const section = seccionesValidas[i];
    const sectionId = section.id;

    switch (sectionId) {
      case "section1":
        content.push(...addGeneralidades(section));
        break;
      case "section2":
        content.push(...addDetallesEquipo(section));
        break;
      case "section3":
        content.push(...addProcedimientos(section));
        break;
      case "section4":
        content.push(...addEsquematicas(section));
        break;
      case "section5":
        content.push(...addFiabilidad(section));
        break;
    }

    // Agregar salto de página solo si no es la última sección
    if (i < seccionesValidas.length - 1) {
      content.push({ text: '', pageBreak: 'after' });
    }
  }

  const docDefinition = {
    pageSize: 'LETTER',
    pageMargins: [40, 60, 40, 60],
    defaultStyle: {
      font: 'Inter',
      fontSize: 11
    },
    styles: {
      titulo: {
        fontSize: 16,
        bold: true,
        color: '#1E47A4',
        margin: [0, 0, 0, 10]
      },
      sectionTitle: {
        fontSize: 14,
        bold: true,
        color: '#323232',
        margin: [0, 10, 0, 10]
      },
      subSectionTitle: {
        fontSize: 12,
        bold: true,
        color: '#323232',
        margin: [0, 10, 0, 5]
      }
    },
    content,
    images: portada.images,
    background: function(currentPage, pageSize) {
      if (currentPage === 1) {
        return portada.background?.(currentPage, pageSize);
      }
      return {
        image: 'backgroundGeneral',
        width: pageSize.width,
        height: pageSize.height
      };
    }
  };

  return await createPdfBlob(docDefinition);
}


async function generateSpecialPDF(className, seccionesPermitidas = []) {
  const content = [];

  const sections = document.querySelectorAll(`.${className}`);
  for (const section of sections) {
    const sectionId = section.id || "";
    const sectionNumber = parseInt(sectionId.replace("section", ""), 10);

    if (
      isNaN(sectionNumber) ||
      sectionNumber < 6 ||
      sectionNumber > 11 ||
      !seccionesPermitidas.includes(sectionId)
    ) {
      continue;
    }

    switch (sectionId) {
      case "section6":
        content.push(...addAnalisisFuncional(section));
        break;
      case "section7":
        content.push(...addHerramientas(section));
        break;
      case "section8":
        content.push(...addRepuesto(section));
        break;
      case "section9":
        content.push(...addFMEA(section));
        break;
      case "section10":
        content.push(...addRCM(section));
        break;
      case "section11":
        content.push(...addMTA(section));
        break;
      default:
        console.log(`[DEBUG] Sección ${sectionId} no tiene función asignada.`);
    }

    content.push({ text: '', pageBreak: 'after' });
  }

  const docDefinition = {
    pageSize: 'LETTER',
    pageOrientation: 'landscape',
    pageMargins: [40, 60, 40, 60],
    defaultStyle: {
      font: 'Inter',
      fontSize: 10
    },
    styles: {
        titulo: {
            fontSize: 14,
            bold: true,
            color: '#1E47A4',
            margin: [0, 0, 0, 10]
        },
        subTitulo: {
            fontSize: 12,
            bold: true,
            margin: [0, 10, 0, 5],
            color: '#003366'
        },
        tableHeader: {
            fillColor: '#1E47A4',
            color: '#ffffff',
            bold: true,
            fontSize: 9,
            alignment: 'center',
            margin: [2, 2, 2, 2]
        },
        sectionTitle: {
            fontSize: 14,
            bold: true,
            color: '#1E47A4',
            margin: [0, 10, 0, 10]
        },
        subSectionTitle: {
            fontSize: 12,
            bold: true,
            color: '#1E47A4',
            margin: [0, 10, 0, 5]
        }
    },
    content
  };

  return await createPdfBlob(docDefinition);
}


function addGeneralidades(section) {
  const content = [];

  const marginLeft = 15;
  const labelWidth = 160;
  const imageWidth = 220;

  content.push({
    text: "1. Generalidades",
    style: 'sectionTitle',
    margin: [marginLeft, 0, 0, 10]
  });

  // 🖼️ Imagen
  const img = section.querySelector("#preview-imagen-equipo");
  if (img) {
    const imgData = getImageData(img);
    if (imgData) {
      content.push({
        image: imgData,
        width: imageWidth,
        alignment: 'center',
        margin: [0, 0, 0, 15]
      });
    }
  }

  // 📋 Datos principales
  const campos = section.querySelectorAll(".col-md-6 .mb-1");
  campos.forEach(item => {
    const labelEl = item.querySelector("label strong, label");
    const valueEl = item.querySelector("span.vista");

    if (!labelEl || !valueEl) return;

    const label = labelEl.textContent.trim();
    let value = valueEl.textContent.trim();
    if (!label || !value) return;

    // 🔍 Añadir código si es un campo jerárquico
    if (label.includes("Grupo constructivo")) {
      value = appendCodigoDesdeSelect("grupo_constructivo", value);
    } else if (label.includes("Subgrupo constructivo")) {
      value = appendCodigoDesdeSelect("subgrupo_constructivo", value);
    } else if (label.includes("Sistema")) {
      value = appendCodigoDesdeSelect("sistema", value);
    } else if (label.includes("Subsistema")) {
      value = appendCodigoDesdeSelect("subsistema", value);
    }

    content.push({
      columns: [
        {
          text: label,
          width: labelWidth,
          bold: true,
          margin: [marginLeft, 0, 0, 4],
          color: '#323232'
        },
        {
          text: value,
          width: '*',
          margin: [0, 0, 0, 2]
        }
      ],
      columnGap: 10
    });
  });

  // 📄 Descripción
  const descripcionContainer = section.querySelector("#descripcionEquipo");
  const descripcion = descripcionContainer?.querySelector("p")?.textContent?.trim();
  if (descripcion) {
    content.push({
      text: "Descripción del Equipo:",
      style: 'subSectionTitle',
      margin: [marginLeft, 10, 0, 5]
    });

    content.push({
      text: descripcion,
      alignment: 'justify',
      fontSize: 11,
      margin: [marginLeft, 0, 15, 10]
    });
  }

  return content;
}

// Función auxiliar para obtener el código del <select> correspondiente
function appendCodigoDesdeSelect(selectId, textoActual) {
  const select = document.getElementById(selectId);
  const selectedOption = select?.selectedOptions[0];
  if (!selectedOption) return textoActual;

  const fullText = selectedOption.textContent.trim(); // e.g. "311 - Generación de energía eléctrica"
  const match = fullText.match(/^(\d{2,5})\s*-\s*/); // Captura "311"
  if (match) {
    const codigo = match[1];
    return `${textoActual} (${codigo})`;
  }

  return textoActual;
}


function addDetallesEquipo(section) {
  const content = [];

  const marginLeft = 15;
  const labelStyle = {
    fontSize: 11,
    bold: true,
    color: '#323232',
    margin: [0, 0, 0, 2]
  };

  const valueStyle = {
    fontSize: 11,
    color: '#000000'
  };

  // 🏷️ 1️⃣ Título
  content.push({
    text: "2. Detalles del Equipo",
    style: "sectionTitle",
    margin: [marginLeft, 0, 0, 12]
  });

  // 🧾 2️⃣ Recolectar campos
  const items = Array.from(section.querySelectorAll("div.mb-3"));
  const rows = [];

  for (let i = 0; i < items.length; i += 2) {
    const row = [];

    for (let j = 0; j < 2; j++) {
      const item = items[i + j];
      if (!item) {
        row.push({ text: "" });
        continue;
      }

      const labelEl = item.querySelector("label");
      const valueEl = item.querySelector("input, select, textarea");

      const label = labelEl?.innerText?.trim() || "";
      const value = valueEl?.tagName === "SELECT"
        ? valueEl.options[valueEl.selectedIndex]?.text?.trim() || ""
        : valueEl?.value?.trim() || "";

      if (!label && !value) {
        row.push({ text: "" });
        continue;
      }

      // Envolver en tabla de una celda
        row.push({
        table: {
            widths: ['*'],
            body: [[{
            stack: [
                { text: label, ...labelStyle },
                { text: value, ...valueStyle }
            ],
            margin: [5, 1, 5, 1]
            }]]
        },
        layout: {
            hLineWidth: () => 0.4,
            vLineWidth: () => 0.4,
            hLineColor: () => '#CCCCCC',
            vLineColor: () => '#CCCCCC'
        },
        width: '50%',
        unbreakable: true
        });
    }

    content.push({
      columns: row,
      columnGap: 20,
      margin: [marginLeft, 0, 0, 5]
    });
  }

  return content;
}


function addProcedimientos(section) {
  const content = [];

  // 🏷️ Título general de la sección
  content.push({
    text: "3. Procedimientos",
    style: "sectionTitle",
    margin: [15, 0, 0, 10]
  });

  // 🔄 Recorrer "Procedimiento de Arranque" y "Parada"
  section.querySelectorAll("p strong").forEach(parrafoTitulo => {
    const labelTitulo = parrafoTitulo.textContent?.trim();
    const container = parrafoTitulo.parentElement.nextElementSibling;

    if (!labelTitulo || !container?.id?.endsWith("-container")) return;

    // 🧩 Subtítulo principal (Ej: "Procedimiento de Arranque:")
    content.push({
      text: labelTitulo,
      fontSize: 11,
      bold: true,
      margin: [15, 10, 0, 5],
      color: '#323232'
    });

    // 🔍 Para cada bloque-procedimiento dentro de este contenedor
    container.querySelectorAll('.bloque-procedimiento').forEach(bloque => {
      const tituloSeccion = bloque.querySelector('.titulo-seccion')?.textContent?.trim();
      if (!tituloSeccion) return;

      // 📌 Subtítulo de la sección (Ej: "Arranque del motor:")
      content.push({
        text: tituloSeccion,
        margin: [20, 6, 0, 2],
        bold: true,
        fontSize: 10,
        color: '#0d6efd'
      });

      // 📋 Lista de pasos en esa sección
      const pasos = bloque.querySelectorAll('.input-paso');
      pasos.forEach((paso, index) => {
        const textoPaso = paso.textContent?.trim();
        if (!textoPaso) return;

        content.push({
          text: [
            { text: `${index + 1}. `, bold: true, color: '#323232' },
            { text: textoPaso }
          ],
          margin: [30, 0, 0, 4],
          fontSize: 10
        });
      });
    });
  });

  content.push({ text: '' }); // Espacio final opcional
  return content;
}


// Representaciones Esquemáticas
function addEsquematicas(section) {
  const content = [];

  // 🏷️ Título principal
  content.push({
    text: "4. Representaciones Esquemáticas",
    style: "sectionTitle",
    margin: [15, 0, 0, 10]
  });

  // 📦 Diagramas: Flujo, Caja Negra, Caja Transparente
  section.querySelectorAll(".diagrama").forEach(diagrama => {
    const title = diagrama.querySelector("h4")?.innerText || "";
    const imgEl = diagrama.querySelector("img");

    if (!imgEl) return;

    const imgData = getImageData(imgEl);
    if (!imgData) return;

    // Subtítulo del tipo de diagrama
    if (title) {
      content.push({
        text: title,
        bold: true,
        fontSize: 11,
        margin: [15, 10, 0, 5],
        color: '#323232'
      });
    }

    // Imagen centrada
    content.push({
      image: imgData,
      width: 300,
      alignment: "center",
      margin: [0, 0, 0, 10]
    });
  });

  content.push({ text: "" });
  return content;
}

// Datos de Fiabilidad
function addFiabilidad(section) {
  const content = [];
  const textWidth = 450;
  const marginLeft = 15;

  // 1️⃣ Título de sección
  content.push({
    text: "5. Datos de Fiabilidad",
    style: "sectionTitle",
    margin: [marginLeft, 0, 0, 10]
  });

  // 2️⃣ Recolectar bloques de contenido
  const paragraphs = Array.from(section.querySelectorAll(".col-6 p"));
  const bloques = [];

  for (let i = 0; i < paragraphs.length; i++) {
    const p = paragraphs[i];
    const strongText = p.querySelector("strong")?.innerText || "";
    const value = p.innerText.replace(strongText, "").trim();

    let description = "";
    if (i + 1 < paragraphs.length && paragraphs[i + 1].classList.contains("text-muted")) {
      description = paragraphs[i + 1].innerText.trim();
      i++;
    }

    bloques.push({ title: strongText, value, description });
  }

  // 3️⃣ Agregar al contenido con espaciado adecuado
  bloques.forEach(({ title, value, description }) => {
    content.push({
      columns: [
        {
          text: title,
          bold: true,
          color: "#323232",
          margin: [marginLeft, 0, 0, 2],
          width: "auto"
        },
        {
          text: value,
          margin: [5, 0, 0, 2],
          width: "*"
        }
      ],
      columnGap: 4
    });

    if (description) {
      content.push({
        text: description,
        margin: [marginLeft, 0, 0, 10],
        fontSize: 11,
        alignment: 'justify'
      });
    } else {
      content.push({ text: "", margin: [0, 0, 0, 10] });
    }
  });

  return content;
}


function addAnalisisFuncional(section) {
  const content = [];
  const marginLeft = 15;

  // 🏷️ Título de la sección
  content.push({
    text: '6. Análisis Funcional',
    style: 'sectionTitle',
    margin: [marginLeft, 0, 0, 10]
  });

  // 📊 1️⃣ Tabla principal
  const mainTable = section.querySelector("table.table-bordered:not(.componentes)");
  if (mainTable) {
    const headers = [];
    const tableData = [];

    const headerRow = mainTable.querySelector("thead tr:last-child");
    if (headerRow) {
      headerRow.querySelectorAll("th").forEach(th => {
        headers.push({ text: th.innerText.trim(), style: 'tableHeader' });
      });
    }

    mainTable.querySelectorAll("tbody tr").forEach(tr => {
      const row = Array.from(tr.querySelectorAll("td")).map(td => ({
        text: td.innerText.trim(),
        margin: [2, 2, 2, 2],
        fontSize: 9
      }));
      tableData.push(row);
    });

    if (headers.length && tableData.length) {
      content.push({ text: '' }); // 🧾 Página nueva antes de la tabla principal
      content.push({
        table: {
          headerRows: 1,
          widths: ['*', '*', '*', '*', '*'],
          body: [headers, ...tableData]
        },
        layout: {
          hLineWidth: () => 0.5,
          vLineWidth: () => 0.5,
          hLineColor: () => '#cccccc',
          vLineColor: () => '#cccccc',
          paddingLeft: () => 4,
          paddingRight: () => 4,
          paddingTop: () => 3,
          paddingBottom: () => 3
        },
        margin: [marginLeft, 0, 0, 10]
      });
    }
  }

  // 🧩 2️⃣ Tablas de componentes
  const componentesTables = section.querySelectorAll("table.componentes");
  componentesTables.forEach(table => {
    const componentHeaders = [];
    const componentData = [];

    const titleCell = table.querySelector("thead tr:first-child th[colspan]");
    const tableTitle = titleCell?.innerText.trim();

    let headerRow = table.querySelector("thead tr:nth-child(2)");
    if (!headerRow || headerRow.querySelectorAll("th").length < 2) {
      headerRow = table.querySelector("thead tr:last-child");
    }

    if (headerRow) {
      headerRow.querySelectorAll("th").forEach(th => {
        componentHeaders.push({ text: th.innerText.trim(), style: 'tableHeader' });
      });
    }

    table.querySelectorAll("tbody tr").forEach(tr => {
      const row = Array.from(tr.querySelectorAll("td")).map(td => ({
        text: td.innerText.trim(),
        margin: [2, 2, 2, 2],
        fontSize: 9
      }));
      componentData.push(row);
    });

    if (componentData.length > 0) {
      content.push({ text: '', pageBreak: 'before' }); // 📄 Página nueva antes de cada tabla de componentes

      if (tableTitle) {
        content.push({
          text: tableTitle,
          style: 'subSectionTitle',
          margin: [marginLeft, 10, 0, 6]
        });
      }

      content.push({
        table: {
          headerRows: 1,
          widths: ['*', '*', '*'],
          body: [componentHeaders, ...componentData]
        },
        layout: {
          hLineWidth: () => 0.5,
          vLineWidth: () => 0.5,
          hLineColor: () => '#cccccc',
          vLineColor: () => '#cccccc',
          paddingLeft: () => 4,
          paddingRight: () => 4,
          paddingTop: () => 3,
          paddingBottom: () => 3
        },
        margin: [marginLeft, 0, 0, 10]
      });
    }
  });

  return content;
}

function addHerramientas(section) {
  const marginLeft = 15;
  const generalTable = section.querySelector("#tab-generales table");
  const specialTable = section.querySelector("#tab-especiales table");

  const result = [];

  // 🔷 Título fijo (sin salto de página)
  result.push({
    text: '7. Herramientas',
    style: 'sectionTitle',
    margin: [marginLeft, 0, 0, 10]
  });

  const imagesData = [];
  let imageCounter = 1;

  const procesarTabla = (table, title, columnasEsperadas) => {
    if (!table) return;

    const headers = Array.from(table.querySelectorAll("thead th")).map(th => th.innerText.trim());
    const rows = [];

    table.querySelectorAll("tbody tr").forEach(tr => {
      const tds = Array.from(tr.querySelectorAll("td"));
      const row = [];

      tds.forEach((td, i) => {
        if (i === 2) { // columna de imagen
          const imgElement = td.querySelector("[data-img]");
          if (imgElement) {
            const imgData = imgElement.getAttribute("data-img");
            if (imgData) {
              imagesData.push({
                imgNumber: imageCounter,
                herramienta: tds[0]?.innerText?.trim() || "",
                imgData
              });
              row.push(`Ver en anexo\nImagen (${imageCounter})`);
              imageCounter++;
            } else {
              row.push("Sin imagen");
            }
          } else {
            row.push("Sin imagen");
          }
        } else {
          row.push(td.innerText.trim());
        }
      });

      while (row.length < columnasEsperadas) row.push("");
      rows.push(row);
    });

    result.push({
      text: title,
      style: 'subTitulo',
      margin: [marginLeft, 10, 0, 6],
      pageBreak: result.length > 1 ? 'before' : undefined // solo si ya hay contenido
    });

    result.push({
      table: {
        headerRows: 1,
        widths: Array(headers.length).fill('*'),
        body: [
          headers.map(h => ({ text: h, style: 'tableHeader' })),
          ...rows
        ]
      },
      layout: {
        fillColor: (rowIndex) => rowIndex === 0 ? '#1E47A4' : null,
        hLineColor: '#ccc',
        vLineColor: '#ccc',
        paddingLeft: () => 6,
        paddingRight: () => 6,
        paddingTop: () => 4,
        paddingBottom: () => 4
      },
      fontSize: 9,
      margin: [marginLeft, 0, 15, 10]
    });
  };

  // 🔧 Herramientas Generales
  procesarTabla(generalTable, "Herramientas Generales", 5);

  // 🛠️ Herramientas Especiales
  procesarTabla(specialTable, "Herramientas Especiales", 6);

  // 🖼️ 7.1 Anexo
  if (imagesData.length > 0) {
    result.push({
      text: '7.1 Anexo Dibujos de Sección Transversal',
      style: 'subTitulo',
      margin: [marginLeft, 10, 0, 10]
    });

    const imgWidth = 300;
    const imgHeight = 220;
    const imagesPerPage = 4;
    const imagesPerRow = 2;

    for (let i = 0; i < imagesData.length; i += imagesPerPage) {
      const pageGroup = imagesData.slice(i, i + imagesPerPage);

      for (let j = 0; j < pageGroup.length; j += imagesPerRow) {
        const rowGroup = pageGroup.slice(j, j + imagesPerRow).map(({ imgData, herramienta, imgNumber }) => {
          return {
            stack: [
              {
                image: imgData,
                width: imgWidth,
                height: imgHeight,
                alignment: 'center',
                margin: [0, 0, 0, 5]
              },
              {
                text: `Imagen (${imgNumber}): ${herramienta}`,
                fontSize: 9,
                alignment: 'center'
              }
            ],
            margin: [5, 5, 5, 5]
          };
        });

        result.push({
          columns: rowGroup,
          columnGap: 10,
          margin: [marginLeft, 0, 0, 10]
        });
      }

      // 🔁 Salto de página tras cada grupo de 4
      if (i + imagesPerPage < imagesData.length) {
        result.push({ text: '', pageBreak: 'after' });
      }
    }
  }

  return result;
}


function addRepuesto(section) {
  const marginLeft = 15;
  const result = [];

  // 🟦 Título de sección
  result.push({
    text: '8. Repuestos',
    style: 'sectionTitle',
    margin: [marginLeft, 0, 0, 10]
  });

  const table = section.querySelector("table.table-bordered");
  if (!table) return result;

  const headers = Array.from(table.querySelectorAll("thead th")).map(th => th.innerText.trim());
  const bodyRows = [];

  // Procesar filas
  table.querySelectorAll("tbody tr").forEach(tr => {
    const row = [];
    const tds = Array.from(tr.querySelectorAll("td"));

    tds.forEach((td, i) => {
      if (i === 2) {
        const hasImage = td.querySelector("img");
        row.push(hasImage ? "[Dibujo]" : "");
      } else {
        row.push(td.innerText.trim());
      }
    });

    // Rellenar si faltan celdas (seguridad)
    while (row.length < headers.length) row.push("");
    bodyRows.push(row);
  });

  // 🧾 Tabla renderizada
  result.push({
    table: {
      headerRows: 1,
      widths: Array(headers.length).fill('*'),
      body: [
        headers.map(h => ({ text: h, style: 'tableHeader' })),
        ...bodyRows
      ]
    },
    layout: {
      fillColor: (rowIndex) => rowIndex === 0 ? '#1E47A4' : null,
      hLineColor: '#ccc',
      vLineColor: '#ccc',
      paddingLeft: () => 6,
      paddingRight: () => 6,
      paddingTop: () => 4,
      paddingBottom: () => 4
    },
    fontSize: 9,
    margin: [marginLeft, 0, 15, 10]
  });

  return result;
}


function addFMEA(section, colsPerPart = 9) {
  const marginLeft = 15;
  const result = [];

  const titulo = "9. Análisis de Modos y Efectos de Falla (FMEA)";
  result.push({
    text: titulo,
    style: 'sectionTitle',
    margin: [marginLeft, 0, 0, 10]
  });

  const mainTable = section.querySelector("table.table-bordered");
  if (!mainTable) return result;

  // Encabezados y filas desde el DOM
  const headers = Array.from(mainTable.querySelectorAll("thead th")).map(th => th.innerText.trim());
  const rows = Array.from(mainTable.querySelectorAll("tbody tr")).map(tr =>
    Array.from(tr.querySelectorAll("td")).map(td => td.innerText.trim())
  );

  // ---- División automática de columnas en partes seguras ----
  const indices = headers.map((_, i) => i);
  const columnGroups = [];
  for (let i = 0; i < indices.length; i += colsPerPart) {
    columnGroups.push(indices.slice(i, i + colsPerPart));
  }

  columnGroups.forEach((columns, index) => {
    const subHeaders = columns.map(i => headers[i]);
    const subBody = rows.map(row => columns.map(i => row[i]));

    result.push({
      text: `FMEA - Parte ${index + 1}`,
      style: 'subTitulo',
      margin: [marginLeft, 0, 0, 6],
      pageBreak: index > 0 ? 'before' : undefined
    });

    // Celdas con wrap para no desbordar y tamaño pequeño para caber mejor
    const headerRow = subHeaders.map(h => ({ text: h, style: 'tableHeader', noWrap: false }));
    const bodyRows = subBody.map(r => r.map(v => ({ text: v ?? '', fontSize: 8, noWrap: false })));

    result.push({
      table: {
        headerRows: 1,
        // '*' reparte ancho disponible; al reducir columnas ya no se “sale” de la página
        widths: Array(subHeaders.length).fill('*'),
        body: [headerRow, ...bodyRows],
        // Evita que una fila quede partida entre páginas
        dontBreakRows: true,
        // Si no cabe la fila con el header, pasa todo a la siguiente página
        keepWithHeaderRows: 1
      },
      layout: {
        fillColor: (rowIndex) => rowIndex === 0 ? '#1E47A4' : null,
        hLineColor: '#ccc',
        vLineColor: '#ccc',
        paddingLeft: () => 5,
        paddingRight: () => 5,
        paddingTop: () => 4,
        paddingBottom: () => 4
      },
      fontSize: 8,
      margin: [marginLeft, 0, 15, 10]
    });
  });

  return result;
}


function addRCM(section, colsPerPart = 8, pinned = [0]) {
  const marginLeft = 15;
  const result = [];

  const titulo = "10. Formato de Cuadro de Decisiones (RCM)";
  result.push({
    text: titulo,
    style: 'sectionTitle',
    margin: [marginLeft, 0, 0, 10]
  });

  const mainTable = section.querySelector("table.table-bordered");
  if (!mainTable) return result;

  // --- Encabezados
  const headers = Array.from(mainTable.querySelectorAll("thead th")).map(th => th.innerText.trim());

  // Buscar índice de "Patrón de falla" (robusto a variantes)
  const patronFallaIndex = headers.findIndex(h => h.toLowerCase().includes("patrón") && h.toLowerCase().includes("falla"));

  // --- Filas + captura de imágenes
  const rows = [];
  const imagesData = [];
  let imageCounter = 1;

  Array.from(mainTable.querySelectorAll("tbody tr")).forEach(tr => {
    const tds = Array.from(tr.querySelectorAll("td"));
    const row = [];
    let patronImg = null;
    let noModoFalla = "";

    tds.forEach((td, i) => {
      const text = (td.innerText || "").trim();
      if (headers[i] && headers[i].toLowerCase().includes("modo de falla")) {
        noModoFalla = text;
      }

      if (i === patronFallaIndex) {
        const imgElement = td.querySelector("[data-img]");
        if (imgElement) {
          const imgData = imgElement.getAttribute("data-img");
          if (imgData) {
            patronImg = imgData;
            row.push(`Ver en anexo\nImagen (${imageCounter})`);
          } else {
            row.push("No disponible");
          }
        } else {
          row.push("No disponible");
        }
      } else {
        row.push(text);
      }
    });

    rows.push(row);

    if (patronImg && noModoFalla) {
      imagesData.push({ imgNumber: imageCounter, noModoFalla, imgData: patronImg });
      imageCounter++;
    }
  });

  // --- Construir grupos de columnas automáticamente, repitiendo las "pinned"
  const allIdx = headers.map((_, i) => i);
  const restIdx = allIdx.filter(i => !pinned.includes(i));
  const payloadSize = Math.max(1, colsPerPart - pinned.length);

  const columnGroups = [];
  for (let i = 0; i < restIdx.length; i += payloadSize) {
    columnGroups.push([...pinned, ...restIdx.slice(i, i + payloadSize)]);
  }

  // --- Render por partes
  columnGroups.forEach((columns, index) => {
    const subHeaders = columns.map(i => headers[i]);
    const subBody = rows.map(row => columns.map(i => row[i]));

    result.push({
      text: `RCM - Parte ${index + 1}`,
      style: 'subTitulo',
      margin: [marginLeft, 10, 0, 6],
      pageBreak: index > 0 ? 'before' : undefined
    });

    const headerRow = subHeaders.map(h => ({ text: h, style: 'tableHeader', noWrap: false }));
    const bodyRows = subBody.map(r => r.map(v => ({ text: v ?? '', fontSize: 8, noWrap: false })));

    result.push({
      table: {
        headerRows: 1,
        widths: Array(subHeaders.length).fill('*'),
        body: [headerRow, ...bodyRows],
        dontBreakRows: true,
        keepWithHeaderRows: 1
      },
      layout: {
        fillColor: (rowIndex) => rowIndex === 0 ? '#1E47A4' : null,
        hLineColor: '#ccc',
        vLineColor: '#ccc',
        paddingLeft: () => 5,
        paddingRight: () => 5,
        paddingTop: () => 4,
        paddingBottom: () => 4
      },
      fontSize: 8,
      margin: [marginLeft, 0, 15, 10]
    });
  });

  // --- Anexo de imágenes (2 por fila, sin pageBreaks agresivos)
  if (imagesData.length > 0) {
    result.push({
      text: '10.1 Anexo Fotos de Patrón de Falla',
      style: 'subTitulo',
      margin: [marginLeft, 10, 0, 10]
    });

    const imgWidth = 200;
    const imgHeight = 200;
    const items = imagesData.map(({ imgData, noModoFalla, imgNumber }) => ({
      stack: [
        { image: imgData, width: imgWidth, height: imgHeight, alignment: 'center', margin: [0, 0, 0, 6] },
        { text: `Imagen (${imgNumber}): Patrón de Falla para No. Modo de Falla (${noModoFalla})`, fontSize: 9, alignment: 'center' }
      ],
      margin: [0, 0, 0, 20]
    }));

    for (let i = 0; i < items.length; i += 2) {
      result.push({
        columns: [items[i], items[i + 1] || { text: '' }],
        columnGap: 15,
        margin: [marginLeft, 0, 0, 0]
      });
    }
  }

  return result;
}


function addMTA(section) {
  const marginLeft = 15;
  const result = [];

  result.push({
    text: "11. Maintenance Task Analysis (MTA) & Level of Repair Analysis (LORA)",
    style: 'sectionTitle',
    margin: [marginLeft, 0, 0, 10],
    pageBreak: 'before'
  });

  const mainTable = section.querySelector("table.table-bordered");
  if (!mainTable) return result;

  const headers = Array.from(mainTable.querySelectorAll("thead th")).map(th => th.innerText.trim());
  const rows = Array.from(mainTable.querySelectorAll("tbody tr")).map(tr =>
    Array.from(tr.querySelectorAll("td")).map(td => td.innerText.trim())
  );

  const columnGroups = [
    [0, 1, 2, 3, 4, 5, 6, 7],
    [0, 8, 9, 10, 11, 12, 13, 14],
    [0, 15, 16, 17]
  ];

  columnGroups.forEach((columns, index) => {
    const subHeaders = columns.map(i => headers[i]);
    const subBody = rows.map(row => columns.map(i => row[i]));

    result.push({
      text: `MTA - Parte ${index + 1}`,
      style: 'subTitulo',
      margin: [marginLeft, 10, 0, 6],
      pageBreak: index > 0 ? 'before' : undefined
    });

    result.push({
      table: {
        headerRows: 1,
        widths: Array(subHeaders.length).fill('*'),
        body: [
          subHeaders.map(h => ({ text: h, style: 'tableHeader' })),
          ...subBody
        ]
      },
      layout: {
        fillColor: rowIndex => rowIndex === 0 ? '#1E47A4' : null,
        hLineColor: '#ccc',
        vLineColor: '#ccc',
        paddingLeft: () => 5,
        paddingRight: () => 5,
        paddingTop: () => 4,
        paddingBottom: () => 4
      },
      fontSize: 8,
      margin: [marginLeft, 0, 15, 10]
    });
  });

  return result;
}





/* JSPDF
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
}*/


// Combinar dos blobs PDF (portrait y landscape) en uno solo
async function combinePDFs(blob1, blob2) {
    const mergedPdf = await PDFLib.PDFDocument.create();

    // Cargar ambos documentos desde blobs
    const [pdf1, pdf2] = await Promise.all([
        PDFLib.PDFDocument.load(await blob1.arrayBuffer()),
        PDFLib.PDFDocument.load(await blob2.arrayBuffer())
    ]);

    // Importar páginas del primer PDF
    const pages1 = await mergedPdf.copyPages(pdf1, pdf1.getPageIndices());
    pages1.forEach(page => mergedPdf.addPage(page));

    // Importar páginas del segundo PDF
    const pages2 = await mergedPdf.copyPages(pdf2, pdf2.getPageIndices());
    pages2.forEach(page => mergedPdf.addPage(page));

    // Convertir a Blob final
    const mergedBytes = await mergedPdf.save();
    return new Blob([mergedBytes], { type: "application/pdf" });
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

