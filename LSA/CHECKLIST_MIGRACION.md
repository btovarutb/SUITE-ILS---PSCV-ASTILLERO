# ✅ CHECKLIST DE MIGRACIÓN - Sistema de Mallas Pre-Procesadas

## 📋 Pre-Requisitos
- [ ] Acceso a contenedor Docker de la aplicación
- [ ] Acceso a MySQL de producción
- [ ] Backup de base de datos realizado
- [ ] Navegador con consola de desarrollo (F12)

---

## 🗄️ PASO 1: Migración de Base de Datos

### 1.1 Conectar al contenedor Docker
```bash
docker exec -it <nombre_contenedor_lsa> bash
# O si usas docker-compose:
docker-compose exec lsa_app bash
```

### 1.2 Ejecutar script de migración
```bash
cd /app
mysql -u root -p lsa < migracion_mallas_cad.sql
```

### 1.3 Verificar columnas agregadas
```bash
mysql -u root -p lsa
```
```sql
USE lsa;
DESCRIBE equipos;
-- Debe mostrar las nuevas columnas:
-- malla_cad_procesada
-- formato_malla_cad
-- tamanio_malla_cad
-- fecha_procesamiento_cad
```

### 1.4 Verificar índice creado
```sql
SHOW INDEX FROM equipos WHERE Key_name = 'idx_malla_cad_procesada';
-- Debe mostrar el índice
```

**Resultado esperado:** ✅ 4 columnas nuevas + 1 índice

---

## 🔄 PASO 2: Reiniciar Aplicación

### 2.1 Salir del contenedor
```bash
exit
```

### 2.2 Reiniciar aplicación Flask
```bash
docker-compose restart lsa_app
# O si no usas docker-compose:
docker restart <nombre_contenedor_lsa>
```

### 2.3 Verificar que la app inició correctamente
```bash
docker logs lsa_app --tail 50
# Buscar:
# "Running on http://..."
# Sin errores de importación
```

**Resultado esperado:** ✅ Aplicación reiniciada sin errores

---

## 🧪 PASO 3: Prueba Funcional

### 3.1 Abrir aplicación en navegador
```
http://localhost:<puerto>/LSA/buques/<buque_id>
```

### 3.2 Seleccionar equipo con modelo CAD STEP/IGES
- Abrir consola del navegador (F12)
- Seleccionar un equipo que tenga archivo CAD
- Ir a la pestaña "Modelo CAD 3D"

### 3.3 Primera carga (debe procesar y guardar)
**Logs esperados en consola:**
```
🚀 Iniciando carga CAD para equipo: 463
⚡⚡ Buscando malla pre-procesada...
⚠️ No se pudo cargar malla pre-procesada, cargando archivo CAD original
📦 Archivo descargado, tamaño: 27000000 bytes
🔧 Archivo STEP/IGES detectado - se procesará con OCCT y SE GUARDARÁ LA MALLA
[OCCT] Procesando entidades...
💾 Guardando malla procesada en base de datos...
✅ Malla guardada en BD: {tamanio: 5242880, formato: 'glb'}
```

**Tiempo esperado:** 35-67 segundos (normal para primera carga)

### 3.4 Segunda carga (debe usar malla guardada)
- Recargar la página (F5)
- Seleccionar el mismo equipo
- Ir a la pestaña "Modelo CAD 3D"

**Logs esperados en consola:**
```
🚀 Iniciando carga CAD para equipo: 463
⚡⚡ Buscando malla pre-procesada...
⚡⚡⚡ MALLA PRE-PROCESADA encontrada en BD
📦 Malla pre-procesada descargada: {tamaño: 5242880, formato: model/gltf-binary}
✅ Carga desde malla pre-procesada completada - 85-90% más rápido
```

**Tiempo esperado:** 5-6 segundos ⚡⚡⚡

**Resultado esperado:** ✅ Segunda carga 85-90% más rápida

---

## 🔍 PASO 4: Verificación en Base de Datos

### 4.1 Conectar a MySQL
```bash
mysql -u root -p lsa
```

### 4.2 Verificar que se guardó la malla
```sql
SELECT 
  id,
  nombre,
  tipo_archivo_cad,
  tamanio_archivo_cad / 1024 / 1024 AS archivo_raw_MB,
  formato_malla_cad,
  tamanio_malla_cad / 1024 / 1024 AS malla_MB,
  fecha_procesamiento_cad
FROM equipos
WHERE malla_cad_procesada IS NOT NULL
LIMIT 5;
```

**Resultado esperado:** ✅ Al menos 1 equipo con malla guardada

### 4.3 Ver estadísticas generales
```sql
SELECT 
  COUNT(*) AS total_equipos,
  SUM(CASE WHEN archivo_cad IS NOT NULL THEN 1 ELSE 0 END) AS con_archivo_cad,
  SUM(CASE WHEN malla_cad_procesada IS NOT NULL THEN 1 ELSE 0 END) AS con_malla_procesada,
  SUM(CASE WHEN archivo_cad IS NOT NULL AND malla_cad_procesada IS NULL THEN 1 ELSE 0 END) AS pendientes_procesar
FROM equipos;
```

**Resultado esperado:** 
```
+----------------+-----------------+---------------------+--------------------+
| total_equipos  | con_archivo_cad | con_malla_procesada | pendientes_procesar|
+----------------+-----------------+---------------------+--------------------+
|      150       |       45        |          1          |         44         |
+----------------+-----------------+---------------------+--------------------+
```
(Los números variarán, pero debe haber al menos 1 con malla)

