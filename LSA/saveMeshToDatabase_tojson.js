    async saveMeshToDatabase(equipoId) {
        try {
            if (!this.currentModel) {
                console.warn('⚠️ No hay modelo para guardar');
                return;
            }
            
            console.log('💾 Serializando malla con toJSON() para guardar en BD...');
            this.showStatus('💾 Procesando malla para optimización...');
            
            // Serializar usando toJSON() nativo de Three.js
            const modelJSON = this.currentModel.toJSON();
            
            // Convertir a string JSON
            const jsonString = JSON.stringify(modelJSON);
            
            // Convertir a ArrayBuffer para enviar como binario
            const encoder = new TextEncoder();
            const jsonBuffer = encoder.encode(jsonString);
            
            console.log('📦 Malla serializada correctamente:', {
                tamaño: jsonBuffer.byteLength,
                tamaño_MB: (jsonBuffer.byteLength / 1024 / 1024).toFixed(2) + ' MB',
                formato: 'json',
                objetos: modelJSON.object ? 'presente' : 'ausente',
                geometrias: modelJSON.geometries?.length || 0,
                materiales: modelJSON.materials?.length || 0
            });
            
            // Validar que el JSON tiene un tamaño razonable
            if (jsonBuffer.byteLength < 100) {
                console.error('❌ Malla serializada es demasiado pequeña o vacía:', jsonBuffer.byteLength, 'bytes');
                console.warn('⚠️ No se guardará malla corrupta en BD');
                return;
            }
            
            // Enviar al servidor
            this.showStatus('💾 Guardando malla optimizada en BD...');
            
            const response = await fetch(`/LSA/save-cad-mesh/${equipoId}?format=json`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/octet-stream'
                },
                body: jsonBuffer
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
