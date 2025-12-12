/**
 * CAD Viewer para LSA - Basado en la tecnología de flaskapp
 * Integrado con base de datos para cargar archivos CAD desde BLOB
 */

class CADViewer {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.scene = null;
        this.camera = null;
        this.renderer = null;
        this.currentModel = null;
        this.isPanning = false;
        this.lastX = 0;
        this.lastY = 0;
        this.infoTimeout = null;
        this.wireframeMode = false;
        this.occtModulePromise = null;
        
        // Control de carga asíncrona y cancelación
        this.isLoading = false;
        this.shouldCancelLoad = false;
        this.currentLoadOperation = null;
        this.loadProgress = 0;
        
        // Variables para controles profesionales
        this.modelCenter = new THREE.Vector3(0, 0, 0);
        this.modelSize = 100;
        
        this.init();
    }

    init() {
        // Verificar que el contenedor existe
        if (!this.container) {
            throw new Error('Contenedor no encontrado');
        }
        
        console.log('🚀 Inicializando CAD Viewer en contenedor:', this.container.id);
        
        // Configurar escena Three.js
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(0xf8f9fa);
        
        // Configurar cámara
        const width = this.container.clientWidth || 800;
        const height = this.container.clientHeight || 600;
        
        console.log(`📱 Dimensiones del contenedor: ${width}x${height}`);
        
        this.camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
        this.camera.position.set(50, 50, 50);
        this.camera.lookAt(0, 0, 0);
        
        // Configurar renderer
        this.renderer = new THREE.WebGLRenderer({ 
            antialias: true,
            alpha: true,
            preserveDrawingBuffer: true
        });
        this.renderer.setSize(width, height);
        this.renderer.setPixelRatio(window.devicePixelRatio);
        this.renderer.setClearColor(0xf8f9fa, 1);
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        
        // Limpiar contenedor y agregar canvas
        this.container.innerHTML = '';
        this.container.style.overflow = 'hidden';
        this.container.appendChild(this.renderer.domElement);
        
        // Asegurar que el canvas ocupe todo el espacio
        const canvas = this.renderer.domElement;
        canvas.style.width = '100%';
        canvas.style.height = '100%';
        canvas.style.display = 'block';
        
        console.log(`📱 Renderer configurado: ${width}x${height}`);
        console.log('🖼️ Canvas agregado al contenedor');
        
        // Configurar controles
        this.setupControls();
        
        // Configurar iluminación mejorada
        const ambientLight = new THREE.AmbientLight(0x404040, 0.8);
        this.scene.add(ambientLight);
        
        const directionalLight = new THREE.DirectionalLight(0xffffff, 0.6);
        directionalLight.position.set(20, 80, 20);
        directionalLight.castShadow = true;
        directionalLight.shadow.mapSize.width = 2048;
        directionalLight.shadow.mapSize.height = 2048;
        this.scene.add(directionalLight);

        // Luz inferior
        const hemiLight = new THREE.HemisphereLight(0xffffff, 0x444444, 0.6);
        this.scene.add(hemiLight);

        // Configurar eventos
        this.setupEvents();
        
        // Iniciar bucle de renderizado
        this.animate();
        
        console.log('✅ CAD Viewer inicializado correctamente');
        
        // Renderizar inmediatamente para verificar
        this.renderer.render(this.scene, this.camera);
    }

    setupControls() {
        let isMouseDown = false;
        let mouseX = 0;
        let mouseY = 0;
        let mode = null;
        
        // Variables para controles profesionales tipo APS/Inventor
        this.modelSize = 100; // Tamaño por defecto
        this.modelCenter = new THREE.Vector3(0, 0, 0); // Centro del modelo
        this.baseSensitivity = {
            orbit: 0.005,  // Más suave para rotación
            pan: 0.002,    // Más preciso para pan
            zoom: 0.05     // Zoom más controlado
        };

        this.renderer.domElement.addEventListener('mousedown', (e) => {
            if (e.button === 2) { // Clic derecho exclusivo para PAN
                this.isPanning = true;
                mode = 'pan';
                console.log('🖱️ Modo PAN activado (clic derecho)');
            } else if (e.button === 0) { // Clic izquierdo para ORBIT
                isMouseDown = true;
                mode = 'orbit';
                console.log('🔄 Modo ORBIT activado (clic izquierdo)');
            }
            mouseX = e.clientX;
            mouseY = e.clientY;
            e.preventDefault();
        });

        this.renderer.domElement.addEventListener('mouseup', () => {
            isMouseDown = false;
            this.isPanning = false;
            mode = null;
        });

        this.renderer.domElement.addEventListener('mouseleave', () => {
            isMouseDown = false;
            this.isPanning = false;
            mode = null;
        });

        this.renderer.domElement.addEventListener('mousemove', (e) => {
            if (mode === 'orbit' && isMouseDown) {
                const deltaX = e.clientX - mouseX;
                const deltaY = e.clientY - mouseY;
                
                // Sensibilidad adaptativa para orbit
                const orbitSensitivity = this.baseSensitivity.orbit * Math.max(0.5, Math.min(1.5, this.modelSize / 100));
                
                // Rotar alrededor del centro del modelo (no del origen)
                const spherical = new THREE.Spherical();
                const cameraOffset = new THREE.Vector3().copy(this.camera.position).sub(this.modelCenter);
                spherical.setFromVector3(cameraOffset);
                
                spherical.theta -= deltaX * orbitSensitivity;
                spherical.phi += deltaY * orbitSensitivity;
                spherical.phi = Math.max(0.01, Math.min(Math.PI - 0.01, spherical.phi));
                
                // Mantener distancia mínima
                spherical.radius = Math.max(this.modelSize * 0.1, spherical.radius);
                
                cameraOffset.setFromSpherical(spherical);
                this.camera.position.copy(this.modelCenter).add(cameraOffset);
                this.camera.lookAt(this.modelCenter);
                
                mouseX = e.clientX;
                mouseY = e.clientY;
                
            } else if (mode === 'pan' && this.isPanning) {
                const deltaX = e.clientX - mouseX;
                const deltaY = e.clientY - mouseY;
                
                // Pan profesional relativo a la cámara
                this.panCameraProfessional(deltaX, deltaY);
                
                mouseX = e.clientX;
                mouseY = e.clientY;
            }
        });

        this.renderer.domElement.addEventListener('wheel', (e) => {
            e.preventDefault();
            
            // Zoom adaptativo con límites inteligentes
            const zoomSensitivity = this.baseSensitivity.zoom * Math.max(0.3, Math.min(2.0, this.modelSize / 100));
            const zoomFactor = e.deltaY > 0 ? (1 + zoomSensitivity) : (1 - zoomSensitivity);
            
            // Calcular nueva posición
            const direction = new THREE.Vector3().copy(this.camera.position).sub(this.modelCenter).normalize();
            const currentDistance = this.camera.position.distanceTo(this.modelCenter);
            
            // Límites adaptativos basados en el tamaño del modelo
            const minDistance = this.modelSize * 0.05;  // Muy cerca para detalles
            const maxDistance = this.modelSize * 15;    // Lejos para vista completa
            
            const newDistance = currentDistance * zoomFactor;
            
            if (newDistance >= minDistance && newDistance <= maxDistance) {
                const newPosition = new THREE.Vector3().copy(this.modelCenter).add(direction.multiplyScalar(newDistance));
                this.camera.position.copy(newPosition);
                this.camera.lookAt(this.modelCenter);
            }
        });

        this.renderer.domElement.addEventListener('contextmenu', e => e.preventDefault());
    }
    
    // Pan profesional relativo a la orientación de la cámara (estilo APS/Inventor)
    panCameraProfessional(deltaX, deltaY) {
        const camera = this.camera;
        const distance = camera.position.distanceTo(this.modelCenter);
        
        // Sensibilidad de pan adaptativa (más precisa para modelos pequeños)
        const panSensitivity = this.baseSensitivity.pan * distance * Math.max(0.3, Math.min(1.8, this.modelSize / 100));
        
        // Obtener los vectores de la cámara en espacio mundo
        camera.updateMatrixWorld();
        
        // Vector derecho (right) de la cámara
        const right = new THREE.Vector3();
        camera.getWorldDirection(new THREE.Vector3()); // Actualizar matriz
        right.setFromMatrixColumn(camera.matrixWorld, 0); // X axis de la cámara
        right.normalize();
        
        // Vector arriba (up) de la cámara  
        const up = new THREE.Vector3();
        up.setFromMatrixColumn(camera.matrixWorld, 1); // Y axis de la cámara
        up.normalize();
        
        // Calcular desplazamiento en el plano de la pantalla
        const panOffsetX = right.clone().multiplyScalar(-deltaX * panSensitivity);
        const panOffsetY = up.clone().multiplyScalar(deltaY * panSensitivity);
        
        const totalOffset = new THREE.Vector3().add(panOffsetX).add(panOffsetY);
        
        // Mover tanto la cámara como el centro del modelo (pan verdadero)
        this.camera.position.add(totalOffset);
        this.modelCenter.add(totalOffset);
        
        // Mantener la cámara mirando al nuevo centro
        this.camera.lookAt(this.modelCenter);
        
        console.log('📐 Pan aplicado:', { 
            deltaX, 
            deltaY, 
            sensitivity: panSensitivity, 
            offset: totalOffset,
            newCenter: this.modelCenter 
        });
    }

    setupEvents() {
        window.addEventListener('resize', () => this.onWindowResize());
    }

    onWindowResize() {
        if (!this.camera || !this.renderer || !this.container) {
            console.warn('⚠️ onWindowResize: componentes no disponibles');
            return;
        }
        
        const width = this.container.clientWidth || 800;
        const height = this.container.clientHeight || 600;
        
        console.log(`🔄 Redimensionando canvas: ${width}x${height}`);
        
        this.camera.aspect = width / height;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(width, height);
        
        // Forzar renderizado después del resize
        if (this.scene && this.camera) {
            this.renderer.render(this.scene, this.camera);
        }
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        
        // Verificar que todos los componentes están disponibles
        if (this.renderer && this.scene && this.camera) {
            this.renderer.render(this.scene, this.camera);
        } else {
            console.warn('⚠️ Componentes de renderizado no disponibles');
        }
    }

    // Método principal para cargar desde base de datos (BLOB) - ASÍNCRONO
    async loadFromBlob(blobData, fileName, fileType) {
        console.log(`🔄 Cargando desde BLOB: ${fileName} (${fileType})`);
        
        // Cancelar cualquier carga anterior
        if (this.isLoading) {
            console.log('⏹️ Cancelando carga anterior...');
            this.cancelCurrentLoad();
            await this.waitForLoadComplete();
        }
        
        // Inicializar nueva carga
        this.isLoading = true;
        this.shouldCancelLoad = false;
        this.loadProgress = 0;
        
        try {
            this.showLoadingPopup(true, fileName);
            this.updateLoadProgress(10, 'Preparando datos...');
            
            // Limpiar escena completamente
            await this.clearSceneCompletely();
            
            this.updateLoadProgress(20, 'Analizando formato...');
            
            // Si ya es ArrayBuffer, usarlo directamente
            let arrayBuffer;
            if (blobData instanceof ArrayBuffer) {
                arrayBuffer = blobData;
            } else if (typeof blobData === 'string') {
                // Convertir base64 a ArrayBuffer si es necesario
                arrayBuffer = this.base64ToArrayBuffer(blobData);
            } else {
                throw new Error('Formato de datos no soportado');
            }
            
            this.updateLoadProgress(30, 'Procesando archivo...');
            
            const ext = fileType.toLowerCase() || fileName.split('.').pop().toLowerCase();
            
            // Procesar según el formato, con puntos de cancelación
            if (this.shouldCancelLoad) throw new Error('Carga cancelada');
            
            if (ext === 'stl') {
                await this.loadSTLFromBufferAsync(arrayBuffer, fileName);
            } else if (ext === 'obj') {
                await this.loadOBJFromBufferAsync(arrayBuffer, fileName);
            } else if (ext === 'gltf' || ext === 'glb') {
                await this.loadGLBFromBufferAsync(arrayBuffer, fileName);
            } else if (ext === 'step' || ext === 'stp' || ext === 'iges' || ext === 'igs') {
                await this.loadSTEPFromBufferAsync(arrayBuffer, fileName);
            } else {
                throw new Error('Formato no soportado: ' + ext);
            }
            
            if (this.shouldCancelLoad) throw new Error('Carga cancelada');
            
            this.updateLoadProgress(100, 'Completado');
            this.showStatus('✅ ' + fileName + ' cargado', 2000);
            
        } catch (error) {
            console.error('❌ Error cargando archivo:', error);
            if (error.message !== 'Carga cancelada') {
                this.showStatus('❌ ' + error.message, 3000);
            }
            throw error;
        } finally {
            this.isLoading = false;
            this.shouldCancelLoad = false;
            setTimeout(() => this.showLoadingPopup(false), 500);
        }
    }
    
    // Cancelar carga actual
    cancelCurrentLoad() {
        this.shouldCancelLoad = true;
        if (this.currentLoadOperation) {
            this.currentLoadOperation.cancel = true;
        }
    }
    
    // Esperar a que termine la carga actual
    async waitForLoadComplete() {
        while (this.isLoading) {
            await new Promise(resolve => setTimeout(resolve, 100));
        }
    }
    
    // Limpiar escena completamente
    async clearSceneCompletely() {
        console.log('🧹 Iniciando limpieza completa de la escena...');
        
        // Limpiar modelo actual
        if (this.currentModel) {
            console.log('🗑️ Removiendo modelo actual');
            this.scene.remove(this.currentModel);
            this.disposeObject(this.currentModel);
            this.currentModel = null;
        }
        
        // Limpiar TODOS los objetos de la escena excepto luces básicas
        const objectsToRemove = [];
        this.scene.traverse((child) => {
            // Mantener solo la escena principal y luces básicas
            if (child !== this.scene && 
                child.type !== 'AmbientLight' && 
                child.type !== 'DirectionalLight' && 
                child.type !== 'HemisphereLight') {
                objectsToRemove.push(child);
            }
        });
        
        console.log(`🗂️ Objetos a remover: ${objectsToRemove.length}`);
        
        // Remover cada objeto y liberar recursos
        objectsToRemove.forEach((obj, index) => {
            try {
                if (obj.parent) {
                    obj.parent.remove(obj);
                }
                this.disposeObject(obj);
                
                if (index % 50 === 0) {
                    console.log(`🔄 Limpieza progreso: ${index}/${objectsToRemove.length}`);
                }
            } catch (error) {
                console.warn('⚠️ Error removiendo objeto:', error);
            }
        });
        
        // Limpiar directamente la escena
        while (this.scene.children.length > 0) {
            const child = this.scene.children[0];
            if (child.type === 'AmbientLight' || 
                child.type === 'DirectionalLight' || 
                child.type === 'HemisphereLight') {
                break; // Conservar luces básicas
            }
            this.scene.remove(child);
            this.disposeObject(child);
        }
        
        // Forzar garbage collection del renderer
        if (this.renderer) {
            this.renderer.render(this.scene, this.camera);
            this.renderer.clear();
        }
        
        // Dar tiempo para que se procese la limpieza
        await new Promise(resolve => setTimeout(resolve, 100));
        
        console.log('✅ Escena limpiada completamente');
        console.log(`📊 Objetos restantes en escena: ${this.scene.children.length}`);
    }
    
    // Método de diagnóstico para depuración
    diagnoseViewer() {
        console.log('🔍 === DIAGNÓSTICO DEL VISOR CAD ===');
        console.log('📊 Estado del visor:', {
            isLoading: this.isLoading,
            shouldCancelLoad: this.shouldCancelLoad,
            hasCurrentModel: !!this.currentModel,
            hasRenderer: !!this.renderer,
            hasScene: !!this.scene,
            hasCamera: !!this.camera,
            containerExists: !!this.container
        });
        
        if (this.scene) {
            console.log('📦 Objetos en escena:', this.scene.children.length);
            this.scene.children.forEach((child, index) => {
                console.log(`  ${index}: ${child.type} - ${child.name || 'sin nombre'}`);
            });
        }
        
        if (this.renderer && this.renderer.domElement) {
            const canvas = this.renderer.domElement;
            const rect = canvas.getBoundingClientRect();
            console.log('🖼️ Estado del canvas:', {
                width: canvas.width,
                height: canvas.height,
                clientWidth: canvas.clientWidth,
                clientHeight: canvas.clientHeight,
                isConnected: canvas.isConnected,
                parentId: canvas.parentElement ? canvas.parentElement.id : 'sin parent',
                parentTagName: canvas.parentElement ? canvas.parentElement.tagName : 'N/A',
                rect: { width: rect.width, height: rect.height, x: rect.x, y: rect.y },
                style: {
                    width: canvas.style.width,
                    height: canvas.style.height,
                    display: canvas.style.display
                }
            });
            
            // Diagnóstico de problemas del canvas
            if (!canvas.isConnected) {
                console.error('❌ PROBLEMA: Canvas no está conectado al DOM');
                
                // Intentar encontrar el contenedor correcto
                const correctContainer = document.getElementById('visor-cad-canvas');
                if (correctContainer) {
                    console.log('🔧 Contenedor encontrado, reconectando...');
                    correctContainer.appendChild(canvas);
                    canvas.style.width = '100%';
                    canvas.style.height = '100%';
                    canvas.style.display = 'block';
                    
                    // Forzar redimensionamiento
                    const newRect = correctContainer.getBoundingClientRect();
                    if (newRect.width > 0 && newRect.height > 0) {
                        this.renderer.setSize(newRect.width, newRect.height);
                        this.camera.aspect = newRect.width / newRect.height;
                        this.camera.updateProjectionMatrix();
                        console.log('✅ Canvas reconectado automáticamente');
                    }
                }
            }
            if (canvas.width === 0 || canvas.height === 0) {
                console.error('❌ PROBLEMA: Canvas tiene dimensiones 0');
            }
            if (rect.width === 0 || rect.height === 0) {
                console.error('❌ PROBLEMA: Canvas no es visible (rect = 0)');
            }
            if (!canvas.parentElement) {
                console.error('❌ PROBLEMA: Canvas no tiene elemento padre');
            }
        }
        
        if (this.camera) {
            console.log('📷 Estado de la cámara:', {
                position: this.camera.position,
                aspect: this.camera.aspect,
                near: this.camera.near,
                far: this.camera.far
            });
        }
        
        console.log('🔚 === FIN DIAGNÓSTICO ===');
    }
    
    // Actualizar progreso de carga
    updateLoadProgress(percent, message) {
        this.loadProgress = percent;
        const progressBar = document.getElementById('cad-load-progress');
        const statusText = document.getElementById('cad-load-status');
        
        if (progressBar) {
            progressBar.style.width = percent + '%';
        }
        if (statusText) {
            statusText.textContent = message;
        }
        
        console.log(`📊 Progreso: ${percent}% - ${message}`);
    }

    // Convertir base64 a ArrayBuffer
    base64ToArrayBuffer(base64) {
        const binaryString = window.atob(base64);
        const len = binaryString.length;
        const bytes = new Uint8Array(len);
        for (let i = 0; i < len; i++) {
            bytes[i] = binaryString.charCodeAt(i);
        }
        return bytes.buffer;
    }

    // Cargar STL desde ArrayBuffer - ASÍNCRONO
    async loadSTLFromBufferAsync(arrayBuffer, fileName) {
        this.updateLoadProgress(40, 'Parseando STL...');
        
        const geometry = await this.parseSTLAsync(arrayBuffer);
        
        if (this.shouldCancelLoad) throw new Error('Carga cancelada');
        
        this.updateLoadProgress(70, 'Creando materiales...');
        
        const material = new THREE.MeshPhongMaterial({
            color: 0x607d8b,
            shininess: 30
        });
        const mesh = new THREE.Mesh(geometry, material);
        
        this.updateLoadProgress(90, 'Agregando a escena...');
        
        await this.addToSceneAsync(mesh, fileName);
    }
    
    // Cargar OBJ desde ArrayBuffer - ASÍNCRONO  
    async loadOBJFromBufferAsync(arrayBuffer, fileName) {
        this.updateLoadProgress(40, 'Parseando OBJ...');
        
        const geometry = await this.parseOBJAsync(arrayBuffer);
        
        if (this.shouldCancelLoad) throw new Error('Carga cancelada');
        
        this.updateLoadProgress(70, 'Creando materiales...');
        
        const material = new THREE.MeshPhongMaterial({
            color: 0x8bc34a,
            shininess: 30
        });
        const mesh = new THREE.Mesh(geometry, material);
        
        this.updateLoadProgress(90, 'Agregando a escena...');
        
        await this.addToSceneAsync(mesh, fileName);
    }
    
    // Cargar GLB desde ArrayBuffer - ASÍNCRONO
    async loadGLBFromBufferAsync(arrayBuffer, fileName) {
        this.updateLoadProgress(40, 'Parseando GLB...');
        
        return new Promise((resolve, reject) => {
            const loader = new THREE.GLTFLoader();
            
            // Configurar operación cancelable
            this.currentLoadOperation = { cancel: false };
            
            loader.parse(arrayBuffer, '', (gltf) => {
                if (this.shouldCancelLoad || this.currentLoadOperation.cancel) {
                    reject(new Error('Carga cancelada'));
                    return;
                }
                
                this.updateLoadProgress(80, 'Procesando geometría...');
                
                setTimeout(async () => {
                    try {
                        if (this.shouldCancelLoad) throw new Error('Carga cancelada');
                        
                        this.updateLoadProgress(90, 'Agregando a escena...');
                        await this.addToSceneAsync(gltf.scene, fileName);
                        resolve();
                    } catch (error) {
                        reject(error);
                    }
                }, 50);
            }, (error) => {
                reject(new Error('Error parseando GLB: ' + error.message));
            });
        });
    }
    
    // Cargar STEP desde ArrayBuffer - ASÍNCRONO (RESTAURADO desde backup con mejoras)
    async loadSTEPFromBufferAsync(arrayBuffer, fileName) {
        this.updateLoadProgress(40, 'Inicializando OCCT...');
        
        const occt = await this.getOCCTModule();
        
        if (this.shouldCancelLoad) throw new Error('Carga cancelada');
        
        this.updateLoadProgress(50, 'Triangulando STEP/IGES...');
        
        // Procesar STEP en chunks para archivos grandes
        const fileSize = arrayBuffer.byteLength;
        const fileSizeMB = fileSize / 1024 / 1024;
        console.log(`📊 Tamaño del archivo STEP: ${fileSizeMB.toFixed(2)} MB`);
        
        // Para archivos muy grandes (>40MB), advertir al usuario
        if (fileSizeMB > 40) {
            console.warn('⚠️ ARCHIVO MUY GRANDE: Esto puede causar bloqueos');
            this.updateLoadProgress(52, `Archivo muy grande (${fileSizeMB.toFixed(1)}MB) - puede tomar varios minutos...`);
            await new Promise(resolve => setTimeout(resolve, 2000)); // Pausa para que el usuario lea
            return await this.processVeryLargeSTEPFile(occt, arrayBuffer, fileName);
        }
        // Para archivos grandes (>20MB), usar procesamiento especial
        else if (fileSizeMB > 20) {
            console.log('📦 Archivo grande detectado, procesando con menor precisión...');
            return await this.processLargeSTEPFile(occt, arrayBuffer, fileName);
        }
        
        // Para archivos normales, usar el método directo
        return await this.processRegularSTEPFile(occt, arrayBuffer, fileName);
    }
    
    // Procesar archivo STEP regular
    async processRegularSTEPFile(occt, arrayBuffer, fileName) {
        const fileData = new Uint8Array(arrayBuffer);
        
        const params = {
            linearUnit: 'millimeter',
            linearDeflectionType: 'bounding_box_ratio',
            linearDeflection: 0.003,
            angularDeflection: 0.5
        };
        
        const ext = fileName.split('.').pop().toLowerCase();
        let result = null;
        
        console.time('occt-import');
        if (ext === 'step' || ext === 'stp') {
            result = occt.ReadStepFile(fileData, params);
        } else if (ext === 'iges' || ext === 'igs') {
            result = occt.ReadIgesFile(fileData, params);
        }
        console.timeEnd('occt-import');
        
        if (this.shouldCancelLoad) throw new Error('Carga cancelada');
        
        if (!result || !result.success) {
            console.error('OCCT import error:', result);
            throw new Error('Fallo al importar archivo CAD');
        }
        
        await this.createMeshesFromResult(result, fileName);
    }
    
    // Procesar archivo STEP grande con pausas y timeout de seguridad
    async processLargeSTEPFile(occt, arrayBuffer, fileName) {
        return new Promise(async (resolve, reject) => {
            let timeoutId = null;
            let completed = false;
            
            try {
                // Timeout de seguridad para evitar bloqueos indefinidos
                timeoutId = setTimeout(() => {
                    if (!completed) {
                        completed = true;
                        console.error('⏰ TIMEOUT: Procesamiento STEP cancelado por tiempo excedido (30s)');
                        reject(new Error('Archivo demasiado complejo. Intente con un archivo más pequeño o menos detallado.'));
                    }
                }, 30000); // 30 segundos timeout
                
                // Dar tiempo al UI para actualizar
                await new Promise(res => setTimeout(res, 100));
                
                this.updateLoadProgress(55, 'Procesando archivo grande...');
                
                const fileData = new Uint8Array(arrayBuffer);
                
                // Parámetros muy agresivos para archivos grandes
                const params = {
                    linearUnit: 'millimeter',
                    linearDeflectionType: 'bounding_box_ratio',
                    linearDeflection: 0.01, // Muy baja precisión
                    angularDeflection: 1.5  // Muy baja precisión angular
                };
                
                const ext = fileName.split('.').pop().toLowerCase();
                
                // Mostrar advertencia al usuario
                console.warn('⚠️ ARCHIVO GRANDE: Reduciendo precisión para evitar bloqueos');
                this.updateLoadProgress(58, 'Reduciendo precisión para archivo grande...');
                
                // Dar más tiempo antes del procesamiento pesado
                await new Promise(res => setTimeout(res, 200));
                
                // Usar setTimeout más largo para dar tiempo al browser
                setTimeout(async () => {
                    try {
                        if (completed) return;
                        
                        console.time('occt-import-large');
                        this.updateLoadProgress(60, 'OCCT procesando (esto puede tomar varios minutos)...');
                        
                        // Agregar verificación de cancelación antes del procesamiento pesado
                        if (this.shouldCancelLoad) {
                            completed = true;
                            clearTimeout(timeoutId);
                            reject(new Error('Carga cancelada'));
                            return;
                        }
                        
                        let result = null;
                        
                        // Intentar procesamiento con manejo de errores
                        try {
                            if (ext === 'step' || ext === 'stp') {
                                result = occt.ReadStepFile(fileData, params);
                            } else if (ext === 'iges' || ext === 'igs') {
                                result = occt.ReadIgesFile(fileData, params);
                            }
                        } catch (occtError) {
                            console.error('❌ Error OCCT interno:', occtError);
                            completed = true;
                            clearTimeout(timeoutId);
                            reject(new Error('Error procesando archivo CAD. El archivo puede estar corrupto o ser demasiado complejo.'));
                            return;
                        }
                        
                        console.timeEnd('occt-import-large');
                        
                        if (completed) return;
                        
                        if (this.shouldCancelLoad) {
                            completed = true;
                            clearTimeout(timeoutId);
                            reject(new Error('Carga cancelada'));
                            return;
                        }
                        
                        if (!result || !result.success) {
                            console.error('OCCT import error:', result);
                            completed = true;
                            clearTimeout(timeoutId);
                            reject(new Error('Fallo al importar archivo CAD. Verifique que el archivo no esté corrupto.'));
                            return;
                        }
                        
                        // Limpiar timeout ya que el procesamiento fue exitoso
                        clearTimeout(timeoutId);
                        completed = true;
                        
                        await this.createMeshesFromResult(result, fileName);
                        resolve();
                        
                    } catch (error) {
                        if (!completed) {
                            completed = true;
                            clearTimeout(timeoutId);
                            console.error('❌ Error inesperado en procesamiento STEP:', error);
                            reject(new Error('Error inesperado procesando archivo. Intente con un archivo más pequeño.'));
                        }
                    }
                }, 100); // Dar tiempo mínimo al UI
                
            } catch (error) {
                if (!completed) {
                    completed = true;
                    if (timeoutId) clearTimeout(timeoutId);
                    reject(error);
                }
            }
        });
    }
    
    // Procesar archivo STEP muy grande (>40MB) con parámetros extremadamente agresivos
    async processVeryLargeSTEPFile(occt, arrayBuffer, fileName) {
        return new Promise(async (resolve, reject) => {
            let timeoutId = null;
            let completed = false;
            
            try {
                // Timeout más largo para archivos muy grandes
                timeoutId = setTimeout(() => {
                    if (!completed) {
                        completed = true;
                        console.error('⏰ TIMEOUT: Archivo muy grande cancelado por tiempo excedido (60s)');
                        reject(new Error('Archivo demasiado grande y complejo. Considere dividir el modelo o usar un formato más simple como STL.'));
                    }
                }, 60000); // 60 segundos timeout
                
                this.updateLoadProgress(55, 'Procesando archivo muy grande con precisión mínima...');
                
                const fileData = new Uint8Array(arrayBuffer);
                
                // Parámetros extremadamente agresivos para archivos muy grandes
                const params = {
                    linearUnit: 'millimeter',
                    linearDeflectionType: 'bounding_box_ratio',
                    linearDeflection: 0.02, // Precisión muy baja
                    angularDeflection: 2.0  // Precisión angular muy baja
                };
                
                const ext = fileName.split('.').pop().toLowerCase();
                
                console.warn('⚠️ ARCHIVO MUY GRANDE: Usando precisión mínima para evitar bloqueos');
                this.updateLoadProgress(58, 'Aplicando simplificación extrema...');
                
                // Dar tiempo sustancial antes del procesamiento
                await new Promise(res => setTimeout(res, 500));
                
                setTimeout(async () => {
                    try {
                        if (completed) return;
                        
                        console.time('occt-import-very-large');
                        this.updateLoadProgress(60, 'OCCT procesando archivo muy grande (sea paciente)...');
                        
                        if (this.shouldCancelLoad) {
                            completed = true;
                            clearTimeout(timeoutId);
                            reject(new Error('Carga cancelada'));
                            return;
                        }
                        
                        let result = null;
                        
                        try {
                            if (ext === 'step' || ext === 'stp') {
                                result = occt.ReadStepFile(fileData, params);
                            } else if (ext === 'iges' || ext === 'igs') {
                                result = occt.ReadIgesFile(fileData, params);
                            }
                        } catch (occtError) {
                            console.error('❌ Error OCCT interno con archivo muy grande:', occtError);
                            completed = true;
                            clearTimeout(timeoutId);
                            reject(new Error('El archivo es demasiado complejo para procesarse. Intente exportar el modelo con menos detalle desde el CAD original.'));
                            return;
                        }
                        
                        console.timeEnd('occt-import-very-large');
                        
                        if (completed) return;
                        
                        if (this.shouldCancelLoad) {
                            completed = true;
                            clearTimeout(timeoutId);
                            reject(new Error('Carga cancelada'));
                            return;
                        }
                        
                        if (!result || !result.success) {
                            console.error('OCCT import error para archivo muy grande:', result);
                            completed = true;
                            clearTimeout(timeoutId);
                            reject(new Error('Archivo muy grande no se pudo procesar. Considere usar un archivo más pequeño o simplificar el modelo.'));
                            return;
                        }
                        
                        clearTimeout(timeoutId);
                        completed = true;
                        
                        await this.createMeshesFromResult(result, fileName);
                        resolve();
                        
                    } catch (error) {
                        if (!completed) {
                            completed = true;
                            clearTimeout(timeoutId);
                            console.error('❌ Error inesperado con archivo muy grande:', error);
                            reject(new Error('Error procesando archivo muy grande. Recomendamos usar un archivo más simple.'));
                        }
                    }
                }, 200);
                
            } catch (error) {
                if (!completed) {
                    completed = true;
                    if (timeoutId) clearTimeout(timeoutId);
                    reject(error);
                }
            }
        });
    }
    
    // Crear meshes desde el resultado OCCT
    async createMeshesFromResult(result, fileName) {
        this.updateLoadProgress(70, 'Generando geometría...');
        
        const group = new THREE.Group();
        const meshes = result.meshes || [];
        console.log(`🧩 Meshes importados: ${meshes.length}`);
        
        const totalMeshes = meshes.length;
        
        for (let i = 0; i < totalMeshes; i++) {
            if (this.shouldCancelLoad) throw new Error('Carga cancelada');
            
            // Pausa cada 10 meshes para no bloquear UI
            if (i > 0 && i % 10 === 0) {
                const progress = 70 + (i / totalMeshes) * 15;
                this.updateLoadProgress(progress, `Procesando mesh ${i}/${totalMeshes}...`);
                await new Promise(resolve => setTimeout(resolve, 10));
            }
            
            const m = meshes[i];
            const geom = new THREE.BufferGeometry();
            const pos = (m.attributes?.position?.array) || [];
            const nrm = (m.attributes?.normal?.array) || null;
            const idx = (m.index?.array) || null;
            
            if (!pos || pos.length === 0) continue;
            
            geom.setAttribute('position', new THREE.Float32BufferAttribute(pos, 3));
            if (nrm && nrm.length > 0) {
                geom.setAttribute('normal', new THREE.Float32BufferAttribute(nrm, 3));
            } else {
                geom.computeVertexNormals();
            }
            if (idx && idx.length > 0) {
                geom.setIndex(idx);
            }
            
            let color = 0x607d8b;
            if (Array.isArray(m.color) && m.color.length === 3) {
                color = new THREE.Color(m.color[0], m.color[1], m.color[2]);
            }
            
            const material = new THREE.MeshPhongMaterial({ color, shininess: 30 });
            const mesh = new THREE.Mesh(geom, material);
            group.add(mesh);
        }
        
        if (group.children.length === 0) {
            throw new Error('No se generaron mallas del STEP/IGES');
        }
        
        this.updateLoadProgress(90, 'Agregando a escena...');
        
        console.log('✅ Archivo STEP/IGES procesado exitosamente');
        await this.addToSceneAsync(group, fileName);
    }
    
    // Parser STL mejorado (binario y ASCII) - ASÍNCRONO
    async parseSTLAsync(arrayBuffer) {
        console.log('🔍 Analizando STL, tamaño:', arrayBuffer.byteLength);
        
        const isASCII = this.detectSTLFormat(arrayBuffer);
        
        if (isASCII) {
            console.log('📄 STL ASCII detectado');
            return await this.parseSTLAsciiAsync(arrayBuffer);
        } else {
            console.log('💾 STL binario detectado');
            return await this.parseSTLBinaryAsync(arrayBuffer);
        }
    }
    
    // Parser STL ASCII - ASÍNCRONO
    async parseSTLAsciiAsync(arrayBuffer) {
        const decoder = new TextDecoder('utf-8');
        const text = decoder.decode(arrayBuffer);
        const lines = text.split('\n');
        
        const vertices = [];
        const normals = [];
        let currentNormal = null;
        let vertexCount = 0;
        
        const totalLines = lines.length;
        
        for (let i = 0; i < totalLines; i++) {
            // Pausa cada 1000 líneas para no bloquear UI
            if (i % 1000 === 0) {
                if (this.shouldCancelLoad) throw new Error('Carga cancelada');
                await new Promise(resolve => setTimeout(resolve, 1));
                this.updateLoadProgress(40 + (i / totalLines) * 20, `Procesando línea ${i}/${totalLines}...`);
            }
            
            const line = lines[i].trim();
            
            if (line.startsWith('facet normal')) {
                const parts = line.split(' ');
                currentNormal = [
                    parseFloat(parts[2]) || 0,
                    parseFloat(parts[3]) || 0,
                    parseFloat(parts[4]) || 0
                ];
            } else if (line.startsWith('vertex')) {
                const parts = line.split(' ');
                vertices.push(
                    parseFloat(parts[1]) || 0,
                    parseFloat(parts[2]) || 0,
                    parseFloat(parts[3]) || 0
                );
                
                if (currentNormal) {
                    normals.push(...currentNormal);
                }
                vertexCount++;
            }
        }
        
        if (this.shouldCancelLoad) throw new Error('Carga cancelada');
        
        console.log('📊 Vértices procesados (ASCII):', vertexCount);
        
        const geometry = new THREE.BufferGeometry();
        geometry.setAttribute('position', new THREE.Float32BufferAttribute(vertices, 3));
        
        if (normals.length > 0) {
            geometry.setAttribute('normal', new THREE.Float32BufferAttribute(normals, 3));
        } else {
            geometry.computeVertexNormals();
        }
        
        return geometry;
    }
    
    // Parser STL binario - ASÍNCRONO
    async parseSTLBinaryAsync(arrayBuffer) {
        const dataView = new DataView(arrayBuffer);
        let offset = 80; // Saltar header
        
        const triangleCount = dataView.getUint32(offset, true);
        offset += 4;
        
        console.log('🔢 Triángulos en STL binario:', triangleCount);
        
        const vertices = [];
        const normals = [];
        
        for (let i = 0; i < triangleCount; i++) {
            // Pausa cada 1000 triángulos para no bloquear UI
            if (i % 1000 === 0) {
                if (this.shouldCancelLoad) throw new Error('Carga cancelada');
                await new Promise(resolve => setTimeout(resolve, 1));
                this.updateLoadProgress(40 + (i / triangleCount) * 20, `Procesando triángulo ${i}/${triangleCount}...`);
            }
            
            // Leer normal
            const normal = [
                dataView.getFloat32(offset, true),
                dataView.getFloat32(offset + 4, true),
                dataView.getFloat32(offset + 8, true)
            ];
            offset += 12;
            
            // Leer 3 vértices
            for (let j = 0; j < 3; j++) {
                vertices.push(
                    dataView.getFloat32(offset, true),
                    dataView.getFloat32(offset + 4, true),
                    dataView.getFloat32(offset + 8, true)
                );
                normals.push(...normal);
                offset += 12;
            }
            
            offset += 2; // Attribute byte count
        }
        
        if (this.shouldCancelLoad) throw new Error('Carga cancelada');
        
        console.log('📊 Vértices procesados (binario):', vertices.length / 3);
        
        const geometry = new THREE.BufferGeometry();
        geometry.setAttribute('position', new THREE.Float32BufferAttribute(vertices, 3));
        geometry.setAttribute('normal', new THREE.Float32BufferAttribute(normals, 3));
        
        return geometry;
    }
    
    // Parser OBJ - ASÍNCRONO
    async parseOBJAsync(arrayBuffer) {
        const decoder = new TextDecoder('utf-8');
        const text = decoder.decode(arrayBuffer);
        const lines = text.split('\n');
        
        const vertices = [];
        const faces = [];
        const tempVertices = [];
        
        const totalLines = lines.length;
        
        for (let i = 0; i < totalLines; i++) {
            // Pausa cada 1000 líneas para no bloquear UI
            if (i % 1000 === 0) {
                if (this.shouldCancelLoad) throw new Error('Carga cancelada');
                await new Promise(resolve => setTimeout(resolve, 1));
                this.updateLoadProgress(40 + (i / totalLines) * 20, `Procesando línea ${i}/${totalLines}...`);
            }
            
            const line = lines[i].trim();
            
            if (line.startsWith('v ')) {
                const parts = line.split(/\s+/);
                tempVertices.push([
                    parseFloat(parts[1]) || 0,
                    parseFloat(parts[2]) || 0,
                    parseFloat(parts[3]) || 0
                ]);
            } else if (line.startsWith('f ')) {
                const parts = line.split(/\s+/).slice(1);
                
                if (parts.length >= 3) {
                    const indices = parts.map(part => {
                        const index = parseInt(part.split('/')[0]);
                        return index > 0 ? index - 1 : tempVertices.length + index;
                    });
                    
                    for (let j = 1; j < indices.length - 1; j++) {
                        faces.push(indices[0], indices[j], indices[j + 1]);
                    }
                }
            }
        }
        
        if (this.shouldCancelLoad) throw new Error('Carga cancelada');
        
        // Construir geometría final
        for (const faceIndex of faces) {
            if (tempVertices[faceIndex]) {
                vertices.push(...tempVertices[faceIndex]);
            }
        }
        
        console.log('📊 Vértices procesados (OBJ):', vertices.length / 3);
        
        const geometry = new THREE.BufferGeometry();
        geometry.setAttribute('position', new THREE.Float32BufferAttribute(vertices, 3));
        geometry.computeVertexNormals();
        
        return geometry;
    }

    // Detectar formato STL
    detectSTLFormat(arrayBuffer) {
        if (arrayBuffer.byteLength < 84) {
            return true;
        }
        
        const firstBytes = new Uint8Array(arrayBuffer, 0, 5);
        const firstString = String.fromCharCode.apply(null, firstBytes);
        
        if (firstString.toLowerCase().startsWith('solid')) {
            const view = new Uint8Array(arrayBuffer, 0, Math.min(200, arrayBuffer.byteLength));
            let textChars = 0;
            let totalChars = 0;
            
            for (let i = 0; i < view.length; i++) {
                const char = view[i];
                totalChars++;
                if ((char >= 32 && char <= 126) || char === 10 || char === 13) {
                    textChars++;
                }
            }
            
            const textRatio = textChars / totalChars;
            console.log(`📊 Ratio de texto: ${(textRatio * 100).toFixed(1)}%`);
            return textRatio > 0.9;
        }
        
        return false;
    }

    // Parser STL ASCII
    parseSTLAscii(arrayBuffer) {
        const text = new TextDecoder().decode(arrayBuffer);
        const lines = text.split('\n');
        
        const vertices = [];
        const normals = [];
        let currentNormal = [0, 0, 0];
        
        for (let i = 0; i < lines.length; i++) {
            const line = lines[i].trim();
            
            if (line.startsWith('facet normal')) {
                const parts = line.split(/\s+/);
                currentNormal = [
                    parseFloat(parts[2]) || 0,
                    parseFloat(parts[3]) || 0,
                    parseFloat(parts[4]) || 0
                ];
            } else if (line.startsWith('vertex')) {
                const parts = line.split(/\s+/);
                vertices.push(
                    parseFloat(parts[1]) || 0,
                    parseFloat(parts[2]) || 0,
                    parseFloat(parts[3]) || 0
                );
                normals.push(...currentNormal);
            }
        }
        
        console.log(`✅ STL ASCII parseado: ${vertices.length/3} vértices`);
        
        const geometry = new THREE.BufferGeometry();
        geometry.setAttribute('position', new THREE.Float32BufferAttribute(vertices, 3));
        geometry.setAttribute('normal', new THREE.Float32BufferAttribute(normals, 3));
        
        return geometry;
    }

    // Parser STL binario
    parseSTLBinary(arrayBuffer) {
        try {
            const view = new DataView(arrayBuffer);
            const isLittleEndian = true;
            
            if (arrayBuffer.byteLength < 84) {
                throw new Error('Archivo STL binario demasiado pequeño');
            }
            
            let offset = 80; // Saltar header
            const triangles = view.getUint32(offset, isLittleEndian);
            offset += 4;
            
            console.log(`📊 STL binario: ${triangles} triángulos`);
            
            const vertices = [];
            const normals = [];
            
            for (let i = 0; i < triangles; i++) {
                if (offset + 50 > arrayBuffer.byteLength) {
                    console.warn(`⚠️ Triángulo ${i} fuera de rango, deteniendo`);
                    break;
                }
                
                // Normal (3 floats)
                const nx = view.getFloat32(offset, isLittleEndian); offset += 4;
                const ny = view.getFloat32(offset, isLittleEndian); offset += 4;
                const nz = view.getFloat32(offset, isLittleEndian); offset += 4;
                
                // 3 vértices (9 floats)
                for (let j = 0; j < 3; j++) {
                    const vx = view.getFloat32(offset, isLittleEndian); offset += 4;
                    const vy = view.getFloat32(offset, isLittleEndian); offset += 4;
                    const vz = view.getFloat32(offset, isLittleEndian); offset += 4;
                    
                    vertices.push(vx, vy, vz);
                    normals.push(nx, ny, nz);
                }
                
                offset += 2; // Saltar attribute byte count
            }
            
            console.log(`✅ STL binario parseado: ${vertices.length/3} vértices, ${triangles} triángulos`);
            
            if (vertices.length === 0) {
                throw new Error('No se encontraron vértices válidos');
            }
            
            const geometry = new THREE.BufferGeometry();
            geometry.setAttribute('position', new THREE.Float32BufferAttribute(vertices, 3));
            geometry.setAttribute('normal', new THREE.Float32BufferAttribute(normals, 3));
            
            return geometry;
            
        } catch (error) {
            console.error('❌ Error parseando STL binario:', error);
            throw error;
        }
    }

    // Inicializar módulo OCCT (WASM)
    async getOCCTModule() {
        if (!this.occtModulePromise) {
            this.occtModulePromise = occtimportjs();
        }
        return this.occtModulePromise;
    }
    
    // Mejoras en el método clearModel
    clearModel() {
        if (this.isLoading) {
            this.cancelCurrentLoad();
        }
        
        if (this.currentModel) {
            this.scene.remove(this.currentModel);
            this.disposeObject(this.currentModel);
            this.currentModel = null;
            this.showStatus('Modelo eliminado');
        }
    }

    // Cargar STEP/IGES desde ArrayBuffer
    async loadSTEPFromBuffer(arrayBuffer, fileName) {
        this.showStatus('Triangulando STEP/IGES...');
        const fileData = new Uint8Array(arrayBuffer);
        const occt = await this.ensureOcct();
        
        const params = {
            linearUnit: 'millimeter',
            linearDeflectionType: 'bounding_box_ratio',
            linearDeflection: 0.003,
            angularDeflection: 0.5
        };
        
        const ext = fileName.split('.').pop().toLowerCase();
        let result = null;
        
        console.time('occt-import');
        if (ext === 'step' || ext === 'stp') {
            result = occt.ReadStepFile(fileData, params);
        } else if (ext === 'iges' || ext === 'igs') {
            result = occt.ReadIgesFile(fileData, params);
        }
        console.timeEnd('occt-import');
        
        if (!result || !result.success) {
            console.error('OCCT import error:', result);
            throw new Error('Fallo al importar archivo CAD');
        }
        
        const group = new THREE.Group();
        const meshes = result.meshes || [];
        console.log(`🧩 Meshes importados: ${meshes.length}`);
        
        for (const m of meshes) {
            const geom = new THREE.BufferGeometry();
            const pos = (m.attributes?.position?.array) || [];
            const nrm = (m.attributes?.normal?.array) || null;
            const idx = (m.index?.array) || null;
            
            if (!pos || pos.length === 0) continue;
            
            geom.setAttribute('position', new THREE.Float32BufferAttribute(pos, 3));
            if (nrm && nrm.length > 0) {
                geom.setAttribute('normal', new THREE.Float32BufferAttribute(nrm, 3));
            } else {
                geom.computeVertexNormals();
            }
            if (idx && idx.length > 0) {
                geom.setIndex(idx);
            }
            
            let color = 0x607d8b;
            if (Array.isArray(m.color) && m.color.length === 3) {
                color = new THREE.Color(m.color[0], m.color[1], m.color[2]);
            }
            
            const material = new THREE.MeshPhongMaterial({ color, shininess: 30 });
            const mesh = new THREE.Mesh(geom, material);
            group.add(mesh);
        }
        
        if (group.children.length === 0) {
            throw new Error('No se generaron mallas del STEP/IGES');
        }
        
        this.addToScene(group, fileName);
    }

    // Agregar modelo a la escena - ASÍNCRONO
    async addToSceneAsync(object, name) {
        console.log('🎭 Agregando objeto a la escena:', name);
        console.log('📊 Tipo de objeto:', object.type);
        console.log('📊 Hijos del objeto:', object.children ? object.children.length : 'N/A');
        
        if (this.currentModel) {
            console.log('🗑️ Removiendo modelo anterior');
            this.scene.remove(this.currentModel);
            this.disposeObject(this.currentModel);
        }
        
        // Dar tiempo para que se procese la remoción
        await new Promise(resolve => setTimeout(resolve, 50));
        
        if (this.shouldCancelLoad) throw new Error('Carga cancelada');
        
        // Centrar y escalar el modelo
        const box = new THREE.Box3().setFromObject(object);
        const center = box.getCenter(new THREE.Vector3());
        const size = box.getSize(new THREE.Vector3());
        
        console.log('📏 Tamaño del modelo:', size);
        console.log('📍 Centro del modelo:', center);
        
        object.position.sub(center);
        
        const maxSize = Math.max(size.x, size.y, size.z);
        if (maxSize > 100) {
            const scale = 100 / maxSize;
            console.log('🔍 Escalando modelo por:', scale);
            object.scale.multiplyScalar(scale);
        }
        
        // Agregar a la escena
        this.scene.add(object);
        this.currentModel = object;
        
        console.log('✅ Modelo agregado a la escena');
        console.log('📊 Total objetos en escena:', this.scene.children.length);
        
        // Verificar visibilidad del modelo
        object.traverse((child) => {
            if (child.isMesh) {
                console.log('🔍 Mesh encontrado:', child.geometry.attributes);
                child.material.needsUpdate = true;
            }
        });
        
        // Verificar conexión del canvas antes de renderizar
        const canvas = this.renderer.domElement;
        if (!canvas.isConnected) {
            console.log('❌ PROBLEMA: Canvas no está conectado al DOM');
            console.log('🔧 Intentando reconectar canvas...');
            
            const canvasContainer = document.getElementById('visor-cad-canvas');
            if (canvasContainer && !canvas.parentElement) {
                canvasContainer.appendChild(canvas);
                console.log('✅ Canvas reconectado al DOM');
            }
        } else {
            console.log('✅ Canvas conectado correctamente');
        }
        
        // Renderizar inmediatamente
        if (this.renderer && this.scene && this.camera) {
            this.renderer.render(this.scene, this.camera);
            console.log('🖼️ Renderizado inmediato después de agregar modelo');
            console.log('🔍 Estado final del canvas:', {
                isConnected: canvas.isConnected,
                width: canvas.width,
                height: canvas.height
            });
        }
        
        // Ajustar vista al modelo
        await this.fitModelAsync();
    }
    
    // Ajustar vista al modelo - ASÍNCRONO CON POSICIONAMIENTO ADAPTATIVO
    async fitModelAsync() {
        if (this.currentModel) {
            console.log('🎯 Ajustando vista profesional con centrado automático');
            
            // Calcular el bounding box del modelo
            const box = new THREE.Box3().setFromObject(this.currentModel);
            const size = box.getSize(new THREE.Vector3());
            const center = box.getCenter(new THREE.Vector3());
            const maxSize = Math.max(size.x, size.y, size.z);
            
            console.log('📦 Información del modelo:', {
                size: size,
                center: center,
                maxSize: maxSize
            });
            
            // CENTRADO AUTOMÁTICO: Mover el modelo para que su centro esté en el origen
            this.currentModel.position.sub(center);
            console.log('📍 Modelo centrado en origen, desplazamiento aplicado:', center);
            
            // Actualizar el centro del modelo a origen
            this.modelCenter.set(0, 0, 0);
            this.modelSize = maxSize;
            
            // 📐 Posicionamiento adaptativo de cámara basado en tamaño del modelo
            let distanceMultiplier, heightRatio, angleOffset;
            
            if (maxSize < 50) {
                // Modelos pequeños - vista más cercana e íntima
                distanceMultiplier = 2.2;
                heightRatio = 0.6;
                angleOffset = 15; // Ángulo más bajo para detalles
                console.log('📱 Modelo pequeño detectado - Vista cercana');
            } else if (maxSize < 200) {
                // Modelos medianos - vista equilibrada
                distanceMultiplier = 2.8;
                heightRatio = 0.75;
                angleOffset = 30; // Ángulo medio
                console.log('🏠 Modelo mediano detectado - Vista equilibrada');
            } else {
                // Modelos grandes - vista panorámica
                distanceMultiplier = 3.5;
                heightRatio = 0.9;
                angleOffset = 45; // Ángulo más alto para perspectiva
                console.log('🏭 Modelo grande detectado - Vista panorámica');
            }
            
            const distance = maxSize * distanceMultiplier;
            const height = distance * heightRatio;
            
            console.log('📐 Parámetros de cámara:', {
                maxSize,
                distance,
                height,
                angleOffset,
                distanceMultiplier
            });
            
            // Posicionar cámara con ángulo adaptativo
            const angleRad = (angleOffset * Math.PI) / 180;
            const x = distance * Math.cos(angleRad);
            const z = distance * Math.sin(angleRad);
            
            this.camera.position.set(x, height, z);
            this.camera.lookAt(center);
            
            console.log('� Nueva posición de cámara:', this.camera.position);
            console.log('🎯 Centro del modelo:', center);
            
            // Dar tiempo para que se procese el ajuste
            await new Promise(resolve => setTimeout(resolve, 50));
            
            // Verificar conexión del canvas antes de renderizar
            const canvas = this.renderer.domElement;
            if (!canvas.isConnected) {
                console.log('❌ Canvas desconectado en fitModelAsync, reconectando...');
                const canvasContainer = document.getElementById('visor-cad-canvas');
                if (canvasContainer && !canvas.parentElement) {
                    canvasContainer.appendChild(canvas);
                    console.log('✅ Canvas reconectado en fitModelAsync');
                }
            }
            
            // Forzar renderizado inmediato
            if (this.renderer && this.scene && this.camera) {
                this.renderer.render(this.scene, this.camera);
                console.log('🖼️ Renderizado forzado completado');
                console.log('📊 Estado del canvas:', {
                    isConnected: canvas.isConnected,
                    width: canvas.width,
                    height: canvas.height
                });
            }
        } else {
            console.log('⚠️ No hay modelo para ajustar');
        }
    }

    // Liberar recursos de memoria
    disposeObject(obj) {
        if (obj.geometry) {
            obj.geometry.dispose();
        }
        if (obj.material) {
            if (Array.isArray(obj.material)) {
                obj.material.forEach(mat => mat.dispose());
            } else {
                obj.material.dispose();
            }
        }
        if (obj.children) {
            obj.children.forEach(child => this.disposeObject(child));
        }
    }

    // Ajustar vista al modelo
    fitModel() {
        if (this.currentModel) {
            console.log('🎯 Ajustando vista al modelo');
            const box = new THREE.Box3().setFromObject(this.currentModel);
            const size = box.getSize(new THREE.Vector3());
            const center = box.getCenter(new THREE.Vector3());
            const maxSize = Math.max(size.x, size.y, size.z);
            
            // Calcular distancia de cámara apropiada
            const distance = maxSize * 2.5;
            console.log('📐 Distancia de cámara calculada:', distance);
            
            // Posicionar cámara
            this.camera.position.set(distance, distance * 0.7, distance);
            this.camera.lookAt(center);
            
            console.log('📷 Nueva posición de cámara:', this.camera.position);
            console.log('🎯 Centro del modelo:', center);
            
            // Forzar renderizado inmediato
            if (this.renderer && this.scene && this.camera) {
                this.renderer.render(this.scene, this.camera);
                console.log('🖼️ Renderizado forzado completado');
            }
        } else {
            console.log('⚠️ No hay modelo para ajustar');
        }
    }

    // Funciones de control
    resetView() {
        this.camera.position.set(50, 50, 50);
        this.camera.lookAt(0, 0, 0);
    }

    toggleWireframe() {
        if (this.currentModel) {
            this.wireframeMode = !this.wireframeMode;
            this.currentModel.traverse((child) => {
                if (child.material) {
                    child.material.wireframe = this.wireframeMode;
                }
            });
        }
    }

    clearModel() {
        if (this.currentModel) {
            this.scene.remove(this.currentModel);
            this.disposeObject(this.currentModel);
            this.currentModel = null;
            this.showStatus('Modelo eliminado');
        }
    }

    // Popup de carga profesional dentro del contenedor
    showLoadingPopup(show, fileName = '') {
        console.log('🔄 showLoadingPopup:', show, fileName);
        
        // Buscar o crear popup de carga
        let popup = document.getElementById('cad-loading-popup');
        
        if (show) {
            if (!popup) {
                // Crear popup de carga dinámico en el contenedor
                const container = this.container || document.getElementById('cad-viewer-container');
                if (container) {
                    popup = document.createElement('div');
                    popup.id = 'cad-loading-popup';
                    popup.style.cssText = `
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(248, 249, 250, 0.95);
                        backdrop-filter: blur(8px);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        z-index: 9999;
                        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    `;
                    
                    popup.innerHTML = `
                        <div style="
                            background: rgba(255, 255, 255, 0.9);
                            backdrop-filter: blur(10px);
                            border-radius: 20px;
                            padding: 40px 50px;
                            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                            text-align: center;
                            max-width: 400px;
                            border: 1px solid rgba(255,255,255,0.2);
                            animation: fadeInScale 0.3s ease-out;
                        ">
                            <div style="
                                width: 60px;
                                height: 60px;
                                margin: 0 auto 20px;
                                border: 4px solid #e3f2fd;
                                border-top: 4px solid #2196f3;
                                border-radius: 50%;
                                animation: spin 1s linear infinite;
                            "></div>
                            
                            <h4 style="
                                margin: 0 0 15px 0;
                                color: #1976d2;
                                font-size: 18px;
                                font-weight: 600;
                            ">Procesando modelo CAD</h4>
                            
                            <div style="
                                color: #666;
                                font-size: 14px;
                                margin-bottom: 5px;
                                font-weight: 500;
                            " id="cad-load-filename">${fileName || 'Cargando archivo...'}</div>
                            
                            <div style="
                                color: #999;
                                font-size: 13px;
                                margin-bottom: 25px;
                                min-height: 20px;
                            " id="cad-load-status">Iniciando...</div>
                            
                            <div style="
                                width: 100%;
                                height: 8px;
                                background: #e0e0e0;
                                border-radius: 4px;
                                overflow: hidden;
                                margin-bottom: 15px;
                            ">
                                <div style="
                                    height: 100%;
                                    background: linear-gradient(90deg, #2196f3, #21cbf3);
                                    border-radius: 4px;
                                    width: 0%;
                                    transition: width 0.3s ease;
                                " id="cad-load-progress"></div>
                            </div>
                            
                            <button onclick="window.cadViewer?.cancelCurrentLoad()" style="
                                background: #ff5722;
                                color: white;
                                border: none;
                                padding: 8px 20px;
                                border-radius: 20px;
                                font-size: 12px;
                                cursor: pointer;
                                transition: all 0.2s ease;
                                opacity: 0.8;
                            " 
                            onmouseover="this.style.opacity='1'; this.style.transform='scale(1.05)'"
                            onmouseout="this.style.opacity='0.8'; this.style.transform='scale(1)'">
                                Cancelar
                            </button>
                        </div>
                        
                        <style>
                            @keyframes spin {
                                0% { transform: rotate(0deg); }
                                100% { transform: rotate(360deg); }
                            }
                            @keyframes fadeInScale {
                                0% { 
                                    opacity: 0; 
                                    transform: scale(0.8); 
                                }
                                100% { 
                                    opacity: 1; 
                                    transform: scale(1); 
                                }
                            }
                            @keyframes fadeOut {
                                0% { 
                                    opacity: 1; 
                                    transform: scale(1); 
                                }
                                100% { 
                                    opacity: 0; 
                                    transform: scale(0.8); 
                                }
                            }
                        </style>
                    `;
                    
                    container.appendChild(popup);
                    
                    // Exponer viewer globalmente para cancelación
                    window.cadViewer = this;
                }
            } else {
                // Actualizar nombre de archivo si existe
                const filenameEl = document.getElementById('cad-load-filename');
                if (filenameEl && fileName) {
                    filenameEl.textContent = fileName;
                }
                popup.style.display = 'flex';
            }
        } else {
            // Ocultar popup
            if (popup) {
                popup.style.animation = 'fadeOut 0.3s ease-out';
                setTimeout(() => {
                    if (popup.parentNode) {
                        popup.parentNode.removeChild(popup);
                    }
                }, 300);
            }
        }
    }
    
    // Método de carga legacy (mantener compatibilidad)
    showLoading(show) {
        this.showLoadingPopup(show);
    }
    
    // Simular progreso de carga
    simulateLoadingProgress() {
        const statusElement = document.getElementById('loading-status');
        const progressElement = document.getElementById('loading-progress');
        
        if (!statusElement || !progressElement) return;
        
        const steps = [
            { text: 'Descargando archivo...', progress: 10 },
            { text: 'Analizando formato...', progress: 25 },
            { text: 'Triangulando geometría...', progress: 50 },
            { text: 'Optimizando malla...', progress: 75 },
            { text: 'Preparando visualización...', progress: 90 },
            { text: 'Finalizando...', progress: 100 }
        ];
        
        let currentStep = 0;
        
        const updateStep = () => {
            if (currentStep < steps.length) {
                const step = steps[currentStep];
                statusElement.textContent = step.text;
                progressElement.style.width = step.progress + '%';
                currentStep++;
                
                // Siguiente paso en un intervalo aleatorio
                setTimeout(updateStep, Math.random() * 1500 + 500);
            }
        };
        
        updateStep();
    }

    showStatus(text, ms = 2000) {
        const info = document.getElementById('cad-status');
        if (info) {
            info.textContent = text;
            info.style.display = 'block';
            if (this.infoTimeout) clearTimeout(this.infoTimeout);
            this.infoTimeout = setTimeout(() => {
                info.style.display = 'none';
            }, ms);
        } else {
            console.log('📢 Status:', text);
        }
        
        // Actualizar el status en el indicador de carga si existe
        const loadingStatus = document.getElementById('loading-status');
        if (loadingStatus && !text.includes('✅')) {
            loadingStatus.textContent = text;
        }
        
        // Forzar renderizado cuando se muestre el status de éxito
        if (text.includes('✅') && this.renderer && this.scene && this.camera) {
            // Ocultar la animación de carga
            setTimeout(() => {
                this.showLoading(false);
                
                // Mostrar controles de navegación si existen
                this.showNavigationControls(true);
                
                // Renderizado final
                this.renderer.render(this.scene, this.camera);
                console.log('🖼️ Renderizado forzado por status de éxito');
            }, 500);
        }
    }
    
    // Mostrar controles de navegación
    showNavigationControls(show) {
        const container = this.container || document.getElementById('cad-viewer-container');
        if (!container) return;
        
        let controlsContainer = document.getElementById('cad-navigation-controls');
        
        if (show && !controlsContainer) {
            // Crear controles de navegación profesionales
            controlsContainer = document.createElement('div');
            controlsContainer.id = 'cad-navigation-controls';
            controlsContainer.innerHTML = `
                <!-- Barra de herramientas superior -->
                <div style="
                    position: absolute;
                    top: 15px;
                    left: 15px;
                    right: 15px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    z-index: 1000;
                ">
                
                    <div style="
                        display: flex;
                        gap: 8px;
                        background: rgba(255, 255, 255, 0.95);
                        backdrop-filter: blur(10px);
                        padding: 6px;
                        border-radius: 12px;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                        border: 1px solid rgba(255,255,255,0.2);
                    ">
                        <button class="cad-control-btn" onclick="resetCADView()" title="Resetear vista" data-tooltip="Centrar modelo">
                            <i class="bi bi-house-fill"></i>
                        </button>
                        <button class="cad-control-btn" onclick="toggleCADWireframe()" title="Modo wireframe" data-tooltip="Alternar wireframe">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </button>
                    </div>
                </div>
                
                
                <!-- Estilos CSS para los controles -->
                <style>
                    .cad-control-btn {
                        background: transparent;
                        border: none;
                        width: 36px;
                        height: 36px;
                        border-radius: 8px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        cursor: pointer;
                        transition: all 0.2s ease;
                        color: #374151;
                        font-size: 16px;
                        position: relative;
                    }
                    
                    .cad-control-btn:hover {
                        background: rgba(59, 130, 246, 0.1);
                        color: #2563eb;
                        transform: translateY(-1px);
                    }
                    
                    .cad-control-btn:active {
                        transform: translateY(0);
                        background: rgba(59, 130, 246, 0.2);
                    }
                    
                    .cad-control-btn.cad-control-danger:hover {
                        background: rgba(239, 68, 68, 0.1);
                        color: #dc2626;
                    }
                    
                    .cad-control-btn.cad-control-danger:active {
                        background: rgba(239, 68, 68, 0.2);
                    }
                    
                    /* Tooltip efecto */
                    .cad-control-btn::after {
                        content: attr(data-tooltip);
                        position: absolute;
                        top: -35px;
                        left: 50%;
                        transform: translateX(-50%);
                        background: rgba(0, 0, 0, 0.9);
                        color: white;
                        padding: 4px 8px;
                        border-radius: 6px;
                        font-size: 11px;
                        white-space: nowrap;
                        opacity: 0;
                        visibility: hidden;
                        transition: all 0.2s ease;
                        pointer-events: none;
                    }
                    
                    .cad-control-btn:hover::after {
                        opacity: 1;
                        visibility: visible;
                        top: -40px;
                    }
                </style>
            `;
            
            container.appendChild(controlsContainer);
        }
        
        if (controlsContainer) {
            controlsContainer.style.display = show ? 'block' : 'none';
        }
    }

    // ⚡⚡ NUEVA: Cargar malla pre-procesada desde buffer GLB/JSON
    async loadMeshFromBuffer(meshBuffer, mimeType) {
        try {
            console.log('⚡⚡ Cargando malla pre-procesada:', {
                tamaño: meshBuffer.byteLength,
                tipo: mimeType
            });
            
            // Detectar si es GLB (modelo/gltf-binary) o JSON (threejs)
            if (mimeType.includes('gltf')) {
                // Es un archivo GLB - usar GLTFLoader
                const loader = new THREE.GLTFLoader();
                
                return new Promise((resolve, reject) => {
                    loader.parse(meshBuffer, '', (gltf) => {
                        console.log('✅ Malla GLB parseada exitosamente');
                        
                        // Limpiar modelo anterior
                        this.clearModel();
                        
                        // Agregar el modelo a la escena
                        this.currentModel = gltf.scene;
                        this.scene.add(this.currentModel);
                        
                        // Centrar y ajustar cámara
                        this.fitModel();
                        
                        resolve();
                    }, (error) => {
                        console.error('❌ Error parseando GLB:', error);
                        reject(error);
                    });
                });
                
            } else if (mimeType.includes('json')) {
                // Es JSON de Three.js - usar ObjectLoader
                const textDecoder = new TextDecoder();
                const jsonString = textDecoder.decode(meshBuffer);
                const meshData = JSON.parse(jsonString);
                
                const loader = new THREE.ObjectLoader();
                const loadedObject = loader.parse(meshData);
                
                console.log('✅ Malla JSON parseada exitosamente');
                
                // Limpiar modelo anterior
                this.clearModel();
                
                // Agregar el modelo a la escena
                this.currentModel = loadedObject;
                this.scene.add(this.currentModel);
                
                // Centrar y ajustar cámara
                this.fitModel();
                
            } else {
                throw new Error('Formato de malla no soportado: ' + mimeType);
            }
            
        } catch (error) {
            console.error('❌ Error cargando malla pre-procesada:', error);
            throw error;
        }
    }
    
    // ⚡⚡ NUEVA: Guardar malla procesada en BD para evitar re-procesar STEP/IGES
    async saveMeshToDatabase(equipoId) {
        try {
            if (!this.currentModel) {
                console.warn('⚠️ No hay modelo para guardar');
                return;
            }
            
            // Verificar que GLTFExporter existe
            if (typeof THREE.GLTFExporter === 'undefined') {
                console.error('❌ GLTFExporter no está disponible - no se puede guardar malla');
                console.warn('� Asegúrate de que el script GLTFExporter.js está cargado en el HTML');
                return;
            }
            
            console.log('�💾 Serializando malla para guardar en BD...');
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
    
    // ⚡ NUEVA: Precarga silenciosa en background (sin mostrar UI)
    async preloadCADSilently(equipoId) {
        try {
            console.log('🔄 [PRECARGA SILENCIOSA] Iniciando para equipo:', equipoId);
            
            // Verificar si ya está en caché
            if (window.cadPreloader) {
                const cached = await window.cadPreloader.getModel(equipoId);
                if (cached) {
                    console.log('⚡ [PRECARGA] Modelo ya está en caché, saltando precarga');
                    return { success: true, fromCache: true };
                }
            }
            
            // No está en caché, descargar en background
            const infoResponse = await fetch(`/LSA/get-cad/${equipoId}`);
            if (!infoResponse.ok) {
                console.log('⚠️ [PRECARGA] Equipo no tiene modelo CAD');
                return { success: false, reason: 'no_model' };
            }
            
            const infoData = await infoResponse.json();
            if (!infoData.success) {
                return { success: false, reason: 'no_model' };
            }
            
            const fileName = infoData.archivo.nombre || 'archivo.cad';
            const fileType = infoData.archivo.tipo || 'stl';
            
            console.log(`📥 [PRECARGA] Descargando ${fileName} en background...`);
            
            // Descargar archivo
            const fileResponse = await fetch(`/LSA/get-cad-file/${equipoId}`);
            if (!fileResponse.ok) {
                throw new Error('Error descargando archivo');
            }
            
            const arrayBuffer = await fileResponse.arrayBuffer();
            const sizeMB = (arrayBuffer.byteLength / 1024 / 1024).toFixed(2);
            console.log(`✅ [PRECARGA] Archivo descargado: ${sizeMB} MB`);
            
            // Guardar en caché
            if (window.cadPreloader) {
                await window.cadPreloader.saveToCache({
                    equipoId,
                    nombre: fileName,
                    tipo: fileType,
                    data: arrayBuffer,
                    size: arrayBuffer.byteLength,
                    timestamp: Date.now()
                });
                console.log('💾 [PRECARGA] Modelo guardado en caché para acceso instantáneo');
            }
            
            return { success: true, fromCache: false, sizeMB };
            
        } catch (error) {
            console.error('❌ [PRECARGA] Error:', error);
            return { success: false, error: error.message };
        }
    }
    
    // Función pública para cargar archivo CAD desde equipo - ASÍNCRONA CON CACHÉ Y MALLAS PRE-PROCESADAS
    async loadCADFromEquipo(equipoId) {
        try {
            console.log('🚀 Iniciando carga CAD para equipo:', equipoId);
            
            // Diagnóstico inicial
            this.diagnoseViewer();
            
            // Verificar que el visor está funcionando correctamente
            if (!this.renderer || !this.scene || !this.camera) {
                throw new Error('Visor CAD no está correctamente inicializado');
            }
            
            // Cancelar cualquier carga en progreso
            if (this.isLoading) {
                console.log('⏹️ Cancelando carga anterior...');
                this.cancelCurrentLoad();
                await this.waitForLoadComplete();
            }
            
            // ⚡ OPTIMIZACIÓN 0: Malla pre-procesada desde base de datos (ultra-rápida)
            try {
                this.showStatus('⚡⚡ Buscando malla pre-procesada...');
                const meshResponse = await fetch(`/LSA/get-cad-mesh/${equipoId}`);
                
                if (meshResponse.ok) {
                    // ⚡⚡⚡ MALLA PRE-PROCESADA ENCONTRADA - CARGA ULTRARRÁPIDA (sin OCCT)
                    console.log('⚡⚡⚡ MALLA PRE-PROCESADA encontrada en BD - carga ultra-rápida (SIN procesamiento OCCT)');
                    const meshBlob = await meshResponse.arrayBuffer();
                    const meshFormat = meshResponse.headers.get('X-Mesh-Format') || 'json';
                    
                    console.log('📦 Malla pre-procesada descargada:', {
                        tamaño: meshBlob.byteLength,
                        tamaño_MB: (meshBlob.byteLength / 1024 / 1024).toFixed(2) + ' MB',
                        formato: meshFormat,
                        fecha: meshResponse.headers.get('X-Mesh-Date')
                    });
                    
                    this.showStatus('⚡⚡ Cargando malla pre-procesada (ultra-rápido)...');
                    
                    // Cargar la malla directamente (JSON de Three.js)
                    await this.loadMeshFromBuffer(meshBlob, meshFormat);
                    
                    console.log('✅ Carga desde malla pre-procesada completada - 85-90% más rápido');
                    this.showStatus('✅ Modelo cargado (desde malla optimizada)');
                    
                    // Diagnóstico final
                    this.diagnoseViewer();
                    
                    // Verificar que el modelo se cargó correctamente
                    if (!this.currentModel) {
                        throw new Error('El modelo no se cargó correctamente en la escena');
                    }
                    
                    // Forzar renderizado final
                    if (this.renderer && this.scene && this.camera) {
                        this.renderer.render(this.scene, this.camera);
                        console.log('🖼️ Renderizado final forzado después de la carga');
                    }
                    
                    return; // ✅ ÉXITO - Salir aquí si la malla pre-procesada funcionó
                }
                
            } catch (meshError) {
                console.warn('⚠️ No se pudo cargar malla pre-procesada, cargando archivo CAD original:', meshError.message);
                // Continuar con carga normal del archivo raw
            }
            
            // ⚡ OPTIMIZACIÓN 1: Intentar obtener archivo raw desde caché IndexedDB
            let cachedModel = null;
            let fileName, fileType, arrayBuffer;
            let needsProcessing = false; // Flag para saber si es STEP/IGES (necesita OCCT)
            
            if (window.cadPreloader) {
                this.showStatus('⚡ Verificando caché local...');
                cachedModel = await window.cadPreloader.getModel(equipoId);
            }
            
            if (cachedModel) {
                // ⚡ CARGA RÁPIDA DESDE CACHÉ LOCAL
                console.log('⚡⚡ Archivo CAD cargado desde caché local');
                fileName = cachedModel.nombre;
                fileType = cachedModel.tipo;
                arrayBuffer = cachedModel.data;
                
                this.showStatus('⚡ Cargando desde caché local...');
                
            } else {
                // Carga normal desde servidor
                this.showStatus('Conectando con base de datos...');
                
                // Primero obtener información del archivo
                const infoResponse = await fetch(`/LSA/get-cad/${equipoId}`);
                if (!infoResponse.ok) {
                    if (infoResponse.status === 404) {
                        throw new Error('Este equipo no tiene archivo CAD asociado');
                    }
                    throw new Error('Error al obtener información del archivo CAD');
                }
                
                const infoData = await infoResponse.json();
                if (!infoData.success) {
                    throw new Error(infoData.error || 'No hay archivo CAD disponible');
                }
                
                // Mostrar información del archivo
                fileName = infoData.archivo.nombre || 'archivo.cad';
                fileType = infoData.archivo.tipo || 'stl';
                
                console.log('📄 Información del archivo:', { fileName, fileType });
                
                // Obtener el archivo binario
                this.showStatus('Descargando archivo CAD...');
                const fileResponse = await fetch(`/LSA/get-cad-file/${equipoId}`);
                if (!fileResponse.ok) {
                    throw new Error('Error al descargar archivo CAD');
                }
                
                arrayBuffer = await fileResponse.arrayBuffer();
                console.log('📦 Archivo descargado, tamaño:', arrayBuffer.byteLength, 'bytes');
                
                // ⚡ OPTIMIZACIÓN 2: Guardar en caché para próximas veces
                if (window.cadPreloader) {
                    window.cadPreloader.saveToCache({
                        equipoId,
                        nombre: fileName,
                        tipo: fileType,
                        data: arrayBuffer,
                        size: arrayBuffer.byteLength,
                        timestamp: Date.now()
                    }).catch(err => {
                        console.warn('⚠️ No se pudo guardar en caché:', err);
                    });
                }
            }
            
            // Detectar si es un archivo que necesita procesamiento OCCT (STEP/IGES)
            const extensionLower = fileType.toLowerCase();
            needsProcessing = ['step', 'stp', 'iges', 'igs'].includes(extensionLower);
            
            if (needsProcessing) {
                console.log('🔧 Archivo STEP/IGES detectado - se procesará con OCCT y SE GUARDARÁ LA MALLA');
            }
            
            // Cargar usando el nuevo método asíncrono
            await this.loadFromBlob(arrayBuffer, fileName, fileType);
            
            // ⚡⚡ OPTIMIZACIÓN: Guardar malla procesada en BD (con toJSON)
            if (needsProcessing && this.currentModel) {
                console.log('💾 Guardando malla procesada en base de datos para evitar re-procesar...');
                this.saveMeshToDatabase(equipoId).catch(err => {
                    console.warn('⚠️ No se pudo guardar malla en BD:', err);
                });
            }
            
            // Diagnóstico final
            console.log('✅ Carga CAD completada exitosamente');
            this.diagnoseViewer();
            
            // Verificar que el modelo se cargó correctamente
            if (!this.currentModel) {
                throw new Error('El modelo no se cargó correctamente en la escena');
            }
            
            // Forzar renderizado final
            if (this.renderer && this.scene && this.camera) {
                this.renderer.render(this.scene, this.camera);
                console.log('🖼️ Renderizado final forzado después de la carga');
            }
            
        } catch (error) {
            console.error('❌ Error cargando CAD:', error);
            
            // Diagnóstico en caso de error
            this.diagnoseViewer();
            
            // Solo mostrar error si no fue cancelado
            if (error.message !== 'Carga cancelada') {
                this.showStatus('❌ ' + error.message, 3000);
            } else {
                this.showStatus('Carga cancelada', 1500);
            }
            
            throw error;
        }
    }
}

// Instancia global para compatibilidad
let cadViewer = null;

// Función de inicialización para templates
function initCADViewer(containerId = 'cad-viewer') {
    cadViewer = new CADViewer(containerId);
    return cadViewer;
}

// Funciones globales para compatibilidad con templates existentes
function loadCADFile(equipoId) {
    if (cadViewer) {
        return cadViewer.loadCADFromEquipo(equipoId);
    } else {
        console.error('CAD Viewer no inicializado');
    }
}

function clearCADModel() {
    if (cadViewer) {
        cadViewer.clearModel();
    }
}

function resetCADView() {
    if (cadViewer) {
        cadViewer.resetView();
    }
}

function toggleCADWireframe() {
    if (cadViewer) {
        cadViewer.toggleWireframe();
    }
}

// Función de diagnóstico global
function diagnosticarVisorCAD() {
    if (cadViewer) {
        cadViewer.diagnoseViewer();
    } else {
        console.log('❌ No hay visor CAD inicializado');
    }
}

// Función para forzar reinicialización del visor
function reinicializarVisorCAD() {
    console.log('🔄 Forzando reinicialización del visor CAD...');
    
    const container = document.getElementById('cad-viewer-container');
    if (!container) {
        console.error('❌ No se encontró el contenedor cad-viewer-container');
        return false;
    }
    
    // Limpiar instancia anterior
    if (cadViewer) {
        try {
            if (cadViewer.renderer) {
                cadViewer.renderer.dispose();
            }
        } catch (e) {
            console.warn('⚠️ Error limpiando visor anterior:', e);
        }
    }
    
    // Recrear contenedor
    container.innerHTML = `
        <div id="visor-cad-canvas" style="width: 100%; height: 100%; background: #f0f0f0; position: relative;"></div>
    `;
    
    // Reinicializar
    try {
        cadViewer = new CADViewer('visor-cad-canvas');
        console.log('✅ Visor CAD reinicializado exitosamente');
        return true;
    } catch (error) {
        console.error('❌ Error reinicializando visor:', error);
        return false;
    }
}

// Función específica para compatibilidad con equipos_buque.js
window.cargarVisorCAD = function(equipoId) {
    console.log('🎬 cargarVisorCAD llamado con equipoId:', equipoId);
    
    // Buscar el contenedor principal donde está el botón
    const container = document.getElementById('cad-viewer-container');
    if (!container) {
        console.error('❌ No se encontró el contenedor cad-viewer-container');
        return Promise.reject(new Error('Contenedor no encontrado'));
    }
    
    // Verificar si el visor ya existe y está funcionando
    if (cadViewer && cadViewer.renderer && cadViewer.scene && cadViewer.camera) {
        console.log('✅ Visor CAD ya inicializado, verificando estado...');
        
        // Verificar que el canvas esté en el DOM y funcionando
        const canvas = cadViewer.renderer.domElement;
        const isCanvasValid = canvas.isConnected && canvas.width > 0 && canvas.height > 0;
        
        if (!isCanvasValid) {
            console.log('⚠️ Canvas desconectado o inválido, reparando...');
            
            // Encontrar o crear el contenedor del canvas
            let canvasContainer = document.getElementById('visor-cad-canvas');
            if (!canvasContainer) {
                container.innerHTML = `
                    <div id="visor-cad-canvas" style="width: 100%; height: 100%; background: #f0f0f0; position: relative;"></div>
                `;
                canvasContainer = document.getElementById('visor-cad-canvas');
            }
            
            // Limpiar contenedor y reconectar el canvas
            if (canvasContainer) {
                canvasContainer.innerHTML = ''; // Limpiar contenido anterior
                canvasContainer.appendChild(canvas);
                console.log('🔄 Canvas reconectado al DOM');
                
                // Asegurar estilos del canvas
                canvas.style.width = '100%';
                canvas.style.height = '100%';
                canvas.style.display = 'block';
                
                // Forzar redimensionamiento inmediato
                const containerRect = canvasContainer.getBoundingClientRect();
                if (containerRect.width > 0 && containerRect.height > 0) {
                    cadViewer.renderer.setSize(containerRect.width, containerRect.height);
                    cadViewer.camera.aspect = containerRect.width / containerRect.height;
                    cadViewer.camera.updateProjectionMatrix();
                    
                    console.log(`🔧 Canvas redimensionado: ${containerRect.width}x${containerRect.height}`);
                } else {
                    console.warn('⚠️ Contenedor con dimensiones 0, usando valores por defecto');
                    cadViewer.renderer.setSize(800, 600);
                    cadViewer.camera.aspect = 800 / 600;
                    cadViewer.camera.updateProjectionMatrix();
                }
                
                // Renderizar inmediatamente para verificar conexión
                cadViewer.renderer.render(cadViewer.scene, cadViewer.camera);
            }
            
            // Verificar nuevamente después de un breve delay
            setTimeout(() => {
                const rect = canvas.getBoundingClientRect();
                console.log('🔍 Estado del canvas después de reparación:', {
                    width: canvas.width,
                    height: canvas.height,
                    isConnected: canvas.isConnected,
                    rect: rect
                });
            }, 100);
        } else {
            console.log('✅ Canvas válido, continuando...');
        }
        
        // Cargar directamente el nuevo modelo
        return cadViewer.loadCADFromEquipo(equipoId);
    }
    
    // Si el visor no está inicializado o está corrupto, reinicializarlo
    console.log('🔄 Inicializando/Reinicializando CAD Viewer...');
    
    try {
        // Limpiar cualquier instancia anterior
        if (cadViewer) {
            try {
                if (cadViewer.renderer) {
                    cadViewer.renderer.dispose();
                }
            } catch (e) {
                console.warn('⚠️ Error limpiando visor anterior:', e);
            }
        }
        
        // Asegurar que el contenedor tiene el elemento canvas
        let canvasContainer = document.getElementById('visor-cad-canvas');
        if (!canvasContainer) {
            container.innerHTML = `
                <div id="visor-cad-canvas" style="width: 100%; height: 100%; background: #f0f0f0; position: relative;"></div>
            `;
            canvasContainer = document.getElementById('visor-cad-canvas');
        }
        
        // Inicializar el visor en el elemento canvas
        cadViewer = new CADViewer('visor-cad-canvas');
        console.log('✅ CAD Viewer inicializado exitosamente');
        
        // Verificar que el renderer se creó correctamente
        if (!cadViewer.renderer || !cadViewer.scene || !cadViewer.camera) {
            throw new Error('Falló la inicialización del visor 3D');
        }
        
        // Debugging del canvas después de la inicialización
        setTimeout(() => {
            const canvas = cadViewer.renderer.domElement;
            console.log('🖼️ Canvas info después de inicialización:', {
                width: canvas.width,
                height: canvas.height,
                clientWidth: canvas.clientWidth,
                clientHeight: canvas.clientHeight,
                parentId: canvas.parentElement ? canvas.parentElement.id : 'sin parent',
                isConnected: canvas.isConnected
            });
            
            // Verificar que el canvas está visible
            const rect = canvas.getBoundingClientRect();
            console.log('📐 Canvas rect:', rect);
            
            if (rect.width === 0 || rect.height === 0) {
                console.warn('⚠️ Canvas tiene dimensiones 0, forzando resize...');
                cadViewer.onWindowResize();
            }
        }, 100);
        
    } catch (error) {
        console.error('❌ Error inicializando CAD Viewer:', error);
        return Promise.reject(error);
    }
    
    // Cargar el archivo CAD
    return cadViewer.loadCADFromEquipo(equipoId);
};

// Exponer funciones de debugging globalmente
window.diagnosticarVisorCAD = diagnosticarVisorCAD;
window.reinicializarVisorCAD = reinicializarVisorCAD;
