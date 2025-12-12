/**
 * CAD Preloader - Sistema de precarga inteligente para modelos CAD
 * Precarga modelos CAD en segundo plano cuando el usuario navega por las pestañas
 * Usa IndexedDB para cachear modelos y reducir tiempos de carga
 */

class CADPreloader {
    constructor() {
        this.db = null;
        this.dbName = 'LSA_CAD_Cache';
        this.storeName = 'cadModels';
        this.dbVersion = 1;
        this.maxCacheSize = 200 * 1024 * 1024; // 200MB máximo en caché
        this.preloadQueue = [];
        this.isPreloading = false;
        this.prefetchedModels = new Map(); // Caché en memoria para acceso ultrarrápido
        
        this.initDB();
    }

    // Inicializar IndexedDB
    async initDB() {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open(this.dbName, this.dbVersion);

            request.onerror = () => {
                console.error('❌ Error abriendo IndexedDB:', request.error);
                reject(request.error);
            };

            request.onsuccess = () => {
                this.db = request.result;
                console.log('✅ IndexedDB inicializado para caché de CAD');
                resolve(this.db);
            };

            request.onupgradeneeded = (event) => {
                const db = event.target.result;

                // Crear object store si no existe
                if (!db.objectStoreNames.contains(this.storeName)) {
                    const objectStore = db.createObjectStore(this.storeName, { keyPath: 'equipoId' });
                    objectStore.createIndex('timestamp', 'timestamp', { unique: false });
                    objectStore.createIndex('size', 'size', { unique: false });
                    console.log('✅ Object store creado para modelos CAD');
                }
            };
        });
    }

    // Precargar modelo CAD en segundo plano
    async prefetchModel(equipoId, priority = 'low') {
        console.log(`🔄 Programando precarga de modelo CAD para equipo ${equipoId}`);

        // Si ya está en memoria, no hacer nada
        if (this.prefetchedModels.has(equipoId)) {
            console.log(`✅ Modelo ${equipoId} ya está precargado en memoria`);
            return;
        }

        // Verificar si está en IndexedDB
        const cached = await this.getFromCache(equipoId);
        if (cached) {
            console.log(`✅ Modelo ${equipoId} encontrado en caché IndexedDB`);
            this.prefetchedModels.set(equipoId, cached);
            return;
        }

        // Agregar a la cola de precarga
        this.preloadQueue.push({ equipoId, priority });

        // Procesar la cola si no se está haciendo ya
        if (!this.isPreloading) {
            this.processPreloadQueue();
        }
    }

    // Procesar cola de precarga
    async processPreloadQueue() {
        if (this.preloadQueue.length === 0) {
            this.isPreloading = false;
            return;
        }

        this.isPreloading = true;

        // Ordenar por prioridad (ultra-high > high > medium > low)
        this.preloadQueue.sort((a, b) => {
            const priorities = { 'ultra-high': 10, high: 3, medium: 2, low: 1 };
            return (priorities[b.priority] || 1) - (priorities[a.priority] || 1);
        });

        const { equipoId } = this.preloadQueue.shift();

        try {
            console.log(`📥 Precargando modelo CAD en segundo plano: equipo ${equipoId}`);

            // Obtener información del modelo
            const infoResponse = await fetch(`/LSA/get-cad/${equipoId}`);
            if (!infoResponse.ok) {
                console.log(`⚠️ Equipo ${equipoId} no tiene modelo CAD`);
                this.processPreloadQueue(); // Continuar con el siguiente
                return;
            }

            const infoData = await infoResponse.json();
            if (!infoData.success) {
                console.log(`⚠️ No hay archivo CAD para equipo ${equipoId}`);
                this.processPreloadQueue();
                return;
            }

            // Descargar el archivo en segundo plano
            const fileResponse = await fetch(`/LSA/get-cad-file/${equipoId}`);
            if (!fileResponse.ok) {
                throw new Error('Error descargando archivo CAD');
            }

            const arrayBuffer = await fileResponse.arrayBuffer();
            const size = arrayBuffer.byteLength;

            console.log(`✅ Modelo CAD precargado: ${infoData.archivo.nombre} (${(size / 1024 / 1024).toFixed(2)} MB)`);

            // Guardar en caché
            const cacheData = {
                equipoId,
                nombre: infoData.archivo.nombre,
                tipo: infoData.archivo.tipo,
                data: arrayBuffer,
                size: size,
                timestamp: Date.now()
            };

            // Guardar en memoria
            this.prefetchedModels.set(equipoId, cacheData);

            // Guardar en IndexedDB (asíncrono, no bloqueante)
            this.saveToCache(cacheData).catch(err => {
                console.warn('⚠️ No se pudo guardar en IndexedDB:', err);
            });

        } catch (error) {
            console.error(`❌ Error precargando modelo ${equipoId}:`, error);
        }

        // Continuar con el siguiente después de un pequeño delay
        // Ultra-high priority: sin delay, high/medium: 500ms, low: 1000ms
        const delays = { 'ultra-high': 0, high: 200, medium: 500, low: 1000 };
        const delay = delays[this.preloadQueue[0]?.priority] || 500;
        setTimeout(() => this.processPreloadQueue(), delay);
    }

    // Obtener modelo del sistema de caché (memoria o IndexedDB)
    async getModel(equipoId) {
        // Primero buscar en memoria (más rápido)
        if (this.prefetchedModels.has(equipoId)) {
            console.log(`⚡ Modelo ${equipoId} recuperado desde caché en memoria (instantáneo)`);
            return this.prefetchedModels.get(equipoId);
        }

        // Luego buscar en IndexedDB
        const cached = await this.getFromCache(equipoId);
        if (cached) {
            console.log(`✅ Modelo ${equipoId} recuperado desde IndexedDB`);
            // Mover a memoria para próximas veces
            this.prefetchedModels.set(equipoId, cached);
            return cached;
        }

        return null;
    }

    // Guardar en IndexedDB
    async saveToCache(cacheData) {
        if (!this.db) {
            await this.initDB();
        }

        return new Promise((resolve, reject) => {
            // Verificar espacio antes de guardar
            this.cleanupOldCacheIfNeeded().then(() => {
                const transaction = this.db.transaction([this.storeName], 'readwrite');
                const objectStore = transaction.objectStore(this.storeName);
                const request = objectStore.put(cacheData);

                request.onsuccess = () => {
                    console.log(`💾 Modelo ${cacheData.equipoId} guardado en IndexedDB`);
                    resolve();
                };

                request.onerror = () => {
                    console.error('❌ Error guardando en IndexedDB:', request.error);
                    reject(request.error);
                };
            });
        });
    }

    // Obtener desde IndexedDB
    async getFromCache(equipoId) {
        if (!this.db) {
            await this.initDB();
        }

        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction([this.storeName], 'readonly');
            const objectStore = transaction.objectStore(this.storeName);
            const request = objectStore.get(equipoId);

            request.onsuccess = () => {
                resolve(request.result || null);
            };

            request.onerror = () => {
                console.error('❌ Error obteniendo desde IndexedDB:', request.error);
                reject(request.error);
            };
        });
    }

    // Limpiar caché antiguo si excede el tamaño máximo
    async cleanupOldCacheIfNeeded() {
        if (!this.db) return;

        return new Promise((resolve) => {
            const transaction = this.db.transaction([this.storeName], 'readonly');
            const objectStore = transaction.objectStore(this.storeName);
            const request = objectStore.getAll();

            request.onsuccess = () => {
                const items = request.result || [];
                const totalSize = items.reduce((sum, item) => sum + (item.size || 0), 0);

                if (totalSize > this.maxCacheSize) {
                    console.log(`🧹 Limpiando caché (${(totalSize / 1024 / 1024).toFixed(2)} MB > ${(this.maxCacheSize / 1024 / 1024).toFixed(2)} MB)`);

                    // Ordenar por timestamp (más antiguos primero)
                    items.sort((a, b) => a.timestamp - b.timestamp);

                    // Eliminar los más antiguos hasta estar por debajo del límite
                    const deleteTransaction = this.db.transaction([this.storeName], 'readwrite');
                    const deleteStore = deleteTransaction.objectStore(this.storeName);

                    let currentSize = totalSize;
                    for (const item of items) {
                        if (currentSize <= this.maxCacheSize * 0.8) break; // Dejar 80% del máximo

                        deleteStore.delete(item.equipoId);
                        currentSize -= item.size;
                        console.log(`🗑️ Eliminado del caché: equipo ${item.equipoId}`);
                    }

                    deleteTransaction.oncomplete = () => resolve();
                } else {
                    resolve();
                }
            };

            request.onerror = () => resolve(); // Continuar aunque falle
        });
    }

    // Limpiar toda la caché
    async clearAllCache() {
        if (!this.db) {
            await this.initDB();
        }

        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction([this.storeName], 'readwrite');
            const objectStore = transaction.objectStore(this.storeName);
            const request = objectStore.clear();

            request.onsuccess = () => {
                this.prefetchedModels.clear();
                console.log('✅ Caché de modelos CAD limpiada completamente');
                resolve();
            };

            request.onerror = () => {
                console.error('❌ Error limpiando caché:', request.error);
                reject(request.error);
            };
        });
    }

    // Obtener estadísticas de la caché
    async getCacheStats() {
        if (!this.db) {
            await this.initDB();
        }

        return new Promise((resolve) => {
            const transaction = this.db.transaction([this.storeName], 'readonly');
            const objectStore = transaction.objectStore(this.storeName);
            const request = objectStore.getAll();

            request.onsuccess = () => {
                const items = request.result || [];
                const totalSize = items.reduce((sum, item) => sum + (item.size || 0), 0);
                const memorySize = Array.from(this.prefetchedModels.values())
                    .reduce((sum, item) => sum + (item.size || 0), 0);

                resolve({
                    itemsInIndexedDB: items.length,
                    itemsInMemory: this.prefetchedModels.size,
                    totalSizeIndexedDB: totalSize,
                    totalSizeMemory: memorySize,
                    totalSizeIndexedDB_MB: (totalSize / 1024 / 1024).toFixed(2),
                    totalSizeMemory_MB: (memorySize / 1024 / 1024).toFixed(2),
                    maxCacheSize_MB: (this.maxCacheSize / 1024 / 1024).toFixed(2)
                });
            };

            request.onerror = () => {
                resolve({
                    error: 'No se pudieron obtener estadísticas',
                    itemsInMemory: this.prefetchedModels.size
                });
            };
        });
    }
}

// Instancia global
window.cadPreloader = new CADPreloader();

// Exponer funciones útiles globalmente
window.clearCADCache = () => window.cadPreloader.clearAllCache();
window.getCADCacheStats = () => window.cadPreloader.getCacheStats();

console.log('✅ CAD Preloader inicializado');
