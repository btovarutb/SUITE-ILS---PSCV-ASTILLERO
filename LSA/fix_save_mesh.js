// REEMPLAZAR LA FUNCIÓN saveMeshToDatabase EN cad_viewer.js
// Líneas aproximadas: 2077-2170

    // ⚡⚡ NUEVA: Guardar malla procesada en BD para evitar re-procesar STEP/IGES
    async saveMeshToDatabase(equipoId) {
        try {
            if (!this.currentModel) {
                console.warn('⚠️ No hay modelo para guardar');
                return;
            }
            
            console.log('💾 Serializando malla para guardar en BD...');
            this.showStatus('💾 Procesando malla para optimización...');
            
            // ESTRATEGIA SIMPLIFICADA: Usar toJSON() de Three.js
            // toJSON() es más confiable que GLTFExporter para modelos OCCT procesados
            console.log('🔄 Usando Three.js toJSON() para serialización...');
            
            const jsonData = this.currentModel.toJSON();
            const jsonString = JSON.stringify(jsonData);
            const jsonBlob = new TextEncoder().encode(jsonString);
            
            console.log('📦 Malla serializada como JSON:', {
                tamaño: jsonBlob.byteLength,
                tamaño_MB: (jsonBlob.byteLength / 1024 / 1024).toFixed(2) + ' MB',
                formato: 'threejs-json'
            });
            
            // Validar que el blob tiene un tamaño razonable
            if (!jsonBlob || jsonBlob.byteLength < 100) {
                console.error('❌ Malla serializada es demasiado pequeña o vacía:', jsonBlob?.byteLength, 'bytes');
                console.warn('⚠️ No se guardará malla corrupta en BD');
                return;
            }
            
            // Enviar al servidor
            this.showStatus('💾 Guardando malla optimizada en BD...');
            
            const response = await fetch(`/LSA/save-cad-mesh/${equipoId}?format=json`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: jsonBlob
            });
            
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`Error guardando malla en servidor: ${response.status} - ${errorText}`);
            }
            
            const result = await response.json();
            console.log('✅ Malla guardada en BD exitosamente:', result);
            this.showStatus('✅ Malla optimizada guardada - próximas cargas serán ultra-rápidas', 3000);
            
        } catch (error) {
            console.error('❌ Error guardando malla en BD:', error);
            console.warn('⚠️ El modelo se cargó correctamente, pero no se pudo guardar la malla optimizada');
            console.warn('💡 Próximas cargas tomarán el mismo tiempo (sin optimización de malla)');
            // No lanzar el error - es una optimización opcional
        }
    }
