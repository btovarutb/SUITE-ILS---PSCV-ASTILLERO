##este es el pro

from flask import Flask,session,flash, render_template, request, jsonify, redirect, url_for, make_response, g, send_file

from markupsafe import Markup

import logging
import uuid
import json
import MySQLdb.cursors
import uuid  # Para generar un token único
from src.__init__ import create_app, db 
from src.config import config  
from io import BytesIO
from flask_cors import CORS
from flask_session import Session
import unicodedata
import re


from src.database import (
    obtener_id_equipo_por_equipo_info,
    obtener_id_sistema_por_equipo_info,
    obtener_aor_por_id_equipo_info,
    obtener_id_equipo_por_id_info,
    obtener_id_equipo_por_nombre,


    insertar_componente_analisis_funcional,
    verificar_conexion,
    obtener_grupos_constructivos,
    obtener_subgrupos,
    obtener_sistemas,
    obtener_equipos,
    buscar_equipos,
    buscar_subgrupos,
    buscar_sistemas,
    obtener_personal,
    obtener_tipos_equipos,
    insertar_procedimiento,
    insertar_diagrama,
    insertar_equipo_info,
    obtener_equipos_por_tipo,
    obtener_sistema_por_id, 
    obtener_subsistemas_por_equipo, 
    insertar_analisis_funcional,
    obtener_usuario_por_correo,
    insertar_repuesto,
    eliminar_repuesto,
    actualizar_repuesto,


    obtener_repuestos_por_equipo_info,
    obtener_repuesto_por_id,
    obtener_herramientas_especiales_por_equipo,
    obtener_tipos_herramientas,
    insertar_analisis_herramienta,
    obtener_analisis_herramientas_por_equipo,
    insertar_herramienta_requerida,
    insertar_herramienta_especial,
    



    insertar_fmea,
    obtener_nombre_por_id,


    obtener_subsistema_por_id,
    insertar_falla_funcional,
    insertar_descripcion_modo_falla,
    insertar_causa,
    

    #Obtener para desplegables FMEA
    obtener_componentes_por_subsistema,
    obtener_mecanismos_falla,
    obtener_codigos_modo_falla,
    obtener_metodos_deteccion_falla,
    obtener_fallos_ocultos,
    obtener_seguridad_fisica,
    obtener_impacto_operacional,
    obtener_medio_ambiente,
    obtener_costos_reparacion,
    obtener_flexibilidad_operacional,
    obtener_Ocurrencia,
    obtener_probablilidad_deteccion,
    obtener_herramientas_por_equipo,



    obtener_fmeas,
    obtener_fmea_por_id,
    actualizar_fmea,
    obtener_id_equipo_info_por_fmea,
    obtener_id_sistema_por_fmea_id,
    obtener_id_subsistema_por_componente_id,
    obtener_id_componente_por_fmea_id,
    obtener_ID_FMEA,
    obtener_lista_riesgos,

    eliminar_herramienta_especial,
    actualizar_herramienta_especial,
    obtener_herramienta_especial_por_id,
    eliminar_analisis_herramienta,
    actualizar_analisis_herramienta,
    obtener_analisis_herramienta_por_id,
    actualizar_equipo_info,
    obtener_equipo_info_por_id,

    
    obtener_diagramas_por_id,
    obtener_responsables,
    eliminar_equipo_info,


    

    #MTA
    insertar_mta,
    obtener_nombre_componente_por_id,
    obtener_tipos_mantenimiento,
    obtener_tareas_mantenimiento,

    obtener_subsistema_por_id,
    obtener_procedimiento_por_id,
    obtener_personal_por_id,
    obtener_tipo_equipo_por_id,
    obtener_grupo_constructivo_por_sistema_id,
    obtener_datos_equipo_por_id,
    obtener_subgrupo_constructivo_por_sistema_id,
    obtener_mta_por_id_rcm,
    insertar_herramienta_relacion,
    obtener_herramientas_generales_por_equipo,
    obtener_herramientas_especiales_por_equipo,
    obtener_detalle_herramienta_especial,
    obtener_detalle_herramienta_general,
    obtener_herramientas_relacionadas_por_equipo,


    ##analisis funcional

    obtener_analisis_funcionales_por_equipo_info,
    obtener_analisis_funcional_por_id,
    actualizar_analisis_funcional,
    eliminar_analisis_funcional,
    insertar_analisis_funcional,
    obtener_subsistemas_por_equipo,
    obtener_nombre_sistema_por_id,
    obtener_subsistemas_por_equipo_mostrar,





    #RCM
    insertar_rcm,
    obtener_rcm_por_fmea,
    obtener_rcms_completos,
    obtener_fmeas_con_rcm,
    eliminar_rcm,
    actualizar_rcm,

    obtener_lista_acciones_recomendadas,

    obtener_herramientas_requeridas_por_tipo,

    insertar_herramientas_requeridas_mta,
    eliminar_herramientas_requeridas_mta,
    insertar_repuestos_requeridos_mta,
    eliminar_repuestos_requeridos_mta,

    insertar_mta_lora,
    obtener_max_id_mta,

    obtener_rcms_con_mta,

    obtener_lora_mta_por_id_mta,
    obtener_herramientas_mta_por_id_mta,
    obtener_datos_herramienta,

    obtener_repuestos_mta_por_id_mta,

    actualizar_mta_lora,
    actualizar_mta,


    obtener_mtas_completos,

    obtener_herramientas_mta,
    obtener_repuestos_mta,
    obtener_mta_lora,
    obtener_id_equipo_info_por_nombre,

    obtener_informacion_equipo_info,
    obtener_fmeas_por_equipo_info,
    obtener_rcm_por_equipo_info,

    obtener_mta_por_equipo_info,
    crear_personal,
    eliminar_personal,

    obtener_fmeas_con_rcm_por_equipo_info,
    obtener_rcms_con_mta_por_equipo_info,

    obtener_equipos_por_sistema,
    actualizar_diagrama,
    actualizar_procedimiento,
    obtener_sistemas_por_grupo,
    obtener_subgrupos_por_sistema,
    check_nombre_equipo_exists,

    obtener_herramientas_requeridas_por_tipo,

    insertar_herramientas_requeridas_mta,
    eliminar_herramientas_requeridas_mta,
    insertar_repuestos_requeridos_mta,
    eliminar_repuestos_requeridos_mta,

    insertar_mta_lora,
    obtener_max_id_mta,

    obtener_rcms_con_mta,

    obtener_lora_mta_por_id_mta,
    obtener_herramientas_mta_por_id_mta,
    obtener_repuestos_mta_por_id_mta,

    actualizar_mta_lora,
    actualizar_mta,

    obtener_rcm_por_id,
    obtener_mtas_completos,

    eliminar_mta,
    obtener_herramientas_mta,
    obtener_repuestos_mta,
    obtener_mta_lora,
    obtener_id_equipo_info_por_nombre,

    obtener_informacion_equipo_info,
    obtener_fmeas_por_equipo_info,
    obtener_rcm_por_equipo_info,

    obtener_mta_por_equipo_info,
   

    obtener_fmeas_con_rcm_por_equipo_info,
    obtener_rcms_con_mta_por_equipo_info,

    obtener_equipos_por_sistema,
    actualizar_diagrama,
    actualizar_procedimiento,
    obtener_sistemas_por_grupo,
    obtener_subgrupos_por_sistema,

    obtener_equipos_por_buque_y_sistema,
    obtener_sistema_por_codigo,
    obtener_subgrupo_por_codigo,
    obtener_grupo_por_codigo,
    guardar_o_actualizar_buque,
    obtener_datos_buque,
    actualizar_fua_fr_db, 
    obtener_fua_fr_db,
    obtener_nombre_equipo_por_id
)

from src.__init__ import create_app


app = Flask(__name__)
app = create_app()
app.config.from_object(config['development'])
app.config['UPLOAD_FOLDER'] = 'uploads'
app.config['MAX_CONTENT_LENGTH'] = 16 * 1024 * 1024
app.secret_key = 'tu_clave_secreta'
app.config['SECRET_KEY'] = 'tu_clave_secreta_aquí'

app.config['SESSION_TYPE'] = 'filesystem'
app.config['SESSION_COOKIE_SAMESITE'] = 'None'
app.config['SESSION_COOKIE_SECURE'] = True


Session(app)
CORS(app, supports_credentials=True, resources={
    r"/*": {"origins": ["http://localhost:8010", "http://localhost:8080"]}
})




# Configura el logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)


@app.route('/login-external', methods=['POST', 'GET'])
def login_external():
    # Verificar si ya tenemos un token
    token = request.args.get('token') or request.json.get('token') or request.cookies.get('user_token')

    if token:
        # Si el token ya existe, lo guardamos en la cookie y redirigimos a la página de inicio (LSA)
        response = make_response(redirect(url_for('index')))
        response.set_cookie('user_token', token, httponly=True, secure=False, samesite='Lax')
        return response
    
    # Si no hay token, retornamos un error
    return "Token no recibido", 400




@app.errorhandler(Exception)
def handle_all_errors(error):
    app.logger.error(f"Error atrapado por errorhandler: {error}")
    return render_template('error.html', mensaje=str(error)), 500

@app.route('/check', methods=['GET', 'POST'])

def check_db_connection():
    result, status_code = verificar_conexion()
    return jsonify(result), status_code

@app.route('/api/popup-data', methods=['GET'])
def obtener_datos_popup():
    return render_template('pop.html')

