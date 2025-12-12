-- Limpiar malla procesada del equipo 463 para forzar re-procesamiento con toJSON()
UPDATE equipo_info 
SET 
    malla_cad_procesada = NULL,
    formato_malla_cad = NULL,
    tamanio_malla_cad = NULL,
    fecha_procesamiento_cad = NULL
WHERE id = 463;

-- Verificar
SELECT id, nombre, formato_malla_cad, tamanio_malla_cad, fecha_procesamiento_cad
FROM equipo_info
WHERE id = 463;
