/**
 * Visor CAD Simplificado - Sin archivos basura, conversión directa
 * Enfoque: Velocidad y limpieza
 */

class SimpleCADViewer {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.scene = null;
        this.camera = null;
        this.renderer = null;
        this.controls = null;
        this.currentModel = null;
        
        // Variables de estado
        this.isLoading = false;
        this.loadingStartTime = null;
        
        this.init();
    }

    init() {
        if (!this.container) {
            console.error('Container no encontrado');
            return;
        }

        this.setupScene();
        this.setupCamera();
        this.setupRenderer();
        this.setupControls();
        this.setupLights();
        this.animate();
        
        console.log('✅ Simple CAD Viewer inicializado');
    }

    setupScene() {
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(0xf0f0f0);
    }

    setupCamera() {
        const aspect = this.container.clientWidth / this.container.clientHeight;
        this.camera = new THREE.PerspectiveCamera(75, aspect, 0.1, 10000);
        this.camera.position.set(10, 10, 10);
    }

    setupRenderer() {
        this.renderer = new THREE.WebGLRenderer({ antialias: true });
        this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        this.container.appendChild(this.renderer.domElement);
    }

    setupControls() {
        this.controls = new THREE.OrbitControls(this.camera, this.renderer.domElement);
        this.controls.enableDamping = true;
        this.controls.dampingFactor = 0.1;
    }

    setupLights() {
        // Luz ambiente
        const ambientLight = new THREE.AmbientLight(0x404040, 0.6);
        this.scene.add(ambientLight);

        // Luz direccional
        const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
        directionalLight.position.set(50, 50, 50);
        directionalLight.castShadow = true;
        this.scene.add(directionalLight);
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        this.controls.update();
        this.renderer.render(this.scene, this.camera);
    }

    // *** FUNCIÓN PRINCIPAL: Cargar archivo STEP de forma eficiente ***
    async loadSTEPFile(file) {
        if (this.isLoading) {
            console.warn('Ya hay una carga en progreso');
            return;
        }

        this.isLoading = true;
        this.loadingStartTime = Date.now();
        
        console.log('🚀 Iniciando carga rápida de archivo STEP:', file.name);
        console.log('📏 Tamaño:', (file.size / 1024 / 1024).toFixed(1), 'MB');
        
        this.showLoadingIndicator();

        try {
            // *** ESTRATEGIA: Conversión directa sin archivos intermedios ***
            const formData = new FormData();
            formData.append('cad_file', file);
            formData.append('convert_to', 'glb');
            formData.append('quality', file.size > 50 * 1024 * 1024 ? 'fast' : 'medium');

            const response = await fetch('/LSA/convert-cad-opencascade', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Error en conversión');
            }

            // Obtener datos binarios del GLB
            const glbData = await response.arrayBuffer();
            const loadTime = Date.now() - this.loadingStartTime;
            
            console.log('✅ Conversión completada en', loadTime, 'ms');
            console.log('📁 Archivo GLB recibido:', glbData.byteLength, 'bytes');

            // *** CARGA DIRECTA EN MEMORIA - SIN ARCHIVOS TEMPORALES ***
            await this.loadGLBFromMemory(glbData, file.name);
            
            this.hideLoadingIndicator();
            this.fitCameraToModel();
            
            const totalTime = Date.now() - this.loadingStartTime;
            console.log('🎯 Carga total completada en', totalTime, 'ms');
            
        } catch (error) {
            console.error('❌ Error cargando archivo STEP:', error);
            this.hideLoadingIndicator();
            this.showError('Error cargando archivo: ' + error.message);
        } finally {
            this.isLoading = false;
        }
    }

    // *** CARGA GLB DIRECTA DESDE MEMORIA ***
    async loadGLBFromMemory(arrayBuffer, originalName) {
        return new Promise((resolve, reject) => {
            // Verificar que GLTFLoader esté disponible
            if (!THREE.GLTFLoader) {
                reject(new Error('GLTFLoader no está disponible'));
                return;
            }

            const loader = new THREE.GLTFLoader();
            
            loader.parse(arrayBuffer, '', (gltf) => {
                console.log('✅ GLB cargado desde memoria exitosamente');
                
                // Limpiar modelo anterior
                if (this.currentModel) {
                    this.scene.remove(this.currentModel);
                }
                
                const model = gltf.scene;
                model.name = originalName;
                
                // Optimizar materiales
                model.traverse((child) => {
                    if (child.isMesh) {
                        child.material = new THREE.MeshPhongMaterial({
                            color: child.material.color || 0x888888,
                            shininess: 30
                        });
                        child.castShadow = true;
                        child.receiveShadow = true;
                    }
                });
                
                this.scene.add(model);
                this.currentModel = model;
                
                console.log('🎯 Modelo añadido a la escena');
                resolve();
                
            }, (error) => {
                console.error('❌ Error parseando GLB:', error);
                reject(error);
            });
        });
    }

    fitCameraToModel() {
        if (!this.currentModel) return;

        const box = new THREE.Box3().setFromObject(this.currentModel);
        const center = box.getCenter(new THREE.Vector3());
        const size = box.getSize(new THREE.Vector3());
        
        const maxDim = Math.max(size.x, size.y, size.z);
        const distance = maxDim * 2;
        
        this.camera.position.set(
            center.x + distance,
            center.y + distance,
            center.z + distance
        );
        
        this.controls.target.copy(center);
        this.controls.update();
        
        console.log('📐 Cámara ajustada al modelo');
    }

    showLoadingIndicator() {
        const indicator = document.createElement('div');
        indicator.id = 'cad-loading';
        indicator.innerHTML = `
            <div style="
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(0,0,0,0.8);
                color: white;
                padding: 20px;
                border-radius: 10px;
                text-align: center;
                z-index: 1000;
            ">
                <div style="margin-bottom: 10px;">⚡ Procesando archivo STEP...</div>
                <div style="font-size: 12px; opacity: 0.7;">Conversión optimizada en progreso</div>
            </div>
        `;
        this.container.appendChild(indicator);
    }

    hideLoadingIndicator() {
        const indicator = document.getElementById('cad-loading');
        if (indicator) {
            indicator.remove();
        }
    }

    showError(message) {
        const error = document.createElement('div');
        error.innerHTML = `
            <div style="
                position: absolute;
                top: 20px;
                right: 20px;
                background: #ff4444;
                color: white;
                padding: 15px;
                border-radius: 5px;
                z-index: 1000;
            ">
                ❌ ${message}
                <div style="margin-top: 10px;">
                    <button onclick="this.parentElement.parentElement.remove()" 
                            style="background: white; color: #ff4444; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">
                        Cerrar
                    </button>
                </div>
            </div>
        `;
        this.container.appendChild(error);
    }

    // Limpiar recursos
    dispose() {
        if (this.renderer) {
            this.renderer.dispose();
        }
        if (this.controls) {
            this.controls.dispose();
        }
        console.log('🧹 Recursos limpiados');
    }
}

// *** FUNCIÓN GLOBAL SIMPLE ***
window.createSimpleCADViewer = function(containerId) {
    return new SimpleCADViewer(containerId);
};

console.log('✅ Simple CAD Viewer cargado - Sin archivos basura');