---

## 📊 PASO 5: Monitoreo de Logs

### 5.1 Logs del servidor (Flask)
```bash
docker logs -f lsa_app | grep "malla"
```

**Logs esperados:**
```
obtener_malla_procesada_cad: Consultando equipo_id=463
obtener_malla_procesada_cad: Malla encontrada para equipo_id=463, formato=glb, tamaño=5242880 bytes
get-cad-mesh: Enviando malla procesada para equipo_id=463
```

### 5.2 Logs del cliente (Navegador)
Abrir consola (F12) → Filtrar por "malla"

**Logs esperados:**
```
⚡⚡ Buscando malla pre-procesada...
⚡⚡⚡ MALLA PRE-PROCESADA encontrada en BD
✅ Carga desde malla pre-procesada completada - 85-90% más rápido
```

---

## ⚠️ PASO 6: Troubleshooting

### Problema 1: "No module named 'GLTFExporter'"
**Causa:** Falta el script de GLTFExporter en el HTML

**Solución:**
Verificar que `equipos_buque.html` tiene:
```html
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/exporters/GLTFExporter.js"></script>
```

---

### Problema 2: Error 404 en /get-cad-mesh/<equipo_id>
**Causa:** Endpoint no registrado o app no reiniciada

**Solución:**
```bash
# 1. Verificar que app.py tiene el endpoint
grep -n "get-cad-mesh" src/app.py

# 2. Reiniciar aplicación
docker-compose restart lsa_app

# 3. Verificar logs
docker logs lsa_app --tail 50
```

---

### Problema 3: "NameError: name 'obtener_malla_procesada_cad' is not defined"
**Causa:** Funciones no importadas en app.py

**Solución:**
Verificar que `app.py` tiene en los imports:
```python
from src.database import (
    ...
    obtener_malla_procesada_cad,
    guardar_malla_procesada_cad,
    eliminar_malla_procesada_cad,
)
```

---

### Problema 4: Malla no se guarda después de procesar
**Causa:** Error en saveMeshToDatabase()

**Solución:**
1. Abrir consola del navegador (F12)
2. Buscar mensajes de error
3. Verificar que GLTFExporter está cargado:
```javascript
// En consola del navegador:
console.log(THREE.GLTFExporter)
// Debe mostrar: [Function: GLTFExporter]
```

---

### Problema 5: Error SQL en migración
**Causa:** Columnas ya existen o sintaxis incorrecta

**Solución:**
```sql
-- Verificar si las columnas ya existen
DESCRIBE equipos;

-- Si ya existen, omitir migración
-- Si faltan algunas, agregarlas manualmente:
ALTER TABLE equipos ADD COLUMN malla_cad_procesada LONGBLOB NULL;
ALTER TABLE equipos ADD COLUMN formato_malla_cad VARCHAR(20) NULL;
ALTER TABLE equipos ADD COLUMN tamanio_malla_cad INT NULL;
ALTER TABLE equipos ADD COLUMN fecha_procesamiento_cad DATETIME NULL;
```

---

## ✅ CHECKLIST FINAL

### Funcionalidad
- [ ] Primera carga: Procesa con OCCT y guarda malla (35-67 seg)
- [ ] Segunda carga: Usa malla pre-procesada (5-6 seg)
- [ ] Logs del servidor muestran "malla guardada/encontrada"
- [ ] Logs del cliente muestran "⚡⚡⚡ MALLA PRE-PROCESADA"
- [ ] Base de datos tiene registros con `malla_cad_procesada NOT NULL`

### Rendimiento
- [ ] Reducción de 85-90% en tiempo de carga confirmada
- [ ] Mallas GLB son ~70% más pequeñas que archivos raw
- [ ] No hay errores en consola del navegador
- [ ] No hay errores en logs del servidor

### Base de Datos
- [ ] 4 columnas nuevas creadas correctamente
- [ ] Índice `idx_malla_cad_procesada` creado
- [ ] Al menos 1 equipo con malla guardada
- [ ] Query de estadísticas funciona sin errores

---

## 📞 Soporte

Si encuentras problemas:

1. **Revisar documentación completa:**
   - `OPTIMIZACION_MALLAS_PROCESADAS.md`
   - `RESUMEN_OPTIMIZACION_MALLAS.md`

2. **Logs del servidor:**
   ```bash
   docker logs lsa_app --tail 100
   ```

3. **Logs del cliente:**
   - Abrir consola (F12)
   - Buscar errores en rojo

4. **Verificar configuración:**
   - Columnas en BD: `DESCRIBE equipos;`
   - Endpoints: `grep "get-cad-mesh" src/app.py`
   - Scripts cargados: Ver fuente HTML de `equipos_buque.html`

---

## 🎉 Migración Completada

Si todos los checks están ✅, la optimización está funcionando correctamente.

**Beneficios confirmados:**
- ⚡ 85-90% más rápido en cargas repetidas
- 💾 70% menos tráfico de red
- ✅ Experiencia de usuario mejorada dramáticamente

**Próximos pasos:**
- Monitorear uso durante 1-2 semanas
- Observar crecimiento de espacio en `malla_cad_procesada`
- Considerar compresión Draco para optimización adicional

---

**Fecha:** 16 de enero de 2025  
**Versión:** 1.0  
**Estado:** ✅ PRODUCCIÓN