@app.route('/LSA', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        # Manejo de solicitudes POST
        data = request.json

        # Extraer datos del payload
        buque_id = data.get('buqueId')
        sistema_id = data.get('sistemaId')
        nombre_buque = data.get('nombre_buque')
        codigo = data.get('codigo')
        nombre = data.get('nombre')
        nombre_sistema = data.get('nombre')  # Este es el nombre del sistema, no del buque
        mec = data.get('mec')
        misiones = data.get('misiones', [])  
        datosPuertoBase = data.get('datosPuertoBase',[])
        origen = data.get('origen', 'desconocido') 

        # Guardar misiones en la base de datos
        guardar_o_actualizar_buque(buque_id, "", misiones)

        app.logger.info("Ya actualizo o guardo la info del buque")

        # Guardar información general en la sesión
        session['desde_ils'] = True
        session['buque_id'] = buque_id
        session['sistema_id'] = sistema_id
        session['nombre_buque'] = nombre_buque
        session['codigo'] = codigo
        session['nombre'] = nombre
        session['nombre_sistema'] = nombre_sistema
        session['mec'] = mec
        session['datosPuertoBase'] = datosPuertoBase
        session['origen'] = origen

        app.logger.info(f"Session after POST: {dict(session)}")

        redirect_url = url_for('index', _external=True, desde_ils=True, buqueId=buque_id)
        return jsonify({
            "message": "Datos guardados en la base de datos correctamente.",
            "redirect_url": redirect_url
        })

    elif request.method == 'GET':
        # Manejo de solicitudes GET
        desde_ils = request.args.get('desde_ils', 'false') == 'true' or session.get('desde_ils', False)
        buque_id = request.args.get('buqueId', type=int) or session.get('buque_id')
        origen = session.get('origen', 'desconocido')

        app.logger.info(f"Session after GET: {dict(session)}")

        app.logger.info(f"Obteniendo datos para el buque_id: {buque_id}")

        # Validar si hay un buque_id
        if not buque_id:
            return redirect(url_for('login'))

        # Obtener datos de la sesión
        sistema_id = session.get('sistema_id')
        codigo = session.get('codigo')
        nombre = session.get('nombre')
        nombre_sistema = session.get('nombre_sistema')
        mec = session.get('mec')
        nombre_buque = session.get('nombre_buque')

        # Verificar si proviene de Laravel o no
        if desde_ils:
            grupos = obtener_grupos_constructivos()
            equipos = obtener_equipos_por_buque_y_sistema(buque_id, sistema_id)

            return render_template(
                'index.html',
                buque_id=buque_id,
                sistema_id=sistema_id,
                codigo=codigo,
                nombre=nombre,
                nombre_sistema=nombre_sistema,
                mec=mec,
                grupos=grupos,
                equipos=equipos,
                desde_ils=True,
                origen=origen
            )

        # Acceso estándar (sin desde_ils)
        grupos = obtener_grupos_constructivos()

        return render_template(
            'lsa_view.html',
            buque_id=buque_id,
            nombre_buque=nombre_buque,
            grupos=grupos,
            desde_ils=False
        )

@app.route('/api/grupos', methods=['GET'])
def obtener_grupos_api():
    grupos = obtener_grupos_constructivos()
    return jsonify(grupos)

@app.route('/api/subgrupos/<int:id_grupo>', methods=['GET'])
def obtener_subgrupos_api(id_grupo):
    subgrupos = obtener_subgrupos(id_grupo)
    return jsonify(subgrupos)

@app.route('/api/sistemas/<int:id_subgrupo>', methods=['GET'])
def obtener_sistemas_api(id_subgrupo):
    sistemas = obtener_sistemas(id_subgrupo)
    return jsonify(sistemas)

@app.route('/api/equipos/<int:id_sistema>', methods=['GET'])
def obtener_equipos_api(id_sistema):
    id_buque = request.args.get('id_buque')  # Obtener id_buque del query string
    equipos = obtener_equipos(id_sistema, id_buque if id_buque else None)
    return jsonify(equipos)


@app.route('/api/buscar_equipos', methods=['GET'])
def buscar_equipos_api():
    busqueda = request.args.get('busqueda', '')
    id_sistema = request.args.get('id_sistema', type=int)
    if busqueda:
        equipos = buscar_equipos(busqueda, id_sistema)
        return jsonify(equipos)
    return jsonify([])

@app.route('/api/buscar_equipos_buque', methods=['GET'])
def buscar_equipos_buque_api():
    busqueda = request.args.get('busqueda', '')
    id_sistema = request.args.get('id_sistema', type=int)
    id_buque = session['buque_id']
    if busqueda:
        equipos = buscar_equipos(busqueda, id_sistema, id_buque)
        return jsonify(equipos)
    return jsonify([])

@app.route('/api/buscar_subgrupos', methods=['GET'])
def buscar_subgrupos_api():
    busqueda = request.args.get('busqueda', '')
    id_grupo = request.args.get('id_grupo', type=int)
    if busqueda and id_grupo:
        subgrupos = buscar_subgrupos(busqueda, id_grupo)
        return jsonify(subgrupos)
    return jsonify([])

@app.route('/api/buscar_sistemas', methods=['GET'])
def buscar_sistemas_api():
    busqueda = request.args.get('busqueda', '')
    id_subgrupo = request.args.get('id_subgrupo', type=int)
    if busqueda and id_subgrupo:
        sistemas = buscar_sistemas(busqueda, id_subgrupo)
        return jsonify(sistemas)
    return jsonify([])


@app.route('/LSA/registro-generalidades', methods=['GET', 'POST'])
def registro_generalidades():
    token = g.user_token
    app.logger.info(f"Recibida solicitud {request.method} en /LSA/registro-generalidades")

    if not g.get('user_token'):
        return redirect(url_for('login'))

    # Identificar si se accedió desde index.html o lsa_view
    desde_index = 'buqueId' in request.args and 'codigo' in request.args
    buque_id = request.args.get('buqueId', type=int) if desde_index else None
    codigo = request.args.get('codigo', type=int) if desde_index else None
    sistema_id_ils = request.args.get('sistemaId', type=int) if desde_index else None
    mec = request.args.get('mec') if desde_index else None
    

    if request.method == 'POST':
        try:
            
            fecha = request.form.get('fecha')
            nombre_equipo = request.form.get('nombre_equipo')
            id_personal = request.form.get('responsable')
            id_sistema = request.form.get('sistema')
            id_equipo = request.form.get('equipo')
            GRES = int(mec.split()[-1]) if mec.split()[-1].isdigit() else None
            fiabilidad_equipo = request.form.get('fiabilidad_equipo')
            criticidad_equipo = request.form.get('criticidad_equipo')
            marca = request.form.get('marca')
            modelo = request.form.get('modelo')
            peso_seco = request.form.get('peso_seco')
            dimensiones = request.form.get('dimensiones')
            descripcion = request.form.get('descripcion_equipo')
            procedimiento_arranque = request.form.get('procedimiento_arranque')
            procedimiento_parada = request.form.get('procedimiento_parada')
            id_buque = buque_id
            id_sistema_ils = sistema_id_ils

            # Manejo de archivos
            imagen_file = request.files.get('imagen_equipo')
            if imagen_file and imagen_file.filename != '':
                imagen = imagen_file.read()
            else:
                imagen = None

            diagrama_flujo_file = request.files.get('diagrama_flujo')
            if diagrama_flujo_file and diagrama_flujo_file.filename != '':
                diagrama_flujo = diagrama_flujo_file.read()
            else:
                diagrama_flujo = None

            diagrama_caja_negra_file = request.files.get('diagrama_caja_negra')
            if diagrama_caja_negra_file and diagrama_caja_negra_file.filename != '':
                diagrama_caja_negra = diagrama_caja_negra_file.read()
            else:
                diagrama_caja_negra = None

            diagrama_caja_transparente_file = request.files.get('diagrama_caja_transparente')
            if diagrama_caja_transparente_file and diagrama_caja_transparente_file.filename != '':
                diagrama_caja_transparente = diagrama_caja_transparente_file.read()
            else:
                diagrama_caja_transparente = None

            # Insertar en la tabla procedimientos
            id_procedimiento = insertar_procedimiento(procedimiento_arranque, procedimiento_parada)

            # Insertar en la tabla diagramas
            id_diagrama = insertar_diagrama(diagrama_flujo, diagrama_caja_negra, diagrama_caja_transparente)

            # Insertar en la tabla equipo_info
            insertar_equipo_info(
                nombre_equipo, fecha, fiabilidad_equipo, GRES, criticidad_equipo,
                marca, modelo, peso_seco, dimensiones, descripcion, imagen,
                id_personal, id_diagrama, id_procedimiento, id_sistema, id_equipo, id_sistema_ils, id_buque
            )

            id_equipo_info = obtener_id_equipo_por_nombre(
                nombre_equipo, buque_id, sistema_id_ils
            )

            # Redirigir a la ruta de 'mostrar_general_page' con el id del equipo recién creado
            return redirect(url_for('mostrar_general_page', id_equipo_info=id_equipo_info))
        except Exception as e:
            app.logger.error(f"Error procesando solicitud POST: {e}")
            return render_template('error.html', mensaje=f"Error procesando el formulario: {e}"), 500

    elif request.method == 'GET':
        try:
            grupos = obtener_grupos_constructivos()
            responsables = obtener_personal()
            tipos_equipos = obtener_tipos_equipos()

            # Si se accede desde index.html, cargar datos específicos
            if desde_index:
                sistema_info = obtener_sistema_por_codigo(codigo)
                if not sistema_info:
                    return "Sistema no encontrado", 404

                subgrupo_info = obtener_subgrupo_por_codigo(codigo)
                grupo_info = obtener_grupo_por_codigo(codigo)
                print(grupo_info)

                return render_template(
                    'registro_generalidades.html',
                    grupos=grupos,
                    responsables=responsables,
                    tipos_equipos=tipos_equipos,
                    buque_id=buque_id,
                    sistema_id=sistema_info['id'],
                    grupo_seleccionado=grupo_info,
                    subgrupo_seleccionado=subgrupo_info,
                    sistema_seleccionado=sistema_info,
                    desde_index=True,
                    mec=mec
                )
            else:
                # Si se accede desde lsa_view, no cargar datos específicos
                return render_template(
                    'registro_generalidades.html',
                    grupos=grupos,
                    responsables=responsables,
                    tipos_equipos=tipos_equipos,
                    desde_index=False
                )
        except Exception as e:
            app.logger.error(f"Error procesando solicitud GET: {e}")
            return render_template('error.html', mensaje=f"Error cargando la página: {e}"), 500


##################################################################################################################3















###########################################################################################################


##### Análisis Funcional #####

# Ruta para obtener los equipos por tipo de equipo
@app.route('/api/equipos_por_tipo/<int:id_tipo_equipo>', methods=['GET'])
def obtener_equipos_por_tipo_api(id_tipo_equipo):
    # Obtiene la lista de equipos para un tipo específico
    equipospro = obtener_equipos_por_tipo(id_tipo_equipo)
    return jsonify(equipospro)

# Ruta para obtener los componentes de un subsistema específico
@app.route('/api/componentes/<int:subsistema_id>', methods=['GET'])
def obtener_componentes(subsistema_id):
    # Llama a la función para obtener componentes por el id de subsistema y retorna en JSON
    componentes = obtener_componentes_por_subsistema(subsistema_id)
    return jsonify({'componentes': componentes})

# Ruta para registrar un nuevo análisis funcional
@app.route('/LSA/registro-analisis-funcional', methods=['GET', 'POST'])
def registro_analisis_funcional():
    # Generación del token y obtención de información del usuario
    token = g.get('user_token', None)
    # Priorizar el parámetro de URL 'id_equipo_info' si está presente
    id_equipo_info = (
        request.args.get('id_equipo_info') or
        session.get('id_equipo_info') or
        request.form.get('id_equipo_info')
    )

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_sistema = user_data.get('id_sistema')
        id_equipo = user_data.get('id_equipo')
        id_equipo_info = user_data.get('id_equipo_info')
    

    id_equipo = obtener_id_equipo_por_id_info(id_equipo_info)
    id_sistema = obtener_id_sistema_por_equipo_info(id_equipo_info)

    # Verificación de existencia de id_sistema y obtención de sistema y subsistemas
    if id_sistema is None:
        sistema = None
        subsistemas = []
    else:
        sistema = obtener_sistema_por_id(id_sistema)
        if sistema:
            subsistemas = obtener_subsistemas_por_equipo(id_equipo) if id_equipo else []
        else:
            subsistemas = []

    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()

    # Renderiza la plantilla con los datos obtenidos
    return render_template('registro_analisis_funcional.html', sistema=sistema, subsistemas=subsistemas,id_equipo_info=id_equipo_info, nombre_equipo=nombre_equipo)

# Ruta para registrar un nuevo análisis funcional en la base de datos
@app.route('/api/analisis-funcional', methods=['POST'])
def api_analisis_funcional():
    token = g.get('user_token', None)
    data = request.get_json()

    id_equipo_info = (
        data.get('id_equipo_info') or
        request.args.get('id_equipo_info') or
        session.get('id_equipo_info')
    )

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_sistema = user_data.get('id_sistema')
        id_equipo = user_data.get('id_equipo')
        id_equipo_info = user_data.get('id_equipo_info')
        subsistema_id = user_data.get('subsistema_id')


   

    # Obtener los datos principales del análisis funcional
    sistema_id = data.get('sistema')
    subsistema_id = data.get('subsistema')
    verbo = data.get('verbo')
    accion = data.get('accion')
    estandar_desempeño = data.get('estandar_desempeño')
    

    # Obtener los componentes enviados (debería ser una lista de componentes)
    componentes = data.get('componentes', [])  # Esto se espera como una lista [{id_componente, verbo, accion}, ...]

    # Validar los datos recibidos
    if not sistema_id or not subsistema_id or not verbo or not accion or not estandar_desempeño or not id_equipo_info:
        return jsonify({'error': 'Faltan datos obligatorios'}), 400

    # Insertar en la base de datos el análisis funcional principal
    analisis_funcional_id = insertar_analisis_funcional(
        verbo,
        accion,
        estandar_desempeño,
        id_equipo_info,
        subsistema_id
    )

    # Verificar si hay componentes y guardar cada componente en la tabla relacionada
    if componentes:
        for componente in componentes:
            id_componente = componente.get('id_')
            verbo_componente = componente.get('verbo') if componente.get('verbo') else None
            accion_componente = componente.get('accion') if componente.get('accion') else None

            # Insertar cada componente en la tabla `componente_analisis_funcional`
            insertar_componente_analisis_funcional(
                analisis_funcional_id,
                id_componente,
                verbo_componente,
                accion_componente
            )

    return jsonify({'message': 'Análisis funcional agregado', 'id': analisis_funcional_id}), 200


# Ruta para editar un análisis funcional específico
@app.route('/LSA/equipo/analisis_funcional/editar/<int:id>', methods=['GET', 'POST'])
def editar_analisis_funcional(id):
    token = g.get('user_token', None)

    id_equipo_info = (
        request.args.get('id_equipo_info') or
        session.get('id_equipo_info') or
        request.form.get('id_equipo_info')
    )


    if not id_equipo_info:
    # Obtención de token y datos del equipo
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_sistema = user_data.get('id_sistema')
        id_equipo = user_data.get('id_equipo')
        id_equipo_info = user_data.get('id_equipo_info')
    
    # Verificación de existencia del sistema
    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()

    id_equipo = obtener_id_equipo_por_id_info(id_equipo_info)
    id_sistema = obtener_id_sistema_por_equipo_info(id_equipo_info)

    sistema = obtener_sistema_por_id(id_sistema) if id_sistema else None
    subsistemas = obtener_subsistemas_por_equipo(id_equipo) if sistema else []

    

    # Obtención del análisis funcional y sus componentes
    analisis_funcional, componentes_analisis_funcionales = obtener_analisis_funcional_por_id(id)

    if request.method == 'POST':
        # Capturar datos de análisis funcional
        verbo = request.form['verbo']
        accion = request.form['accion']
        estandar_desempeño = request.form['estandar_desempeño']
        id_subsistema = request.form['subsistema']
        
        # Capturar datos de los componentes
        ids_componentes = request.form.getlist('id_componente[]')
        verbos = request.form.getlist('verbo[]')
        acciones = request.form.getlist('accion[]')

        # Crear estructura para los componentes usando valores obtenidos del formulario
        componentes_formateados = []
        ids_procesados = set()  # Conjunto temporal solo para este procesamiento

        for i in range(len(ids_componentes)):
            id_componente = ids_componentes[i]

            # Verificar si este id ya fue procesado en esta extracción
            if id_componente not in ids_procesados:
                componente = {
                    'id_': id_componente,
                    'verbo': verbos[i] if verbos[i] else None,  # Convertimos valores vacíos a None
                    'accion': acciones[i] if acciones[i] else None
                }
                componentes_formateados.append(componente)
                ids_procesados.add(id_componente)  # Marcamos este id como procesado en este ciclo


        # Debug para verificar los componentes formateados

        for componente in componentes_formateados:
            print(f"ID: {componente['id_']}, Verbo: {componente['verbo']}, Acción: {componente['accion']}")

        # Llamar a la función de actualización con los datos capturados
        actualizar_analisis_funcional(id, verbo, accion, estandar_desempeño, id_subsistema, componentes_formateados)
        flash('Análisis funcional actualizado correctamente')

        # Redireccionar después de la actualización
        return redirect(url_for('mostrar_analisis_funcional'))

    return render_template('editar_analisis_funcional.html', 
                           nombre_equipo=nombre_equipo,
                           analisis_funcional=analisis_funcional, 
                           sistema=sistema, 
                           subsistemas=subsistemas, 
                           componentes=componentes_analisis_funcionales,
                           id_equipo_info=id_equipo_info)


# Ruta para eliminar un análisis funcional
@app.route('/analisis_funcional/eliminar/<int:id>', methods=['DELETE'])
def eliminar_analisis_funcional_route(id):
    # Llama a la función para eliminar el análisis funcional
    eliminar_analisis_funcional(id)
    return jsonify({'message': 'Repuesto eliminado correctamente'}), 200


############## Fin de analisis funcional ######################################
# Diccionario global para almacenar la información temporal de los usuarios
usuario_info_temporal = {}

def generar_token():
    return str(uuid.uuid4())

# Lógica para las solicitudes antes de procesar la solicitud (sin validación de token)
@app.before_request
def before_request():
    # Lista de rutas que no requieren verificación de usuario
    rutas_sin_autenticacion = ['index', 'static', 'login', 'login_external']

    # Si la ruta actual está en la lista de rutas sin autenticación, no hacemos nada
    if request.endpoint in rutas_sin_autenticacion:
        return

    # Acceso desde ILS: si 'buqueId' está en los argumentos, permitimos el acceso sin login
    if 'buqueId' in request.args:
        g.usuario = {
            'correo': 'correo1@example.com',
            'nombre': 'Usuario ILS'
        }
        return  # Permitir acceso desde ILS sin redirección

    # Verificación de usuario para otras rutas
    token = request.cookies.get('user_token')
    if not token:
        # Redirige al login solo si no hay token y no es un acceso desde ILS
        return redirect(url_for('login'))


# No es necesario 'after_request' en este caso
#aui se crea el diccionario de usuario info o usuario data

def guardar_info_usuario(token, id_sistema=None, id_equipo=None, id_equipo_info=None, usuario_id=None,subsistema_id=None):
    
    if token in usuario_info_temporal:
        # Actualizar la información existente
        if id_sistema is not None:
            usuario_info_temporal[token]['id_sistema'] = id_sistema
        if id_equipo is not None:
            usuario_info_temporal[token]['id_equipo'] = id_equipo
        if id_equipo_info is not None:
            usuario_info_temporal[token]['id_equipo_info'] = id_equipo_info
        if usuario_id is not None:
            usuario_info_temporal[token]['usuario_id'] = usuario_id
        if subsistema_id is not None:
            usuario_info_temporal[token]['subsistema_id'] = subsistema_id
    else:

        usuario_info_temporal[token] = {
            'id_sistema': id_sistema,
            'id_equipo': id_equipo,
            'id_equipo_info': id_equipo_info,
            'usuario_id': usuario_id,
            'subsistema_id': subsistema_id
        }

def obtener_info_usuario(token):
    return usuario_info_temporal.get(token, {})

@app.route('/', methods=['GET', 'POST'])
def login():
    if request.method == 'GET':
        return render_template('login.html')

    # Manejo del POST para autenticación
    correo = request.form.get('correo')
    password = request.form.get('password')

    # Validar credenciales de usuario
    usuario = obtener_usuario_por_correo(correo)
    if usuario and usuario['password'] == password:
        # Autenticación exitosa: guardar token en cookie
        token = generar_token()
        response = make_response(redirect(url_for('index')))
        response.set_cookie('user_token', token, httponly=True, secure=False)
        g.user_token = token
        return response

    return render_template('login.html', error='Credenciales incorrectas')

    
@app.route('/logout')
def logout():
    token = request.cookies.get('user_token')
    if token and token in usuario_info_temporal:
        usuario_info_temporal.pop(token)  # Eliminar la información del usuario
    response = make_response(redirect(url_for('login')))
    response.set_cookie('user_token', '', expires=0)  # Eliminar la cookie
    return response



#Rutas para repuesto
# app.py
@app.route('/LSA/mostrar-repuesto', methods=['GET'])
def mostrar_repuestos():

    # Priorizar el parámetro de URL 'id_equipo_info' si está presente
    id_equipo_info = request.args.get('id_equipo_info')


    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')
    #    repuestos = obtener_repuestos_por_equipo_info(id_equipo_info)

    if id_equipo_info is None:
        return redirect(url_for('registro_generalidades'))

    repuestos = obtener_repuestos_por_equipo_info(id_equipo_info)
    return render_template('mostrar_repuesto.html', repuestos=repuestos,id_equipo_info=id_equipo_info)

@app.route('/LSA/mostrar-repuesto-ext', methods=['GET'])
def mostrar_repuestos_ext():
    # Priorizar el parámetro de URL 'id_equipo_info' si está presente
    id_equipo_info = request.args.get('id_equipo_info').title()
    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()
    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')
    #    repuestos = obtener_repuestos_por_equipo_info(id_equipo_info)
    if id_equipo_info is None:
        return redirect(url_for('registro_generalidades'))

    repuestos = obtener_repuestos_por_equipo_info(id_equipo_info)
    
    return render_template('mostrar_respuestos_ext.html', repuestos=repuestos,id_equipo_info=id_equipo_info, nombre_equipo=nombre_equipo)


# app.py
@app.route('/api/repuesto', methods=['POST'])
def agregar_repuesto():

    token = g.user_token
    user_data = obtener_info_usuario(token)
    id_equipo_info = user_data.get('id_equipo_info')
    if id_equipo_info is None:
        id_equipo_info = request.form.get('id_equipo_info')

    # Si estás manejando archivos (imágenes), debes usar request.form en lugar de request.get_json()
    nombre_repuesto = request.form.get('nombre_repuesto')
    valor = request.form.get('valor')
    dibujo_transversal = request.files.get('dibujo_transversal')
    notas = request.form.get('notas')
    mtbf = request.form.get('mtbf')
        
    codigo_otan = request.form.get('codigo_otan')

    if not id_equipo_info or not nombre_repuesto:
        return jsonify({'error': 'Faltan datos obligatorios'}), 400
    
     # Validar y convertir 'valor' a float
    try:
        valor = float(valor) if valor else None
    except ValueError:
        return jsonify({'error': 'El valor debe ser un número decimal'}), 400

    # Validar y convertir 'mtbf' a float
    try:
        mtbf = float(mtbf) if mtbf else None
    except ValueError:
        return jsonify({'error': 'El MTBF debe ser un número decimal'}), 400

    # Leer los datos de la imagen si existe

    # Procesar la imagen 'dibujo_transversal' si existe
    dibujo_transversal_data = dibujo_transversal.read() if dibujo_transversal else None

    repuesto_id = insertar_repuesto(
        id_equipo_info, nombre_repuesto, valor,
        dibujo_transversal_data, notas, mtbf, codigo_otan
    )
    return jsonify({'message': 'Repuesto agregado correctamente', 'id': repuesto_id}), 200


# app.py
@app.route('/api/repuesto/<int:id_repuesto>', methods=['POST'])
def actualizar_repuesto_route(id_repuesto):
    nombre_repuesto = request.form.get('nombre_repuesto')
    valor = request.form.get('valor')
    dibujo_transversal = request.files.get('dibujo_transversal')
    notas = request.form.get('notas')
    mtbf = request.form.get('mtbf')
    codigo_otan = request.form.get('codigo_otan')

    if not nombre_repuesto:
        return jsonify({'error': 'Faltan datos obligatorios'}), 400

    # Validar y convertir los valores numéricos
    try:
        valor = float(valor) if valor else None
        mtbf = float(mtbf) if mtbf else None
    except ValueError:
        return jsonify({'error': 'Valor o MTBF deben ser números válidos'}), 400

    # Leer los datos del archivo si se ha subido uno nuevo
    dibujo_transversal_data = dibujo_transversal.read() if dibujo_transversal else None

    # Llamar a la función para actualizar el repuesto en la base de datos
    actualizar_repuesto(id_repuesto, nombre_repuesto, valor, dibujo_transversal_data, notas, mtbf, codigo_otan)
    return jsonify({'message': 'Repuesto actualizado correctamente'}), 200


# app.py
@app.route('/api/repuesto/<int:id_repuesto>', methods=['DELETE'])
def eliminar_repuesto_route(id_repuesto):
    eliminar_repuesto(id_repuesto)
    return jsonify({'message': 'Repuesto eliminado correctamente'}), 200




@app.route('/LSA/editar-repuesto/<int:id_repuesto>', methods=['GET'])
def editar_repuesto(id_repuesto):
    token = g.user_token
    id_equipo_info = request.args.get('id_equipo_info')  # Obtiene el ID del equipo desde los parámetros de la URL
    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()

    # Validar que id_equipo_info esté presente
    if not id_equipo_info:
        return 'ID del equipo no proporcionado', 400

    # Obtener los datos del repuesto
    repuesto = obtener_repuesto_por_id(id_repuesto)
    if not repuesto:
        return 'Repuesto no encontrado', 404

    return render_template('editar_repuesto.html', repuesto=repuesto, id_equipo_info=id_equipo_info, nombre_equipo=nombre_equipo)


@app.template_filter('b64encode')
def b64encode_filter(data):
    if data:
        import base64
        return Markup(base64.b64encode(data).decode('utf-8'))
    return ''



# app.py



#Aqui se hace todo lo que tiene que ver con herramientas


    #Analisis herramientas es herramientas generales 
    
#agregar herramientas generales:


@app.route('/api/analisis-herramientas', methods=['POST'])
def agregar_analisis_herramienta():

    id_equipo_info = (
        request.args.get('id_equipo_info') or
        session.get('id_equipo_info') or
        request.form.get('id_equipo_info')
    )

    # Si no se recibe desde el formulario, tomarlo del usuario
    if not id_equipo_info:
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')


    nombre = request.form.get('nombre')
    valor = request.form.get('valor')
    parte_numero = request.form.get('parte_numero')
    id_tipo_herramienta = request.form.get('tipo_herramienta')
    cantidad = request.form.get('cantidad')
    
    # Aquí se captura el archivo de dibujo seccion transversal
    dibujo_seccion_transversal = request.files.get('dibujo_seccion_transversal')
    id_clase_herramienta = 1
    id_clase_herramienta = 1  # Define que es herramienta general



    if not all([nombre, valor, parte_numero, id_tipo_herramienta, cantidad]):
        return jsonify({'error': 'Todos los campos son obligatorios excepto la imagen'}), 400


    try:
        valor = float(valor) if valor else None
    except ValueError:
        return jsonify({'error': 'El valor debe ser numérico'}), 400

    # Leer el archivo si existe
    dibujo_seccion_transversal = dibujo_seccion_transversal.read() if dibujo_seccion_transversal else None

    # Insertar en la tabla herramientas_requeridas y obtener el ID
    id_herramienta_requerida = insertar_herramienta_requerida(nombre, id_tipo_herramienta,id_clase_herramienta)

    # Insertar en la tabla herramientas_generales, incluyendo el archivo si está disponible
    analisis_id = insertar_analisis_herramienta(
        nombre, valor, id_equipo_info, parte_numero, id_herramienta_requerida, id_tipo_herramienta,id_clase_herramienta,
        dibujo_seccion_transversal,cantidad
    )
    return jsonify({'message': 'Análisis de herramienta agregado', 'id': analisis_id}), 200



#editar las herramientas generales:

@app.route('/LSA/editar-analisis-herramienta/<int:id_analisis>', methods=['GET'])
def editar_analisis_herramienta(id_analisis):
    token = g.user_token
    id_equipo_info = request.args.get('id_equipo_info')
    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()
    analisis = obtener_analisis_herramienta_por_id(id_analisis)
    if analisis is None:
        return "Análisis no encontrado", 404

    tipos_herramientas = obtener_tipos_herramientas()

    return render_template('editar_analisis_herramienta.html', analisis=analisis, tipos_herramientas=tipos_herramientas, id_equipo_info=id_equipo_info, nombre_equipo=nombre_equipo)

@app.route('/api/analisis-herramientas/<int:id_analisis>', methods=['PUT'])
def actualizar_analisis_herramienta_route(id_analisis):
    nombre = request.form.get('nombre')
    valor = request.form.get('valor')
    parte_numero = request.form.get('parte_numero')
    id_tipo_herramienta = request.form.get('tipo_herramienta')
    dibujo_seccion_transversal = request.files.get('dibujo_seccion_transversal')
    cantidad = request.form.get('cantidad')


    if not nombre or not id_tipo_herramienta:
        return jsonify({'error': 'Faltan datos obligatorios'}), 400

    try:
        valor = float(valor) if valor else None
    except ValueError:
        return jsonify({'error': 'El valor debe ser numérico'}), 400

    dibujo_data = dibujo_seccion_transversal.read() if dibujo_seccion_transversal else None

    # Si no se sube una nueva imagen, conservar la anterior
    if not dibujo_data:
        analisis = obtener_analisis_herramienta_por_id(id_analisis)
        dibujo_data = analisis['dibujo_seccion_transversal']

    actualizar_analisis_herramienta(id_analisis, nombre, valor, parte_numero, dibujo_seccion_transversal,cantidad)


    return jsonify({'message': 'Análisis de herramienta actualizado'}), 200


@app.route('/api/analisis-herramientas/<int:id_analisis>', methods=['DELETE'])
def eliminar_analisis_herramienta_route(id_analisis):
    eliminar_analisis_herramienta(id_analisis)
    return jsonify({'message': 'Análisis de herramienta eliminado'}), 200




# Función para obtener el equipo por id_equipo_info
def obtener_equipo_por_id(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT nombre_equipo FROM equipo_info WHERE id = %s"
    cursor.execute(query, (id_equipo_info,))
    equipo = cursor.fetchone()
    cursor.close()
    return equipo

@app.route('/api/herramientas-especiales', methods=['POST'])
def agregar_herramienta_especial():

    id_equipo_info = (
        request.args.get('id_equipo_info') or
        session.get('id_equipo_info') or
        request.form.get('id_equipo_info')
    )

    # Si no se recibe desde el formulario, tomarlo del usuario
    if not id_equipo_info:
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')



    parte_numero = request.form.get('parte_numero')
    nombre_herramienta = request.form.get('nombre_herramienta')
    valor = request.form.get('valor')
    dibujo_seccion_transversal = request.files.get('dibujo_seccion_transversal')
    nota = request.form.get('nota')
    manual_referencia = request.form.get('manual_referencia')
    id_tipo_herramienta = request.form.get('tipo_herramienta')
    cantidad = request.form.get('cantidad')


    id_clase_herramienta = 2  # Define que es herramienta especial


    if not all([nombre_herramienta, parte_numero, id_tipo_herramienta, cantidad]):
        return jsonify({'error': 'Faltan datos obligatorios.'}), 400

    # Convertir 'valor' a float

    try:
        valor = float(valor) if valor else None
    except ValueError:
        return jsonify({'error': 'El valor debe ser numérico'}), 400

    dibujo_data = dibujo_seccion_transversal.read() if dibujo_seccion_transversal else None

    # Insertar en la tabla herramientas_requeridas y obtener el ID
    id_herramienta_requerida = insertar_herramienta_requerida(nombre_herramienta, id_tipo_herramienta,id_clase_herramienta)

    # Insertar en la tabla herramientas_especiales, incluyendo el id_herramienta_requerida
    herramienta_id = insertar_herramienta_especial(
        parte_numero, nombre_herramienta, valor,
        dibujo_data, nota, id_equipo_info,
        manual_referencia, id_tipo_herramienta, cantidad,
        id_herramienta_requerida,id_clase_herramienta  # Asegurarse de pasar el id_herramienta_requerida aquí
    )
    insertar_herramienta_relacion(id_herramienta_requerida, id_clase_herramienta, id_equipo_info)
    return jsonify({'message': 'Herramienta especial agregada', 'id': herramienta_id}), 200


@app.route('/LSA/mostrar-herramientas-especiales', methods=['GET'])
def mostrar_herramientas_especiales():

    # Priorizar el parámetro de URL 'id_equipo_info' si está presente
    id_equipo_info = request.args.get('id_equipo_info') or session.get('id_equipo_info')

    analisis = obtener_analisis_herramientas_por_equipo(id_equipo_info)
    herramientas = obtener_herramientas_especiales_por_equipo(id_equipo_info)
    # If not found, try to get it from the session

    

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')
        analisis = obtener_analisis_herramientas_por_equipo(id_equipo_info)
        herramientas = obtener_herramientas_especiales_por_equipo(id_equipo_info)



    if id_equipo_info is None:
        return redirect(url_for('registro_generalidades'))


    #analisis = obtener_analisis_herramientas_por_equipo(id_equipo_info)
    #herramientas = obtener_herramientas_especiales_por_equipo(id_equipo_info)


    # Obtener herramientas relacionadas para el equipo desde la tabla de relaciones
    herramientas_relacionadas = obtener_herramientas_relacionadas_por_equipo(id_equipo_info)


    return render_template(
        'mostrar_herramientas-especiales.html',
        analisis=analisis,
        herramientas=herramientas,
        id_equipo_info=id_equipo_info
    )

@app.route('/LSA/mostrar-herramientas-especiales-ext', methods=['GET'])
def mostrar_herramientas_especiales_ext():

    # Priorizar el parámetro de URL 'id_equipo_info' si está presente
    id_equipo_info = request.args.get('id_equipo_info') or session.get('id_equipo_info')
    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()

    analisis = obtener_analisis_herramientas_por_equipo(id_equipo_info)
    herramientas = obtener_herramientas_especiales_por_equipo(id_equipo_info)
    # If not found, try to get it from the session

    

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')
        analisis = obtener_analisis_herramientas_por_equipo(id_equipo_info)
        herramientas = obtener_herramientas_especiales_por_equipo(id_equipo_info)



    if id_equipo_info is None:
        return redirect(url_for('registro_generalidades'))


    #analisis = obtener_analisis_herramientas_por_equipo(id_equipo_info)
    #herramientas = obtener_herramientas_especiales_por_equipo(id_equipo_info)


    # Obtener herramientas relacionadas para el equipo desde la tabla de relaciones
    herramientas_relacionadas = obtener_herramientas_relacionadas_por_equipo(id_equipo_info)


    return render_template(
        'mostrar_herramientas_especiales_ext.html',
        analisis=analisis,
        herramientas=herramientas,
        id_equipo_info=id_equipo_info,
        nombre_equipo=nombre_equipo
    )

@app.route('/LSA/registro-herramientas-especiales', methods=['GET'])
def registro_herramientas_especiales():

    # Priorizar el parámetro de URL 'id_equipo_info' si está presente
    id_equipo_info = request.args.get('id_equipo_info') or session.get('id_equipo_info')


    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')
    

    
    tipos_herramientas = obtener_tipos_herramientas()

    # Obtener el nombre del equipo
    equipo = obtener_equipo_por_id(id_equipo_info)

    return render_template(
        'registro_herramientas_especiales.html',
        equipo=equipo,
        tipos_herramientas=tipos_herramientas,
        id_equipo_info=id_equipo_info
    )





@app.route('/LSA/editar-herramienta-especial/<int:id_herramienta>', methods=['GET'])
def editar_herramienta_especial(id_herramienta):
    token = g.user_token
    id_equipo_info = request.args.get('id_equipo_info')
    herramienta = obtener_herramienta_especial_por_id(id_herramienta)
    if herramienta is None:
        return "Herramienta no encontrada", 404

    tipos_herramientas = obtener_tipos_herramientas()

    return render_template('editar_herramienta_especial.html', herramienta=herramienta, tipos_herramientas=tipos_herramientas, id_equipo_info=id_equipo_info)


@app.route('/api/herramientas-especiales/<int:id_herramienta>', methods=['PUT'])
def actualizar_herramienta_especial_route(id_herramienta):
    parte_numero = request.form.get('parte_numero')
    nombre_herramienta = request.form.get('nombre_herramienta')
    valor = request.form.get('valor')
    dibujo_seccion_transversal = request.files.get('dibujo_seccion_transversal')
    nota = request.form.get('nota')
    manual_referencia = request.form.get('manual_referencia')
    id_tipo_herramienta = request.form.get('tipo_herramienta')
    cantidad = request.form.get('cantidad')

    if not nombre_herramienta or not id_tipo_herramienta:
        return jsonify({'error': 'Faltan datos obligatorios'}), 400

    try:
        valor = float(valor) if valor else None
    except ValueError:
        return jsonify({'error': 'El valor debe ser numérico'}), 400

    dibujo_data = dibujo_seccion_transversal.read() if dibujo_seccion_transversal else None

    # Si no se sube una nueva imagen, conservar la anterior
    if not dibujo_data:
        herramienta = obtener_herramienta_especial_por_id(id_herramienta)
        dibujo_data = herramienta['dibujo_seccion_transversal']
##si algo raro pasa es por pasar como dibujo_Data la imagen viendo que luego se utiliza como dibujo seccion transversal

    actualizar_herramienta_especial(
        id_herramienta, parte_numero, nombre_herramienta, valor,
        dibujo_data, nota, manual_referencia, id_tipo_herramienta, cantidad
    )

    return jsonify({'message': 'Herramienta especial actualizada'}), 200







@app.route('/api/herramientas-especiales/<int:id_herramienta>', methods=['DELETE'])
def eliminar_herramienta_especial_route(id_herramienta):
    eliminar_herramienta_especial(id_herramienta)
    return jsonify({'message': 'Herramienta especial eliminada'}), 200

@app.before_request
def cargar_id_equipo_info():
    # Asignamos el id_equipo_info de la sesión si está disponible
    g.id_equipo_info = session.get('id_equipo_info')

#MARCADOR 2
@app.route('/LSA/equipo/editar-FMEA/<int:id_equipo_info>')
def editar_FMEA_lista(id_equipo_info):

    if id_equipo_info:
        session['id_equipo_info'] = id_equipo_info
    else:
        # Si no se recibe `id_equipo_info` como parámetro, intenta obtenerlo de la sesión
        id_equipo_info = session.get('id_equipo_info')
        if not id_equipo_info:
            # Si `id_equipo_info` no está en la sesión, intenta obtenerlo del usuario
            token = g.user_token
            user_data = obtener_info_usuario(token)
            id_equipo_info = user_data.get('id_equipo_info')
            if id_equipo_info:
                session['id_equipo_info'] = id_equipo_info
    fmeas = obtener_fmeas(id_equipo_info) #Estoy llamando los fmeas para que salgan en la lista
    fmeas_con_rcm = obtener_fmeas_con_rcm()
    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()

    return render_template('editar_FMEA.html', fmeas=fmeas, fmeas_con_rcm=fmeas_con_rcm, id_equipo_info=id_equipo_info, nombre_equipo=nombre_equipo)


#MARCADOR 1
@app.route('/LSA/editar-FMEA/<int:id_equipo_info>/<int:fmea_id>')
def editar_FMEA(id_equipo_info,fmea_id):
    
    AOR = request.args.get('AOR', None)

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')
        AOR = session.get('user_data', {}).get('AOR')
        AOR = user_data.get('AOR') or obtener_aor_por_id_equipo_info(id_equipo_info)

    
    if not AOR:
        AOR = session.get('user_data', {}).get('AOR')

    if not AOR:
        AOR =  obtener_aor_por_id_equipo_info(id_equipo_info)
   
    

    subsistema_id = session.get('subsistema_id')

    # Obtener los datos del FMEA a partir del ID
    fmea = obtener_fmea_por_id(fmea_id, id_equipo_info)
    fmea_id = obtener_ID_FMEA(fmea_id)
    # Cargar la información del sistema

    subsistema = fmea.get('sistema')
    #Obtener datos para desplegables
    
    componente = fmea.get('componente')

    #pasarle sistema_id con alguna funcion
    #componentes = obtener_componentes_por_subsistema(subsistema_id)
    #componentes = obtener_componentes_por_subsistema(sistema_id)
    mecanismos_falla = obtener_mecanismos_falla()
    codigos_modo_falla = obtener_codigos_modo_falla()
    metodos_deteccion_falla = obtener_metodos_deteccion_falla() 
    fallos_ocultos = obtener_fallos_ocultos()
    seguridad_fisica = obtener_seguridad_fisica()
    medio_ambiente_datos = obtener_medio_ambiente()
    impacto_operacional_datos = obtener_impacto_operacional()
    costos_reparacion_datos = obtener_costos_reparacion()
    flexibilidad_operacional_datos= obtener_flexibilidad_operacional()
    ocurrencia_datos = obtener_Ocurrencia()
    probabilidad_deteccion_datos = obtener_probablilidad_deteccion()
    lista_riesgos = obtener_lista_riesgos() or []


    # Renderizar formularios
    return render_template('registro_FMEA.html',fmea=fmea, fmea_id=fmea_id, editar=True,
                           subsistema=subsistema,
                           componente=componente,
                           mecanismos_falla = mecanismos_falla,
                           codigos_modo_falla = codigos_modo_falla,
                           metodos_deteccion_falla = metodos_deteccion_falla,
                           fallos_ocultos=fallos_ocultos,
                           seguridad_fisica=seguridad_fisica,
                           medio_ambiente_datos=medio_ambiente_datos,
                           impacto_operacional_datos=impacto_operacional_datos,
                           costos_reparacion_datos=costos_reparacion_datos,
                           flexibilidad_operacional_datos=flexibilidad_operacional_datos,
                           ocurrencia_datos = ocurrencia_datos,
                           probabilidad_deteccion_datos = probabilidad_deteccion_datos,
                           lista_riesgos= lista_riesgos,
                           AOR=AOR,
                           id_equipo_info=id_equipo_info
                           )

@app.route('/LSA/guardar-FMEA/<int:fmea_id>/<int:id_equipo_info>', methods=['POST'])
def guardar_cambios_fmea(fmea_id,id_equipo_info):
    

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')




    # Los siguientes campos no cambian
    id_equipo_info = obtener_id_equipo_info_por_fmea(fmea_id)
    sistema_id = obtener_id_sistema_por_fmea_id(fmea_id)
    componente=obtener_id_componente_por_fmea_id(fmea_id)
    
    # Obtener los datos del formulario
    falla_funcional = request.form.get('falla_funcional')
    descripcion_modo_falla = request.form.get('descripcion_modo_falla')
    causas = request.form.get('causas')
    mtbf = request.form.get('mtbf')
    mttr = request.form.get('mttr')

    #campos de los menús desplegables
    
    id_mecanismo_falla = request.form.get('mecanismo_falla')
    id_detalle_falla = request.form.get('detalle_falla')
    id_codigo_modo_falla = request.form.get('codigo_modo_falla')
    id_consecutivo_modo_falla = request.form.get('id_consecutivo_modo_falla')


    id_metodo_deteccion_falla = request.form.get('metodo_detecion_falla')
    id_fallo_oculto = request.form.get('fallo_oculto')
    id_seguridad_fisica = request.form.get('seguridad_fisica')
    id_medio_ambiente = request.form.get('medio_ambiente')
    id_impacto_operacional = request.form.get('impacto_operacional')
    id_costos_reparacion = request.form.get('costos_reparacion')
    id_flexibilidad_operacional = request.form.get('flexibilidad_operacional')

    calculo_severidad = request.form.get('calculo_severidad')
    id_ocurrencia = request.form.get('ocurrencia')
    ocurrencia_mate = request.form.get('ocurrencia_matematica')
    id_probabilidad_deteccion = request.form.get('probabilidad_deteccion') 
    rpn = request.form.get('rpn')
    id_riesgo = request.form.get('id_riesgo')

    
    id_falla_funcional = insertar_falla_funcional(falla_funcional)
    id_descripcion_modo_falla = insertar_descripcion_modo_falla(descripcion_modo_falla)
    id_causa = insertar_causa(causas)


    # Actualizar el registro FMEA con los nuevos datos
    actualizar_fmea(
        fmea_id, id_equipo_info, sistema_id, id_falla_funcional, componente, 
        id_codigo_modo_falla, id_consecutivo_modo_falla, id_descripcion_modo_falla, 
        id_causa, id_mecanismo_falla, id_detalle_falla, mtbf, mttr, id_fallo_oculto, 
        id_seguridad_fisica, id_medio_ambiente, id_impacto_operacional, id_costos_reparacion, 
        id_flexibilidad_operacional, calculo_severidad, id_ocurrencia, ocurrencia_mate,
        id_probabilidad_deteccion, id_metodo_deteccion_falla, rpn, id_riesgo
    )



    # Redireccionar después de guardar los cambios
    return redirect(url_for('editar_FMEA_lista',id_equipo_info=id_equipo_info))



@app.route('/LSA/eliminar-FMEA/<int:fmea_id>/<int:id_equipo_info>', methods=['POST'])
def eliminar_FMEA(fmea_id,id_equipo_info):

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')
    



    cursor = db.connection.cursor()

    #Obtener el id_consecutivo_modo_falla del registro a eliminar desde la tabla fmea
    cursor.execute("SELECT id_consecutivo_modo_falla FROM fmea WHERE id = %s", (fmea_id,))
    result = cursor.fetchone()
    
    if result and 'id_consecutivo_modo_falla' in result:
        id_consecutivo_modo_falla = result['id_consecutivo_modo_falla']
        
        #Contar cuántas veces aparece id_consecutivo_modo_falla en la tabla fmea
        count_query = "SELECT COUNT(*) as count FROM fmea WHERE id_consecutivo_modo_falla = %s"
        cursor.execute(count_query, (id_consecutivo_modo_falla,))
        count_result = cursor.fetchone()
        ocurrencias = (count_result['count'])-1 if count_result else 0
        
        
        #Actualizar la numeración en la tabla consecutivo_modo_falla con el número de ocurrencias
        update_query = """
            UPDATE consecutivo_modo_falla
            SET numeracion = %s
            WHERE id = %s
        """
        cursor.execute(update_query, (ocurrencias, id_consecutivo_modo_falla))
        
        #Eliminar el registro de FMEA
        delete_query = "DELETE FROM fmea WHERE id = %s"
        cursor.execute(delete_query, (fmea_id,))
        
        # Confirmar los cambios en la base de datos
        db.connection.commit()

    cursor.close()

    # Redireccionar a la vista de la tabla después de eliminar
    return redirect(url_for('editar_FMEA_lista',id_equipo_info=id_equipo_info))






@app.route('/LSA/equipo/editar-modulo-herramientas')
def editar_modulo_herramientas():
    return render_template('editar_herramientas_especial.html')



@app.route('/LSA/equipo/editar_RCM/<int:id_equipo_info>/<int:fmea_id>')
def editar_RCM(id_equipo_info,fmea_id):
    rcm = obtener_rcm_por_fmea(fmea_id)
    acciones = obtener_lista_acciones_recomendadas()
    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()

    return render_template('registro_rcm.html', rcm=rcm, editar=True, acciones=acciones,id_equipo_info=id_equipo_info, nombre_equipo=nombre_equipo)



@app.route('/LSA/equipo/editar_RCM_lista/<int:id_equipo_info>')
def editar_RCM_lista(id_equipo_info):
    rcms = obtener_rcm_por_equipo_info(id_equipo_info)  # Obtener todos los registros de RCM desde la base de datos
    rcms_con_mta = obtener_rcms_con_mta_por_equipo_info(id_equipo_info)
    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()
    return render_template('editar_RCM.html', rcms=rcms, rcms_con_mta=rcms_con_mta, id_equipo_info=id_equipo_info, nombre_equipo=nombre_equipo)





































# app.py

@app.route('/LSA/mostrar-equipo', methods=['GET'])
def mostrar_equipo():
    token = g.user_token
    user_data = obtener_info_usuario(token)
    id_equipo_info = user_data.get('id_equipo_info')
    if id_equipo_info is None:
        return redirect(url_for('registro_generalidades'))


    equipo = obtener_equipo_info_por_id(id_equipo_info)
    if equipo is None:
        return "Equipo no encontrado", 404
    
     # Obtener el grupo constructivo
    grupo_constructivo = obtener_grupo_constructivo_por_sistema_id(equipo['id_sistema']) if equipo.get('id_sistema') else None

    # Obtener el subgrupo constructivo
    subgrupo_constructivo = obtener_subgrupo_constructivo_por_sistema_id(equipo['id_sistema']) if equipo.get('id_sistema') else None


    diagrama = obtener_diagramas_por_id(equipo['id_diagrama']) if equipo['id_diagrama'] else None

     # Obtener procedimiento relacionado si está presente
    procedimiento = obtener_procedimiento_por_id(equipo['id_procedimiento']) if equipo['id_procedimiento'] else None

    # Opcional: Obtener más detalles relacionados, por ejemplo, personal o sistema
    responsable = obtener_personal_por_id(equipo['id_personal']) if equipo['id_personal'] else None
    sistema = obtener_sistema_por_id(equipo['id_sistema']) if equipo['id_sistema'] else None
    datos_equipo = obtener_datos_equipo_por_id(equipo['id_equipo']) if equipo.get('id_equipo') else None
    # Obtener el tipo de equipo
    tipo_equipo = obtener_tipo_equipo_por_id(equipo['id_tipo_equipo']) if equipo.get('id_tipo_equipo') else None


    return render_template('mostrar_equipo.html', 
                           equipo=equipo,
                           datos_equipo=datos_equipo,
                           tipo_equipo=tipo_equipo, 
                           diagrama=diagrama, 
                           procedimiento=procedimiento, 
                           responsable=responsable,
                           sistema=sistema,
                           grupo_constructivo=grupo_constructivo,
                           subgrupo_constructivo=subgrupo_constructivo
                           )



# app.py

@app.route('/LSA/editar-equipo', methods=['GET', 'POST'])
def editar_equipo():
    id_equipo_info = request.args.get('id_equipo_info')
    active_section = request.args.get('section', 'section1')  # Por defecto 'section1'

    # Si no se proporciona el ID del equipo, obtenerlo de la sesión
    if not id_equipo_info:
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')

    if not id_equipo_info:
        return "ID del equipo no especificado", 400

    if request.method == 'GET':
        try:
            equipo = obtener_equipo_info_por_id(id_equipo_info)
            if equipo is None:
                return "Equipo no encontrado", 404

            # Obtener datos relacionados al equipo
            grupo_constructivo = (
                obtener_grupo_constructivo_por_sistema_id(equipo['id_sistema'])
                if equipo.get('id_sistema') else None
            )
            subgrupo_constructivo = (
                obtener_subgrupo_constructivo_por_sistema_id(equipo['id_sistema'])
                if equipo.get('id_sistema') else None
            )
            procedimiento = (
                obtener_procedimiento_por_id(equipo.get('id_procedimiento'))
                if equipo.get('id_procedimiento') else None
            )
            diagrama = (
                obtener_diagramas_por_id(equipo.get('id_diagrama'))
                if equipo.get('id_diagrama') else None
            )
            responsable = (
                obtener_personal_por_id(equipo.get('id_personal'))
                if equipo.get('id_personal') else None
            )
            sistema = (
                obtener_sistema_por_id(equipo.get('id_sistema'))
                if equipo.get('id_sistema') else None
            )
            datos_equipo = (
                obtener_datos_equipo_por_id(equipo['id_equipo'])
                if equipo.get('id_equipo') else None
            )
            tipo_equipo = (
                obtener_tipo_equipo_por_id(datos_equipo['id_tipos_equipos'])
                if datos_equipo.get('id_tipos_equipos') else None
            )

            equipos = (
                obtener_equipos_por_tipo(tipo_equipo['id'])
                if tipo_equipo else []
            )

            # Listas para selectores
            responsables = obtener_responsables()
            grupos = obtener_grupos_constructivos()
            tipos_equipos = obtener_tipos_equipos()
            subgrupos = (
                obtener_subgrupos_por_sistema(equipo['id_sistema'])
                if equipo.get('id_sistema') else []
            )
            sistemas = (
                obtener_sistemas_por_grupo(grupo_constructivo['id'])
                if grupo_constructivo else []
            )

            return render_template(
                'editar_equipo.html',
                equipo=equipo,
                equipos=equipos,
                datos_equipo=datos_equipo,
                tipo_equipo=tipo_equipo,
                diagrama=diagrama,
                procedimiento=procedimiento,
                responsable=responsable,
                sistema=sistema,
                grupo_constructivo=grupo_constructivo,
                subgrupo_constructivo=subgrupo_constructivo,
                responsables=responsables,
                grupos=grupos,
                subgrupos=subgrupos,
                sistemas=sistemas,
                tipos_equipos=tipos_equipos,
                active_section=active_section  # Pasar la sección activa al template
            )
        except Exception as e:
            app.logger.error(f"Error al cargar el equipo para edición (ID: {id_equipo_info}): {e}")
            return "Error interno al cargar el equipo", 500

    elif request.method == 'POST':
        try:
            # Obtener datos del formulario y asegurar valores por defecto
            data = {
                'fecha': request.form.get('fecha', ''),
                'nombre_equipo': request.form.get('nombre_equipo', ''),
                'responsable': request.form.get('responsable', ''),
                'grupo_constructivo_id': request.form.get('grupo_constructivo', ''),
                'subgrupo_constructivo_id': request.form.get('subgrupo_constructivo', ''),
                'sistema': request.form.get('sistema', ''),
                'tipo_equipo': request.form.get('tipo_equipo', ''),
                'equipo': request.form.get('equipo', ''),
                # Convertir campos numéricos vacíos a None
                'gres_sistema': int(session.get('mec').split()[-1]) if session.get('mec') and session.get('mec').split()[-1].isdigit() else None,
                'fiabilidad_equipo': request.form.get('fiabilidad_equipo', None) or None,
                'criticidad_equipo': request.form.get('criticidad_equipo', None) or None,
                'marca': request.form.get('marca', ''),
                'modelo': request.form.get('modelo', ''),
                'peso_seco': request.form.get('peso_seco', None) or None,
                'dimensiones': request.form.get('dimensiones', ''),
                'descripcion_equipo': request.form.get('descripcion_equipo', ''),
            }

            logger.info(f"Datos recibidos en el formulario para editar equipo: {data}")

            # Manejo de imágenes y archivos
            imagen_file = request.files.get('imagen_equipo')
            data['imagen_equipo'] = imagen_file.read() if imagen_file and imagen_file.filename else None

            diagrama_flujo_file = request.files.get('diagrama_flujo')
            diagrama_caja_negra_file = request.files.get('diagrama_caja_negra')
            diagrama_caja_transparente_file = request.files.get('diagrama_caja_transparente')

            procedimiento_arranque = request.form.get('procedimiento_arranque', '')
            procedimiento_parada = request.form.get('procedimiento_parada', '')

            # Obtener equipo actual para verificar asociaciones existentes
            equipo_actual = obtener_equipo_info_por_id(id_equipo_info)

            # Manejo de procedimientos
            if equipo_actual.get('id_procedimiento'):
                actualizar_procedimiento(
                    equipo_actual['id_procedimiento'], procedimiento_arranque, procedimiento_parada
                )
                data['id_procedimiento'] = equipo_actual['id_procedimiento']
            else:
                id_procedimiento = insertar_procedimiento(procedimiento_arranque, procedimiento_parada)
                data['id_procedimiento'] = id_procedimiento

            # Manejo de diagramas
            if equipo_actual.get('id_diagrama'):
                actualizar_diagrama(
                    equipo_actual['id_diagrama'], diagrama_flujo_file,
                    diagrama_caja_negra_file, diagrama_caja_transparente_file
                )
                data['id_diagrama'] = equipo_actual['id_diagrama']
            else:
                id_diagrama = insertar_diagrama(
                    diagrama_flujo_file, diagrama_caja_negra_file, diagrama_caja_transparente_file
                )
                data['id_diagrama'] = id_diagrama

            # Actualizar equipo
            logger.info(f"Llamando a actualizar_equipo_info con ID: {id_equipo_info}")
            logger.info(f"data")
            actualizar_equipo_info(id_equipo_info, data)

            return redirect(url_for('mostrar_general_page', id_equipo_info=id_equipo_info))
        except Exception as e:
            logger.error(f"Error al actualizar equipo (ID: {id_equipo_info}): {e}")
            return "Error interno al actualizar equipo", 500


       
@app.route('/LSA/eliminar-equipo', methods=['POST'])
def eliminar_equipo():
    try:
        data = request.get_json()
        if data is None:
            return jsonify({"error": "Formato de solicitud incorrecto o datos no recibidos"}), 400

        id_equipo_info = data.get('id_equipo_info')
        if not id_equipo_info:
            return jsonify({"error": "ID de equipo no proporcionado"}), 400

        equipo = obtener_equipo_info_por_id(id_equipo_info)
        if equipo is None:
            return jsonify({"error": "Equipo no encontrado"}), 404

        eliminar_equipo_info(id_equipo_info)
        return jsonify({"message": "Equipo eliminado correctamente"})
    except Exception as e:
        return jsonify({"error": f"Error al eliminar el equipo: {str(e)}"}), 500





















@app.route('/LSA/equipo/mostrar-FMEA/<int:id_equipo_info>')
def mostrar_FMEA(id_equipo_info):
    fmeas = obtener_fmeas(id_equipo_info)# Obtener todos los registros de FMEA desde la base de datos
    return render_template('mostrar_FMEA.html', fmeas=fmeas,id_equipo_info=id_equipo_info)



@app.route('/LSA/equipo/mostrar-RCM')
def mostrar_RCM():
    rcms = obtener_rcms_completos()
    return render_template('mostrar_RCM.html', rcms=rcms)



@app.route('/LSA/equipo/mostrar-analisis-herramientas')
def mostrar_analisis_herramientas():
    return render_template('mostrar_analisis-herramientas.html')


@app.route('/LSA/equipo/mostrar-repuestos')
def mostrar_repuesto():
    return render_template('mostrar_repuesto.html')


@app.route('/LSA/equipo/mostrar-informe')
def mostrar_informe():
    return render_template('mostrar_informe.html')







#########################################################################################################

@app.route('/LSA/registro-MTA/<int:fmea_id>')
def registro_MTA(fmea_id):
    # Priorizar el parámetro de URL 'id_equipo_info' si está presente
    id_equipo_info = request.args.get('id_equipo_info')
    id_equipo_info_query = request.args.get('id_equipo_info')
    if id_equipo_info_query:
        id_equipo_info = id_equipo_info_query

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')
    



    if fmea_id:
        # Obtener los datos de FMEA por su ID
        fmea = obtener_fmea_por_id(fmea_id,id_equipo_info)  #obtenemos los nombres en los compos de fmea
        fmea_id = obtener_ID_FMEA(fmea_id) # optenermos el id de fmea 
        # Variables precargadas desde el FMEA
        sistema = fmea.get('id_sistema')
        componente = fmea.get('id_componente')
        falla_funcional = fmea.get('id_falla_funcional')
        rcm = obtener_rcm_por_fmea(fmea_id['id'])
    else:
        sistema = None
        falla_funcional = None
        componente = None
        fmea = []
    repuestos = obtener_repuestos_por_equipo_info(fmea['id_equipo_info'])
    #Obtener datos para desplegables
    tipo_de_manteniemto = obtener_tipos_mantenimiento()
    tarea_mantenimento = obtener_tareas_mantenimiento()
    rcm=obtener_rcm_por_equipo_info(id_equipo_info)
    
    mta = obtener_mta_por_id_rcm(rcm[0])
    if mta:
     lora_mta = obtener_lora_mta_por_id_mta(mta['id'])
    else:
      lora_mta = None
  
    herramientas = 0
    dict_herramientas_por_tipo = obtener_herramientas_requeridas_por_tipo()
    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()

    return render_template('registro_MTA.html', fmea=fmea, editar = False,
                           sistema=sistema,
                           falla_funcional = falla_funcional,
                           componente = componente,
                           tipo_de_manteniemto = tipo_de_manteniemto,
                           tarea_mantenimento = tarea_mantenimento,
                           herramientas = herramientas,
                           herramientas_por_tipo = dict_herramientas_por_tipo,
                           repuestos = repuestos,
                           lora_mta=lora_mta,
                           rcm=rcm,
                           id_equipo_info=id_equipo_info,
                           nombre_equipo=nombre_equipo
                           )

@app.route('/LSA/equipo/editar-MTA/<int:rcm_id>/<int:id_equipo_info>')
def editar_MTA(rcm_id,id_equipo_info):
    # Priorizar el parámetro de URL 'id_equipo_info' si está presente
    id_equipo_info_query = request.args.get('id_equipo_info')
    if id_equipo_info_query:
        id_equipo_info = id_equipo_info_query
 

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')



    mta = obtener_mta_por_id_rcm(rcm_id)
    rcm = obtener_rcm_por_id(mta['id_rcm'])
    repuestos = obtener_repuestos_por_equipo_info(mta['id_equipo_info'])
    tipo_de_manteniemto = obtener_tipos_mantenimiento()
    tarea_mantenimento = obtener_tareas_mantenimiento()
    lora_mta = obtener_lora_mta_por_id_mta(mta['id'])
    repuestos_mta = obtener_repuestos_mta_por_id_mta(mta['id'])
    herramientas_mta = obtener_herramientas_mta_por_id_mta(mta['id'])
    dict_herramientas_por_tipo = obtener_herramientas_requeridas_por_tipo()
    herramientas = 0

    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()

    return render_template('registro_mta.html',
                           tipo_de_manteniemto=tipo_de_manteniemto,
                           tarea_mantenimento=tarea_mantenimento,
                           mta=mta, rcm=rcm,
                           lora_mta=lora_mta,
                           repuestos=repuestos,
                           repuestos_mta=repuestos_mta,
                           herramientas_mta=herramientas_mta,
                           herramientas_por_tipo=dict_herramientas_por_tipo,
                           id_equipo_info=id_equipo_info,
                           herramienta=herramientas,
                           editar=True,
                           nombre_equipo=nombre_equipo)

@app.route('/LSA/eliminar-MTA/<int:mta_id>/<int:id_equipo_info>')
def eliminar_MTA(mta_id,id_equipo_info):

    # Si existe un parámetro de consulta 'id_equipo_info', lo usamos para sobrescribir el de la URL
    id_equipo_info_query = request.args.get('id_equipo_info')
    if id_equipo_info_query:
        id_equipo_info = id_equipo_info_query

    # Si todavía no tenemos 'id_equipo_info', lo obtenemos de la sesión o del usuario
    if not id_equipo_info:
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')

    # Aseguramos que 'id_equipo_info' tiene un valor antes de continuar
    if not id_equipo_info:
        return "Error: 'id_equipo_info' no encontrado", 400



    eliminar_herramientas_requeridas_mta(mta_id)
    eliminar_repuestos_requeridos_mta(mta_id)
    eliminar_mta(mta_id)
    return redirect(url_for('editar_MTA_lista',id_equipo_info=id_equipo_info))

@app.route('/LSA/editar-MTA-lista/<int:id_equipo_info>')
def editar_MTA_lista(id_equipo_info):
    # Si existe un parámetro de consulta 'id_equipo_info', lo usamos para sobrescribir el de la URL
    id_equipo_info_query = request.args.get('id_equipo_info')
    
    if id_equipo_info_query:
        id_equipo_info = id_equipo_info_query

    # Si todavía no tenemos 'id_equipo_info', lo obtenemos de la sesión o del usuario
    if not id_equipo_info:
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')

    # Ahora 'id_equipo_info' debería tener un valor válido
    


    mtas = obtener_mta_por_equipo_info(id_equipo_info)
    herramientas = obtener_herramientas_especiales_por_equipo(id_equipo_info)
    repuestos = obtener_repuestos_por_equipo_info(id_equipo_info)
    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()
    return render_template('editar_MTA.html', mtas=mtas, herramientas=herramientas, repuestos=repuestos, id_equipo_info=id_equipo_info, nombre_equipo=nombre_equipo)



@app.route('/LSA/registro-MTA/<int:fmea_id>/<int:id_equipo_info>', methods=['POST'])
def guardar_MTA(fmea_id,id_equipo_info):
    # Priorizar el parámetro de URL 'id_equipo_info' si está presente
    id_equipo_info_query = request.args.get('id_equipo_info')
    if id_equipo_info_query:
        id_equipo_info = id_equipo_info_query

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')

     # Obtener los datos del formulario


    fmea = obtener_ID_FMEA(fmea_id)
    rcm = obtener_rcm_por_fmea(fmea_id)
    id_sistema = fmea.get('id_sistema')
    id_componente = fmea.get('id_componente')
    # id_falla_funcional = fmea_id.get('id_falla_funcional')
    id_tipo_mantenimiento = request.form.get('tipo_mantenimiento')
    id_tarea_mantenimiento = request.form.get('tarea_mantenimiento')
    cantidad_personal = request.form.get('personal_requerido')
    consumibles_requeridos = request.form.get('consumibles_requeridos')

    #repuestos_requeridos = request.form.get('repuestos_requeridos')

    requeridos_tarea = request.form.get('requeridos_tarea')
    condiciones_ambientales = request.form.get('condiciones_requeridas_ambientales')
    condiciones_estado_equipo = request.form.get('condiciones_requeridas_estado_equipo')
    condiciones_especiales = request.form.get('condiciones_requeridas_especiales')
    horas = request.form.get('duracion_tarea_horas')
    minutos = request.form.get('duracion_tarea_minutos')
    detalle_tarea = request.form.get('detalle_tarea')

    nivel = request.form.get('nivel')
    actividades = request.form.get('actividades')
    operario = request.form.get('operario')

    # Recuperar la lista de checkboxes seleccionados
    selected_repuestos_json = request.form.get('selected_repuestos')
    selected_repuestos = json.loads(selected_repuestos_json) if selected_repuestos_json else []

    # Decodificar el JSON de herramientas seleccionadas en una lista
    selected_herramientas_json = request.form.get('selected_herramientas')
    selected_herramientas = json.loads(selected_herramientas_json) if selected_herramientas_json else []

    # Obtener nombres de las herramientas seleccionadas y luego sus datos
    nombres_herramientas = []
    ids_herramientas = []
    for herramienta_id in selected_herramientas:
        nombre = obtener_nombre_por_id('herramientas_requeridas', herramienta_id , columna_id='id_herramienta_requerida')
        if nombre:
            nombres_herramientas.append(nombre)
            id_herramienta, id_clase_herramienta = obtener_datos_herramienta(nombre)
            if id_herramienta:
                ids_herramientas.append((id_herramienta, id_clase_herramienta))

    # Insertar relaciones en la tabla herramientas_relacion
    for id_herramienta, id_clase_herramienta in ids_herramientas:
        insertar_herramienta_relacion(id_herramienta, id_clase_herramienta, id_equipo_info)

    
    # Guardar en la base de datos
    insertar_mta(rcm['id'], fmea['id_equipo_info'], id_sistema, id_componente, fmea['id_falla_funcional'], fmea['id_descripcion_modo_falla'], id_tipo_mantenimiento, id_tarea_mantenimiento, cantidad_personal, consumibles_requeridos ,requeridos_tarea,condiciones_ambientales, condiciones_estado_equipo, condiciones_especiales,  horas, minutos, detalle_tarea)
    id_mta = obtener_max_id_mta()
    if(selected_repuestos):
        insertar_repuestos_requeridos_mta(selected_repuestos, id_mta)
    # Insertar herramientas seleccionadas en la tabla correspondiente si existen
    if selected_herramientas:

        insertar_herramientas_requeridas_mta(selected_herramientas, id_mta)
    if(nivel and actividades and operario):
        insertar_mta_lora(nivel, actividades, operario, id_mta)

    return redirect(url_for('editar_MTA_lista',id_equipo_info=id_equipo_info))


#actualizar mta
@app.route('/LSA/actualizar-MTA/<int:mta_id>/<int:id_equipo_info>', methods=['POST'])
def actualizar_MTA(mta_id,id_equipo_info):

    if not id_equipo_info:
        id_equipo_info = session.get('id_equipo_info')
        if not id_equipo_info:
            token = g.user_token
            user_data = obtener_info_usuario(token)
            id_equipo_info = user_data.get('id_equipo_info')
            if id_equipo_info:
                session['id_equipo_info'] = id_equipo_info


    # Obtener los datos del formulario
    id_tipo_mantenimiento = request.form.get('tipo_mantenimiento')
    id_tarea_mantenimiento = request.form.get('tarea_mantenimiento')
    cantidad_personal = request.form.get('personal_requerido')
    consumibles_requeridos = request.form.get('consumibles_requeridos')
    requeridos_tarea = request.form.get('requeridos_tarea')
    condiciones_ambientales = request.form.get('condiciones_requeridas_ambientales')
    condiciones_estado_equipo = request.form.get('condiciones_requeridas_estado_equipo')
    condiciones_especiales = request.form.get('condiciones_requeridas_especiales')
    horas = request.form.get('duracion_tarea_horas')
    minutos = request.form.get('duracion_tarea_minutos')
    detalle_tarea = request.form.get('detalle_tarea')

    nivel = request.form.get('nivel')
    actividades = request.form.get('actividades')
    operario = request.form.get('operario')

    # Recuperar la lista de checkboxes seleccionados
    selected_repuestos_json = request.form.get('selected_repuestos')
    selected_repuestos = json.loads(selected_repuestos_json) if selected_repuestos_json else []

    # Recuperar la lista de checkboxes seleccionados
    selected_herramientas_json = request.form.get('selected_herramientas')
    selected_herramientas = json.loads(selected_herramientas_json) if selected_repuestos_json else []

    # Actualizar los datos en la base de datos
    actualizar_mta(
        mta_id, id_tipo_mantenimiento, id_tarea_mantenimiento, cantidad_personal, consumibles_requeridos,
        requeridos_tarea, condiciones_ambientales, condiciones_estado_equipo, condiciones_especiales,
        horas, minutos, detalle_tarea
    )
    # Actualizar las herramientas requeridas
    eliminar_herramientas_requeridas_mta(mta_id)
    if selected_herramientas:
        insertar_herramientas_requeridas_mta(selected_herramientas, mta_id)

    # Actualizar los repuestos requeridos
    eliminar_repuestos_requeridos_mta(mta_id)
    if selected_repuestos:
        insertar_repuestos_requeridos_mta(selected_repuestos, mta_id)



    # Actualizar la información de LORA
    actualizar_mta_lora(nivel, actividades, operario, mta_id)

    return redirect(url_for('editar_MTA_lista',id_equipo_info=id_equipo_info))

@app.route('/LSA/equipo/mostrar-MTA')
def mostrar_MTA():
    mtas = obtener_mtas_completos()
    herramientas = obtener_herramientas_mta()
    repuestos = obtener_repuestos_mta()
    return render_template('mostrar_MTA.html', mtas=mtas, herramientas=herramientas, repuestos=repuestos)



##############################################################################################################

@app.route('/LSA/registro-RCM')
def registro_RCM():
    return render_template('registro_RCM.html')



@app.route('/LSA/registro-FMEA/')
def registro_FMEA():
    # Obtener el token y datos del usuario
    AOR = request.args.get('AOR', None)
    id_equipo_info = request.args.get('id_equipo_info')
    
    id_equipo = obtener_id_equipo_por_equipo_info(id_equipo_info)

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')
        id_equipo = user_data.get('id_equipo') or session.get('id_equipo')
        AOR = session.get('user_data', {}).get('AOR')
    
    # Obtener el id_equipo desde los datos del usuario o la sesión



    AOR = session.get('user_data', {}).get('AOR')
    # Si el id_equipo no está en la sesión, lo añadimos
    if id_equipo:
        session['id_equipo'] = id_equipo
    
    if not AOR:
        AOR = obtener_aor_por_id_equipo_info(id_equipo_info)
    
    # Obtener subsistemas relacionados al equipo
    subsistemas = obtener_subsistemas_por_equipo(id_equipo) if id_equipo else []

    # Obtener datos adicionales para desplegables
    subsistema_id = session.get('subsistema_id')
    componentes = obtener_componentes_por_subsistema(subsistema_id) if subsistema_id else []
    mecanismos_falla = obtener_mecanismos_falla()
    codigos_modo_falla = obtener_codigos_modo_falla()
    metodos_deteccion_falla = obtener_metodos_deteccion_falla() 
    fallos_ocultos = obtener_fallos_ocultos()
    seguridad_fisica = obtener_seguridad_fisica()
    medio_ambiente_datos = obtener_medio_ambiente()
    impacto_operacional_datos = obtener_impacto_operacional()
    costos_reparacion_datos = obtener_costos_reparacion()
    flexibilidad_operacional_datos = obtener_flexibilidad_operacional()
    ocurrencia_datos = obtener_Ocurrencia()


    probabilidad_deteccion_datos = obtener_probablilidad_deteccion()
    lista_riesgos = obtener_lista_riesgos() or []

    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()

    # Renderizar la plantilla con los datos
    return render_template(
        'registro_FMEA.html',
        fmea=None,
        fmea_id=None,
        editar=False,
        sistema=subsistemas,
        subsistemas=subsistemas,
        componentes=componentes,
        mecanismos_falla=mecanismos_falla,
        codigos_modo_falla=codigos_modo_falla,
        metodos_deteccion_falla=metodos_deteccion_falla,
        fallos_ocultos=fallos_ocultos,
        seguridad_fisica=seguridad_fisica,
        medio_ambiente_datos=medio_ambiente_datos,
        impacto_operacional_datos=impacto_operacional_datos,
        costos_reparacion_datos=costos_reparacion_datos,
        flexibilidad_operacional_datos=flexibilidad_operacional_datos,
        ocurrencia_datos=ocurrencia_datos,
        AOR=AOR,
        probabilidad_deteccion_datos=probabilidad_deteccion_datos,
        lista_riesgos=lista_riesgos,
        id_equipo_info=id_equipo_info,
        nombre_equipo=nombre_equipo
    )

@app.route('/LSA/registro-FMEA/<int:id_equipo_info>', methods=['POST'])
def guardar_fmea(id_equipo_info):
    if id_equipo_info:
        session['id_equipo_info'] = id_equipo_info
    else:
        # Si no se recibe `id_equipo_info` como parámetro, intenta obtenerlo de la sesión
        id_equipo_info = session.get('id_equipo_info')
        if not id_equipo_info:
            # Si `id_equipo_info` no está en la sesión, intenta obtenerlo del usuario
            token = g.user_token
            user_data = obtener_info_usuario(token)
            id_equipo_info = user_data.get('id_equipo_info')
            if id_equipo_info:
                session['id_equipo_info'] = id_equipo_info
    

    id_equipo = obtener_id_equipo_por_equipo_info(id_equipo_info)
    # Priorizar el parámetro de URL 'id_equipo_info' si está presente
    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')
        id_equipo = user_data.get('id_equipo') or session.get('id_equipo')
    # Obtener el token del usuario y la información relacionada

    # Si el id_equipo no está en la sesión, lo añadimos
    if id_equipo:
        session['id_equipo'] = id_equipo
    

    #id_equipo = user_data.get('id_equipo') or session.get('id_equipo')


    # Obtener id_sistema usando obtener_equipo_info
    
    id_subsistema = request.form.get('subsistema') 




    # Obtener los datos del formulario
    falla_funcional = request.form.get('falla_funcional')
    descripcion_modo_falla = request.form.get('descripcion_modo_falla')
    causas = request.form.get('causas')
    mtbf = request.form.get('mtbf')
    mttr = request.form.get('mttr')

    #campos de los menús desplegables
    id_componente = request.form.get('item_componente')
    session['id_componente'] = id_componente
    id_mecanismo_falla = request.form.get('mecanismo_falla')
    id_detalle_falla = request.form.get('detalle_falla')
    id_codigo_modo_falla = request.form.get('codigo_modo_falla')
    id_consecutivo_modo_falla = request.form.get('id_consecutivo_modo_falla')
    id_metodo_deteccion_falla = request.form.get('metodo_detecion_falla')
    id_fallo_oculto = request.form.get('fallo_oculto')
    id_seguridad_fisica = request.form.get('seguridad_fisica')
    id_medio_ambiente = request.form.get('medio_ambiente')
    id_impacto_operacional = request.form.get('impacto_operacional')
    id_costos_reparacion = request.form.get('costos_reparacion')
    id_flexibilidad_operacional = request.form.get('flexibilidad_operacional')
    calculo_severidad = request.form.get('calculo_severidad')
    id_ocurrencia = request.form.get('ocurrencia')
    ocurrencia_mate= request.form.get('ocurrencia_matematica')
    rpn = request.form.get('rpn')
    id_probabilidad_deteccion = request.form.get('probabilidad_deteccion')
    id_riesgo = request.form.get('id_riesgo')
    

    # Insertar los datos relacionados en las tablas correspondientes y obtener los IDs
    id_falla_funcional = insertar_falla_funcional(falla_funcional)
    id_descripcion_modo_falla = insertar_descripcion_modo_falla(descripcion_modo_falla)
    id_causa = insertar_causa(causas)

    # Insertar todos estos IDs en la tabla FMEA junto con los nuevos campos
    id_fmea = insertar_fmea(

        id_equipo_info, id_subsistema, id_falla_funcional, id_componente, id_codigo_modo_falla,
        id_consecutivo_modo_falla, id_descripcion_modo_falla, id_causa, id_mecanismo_falla,
        id_detalle_falla, mtbf, mttr, id_metodo_deteccion_falla, id_fallo_oculto, id_seguridad_fisica,
        id_medio_ambiente, id_impacto_operacional, id_costos_reparacion, id_flexibilidad_operacional,
        calculo_severidad, id_ocurrencia, ocurrencia_mate, id_probabilidad_deteccion, rpn, id_riesgo

    )

    # Redireccionar o devolver respuesta exitosa
    return redirect(url_for('editar_FMEA_lista',id_equipo_info=id_equipo_info))  

#rutas para funcionesFMEA.js
@app.route('/LSA/obtener-detalles-falla/<int:mecanismo_id>', methods=['GET'])
def obtener_detalles_falla(mecanismo_id):
    cursor = db.connection.cursor()
    query = """
        SELECT id, nombre FROM detalle_falla
        WHERE id_mecanismo_falla = %s
    """
    cursor.execute(query, (mecanismo_id,))
    detalles_falla = cursor.fetchall()
    cursor.close()
    
    detalles_falla_lista = [{'id': detalle['id'], 'nombre': detalle['nombre']} for detalle in detalles_falla]
    return jsonify(detalles_falla_lista)

#Aqui estoy haciendo dos procesos a la vez tanto contando los consecutivos como mostrando el nombre
@app.route('/LSA/obtener-nombre-falla/<int:codigo_id>/<int:id_equipo_info>')
def obtener_nombre_falla(codigo_id,id_equipo_info):
    editar = request.args.get('editar', 'False') == 'True'
    cursor = db.connection.cursor()

    # Obtener el nombre del modo de falla
    query_nombre = """
        SELECT nombre, codigo, id
        FROM codigo_modo_falla
        WHERE id = %s
    """
    cursor.execute(query_nombre, (codigo_id,))
    result = cursor.fetchone()

    if result:
        nombre_modo_falla = result['nombre']
        codigo_modo_falla = result['codigo']
        id_codigo_modo_falla = result['id']


        # Verificar si estamos en modo edición
        if editar:
            # Obtener el consecutivo de modo de falla
            query_consecutivo = """

                SELECT id

                FROM consecutivo_modo_falla 
                WHERE nombre = %s
            """
            cursor.execute(query_consecutivo, (codigo_modo_falla,))
            consecutivo_result = cursor.fetchone()

            if consecutivo_result:
                id_consecutivo_modo_falla = consecutivo_result['id']


                # Contar cuántas veces se usa el id_consecutivo_modo_falla en la tabla fmea
                count_query = """
                    SELECT COUNT(*) as count
                    FROM fmea
                    WHERE id_consecutivo_modo_falla = %s AND id_equipo_info = %s
                """
                cursor.execute(count_query, (id_consecutivo_modo_falla, id_equipo_info))
                count_result = cursor.fetchone()
                ocurrencias = count_result['count'] if count_result else 0
                # Calcular la nueva numeración
                nueva_numeracion = ocurrencias 

                # Actualizar la numeración en la tabla consecutivo_modo_falla

                query_update = """
                    UPDATE consecutivo_modo_falla
                    SET numeracion = %s
                    WHERE id = %s
                """
                cursor.execute(query_update, (nueva_numeracion, id_consecutivo_modo_falla))
                db.connection.commit()

                cursor.close()

                return jsonify({
                    'nombre': nombre_modo_falla,
                    'consecutivo': f"{codigo_modo_falla}-{nueva_numeracion}",
                    'id_consecutivo_modo_falla': id_consecutivo_modo_falla
                })


        # Obtener el consecutivo de modo de falla
        query_consecutivo = """

            SELECT id

            FROM consecutivo_modo_falla 
            WHERE nombre = %s
        """
        cursor.execute(query_consecutivo, (codigo_modo_falla,))
        consecutivo_result = cursor.fetchone()

        if consecutivo_result:
            id_consecutivo_modo_falla = consecutivo_result['id']


            # Contar cuántas veces se usa el id_consecutivo_modo_falla en la tabla fmea
            count_query = """
                SELECT COUNT(*) as count
                FROM fmea
                WHERE id_consecutivo_modo_falla = %s AND id_equipo_info = %s
             """
            cursor.execute(count_query, (id_consecutivo_modo_falla, id_equipo_info))
            count_result = cursor.fetchone()
            ocurrencias = count_result['count'] if count_result else 0
            # Calcular la nueva numeración
            nueva_numeracion = ocurrencias + 1

            # Actualizar la numeración en la tabla consecutivo_modo_falla

            query_update = """
                UPDATE consecutivo_modo_falla
                SET numeracion = %s
                WHERE id = %s
            """
            cursor.execute(query_update, (nueva_numeracion, id_consecutivo_modo_falla))
            db.connection.commit()

            cursor.close()

            return jsonify({
                'nombre': nombre_modo_falla,
                'consecutivo': f"{codigo_modo_falla}-{nueva_numeracion}",
                'id_consecutivo_modo_falla': id_consecutivo_modo_falla
            })
        else:
            cursor.close()
            return jsonify({'nombre': 'No encontrado', 'consecutivo': None}), 404
    else:
        cursor.close()
        return jsonify({'nombre': 'No encontrado', 'consecutivo': None}), 404


############################################################################################################



@app.route('/LSA/equipo/registro-LORA')
def registro_lora():
    return render_template('registro_lora.html')


@app.route('/LSA/registro-repuesto/<int:id_equipo_info>')
def registro_repuesto(id_equipo_info):
    
    if not id_equipo_info or id_equipo_info == 0:
        id_equipo_info = session.get('id_equipo_info')

    if not id_equipo_info:
        token = g.get('user_token')
        if token:
            user_data = obtener_info_usuario(token)
            id_equipo_info = user_data.get('id_equipo_info')
    
    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()

    return render_template('registro_repuesto.html', id_equipo_info=id_equipo_info, nombre_equipo= nombre_equipo)

@app.context_processor
def inject_id_equipo_info():
    from flask import session, g
    id_equipo_info = g.get('id_equipo_info') or session.get('id_equipo_info', 0)
    return {'id_equipo_info': id_equipo_info}




#new functions
@app.route('/LSA/crear_RCM/<int:fmea_id>/<int:id_equipo_info>')
def crear_RCM(fmea_id,id_equipo_info):

    session['id_equipo_info'] = id_equipo_info
    g.id_equipo_info = id_equipo_info

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')



    fmea = obtener_fmea_por_id(fmea_id,id_equipo_info)
    acciones = obtener_lista_acciones_recomendadas()
    if fmea:
        return render_template('registro_rcm.html',id_equipo_info=id_equipo_info, fmea=fmea, acciones=acciones, editar = False)


    else:
        return "FMEA no encontrado", 404

#funcion para guardar el RCM
@app.route('/LSA/guardar_RCM/<int:fmea_id>/<int:id_equipo_info>', methods=['POST'])
def guardar_RCM(fmea_id,id_equipo_info):
    id_equipo_info = request.form.get('id_equipo_info') or session.get('id_equipo_info')

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')
    

    rcm = {
        'id_fmea': fmea_id,
        'sistema': request.form.get('sistema'),
        'codigo_modo_falla': request.form.get('codigo_modo_falla'),
        'causas': request.form.get('causas'),
        'falla_funcional': request.form.get('falla_funcional'),
        'consecutivo_modo_falla': request.form.get('consecutivo_modo_falla'),
        'item_componente': request.form.get('item_componente'),
        'descripcion_modo_falla': request.form.get('descripcion_modo_falla'),
        'hidden_failures': request.form.get('hidden_failures'),
        'safety': request.form.get('safety'),
        'environment': request.form.get('environment'),
        'operation': request.form.get('operation'),
        'h1_s1_n1_o1': request.form.get('h1s1'),
        'h2_s2_n2_o2': request.form.get('h2s2'),
        'h3_s3_n3_o3': request.form.get('h3s3'),
        'h4_s4': request.form.get('h4s4'),
        'h5': request.form.get('h5'),
        'tarea': request.form.get('tarea'),
        'intervalo_inicial_horas': request.form.get('intervalo_inicial'),
        'id_accion_recomendada': request.form.get('accion_recomendada')
    }
    # Insertar los datos en la tabla RCM
    insertar_rcm(rcm)


    # Redireccionar después de guardar los cambios
    return redirect(url_for('editar_RCM_lista',id_equipo_info=id_equipo_info))

#actualizar rcm
@app.route('/LSA/equipos/actualizar_RCM/<int:fmea_id>/<int:id_equipo_info>', methods=['POST'])
def actualizar_RCM(fmea_id,id_equipo_info):
    session['id_equipo_info'] = id_equipo_info
    g.id_equipo_info = id_equipo_info

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')

     

    # Obtener los datos del formulario
    rcm = {
        'id_fmea': fmea_id,
        'sistema': request.form.get('sistema'),
        'codigo_modo_falla': request.form.get('codigo_modo_falla'),
        'causas': request.form.get('causas'),
        'falla_funcional': request.form.get('falla_funcional'),
        'consecutivo_modo_falla': request.form.get('consecutivo_modo_falla'),
        'item_componente': request.form.get('item_componente'),
        'descripcion_modo_falla': request.form.get('descripcion_modo_falla'),
        'hidden_failures': request.form.get('hidden_failures'),
        'safety': request.form.get('safety'),
        'environment': request.form.get('environment'),
        'operation': request.form.get('operation'),
        'h1_s1_n1_o1': request.form.get('h1s1'),
        'h2_s2_n2_o2': request.form.get('h2s2'),
        'h3_s3_n3_o3': request.form.get('h3s3'),
        'h4_s4': request.form.get('h4s4'),
        'h5': request.form.get('h5'),
        'tarea': request.form.get('tarea'),
        'intervalo_inicial_horas': request.form.get('intervalo_inicial'),
        'id_accion_recomendada': request.form.get('accion_recomendada')
    }


    # Actualizar el registro RCM con los nuevos datos
    actualizar_rcm(rcm)

    # Redireccionar después de guardar los cambios



    return redirect(url_for('editar_RCM_lista',id_equipo_info=id_equipo_info,fmea_id=fmea_id))

#eliminar rcm
@app.route('/LSA/eliminar_RCM/<int:fmea_id>/<int:id_rcm>/<int:id_equipo_info>')
def eliminar_RCM(id_rcm,id_equipo_info,fmea_id):
    session['id_equipo_info'] = id_equipo_info
    g.id_equipo_info = id_equipo_info

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')
    eliminar_rcm(fmea_id,id_rcm)
    return redirect(url_for('editar_RCM_lista',id_equipo_info=id_equipo_info,fmea_id=fmea_id))

def eliminar_RCM(fmea_id,id_rcm):
    token = g.user_token
    user_data = obtener_info_usuario(token)
    id_equipo_info = user_data.get('id_equipo_info')
    eliminar_rcm(fmea_id,id_rcm)
    return redirect(url_for('editar_RCM_lista',id_equipo_info=id_equipo_info))

#####analisis_funcional:

@app.route('/LSA/equipo/mostrar-analisis-funcional', methods=['GET'])
def mostrar_analisis_funcional():
    # Priorizar el parámetro de URL 'id_equipo_info' si está presente
    id_equipo_info = request.args.get('id_equipo_info') or session.get('id_equipo_info')
    id_sistema = obtener_id_sistema_por_equipo_info(id_equipo_info)
    id_equipo = obtener_id_equipo_por_equipo_info(id_equipo_info)

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')
        id_sistema = user_data.get('id_sistema')
        id_equipo = user_data.get('id_equipo')

 
   # Obtención del nombre del sistema
    
    sistema_nombre = obtener_nombre_sistema_por_id(id_sistema)

    # Obtención del sistema y subsistemas asociados
    sistema = obtener_sistema_por_id(id_sistema) if id_sistema else None
    analisis_funcionales, componentes_analisis_funcionales = obtener_analisis_funcionales_por_equipo_info(id_equipo_info)

    # Añadir el nombre del sistema a cada análisis funcional
    for analisis in analisis_funcionales:
        analisis['sistema_nombre'] = sistema_nombre

    return render_template('mostrar_analisis_funcional.html', analisis_funcionales=analisis_funcionales, sistema=sistema, componentes=componentes_analisis_funcionales,id_equipo_info=id_equipo_info,id_equipo=id_equipo)

@app.route('/LSA/equipo/mostrar-analisis-funcional-ext', methods=['GET'])
def mostrar_analisis_funcional_ext():
    # Priorizar el parámetro de URL 'id_equipo_info' si está presente
    id_equipo_info = request.args.get('id_equipo_info')
    id_sistema = obtener_id_sistema_por_equipo_info(id_equipo_info)
    id_equipo = obtener_id_equipo_por_equipo_info(id_equipo_info)
    nombre_equipo = obtener_nombre_equipo_por_id(id_equipo_info).title()

    if not id_equipo_info:
        # Si no se recibe el parámetro, se toma el de la sesión
        token = g.user_token
        user_data = obtener_info_usuario(token)
        id_equipo_info = user_data.get('id_equipo_info')
        id_sistema = user_data.get('id_sistema')
        id_equipo = user_data.get('id_equipo')

   # Obtención del nombre del sistema
    
    sistema_nombre = obtener_nombre_sistema_por_id(id_sistema)

    # Obtención del sistema y subsistemas asociados
    sistema = obtener_sistema_por_id(id_sistema) if id_sistema else None
    analisis_funcionales, componentes_analisis_funcionales = obtener_analisis_funcionales_por_equipo_info(id_equipo_info)

    # Añadir el nombre del sistema a cada análisis funcional
    for analisis in analisis_funcionales:
        analisis['sistema_nombre'] = sistema_nombre

    return render_template('mostrar_analisis_funcional_ext.html', analisis_funcionales=analisis_funcionales, sistema=sistema, componentes=componentes_analisis_funcionales,id_equipo_info=id_equipo_info, nombre_equipo=nombre_equipo)




@app.route('/api/crear_personal', methods=['POST'])
def crear_personal_route():
    data = request.get_json()
    nombre_completo = data.get('nombre_completo')
    if nombre_completo:
        new_id = crear_personal(nombre_completo)
        return jsonify({'id': new_id, 'nombre_completo': nombre_completo}), 200
    else:
        return jsonify({'error': 'Nombre completo es requerido'}), 400












def obtener_equipo_info(id=None):
    if id:
        # Usar el id proporcionado para obtener id_sistema e id_equipo desde la tabla equipo_info
        cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
        query = "SELECT id, id_sistema, id_equipo FROM equipo_info WHERE id = %s"
        cursor.execute(query, (id,))
        result = cursor.fetchone()
        cursor.close()
        if result:
            # Asignar id a id_equipo_info para su uso en otras funciones
            id_equipo_info = id
            # Retornar los valores en el diccionario
            return {
                'id_equipo_info': id_equipo_info,
                'id_sistema': result['id_sistema'],
                'id_equipo': result['id_equipo']
            }
        else:
            return None
    else:
        # Obtener id_equipo_info, id_sistema, id_equipo desde el diccionario temporal por token
        token = g.user_token
        if token:
            user_data = obtener_info_usuario(token)
            id_equipo_info = user_data.get('id_equipo_info')
            id_sistema = user_data.get('id_sistema')
            id_equipo = user_data.get('id_equipo')
            return {
                'id_equipo_info': id_equipo_info,
                'id_sistema': id_sistema,
                'id_equipo': id_equipo
            }
        else:
            # Manejar el caso donde no hay token
            return None






@app.route('/LSA/mostrar-general', methods=['POST'])
def mostrar_general():
    data = request.json
    nombre_equipo = data.get('nombre_equipo')
    prev_view = request.referrer

    if nombre_equipo is None:
        return jsonify({"error": "Nombre de equipo no proporcionado"}), 400

    # Consultar la base de datos para obtener el id basado en el nombre del equipo
    id_equipo_info = obtener_id_equipo_info_por_nombre(nombre_equipo)
    
    if id_equipo_info is None:
        return jsonify({"error": "Equipo no encontrado"}), 404

    # Ahora, usa el id_equipo_info para obtener la información del equipo
    equipo_info = obtener_equipo_info(id=id_equipo_info)
    
    if equipo_info:
        return redirect(url_for('mostrar_general_page', id_equipo_info=id_equipo_info, prev_view=prev_view ))

    else:
        return jsonify({"error": "No se pudo obtener la información del equipo"}), 500

@app.route('/LSA/mostrar-general/<int:id_equipo_info>', methods=['GET'])
def mostrar_general_page(id_equipo_info):
        session['id_equipo_info'] = id_equipo_info
        g.id_equipo_info = id_equipo_info
        analisis_funcionales, componentes = obtener_analisis_funcionales_por_equipo_info(id_equipo_info)
        equipo = obtener_informacion_equipo_info(id_equipo_info)
        prev_view = request.args.get('prev_view', url_for('index')) 

        if(equipo['FUA_FR']): 
            datosFUA = json.loads(equipo['FUA_FR'])
        else:  datosFUA = ""
        
        if equipo.get('AOR') and equipo['AOR'] != 0:
            equipo['AOR_porcentual'] = round(8760 / equipo['AOR'], 2)
        else:
            equipo['AOR_porcentual'] = 0

        fmeas = obtener_fmeas_por_equipo_info(id_equipo_info)
        # herramientas = obtener_herramientas_especiales(id_equipo_info)
        mtas = obtener_mta_por_equipo_info(id_equipo_info)
        rcms = obtener_rcm_por_equipo_info(id_equipo_info)
        repuestos = obtener_repuestos_por_equipo_info(id_equipo_info)
        herramientas_relacionadas = obtener_herramientas_relacionadas_por_equipo(id_equipo_info)

        # Asegurarse de que `analisis` y `herramientas` sean listas
        analisis = list(obtener_analisis_herramientas_por_equipo(id_equipo_info) or [])
        herramientas = list(obtener_herramientas_especiales_por_equipo(id_equipo_info) or [])

        # Agregar herramientas relacionadas
        for relacion in herramientas_relacionadas:
            id_herramienta = relacion['id_herramienta']
            id_clase_herramienta = relacion['id_clase_herramienta']
            
            if id_clase_herramienta == 1:
                herramienta_general = obtener_detalle_herramienta_general(id_herramienta)
                if herramienta_general:
                    analisis.append(herramienta_general)
            elif id_clase_herramienta == 2:
                herramienta_especial = obtener_detalle_herramienta_especial(id_herramienta)
                if herramienta_especial:
                    herramientas.append(herramienta_especial)
        # Obtener el grupo constructivo
        grupo_constructivo = obtener_grupo_constructivo_por_sistema_id(equipo['id_sistema']) if equipo.get(
            'id_sistema') else None

        # Obtener el subgrupo constructivo
        subgrupo_constructivo = obtener_subgrupo_constructivo_por_sistema_id(equipo['id_sistema']) if equipo.get('id_sistema') else None

        diagrama = obtener_diagramas_por_id(equipo['id_diagrama']) if equipo['id_diagrama'] else None

        # Obtener procedimiento relacionado si está presente
        procedimiento = obtener_procedimiento_por_id(equipo['id_procedimiento']) if equipo['id_procedimiento'] else None

        # Opcional: Obtener más detalles relacionados, por ejemplo, personal o sistema
        responsable = obtener_personal_por_id(equipo['id_personal']) if equipo['id_personal'] else None
        sistema = obtener_sistema_por_id(equipo['id_sistema']) if equipo['id_sistema'] else None
        datos_equipo = obtener_datos_equipo_por_id(equipo['id_equipo']) if equipo.get('id_equipo') else None
        # Obtener el tipo de equipo
        tipo_equipo = obtener_tipo_equipo_por_id(datos_equipo['id_tipos_equipos']) if datos_equipo.get('id_tipos_equipos') else None

        session['id_equipo_info'] = id_equipo_info

        return render_template('mostrar_general.html',
                               analisis_funcionales=analisis_funcionales,
                               componentes=componentes, 
                               equipo=equipo,
                               fmeas=fmeas,
                               herramientas=herramientas,
                               mtas=mtas,
                               rcms=rcms,
                               analisis=analisis,
                               datos_equipo=datos_equipo,
                               tipo_equipo=tipo_equipo,
                               diagrama=diagrama,
                               procedimiento=procedimiento,
                               responsable=responsable,
                               sistema=sistema,
                               grupo_constructivo=grupo_constructivo,
                               subgrupo_constructivo=subgrupo_constructivo,
                               repuestos=repuestos,
                               id_equipo_info=id_equipo_info,
                               datosFUA = datosFUA,
                               prev_view=prev_view
                               )
  

@app.route('/LSA/check_nombre_equipo', methods=['POST'])
def check_nombre_equipo():
    nombre_equipo = request.form.get('nombre_equipo')
    if nombre_equipo:
        exists = check_nombre_equipo_exists(nombre_equipo)
        return jsonify({'exists': exists})
    else:
        return jsonify({'exists': False})


def status404(error):
    return '<h1>La pagina no se encuentra, buscalo por otro lado</h1>',404



@app.before_request
def before_request():
    # Si necesitas limpiar `id_equipo_info` en cada reinicio del servidor
    session.pop('id_equipo_info', None)

@app.before_request
def before_request():
    if request.path.startswith('/static'):
        return  # Permitir acceso a archivos estáticos sin redirección


@app.route('/api/eliminar_personal', methods=['POST'])
def eliminar_personal_route():
    data = request.get_json()
    id_personal = data.get('id_personal')
    if id_personal:
        eliminar_personal(id_personal)
        return jsonify({'message': 'Personal eliminado'}), 200
    else:
        return jsonify({'error': 'ID de personal es requerido'}), 400

def obtener_equipo_info(id=None):
    if id:
        # Usar el id proporcionado para obtener id_sistema e id_equipo desde la tabla equipo_info
        cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
        query = "SELECT id, id_sistema, id_equipo FROM equipo_info WHERE id = %s"
        cursor.execute(query, (id,))
        result = cursor.fetchone()
        cursor.close()
        if result:
            # Asignar id a id_equipo_info para su uso en otras funciones
            id_equipo_info = id
            # Retornar los valores en el diccionario
            return {
                'id_equipo_info': id_equipo_info,
                'id_sistema': result['id_sistema'],
                'id_equipo': result['id_equipo']
            }
        else:
            return None
    else:
        # Obtener id_equipo_info, id_sistema, id_equipo desde el diccionario temporal por token
        token = g.user_token
        if token:
            user_data = obtener_info_usuario(token)
            id_equipo_info = user_data.get('id_equipo_info')
            id_sistema = user_data.get('id_sistema')
            id_equipo = user_data.get('id_equipo')
            return {
                'id_equipo_info': id_equipo_info,
                'id_sistema': id_sistema,
                'id_equipo': id_equipo
            }
        else:
            # Manejar el caso donde no hay token
            return None

def status404(error):
    return '<h1>La pagina no se encuentra, buscalo por otro lado</h1>',404

@app.before_request
def asignar_token_usuario():
    # Intentar obtener el token de la cookie o de los parámetros de la URL
    token = request.cookies.get('user_token') or request.args.get('token')

    # Si el token no existe, establecer un valor predeterminado para accesos desde ILS
    if not token and 'buqueId' in request.args:
        token = generar_token()  # Generar un token único para accesos desde ILS
        g.user_token = token
        g.usuario = {
            'correo': 'correo1@example.com',
            'nombre': 'Usuario ILS'
        }
        # Guardar el token en una cookie para futuras solicitudes
        response = make_response()
        response.set_cookie('user_token', token, httponly=True, secure=False, samesite='Lax')
        return response

    # Si el token existe, almacenarlo en g
    g.user_token = token


@app.route('/lsa-view', methods=['GET'])
def lsa_view():
    grupos = obtener_grupos_constructivos()  # Obtener los grupos constructivos
    nombre_buque= session['nombre_buque']
    buque_id = request.args.get('buqueId', type=int) or session.get('buque_id')

    return render_template('lsa_view.html', grupos=grupos, nombre_buque=nombre_buque, buque_id=buque_id)

@app.route('/desglose_general', methods=['GET'])
def desglose_general():
    grupos = obtener_grupos_constructivos()
    return render_template('desglose.html', grupos=grupos)


def normalize_key(text):
    """
    Normaliza un texto eliminando tildes, convirtiéndolo a minúsculas
    y reemplazando espacios por guiones bajos.
    """
    text = unicodedata.normalize('NFD', text)  # Descomponer caracteres Unicode
    text = re.sub(r'[\u0300-\u036f]', '', text)  # Eliminar diacríticos
    text = text.lower()  # Convertir a minúsculas
    text = re.sub(r'\s+', '_', text)  # Reemplazar espacios por guiones bajos
    text = re.sub(r'[^\w\-]', '', text)  # Eliminar caracteres no alfanuméricos
    return text


@app.route('/FUA-STRESS', methods=['GET'])
def fua_stress():
    id_equipo_info = request.args.get('id_equipo_info', type=int)
    buque_id = request.args.get('buqueId', type=int) or session.get('buque_id')
    sistema_id = session.get('sistema_id')

    datos_buque = obtener_datos_buque(buque_id)
    misiones = datos_buque.get("misiones", []) if datos_buque else []

    # Normalizar las claves para las misiones
    for mision in misiones:
        mision['normalized_id'] = normalize_key(mision['mision'])

    equipos = obtener_equipos_por_buque_y_sistema(buque_id, sistema_id)
    datosPuertoBase = session.get('datosPuertoBase')

    # Obtener información FUA_FR de cada equipo
    for equipo in equipos:
        fua_fr_data = obtener_fua_fr_db(equipo['id'])
        if fua_fr_data:
            try:
                equipo['fua_fr'] = json.loads(fua_fr_data)
            except json.JSONDecodeError:
                equipo['fua_fr'] = {}
        else:
            equipo['fua_fr'] = {}

    # Campos estáticos con `id` normalizados
    campos_estaticos = [
        {'label': 'Disponible para Misiones', 'id': 'disponible_para_misiones'},
        {'label': 'Disponibilidad de Mantenimiento', 'id': 'disponibilidad_de_mantenimiento'},
        {'label': 'Revisión Periódica (ROH)', 'id': 'revision_periodica_roh'}
    ]

    return render_template(
        'fua_stress.html',
        misiones=misiones,
        equipos=equipos,
        campos_estaticos=campos_estaticos,
        datosPuertoBase=datosPuertoBase,
        codigo=session.get('codigo'),
        nombre=session.get('nombre'),
        equipo_seleccionado=next((e for e in equipos if e['id'] == id_equipo_info), None)
    )


@app.route('/api/equipos/<int:equipo_id>/fua_fr', methods=['POST'])
def actualizar_fua_fr(equipo_id):
    """
    Ruta para actualizar la columna FUA_FR de un equipo.
    """
    try:
        recievedData = request.get_json()  # Obtener el JSON del cuerpo de la solicitud

        fua_fr_data = recievedData['data']
        AOR = recievedData['AOR']

        actualizar_fua_fr_db(equipo_id, AOR, json.dumps(fua_fr_data))  # Convertir el dict a JSON string
        return jsonify({"message": "FUA_FR actualizado correctamente."}), 200
    except Exception as e:
        return jsonify({"error": str(e)}), 500


@app.route('/api/equipos/<int:equipo_id>/fua_fr', methods=['GET'])
def obtener_fua_fr(equipo_id):
    """
    Ruta para obtener la columna FUA_FR de un equipo.
    """
    try:
        fua_fr_data = obtener_fua_fr_db(equipo_id)  # Llama a la función para obtener datos
        return jsonify({"fua_fr": json.loads(fua_fr_data) if fua_fr_data else {}}), 200
    except Exception as e:
        return jsonify({"error": str(e)}), 500
    

if __name__ == '__main__':
    app.run(debug=True)
