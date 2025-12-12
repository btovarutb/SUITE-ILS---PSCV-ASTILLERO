from flask import jsonify
from src.__init__ import db
import MySQLdb.cursors
from functools import wraps
import logging
import json
import base64

# Obtener un logger para este módulo
logger = logging.getLogger(__name__)

from flask import current_app
from MySQLdb import OperationalError
import time
import string

def retry_on_disconnect(func):
    """ Decorador para reintentar operaciones de base de datos en caso de desconexión. """
    @wraps(func)
    def wrapper(*args, **kwargs):
        max_retries = 10
        delay = 0.2  # Segundos entre intentos
        for attempt in range(max_retries):
            try:
                result = func(*args, **kwargs)
                current_app.logger.info(f"Función {func.__name__} ejecutada exitosamente con args={args}")
                return result
            except OperationalError as e:
                current_app.logger.error(f"OperationalError en {func.__name__}: {str(e)}")
                if e.args[0] in (1049, 2006, 2013):  # Errores comunes: DB desconocida o desconexión
                    current_app.logger.warning(f"Intentando reconectar a la base de datos (intento {attempt + 1})")
                    time.sleep(delay)
                    continue
                raise
            except Exception as e:
                current_app.logger.error(f"Excepción general en {func.__name__}: {str(e)} (tipo: {type(e)})")
                raise
        raise Exception("No se pudo conectar a la base de datos después de varios intentos.")
    return wrapper


@retry_on_disconnect
def insertar_componente_analisis_funcional(id_analisis_funcional, id_componente, verbo, accion):
    # Conexión a la base de datos
    cursor = db.connection.cursor()
    
    # Insertar los datos del componente relacionado con el análisis funcional
    query = """
    INSERT INTO `componente_analisis_funcional`(`id_componente`, `verbo`, `accion`, `id_analisis_funcional`)
    VALUES (%s, %s, %s, %s)
    """
    print(f"Query: {query}")
    print(f"Valores: id_componente={id_componente}, verbo={verbo}, accion={accion}, id_analisis_funcional={id_analisis_funcional}")
    
    cursor.execute(query, (id_componente, verbo, accion, id_analisis_funcional))
    db.connection.commit()

    cursor.close()



@retry_on_disconnect
def actualizar_componente_analisis_funcional(id_analisis_funcional, id_componente, verbo, accion):
    # Conexión a la base de datos
    cursor = db.connection.cursor()

    # Insertar los datos del componente relacionado con el análisis funcional
    query = """
    INSERT INTO `componente_analisis_funcional`(`id_componente`, `verbo`, `accion`, `id_analisis_funcional`)
    VALUES (%s, %s, %s, %s)
    """
    print(f'\n\n\n\nActualizar componentea:')
    print(f"Query: {query}")
    print(f"Valores: id_componente={id_componente}, verbo={verbo}, accion={accion}, id_analisis_funcional={id_analisis_funcional}\n\n\n")

    cursor.execute(query, (id_componente, verbo, accion, id_analisis_funcional))
    db.connection.commit()

    cursor.close()


@retry_on_disconnect
def verificar_conexion():
    try:
        cursor = db.connection.cursor()
        cursor.execute("SELECT 1")
        cursor.close()
        return {"status": "success", "message": "Database connection successful"}, 200
    except db.connection.Error as e:
        return {"status": "error", "message": str(e)}, 500


@retry_on_disconnect
def obtener_grupos_constructivos():
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT id, numeracion, nombre FROM grupo_constructivo ORDER BY numeracion"
    cursor.execute(query)
    grupos = cursor.fetchall()
    cursor.close()
    return grupos


@retry_on_disconnect
def obtener_subgrupos(id_grupo):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT id, numeracion, nombre FROM subgrupo WHERE id_grupo_constructivo = %s ORDER BY numeracion"
    cursor.execute(query, (id_grupo,))
    subgrupos = cursor.fetchall()
    cursor.close()
    return subgrupos


@retry_on_disconnect
def obtener_sistemas(id_subgrupo):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT id, numeracion, nombre FROM sistema WHERE id_subgrupo = %s ORDER BY numeracion"
    cursor.execute(query, (id_subgrupo,))
    sistemas = cursor.fetchall()
    cursor.close()
    return sistemas


@retry_on_disconnect
def obtener_equipos(id_sistema, id_buque=None):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    # Construcción dinámica de la consulta SQL
    query = "SELECT id, nombre_equipo FROM equipo_info WHERE id_sistema = %s"
    params = [id_sistema]

    # Si se proporciona un id_buque, se agrega a la consulta
    if id_buque:
        query += " AND id_buque = %s"
        params.append(id_buque)
    
    query += " ORDER BY nombre_equipo"

    cursor.execute(query, params)
    equipos = cursor.fetchall()
    cursor.close()
    return equipos



@retry_on_disconnect
def obtener_personal():
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT id, nombre_completo FROM personal ORDER BY nombre_completo"
    cursor.execute(query)
    personal = cursor.fetchall()
    cursor.close()
    return personal


@retry_on_disconnect
def obtener_tipos_equipos():
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT id, nombre FROM tipo_equipos ORDER BY nombre"
    cursor.execute(query)
    tipos = cursor.fetchall()
    cursor.close()
    return tipos


@retry_on_disconnect
def buscar_subgrupos(busqueda, id_grupo):
    cursor = db.connection.cursor()
    query = "SELECT id, numeracion, nombre FROM subgrupo WHERE id_grupo_constructivo = %s AND nombre LIKE %s ORDER BY numeracion"
    cursor.execute(query, (id_grupo, '%' + busqueda + '%'))
    subgrupos = cursor.fetchall()
    cursor.close()
    return subgrupos


@retry_on_disconnect
def buscar_sistemas(busqueda, id_subgrupo):
    cursor = db.connection.cursor()
    query = "SELECT id, numeracion, nombre FROM sistema WHERE id_subgrupo = %s AND nombre LIKE %s ORDER BY numeracion"
    cursor.execute(query, (id_subgrupo, '%' + busqueda + '%'))
    sistemas = cursor.fetchall()
    cursor.close()
    return sistemas


@retry_on_disconnect
def buscar_equipos(busqueda, id_sistema=None, id_buque=None):
    cursor = db.connection.cursor()
    if id_sistema:
        if id_buque: 
            query = "SELECT id, nombre_equipo FROM equipo_info WHERE id_sistema = %s AND nombre_equipo LIKE %s AND id_buque = %s ORDER BY nombre_equipo"
            cursor.execute(query, (id_sistema, '%' + busqueda + '%', id_buque))
        else:
            query = "SELECT id, nombre_equipo FROM equipo_info WHERE id_sistema = %s AND nombre_equipo LIKE %s ORDER BY nombre_equipo"
            cursor.execute(query, (id_sistema, '%' + busqueda + '%' ))

    else:
        if id_buque:
            query = "SELECT id, nombre_equipo FROM equipo_info WHERE nombre_equipo LIKE %s AND id_buque = %s ORDER BY nombre_equipo"
            cursor.execute(query, ('%' + busqueda + '%', id_buque))
        else:
            query = "SELECT id, nombre_equipo FROM equipo_info WHERE nombre_equipo LIKE %s ORDER BY nombre_equipo"
            cursor.execute(query, ('%' + busqueda + '%',))


    equipos = cursor.fetchall()
    cursor.close()
    return equipos


@retry_on_disconnect
def obtener_personal():
    cursor = db.connection.cursor()
    query = "SELECT id, nombre_completo FROM personal ORDER BY nombre_completo"
    cursor.execute(query)
    personal = cursor.fetchall()
    cursor.close()
    return personal


@retry_on_disconnect
def obtener_tipos_equipos():
    cursor = db.connection.cursor()
    query = "SELECT id, nombre FROM tipo_equipos ORDER BY nombre"
    cursor.execute(query)
    tipos_equipos = cursor.fetchall()
    cursor.close()
    return tipos_equipos


#Funciones para FMEA

#Obtener datos desplegables

@retry_on_disconnect
def obtener_fallos_ocultos():
    cursor = db.connection.cursor()
    query = "SELECT id, nombre, valor FROM fallo_oculto"
    cursor.execute(query)
    fallos_ocultos = cursor.fetchall()

    cursor.close()

    return [{'id': fila['id'], 'nombre': fila['nombre'], 'valor': fila['valor']} for fila in fallos_ocultos]


@retry_on_disconnect
def obtener_seguridad_fisica():
    cursor = db.connection.cursor()
    query = "SELECT id, nombre, valor FROM seguridad_fisica"
    cursor.execute(query)
    seguridad_fisica = cursor.fetchall()
    cursor.close()

    return [{'id': fila['id'], 'nombre': fila['nombre'], 'valor': fila['valor']} for fila in seguridad_fisica]


@retry_on_disconnect
def obtener_medio_ambiente():
    cursor = db.connection.cursor()
    query = "SELECT id, nombre, valor FROM medio_ambiente"
    cursor.execute(query)
    medio_ambiente_datos = cursor.fetchall()
    cursor.close()

    return [{'id': fila['id'], 'nombre': fila['nombre'], 'valor': fila['valor']} for fila in medio_ambiente_datos]


@retry_on_disconnect
def obtener_impacto_operacional():
    cursor = db.connection.cursor()
    query = "SELECT id, nombre, valor FROM impacto_operacional"
    cursor.execute(query)
    impacto_operacional_datos = cursor.fetchall()
    cursor.close()

    return [{'id': fila['id'], 'nombre': fila['nombre'], 'valor': fila['valor']} for fila in impacto_operacional_datos]


@retry_on_disconnect
def obtener_costos_reparacion():
    cursor = db.connection.cursor()
    query = "SELECT id, nombre, valor FROM costos_reparacion"
    cursor.execute(query)
    costos_reparacion_datos = cursor.fetchall()
    cursor.close()

    return [{'id': fila['id'], 'nombre': fila['nombre'], 'valor': fila['valor']} for fila in costos_reparacion_datos]


@retry_on_disconnect
def obtener_flexibilidad_operacional():
    cursor = db.connection.cursor()
    query = "SELECT id, nombre, valor FROM flexibilidad_operacional"
    cursor.execute(query)
    flexibilidad_operacional_datos = cursor.fetchall()
    cursor.close()

    return [{'id': fila['id'], 'nombre': fila['nombre'], 'valor': fila['valor']} for fila in
            flexibilidad_operacional_datos]


@retry_on_disconnect
def obtener_Ocurrencia():
    cursor = db.connection.cursor()
    query = "SELECT id, nombre, valor FROM ocurrencia"
    cursor.execute(query)
    ocurrencia_datos = cursor.fetchall()
    cursor.close()

    return [{'id': fila['id'], 'nombre': fila['nombre'], 'valor': fila['valor']} for fila in ocurrencia_datos]


@retry_on_disconnect
def obtener_probablilidad_deteccion():
    cursor = db.connection.cursor()
    query = "SELECT id, descripcion, valor FROM probabilidad_deteccion"
    cursor.execute(query)
    probabilidad_deteccion_datos = cursor.fetchall()
    cursor.close()

    return [{'id': fila['id'], 'descripcion': fila['descripcion'], 'valor': fila['valor']} for fila in
            probabilidad_deteccion_datos]


@retry_on_disconnect
def obtener_componentes_por_subsistema(subsistema_id):
    cursor = db.connection.cursor()

    query = """
        SELECT id, nombre 
        FROM componentes 
        WHERE id_subsistemas = %s
    """
    cursor.execute(query, (subsistema_id,))
    componentes = cursor.fetchall()
    cursor.close()

    # Convertir los resultados en una lista de diccionarios

    return [{'id': c['id'], 'nombre': c['nombre']} for c in componentes]


@retry_on_disconnect
def obtener_mecanismos_falla():
    cursor = db.connection.cursor()
    query = "SELECT id, nombre FROM mecanismo_falla"
    cursor.execute(query)
    mecanismos_falla = cursor.fetchall()
    cursor.close()
    return [{'id': fila['id'], 'nombre': fila['nombre']} for fila in mecanismos_falla]


@retry_on_disconnect
def obtener_detalles_falla_por_mecanismo(id_mecanismo_falla):
    cursor = db.connection.cursor()
    query = """
        SELECT id, nombre 
        FROM detalle_falla
        WHERE id_mecanismo_falla = %s
    """
    cursor.execute(query, (id_mecanismo_falla,))
    detalles_falla = cursor.fetchall()
    cursor.close()
    print(f"Detalles de falla para id_mecanismo_falla {id_mecanismo_falla}: {detalles_falla}")
    return [{'id': fila['id'], 'nombre': fila['nombre']} for fila in detalles_falla]


@retry_on_disconnect
def obtener_codigos_modo_falla():
    cursor = db.connection.cursor()
    query = "SELECT id, codigo, nombre FROM codigo_modo_falla"
    cursor.execute(query)
    codigos = cursor.fetchall()
    cursor.close()
    return [{'id': fila['id'], 'codigo': fila['codigo'], 'nombre': fila['nombre']} for fila in codigos]


@retry_on_disconnect
def obtener_metodos_deteccion_falla():
    cursor = db.connection.cursor()
    query = "SELECT id, nombre FROM metodo_deteccion_falla"
    cursor.execute(query)
    metodos_deteccion_falla = cursor.fetchall()
    cursor.close()

    return [{'id': fila['id'], 'nombre': fila['nombre']} for fila in metodos_deteccion_falla]


#Esta no es para un desplegable pero retorna una lista de la misma manera
@retry_on_disconnect
def obtener_lista_riesgos():
    cursor = db.connection.cursor()
    query = "SELECT id, nombre FROM riesgo ORDER BY id"
    cursor.execute(query)
    riesgos = cursor.fetchall()
    cursor.close()

    # Verificar la lista obtenida antes de retornarla
    print("Lista de riesgos obtenida:", riesgos)

    return [{'id': riesgo['id'], 'nombre': riesgo['nombre']} for riesgo in riesgos]


#Obtener id para FMEA
@retry_on_disconnect
def obtener_id_equipo_info_por_fmea(fmea_id):
    cursor = db.connection.cursor()
    query = """
    SELECT id_equipo_info 
    FROM fmea 
    WHERE id = %s
    """

    cursor.execute(query, (fmea_id,))
    resultado = cursor.fetchone()
    cursor.close()

    if resultado:
        return resultado['id_equipo_info']  # Retorna el id_equipo_info si lo encuentra
    else:
        return None  # Si no encuentra el fmea_id, retorna None


@retry_on_disconnect
def obtener_id_sistema_por_fmea_id(fmea_id):
    cursor = db.connection.cursor()
    query = """
    SELECT id_sistema 
    FROM fmea 
    WHERE id = %s
    """

    cursor.execute(query, (fmea_id,))
    resultado = cursor.fetchone()
    cursor.close()

    if resultado:
        return resultado['id_sistema']
    else:
        return None


@retry_on_disconnect
def obtener_id_componente_por_fmea_id(fmea_id):
    cursor = db.connection.cursor()
    query = """
    SELECT id_componente
    FROM fmea
    WHERE id = %s
    """
    cursor.execute(query, (fmea_id,))
    componente = cursor.fetchone()
    cursor.close()

    return componente['id_componente'] if componente else None


@retry_on_disconnect
def obtener_id_subsistema_por_componente_id(id_componente):
    cursor = db.connection.cursor()
    query = """
    SELECT id_subsistemas
    FROM componentes
    WHERE id = %s
    """
    cursor.execute(query, (id_componente,))
    subsistema_id = cursor.fetchone()
    cursor.close()

    return subsistema_id['id_subsistemas'] if subsistema_id else None


##Insertar en sus respectivas tablas los datos que devuelven el id para la tabla de fmea

#funcion con la queverificamos en cada uno que los datos no existan para incertarlos y si ya estan simplemente se referencian esos
@retry_on_disconnect
def obtener_id_si_existe(query, params):
    cursor = db.connection.cursor()
    cursor.execute(query, params)
    resultado = cursor.fetchone()
    cursor.close()
    return resultado['id'] if resultado else None


@retry_on_disconnect
def insertar_falla_funcional(falla_funcional_nombre):
    query_existencia = "SELECT id FROM falla_funcional WHERE nombre = %s"
    falla_funcional_id = obtener_id_si_existe(query_existencia, (falla_funcional_nombre,))

    if falla_funcional_id:
        return falla_funcional_id

    cursor = db.connection.cursor()
    query = "INSERT INTO falla_funcional (nombre) VALUES (%s)"
    cursor.execute(query, (falla_funcional_nombre,))
    db.connection.commit()
    falla_funcional_id = cursor.lastrowid
    cursor.close()
    return falla_funcional_id


@retry_on_disconnect
def insertar_descripcion_modo_falla(descripcion_modo_falla):
    query_existencia = "SELECT id FROM descripcion_modo_falla WHERE nombre = %s"
    descripcion_modo_falla_id = obtener_id_si_existe(query_existencia, (descripcion_modo_falla,))

    if descripcion_modo_falla_id:
        return descripcion_modo_falla_id

    cursor = db.connection.cursor()
    query = "INSERT INTO descripcion_modo_falla (nombre) VALUES (%s)"
    cursor.execute(query, (descripcion_modo_falla,))
    db.connection.commit()
    descripcion_modo_falla_id = cursor.lastrowid
    cursor.close()
    return descripcion_modo_falla_id


@retry_on_disconnect
def insertar_causa(nombre_causa):
    query_existencia = "SELECT id FROM causa WHERE nombre = %s"
    causa_id = obtener_id_si_existe(query_existencia, (nombre_causa,))

    if causa_id:
        return causa_id

    cursor = db.connection.cursor()
    query = "INSERT INTO causa (nombre) VALUES (%s)"
    cursor.execute(query, (nombre_causa,))
    db.connection.commit()
    causa_id = cursor.lastrowid
    cursor.close()
    return causa_id


################################################################################################################

#Fmea Registro
@retry_on_disconnect
def insertar_fmea(id_equipo_info, id_sistema, id_falla_funcional, id_componente, id_codigo_modo_falla,
                  id_consecutivo_modo_falla, id_descripcion_modo_falla, id_causa, id_mecanismo_falla,
                  id_detalle_falla, MTBF, MTTR, id_metodo_deteccion_falla, id_fallo_oculto, id_seguridad_fisica,
                  id_medio_ambiente, id_impacto_operacional, id_costos_reparacion, id_flexibilidad_operacional,
                  calculo_severidad, id_ocurrencia, ocurrencia_mate, id_probabilidad_deteccion, rpn, id_riesgo,
                  no_funcion, funcion_activo, descripcion_falla_funcional, ref_elemento_tag,
                  funcion_item_componente, no_modo_falla, no_efecto_falla, efecto_falla, observaciones):

    cursor = db.connection.cursor()
    query = """
        INSERT INTO fmea (
            id_equipo_info, id_sistema, id_falla_funcional, id_componente, id_codigo_modo_falla, 
            id_consecutivo_modo_falla, id_descripcion_modo_falla, id_causa, id_mecanismo_falla, 
            id_detalle_falla, MTBF, MTTR, id_metodo_deteccion_falla, id_fallo_oculto, id_seguridad_fisica, 
            id_medio_ambiente, id_impacto_operacional, id_costos_reparacion, id_flexibilidad_operacional, 
            calculo_severidad, id_ocurrencia, ocurrencia_mate, id_probabilidad_deteccion, RPN, id_riesgo,
            no_funcion, funcion_activo, descripcion_falla_funcional, ref_elemento_tag,
            funcion_item_componente, no_modo_falla, no_efecto_falla, efecto_falla, observaciones
        ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
                  %s, %s, %s, %s, %s, %s, %s, %s, %s)
    """

    cursor.execute(query, (
        id_equipo_info, id_sistema, id_falla_funcional, id_componente, id_codigo_modo_falla,
        id_consecutivo_modo_falla, id_descripcion_modo_falla, id_causa, id_mecanismo_falla,
        id_detalle_falla, MTBF, MTTR, id_metodo_deteccion_falla, id_fallo_oculto, id_seguridad_fisica,
        id_medio_ambiente, id_impacto_operacional, id_costos_reparacion, id_flexibilidad_operacional,
        calculo_severidad, id_ocurrencia, ocurrencia_mate, id_probabilidad_deteccion, rpn, id_riesgo,
        no_funcion, funcion_activo, descripcion_falla_funcional, ref_elemento_tag,
        funcion_item_componente, no_modo_falla, no_efecto_falla, efecto_falla, observaciones
    ))

    db.connection.commit()
    fmea_id = cursor.lastrowid
    cursor.close()
    return fmea_id


########################################################################

#Funciones para mostrar fmea

#funcion para poder obtener los nombres que estan ligados al id resgistrados en una tabla


@retry_on_disconnect
def obtener_nombre_por_id(tabla, id, columna_id='id'):

    cursor = db.connection.cursor()

    # Verificar si la tabla tiene la columna 'nombre'
    query_column_check = f"SHOW COLUMNS FROM {tabla} LIKE 'nombre'"
    cursor.execute(query_column_check)
    columna_existe = cursor.fetchone()

    if columna_existe:  # Si la columna 'nombre' existe


        # Usar el nombre de columna dinámico en el WHERE
        query = f"SELECT nombre FROM {tabla} WHERE {columna_id} = %s"

        cursor.execute(query, (id,))
        resultado = cursor.fetchone()
        cursor.close()

        if resultado:
            return resultado['nombre']

    else:

        cursor.close()
        return None

    return None



@retry_on_disconnect
def obtener_fmeas(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    query = """
    SELECT 
        f.id, 
        f.id_equipo_info, 
        f.id_sistema,                                   -- guarda el ID del SUBSISTEMA
        s.id   AS subsistema_id,                        -- NUEVO
        s.nombre AS subsistema_nombre,                  -- NUEVO

        f.id_falla_funcional, 
        ff.nombre AS falla_funcional, 
        f.id_componente, 
        c.nombre AS componente, 
        f.id_codigo_modo_falla, 
        cmf.nombre AS codigo_modo_falla, 
        f.id_consecutivo_modo_falla, 
        cf.nombre AS consecutivo_modo_falla, 
        f.id_descripcion_modo_falla, 
        dmf.nombre AS descripcion_modo_falla, 
        f.id_causa, 
        causa.nombre AS causa, 
        f.id_mecanismo_falla, 
        mf.nombre AS mecanismo_falla, 
        f.id_detalle_falla, 
        df.nombre AS detalle_falla, 
        f.MTBF, 
        f.MTTR, 
        f.id_metodo_deteccion_falla,
        f.id_fallo_oculto,
        fo.valor AS fallo_oculto_valor, 
        fo.nombre AS fallo_oculto_descripcion, 
        f.id_seguridad_fisica, 
        sf.valor AS seguridad_fisica_valor, 
        sf.nombre AS seguridad_fisica_descripcion, 
        f.id_medio_ambiente, 
        ma.valor AS medio_ambiente_valor, 
        ma.nombre AS medio_ambiente_descripcion, 
        f.id_impacto_operacional, 
        io.valor AS impacto_operacional_valor, 
        io.nombre AS impacto_operacional_descripcion, 
        f.id_costos_reparacion, 
        cr.valor AS costos_reparacion_valor, 
        cr.nombre AS costos_reparacion_descripcion, 
        f.id_flexibilidad_operacional, 
        flex.valor AS flexibilidad_operacional_valor, 
        flex.nombre AS flexibilidad_operacional_descripcion, 
        f.calculo_severidad,
        f.id_ocurrencia, 
        o.valor AS ocurrencia_valor, 
        o.nombre AS ocurrencia_descripcion, 
        f.ocurrencia_mate, 
        f.id_probabilidad_deteccion, 
        pd.valor AS probabilidad_deteccion_valor, 
        pd.descripcion AS probabilidad_deteccion_descripcion,
        f.RPN,
        f.id_riesgo,
        r.nombre AS nombre_riesgo,
        f.no_funcion,
        f.funcion_activo,
        f.descripcion_falla_funcional,
        f.ref_elemento_tag,
        f.funcion_item_componente,
        f.no_modo_falla,
        f.no_efecto_falla,
        f.efecto_falla,
        f.observaciones,
        p.nombre_completo AS nombre_completo,
        p.id AS id_personal
    FROM fmea f
    LEFT JOIN equipo_info ei     ON f.id_equipo_info = ei.id
    LEFT JOIN personal p         ON ei.id_personal = p.id
    LEFT JOIN subsistemas_LSA s  ON f.id_sistema = s.id         -- subsistema usado en FMEA
    LEFT JOIN falla_funcional ff ON f.id_falla_funcional = ff.id
    LEFT JOIN componentes c      ON f.id_componente = c.id
    LEFT JOIN codigo_modo_falla cmf ON f.id_codigo_modo_falla = cmf.id
    LEFT JOIN consecutivo_modo_falla cf ON f.id_consecutivo_modo_falla = cf.id
    LEFT JOIN descripcion_modo_falla dmf ON f.id_descripcion_modo_falla = dmf.id
    LEFT JOIN causa              ON f.id_causa = causa.id
    LEFT JOIN mecanismo_falla mf ON f.id_mecanismo_falla = mf.id
    LEFT JOIN detalle_falla df   ON f.id_detalle_falla = df.id
    LEFT JOIN fallo_oculto fo    ON f.id_fallo_oculto = fo.id
    LEFT JOIN seguridad_fisica sf ON f.id_seguridad_fisica = sf.id
    LEFT JOIN medio_ambiente ma  ON f.id_medio_ambiente = ma.id
    LEFT JOIN impacto_operacional io ON f.id_impacto_operacional = io.id
    LEFT JOIN costos_reparacion cr ON f.id_costos_reparacion = cr.id
    LEFT JOIN flexibilidad_operacional flex ON f.id_flexibilidad_operacional = flex.id
    LEFT JOIN ocurrencia o       ON f.id_ocurrencia = o.id
    LEFT JOIN probabilidad_deteccion pd ON f.id_probabilidad_deteccion = pd.id
    LEFT JOIN riesgo r           ON f.id_riesgo = r.id
    WHERE f.id_equipo_info = %s AND f.estado = 'activo'
    """

    cursor.execute(query, (id_equipo_info,))
    fmeas = cursor.fetchall()
    cursor.close()

    return fmeas


#########################

#fmea editar y eliminar
@retry_on_disconnect
def obtener_fmea_por_id(fmea_id, id_equipo_info):
    # Obtener la lista completa de FMEAs con nombres procesados
    fmeas_completos = obtener_fmeas(id_equipo_info)

    # Buscar el FMEA por el ID en la lista completa
    fmea_filtrado = next((fmea for fmea in fmeas_completos if fmea['id'] == fmea_id), None)

    # Si se encuentra el FMEA, lo devolvemos, si no, devolvemos None
    if fmea_filtrado:
        print(fmea_filtrado)
        return fmea_filtrado
    else:
        return None


@retry_on_disconnect
def obtener_ID_FMEA(fmea_id):
    cursor = db.connection.cursor()

    query = "SELECT * FROM fmea WHERE id = %s AND estado = 'activo'"

    cursor.execute(query, (fmea_id,))
    fmea = cursor.fetchone()
    cursor.close()

    return fmea


@retry_on_disconnect
def actualizar_fmea(
        fmea_id, id_equipo_info, sistema_id, id_falla_funcional, id_componente,
        id_codigo_modo_falla, id_consecutivo_modo_falla, id_descripcion_modo_falla,
        id_causa, id_mecanismo_falla, id_detalle_falla, mtbf, mttr, id_fallo_oculto,
        id_seguridad_fisica, id_medio_ambiente, id_impacto_operacional,
        id_costos_reparacion, id_flexibilidad_operacional, calculo_severidad, id_ocurrencia,
        ocurrencia_mate, id_probabilidad_deteccion, id_metodo_deteccion_falla, rpn, id_riesgo,
        no_funcion, funcion_activo, descripcion_falla_funcional, ref_elemento_tag, 
        funcion_item_componente, no_modo_falla, no_efecto_falla, efecto_falla, observaciones
):
    cursor = db.connection.cursor()
    query = """
        UPDATE fmea SET
            id_equipo_info = %s, id_sistema = %s, id_falla_funcional = %s, 
            id_componente = %s, id_codigo_modo_falla = %s, id_consecutivo_modo_falla = %s, 
            id_descripcion_modo_falla = %s, id_causa = %s, id_mecanismo_falla = %s, 
            id_detalle_falla = %s, MTBF = %s, MTTR = %s, id_fallo_oculto = %s, 
            id_seguridad_fisica = %s, id_medio_ambiente = %s, id_impacto_operacional = %s, 
            id_costos_reparacion = %s, id_flexibilidad_operacional = %s, calculo_severidad = %s, id_ocurrencia = %s, 
            ocurrencia_mate = %s, id_probabilidad_deteccion = %s, id_metodo_deteccion_falla = %s, RPN = %s, id_riesgo = %s,
            no_funcion = %s, funcion_activo = %s, descripcion_falla_funcional = %s, 
            ref_elemento_tag = %s, funcion_item_componente = %s, no_modo_falla = %s, 
            no_efecto_falla = %s, efecto_falla = %s, observaciones = %s
        WHERE id = %s
    """
    cursor.execute(query, (
        id_equipo_info, sistema_id, id_falla_funcional, id_componente, id_codigo_modo_falla,
        id_consecutivo_modo_falla, id_descripcion_modo_falla, id_causa, id_mecanismo_falla,
        id_detalle_falla, mtbf, mttr, id_fallo_oculto, id_seguridad_fisica, id_medio_ambiente,
        id_impacto_operacional, id_costos_reparacion, id_flexibilidad_operacional, calculo_severidad,
        id_ocurrencia, ocurrencia_mate, id_probabilidad_deteccion, id_metodo_deteccion_falla, rpn, id_riesgo,
        no_funcion, funcion_activo, descripcion_falla_funcional, ref_elemento_tag, 
        funcion_item_componente, no_modo_falla, no_efecto_falla, efecto_falla, observaciones,
        fmea_id
    ))
    db.connection.commit()
    cursor.close()


##################################################################################################################

@retry_on_disconnect
def obtener_aor_por_id_equipo_info(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT AOR FROM equipo_info WHERE id = %s"
    cursor.execute(query, (id_equipo_info,))
    resultado = cursor.fetchone()
    cursor.close()
    if resultado:
        return resultado['AOR']
    else:
        return None

@retry_on_disconnect
def insertar_procedimiento(arranque, parada):
    cursor = db.connection.cursor()
    query = "INSERT INTO procedimientos (arranque, parada) VALUES (%s, %s)"
    cursor.execute(query, (arranque, parada))
    db.connection.commit()
    procedimiento_id = cursor.lastrowid
    cursor.close()
    return procedimiento_id


def insertar_diagrama(diagrama_flujo, diagrama_caja_negra, diagrama_caja_transparente,
                      xml_flujo=None, xml_caja_negra=None, xml_caja_transparente=None):
    cursor = db.connection.cursor()
    query = """
        INSERT INTO diagramas (
            diagrama_flujo, diagrama_caja_negra, diagrama_caja_transparente,
            xml_diagrama_flujo, xml_diagrama_caja_negra, xml_diagrama_caja_transparente
        ) VALUES (%s, %s, %s, %s, %s, %s)
    """
    cursor.execute(query, (
        diagrama_flujo, diagrama_caja_negra, diagrama_caja_transparente,
        xml_flujo, xml_caja_negra, xml_caja_transparente
    ))
    db.connection.commit()
    diagrama_id = cursor.lastrowid
    cursor.close()
    return diagrama_id



@retry_on_disconnect
def insertar_equipo_info(
    nombre_equipo, fecha, fiabilidad_equipo, GRES, criticidad_equipo,
    marca, modelo, peso_seco, dimensiones, descripcion, imagen_equipo_file,
    id_personal, id_diagrama, id_procedimiento, id_sistema, id_equipo,
    id_sistema_ils, id_buque, cj, id_subsistema,
    eqart, typbz, datsl, inbdt, baujj, baumm, gewei,
    ansdt, answt, waers, herst, herld, mapar, serge, abckz, gewrk, tplnr, Noclase
):
    cursor = db.connection.cursor()
    try:
        # Si viene imagen como bytes, envolver en Binary para BLOB
        imagen_bin = MySQLdb.Binary(imagen_equipo_file) if imagen_equipo_file is not None else None

        query = """
            INSERT INTO equipo_info (
                nombre_equipo, fecha, fiabilidad_equipo, GRES, criticidad_equipo,
                marca, modelo, peso_seco, dimensiones, descripcion,
                imagen, id_personal, id_diagrama, id_procedimiento, id_sistema,
                id_equipo, id_sistema_ils, id_buque, cj, id_subsistema,
                eqart, typbz, datsl, inbdt, baujj,
                baumm, gewei,ansdt, answt, waers,
                herst, herld, mapar, serge, abckz,
                gewrk, tplnr, `class`
            ) VALUES (
                %s,%s,%s,%s,%s,
                %s,%s,%s,%s,%s,
                %s,%s,%s,%s,%s,
                %s,%s,%s,%s,%s,
                %s,%s,%s,%s,%s,
                %s,%s,%s,%s,%s,
                %s,%s,%s,%s,%s,
                %s,%s,%s
            )
        """

        params = (
            nombre_equipo, fecha, fiabilidad_equipo, GRES, criticidad_equipo,
            marca, modelo, peso_seco, dimensiones, descripcion, imagen_bin,
            id_personal, id_diagrama, id_procedimiento, id_sistema, id_equipo,
            id_sistema_ils, id_buque, cj, id_subsistema,
            eqart, typbz, datsl, inbdt, baujj, baumm, gewei,
            ansdt, answt, waers, herst, herld, mapar, serge, abckz, gewrk, tplnr, Noclase
        )

        cursor.execute(query, params)
        db.connection.commit()
        equipo_info_id = cursor.lastrowid
        return equipo_info_id

    except Exception as e:
        try:
            logger.error(f"[DB] _executed: {getattr(cursor, '_executed', None)}")
        except Exception:
            pass
        db.connection.rollback()
        raise Exception(f"Error al insertar equipo_info: {e}")

    finally:
        cursor.close()


@retry_on_disconnect
def obtener_equipos_por_tipo(id_tipo_equipo):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT id, nombre FROM equipos WHERE id_tipos_equipos = %s ORDER BY nombre"
    cursor.execute(query, (id_tipo_equipo,))
    equipospro = cursor.fetchall()
    cursor.close()
    return equipospro


@retry_on_disconnect
def obtener_id_equipo_por_id_info(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT id_equipo FROM equipo_info WHERE id=%s;"
    cursor.execute(query, (id_equipo_info,))
    resultado = cursor.fetchone()
    cursor.close()
    return resultado['id_equipo'] if resultado else None


@retry_on_disconnect
def obtener_sistema_por_id(id_sistema):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM sistema WHERE id = %s"
    cursor.execute(query, (id_sistema,))
    sistema = cursor.fetchone()
    cursor.close()
    return sistema


@retry_on_disconnect
def obtener_subsistema_por_id(id_subsistema):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM subsistemas WHERE id = %s"
    cursor.execute(query, (id_subsistema,))
    sistema = cursor.fetchone()
    cursor.close()
    return sistema


@retry_on_disconnect
def obtener_subsistemas_por_equipo(id_equipo):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM subsistemas_LSA WHERE id_equipo = %s"
    cursor.execute(query, (id_equipo,))
    subsistemas = cursor.fetchall()
    cursor.close()
    return subsistemas


# ... otras funciones ...

@retry_on_disconnect
def obtener_usuario_por_correo(correo):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT id, correo, password, nombre_completo FROM personal WHERE correo = %s"
    cursor.execute(query, (correo,))
    usuario = cursor.fetchone()
    cursor.close()
    return usuario


@retry_on_disconnect
def insertar_analisis_funcional(verbo, accion, estandar_desempeño, id_equipo_info, subsistema_id):
    cursor = db.connection.cursor()
    query = """
            INSERT INTO analisis_funcional (verbo, accion, estandar_desempeño, id_equipo_info,id_subsistema)
            VALUES (%s, %s, %s, %s, %s)
        """
    cursor.execute(query, (verbo, accion, estandar_desempeño, id_equipo_info, subsistema_id,))
    db.connection.commit()
    analisis_funcional_id = cursor.lastrowid
    cursor.close()
    return analisis_funcional_id


###################################################################Funcines para MTA#############################


#insertar_mta(fmea['id_equipo_info'], id_sistema, id_componente, fmea['id_falla_funcional'], fmea['id_descripcion_modo_falla'], id_tipo_mantenimiento, id_tarea_mantenimiento, cantidad_personal, consumibles_requeridos ,requeridos_tarea,condiciones_ambientales, condiciones_estado_equipo, condiciones_especiales,  horas, minutos, detalle_tarea)
@retry_on_disconnect
def insertar_mta(id_rcm, id_equipo_info, id_sistema, id_componente, id_falla_funcional, id_descripcion_modo_falla,
                 id_tipo_mantenimiento, id_tarea_mantenimiento, cantidad_personal, consumibles_requeridos,
                 requeridos_tarea, condiciones_ambientales, condiciones_estado_equipo, condiciones_especiales, horas,
                 minutos, detalle_tarea):
    cursor = db.connection.cursor()
    query = """
        INSERT INTO mta (
            id_rcm, id_equipo_info, id_sistema, id_componente, id_falla_funcional, id_descripcion_modo_falla, id_tipo_mantenimiento, id_tarea_mantenimiento, cantidad_personal, consumibles_requeridos, requeridos_tarea, condiciones_ambientales, condiciones_estado_equipo, condiciones_especiales, horas, minutos, detalle_tarea
        )
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
    """
    cursor.execute(query, (
        id_rcm, id_equipo_info, id_sistema, id_componente, id_falla_funcional, id_descripcion_modo_falla,
        id_tipo_mantenimiento, id_tarea_mantenimiento, cantidad_personal, consumibles_requeridos, requeridos_tarea,
        condiciones_ambientales, condiciones_estado_equipo, condiciones_especiales, horas, minutos, detalle_tarea
    ))
    db.connection.commit()
    mta_id = cursor.lastrowid
    cursor.close()
    return mta_id


@retry_on_disconnect
def actualizar_mta(id_mta, id_tipo_mantenimiento, id_tarea_mantenimiento, cantidad_personal, consumibles_requeridos,
                   requeridos_tarea, condiciones_ambientales, condiciones_estado_equipo, condiciones_especiales, horas,
                   minutos, detalle_tarea):
    cursor = db.connection.cursor()
    query = """
        UPDATE mta
        SET id_tipo_mantenimiento = %s, id_tarea_mantenimiento = %s, cantidad_personal = %s, consumibles_requeridos = %s, requeridos_tarea = %s, condiciones_ambientales = %s, condiciones_estado_equipo = %s, condiciones_especiales = %s, horas = %s, minutos = %s, detalle_tarea = %s
        WHERE id = %s
    """
    cursor.execute(query, (
        id_tipo_mantenimiento, id_tarea_mantenimiento, cantidad_personal, consumibles_requeridos, requeridos_tarea,
        condiciones_ambientales, condiciones_estado_equipo, condiciones_especiales, horas, minutos, detalle_tarea,
        id_mta
    ))
    db.connection.commit()
    cursor.close()


@retry_on_disconnect
def eliminar_mta(id_mta):
    cursor = db.connection.cursor()
    # Cambiar el estado a 'inactivo' en lugar de eliminar
    update_query = "UPDATE mta SET estado = 'inactivo' WHERE id = %s"
    cursor.execute(update_query, (id_mta,))
    db.connection.commit()
    cursor.close()


@retry_on_disconnect
def obtener_mtas_completos():
    cursor = db.connection.cursor()
    query = """
    SELECT 
        m.id, 
        m.id_rcm, 
        m.id_equipo_info, 
        m.id_sistema, 
        m.id_componente, 
        m.id_falla_funcional, 
        m.id_descripcion_modo_falla, 
        m.id_tipo_mantenimiento, 
        m.id_tarea_mantenimiento, 
        m.cantidad_personal, 
        m.consumibles_requeridos, 
        m.requeridos_tarea, 
        m.condiciones_ambientales, 
        m.condiciones_estado_equipo, 
        m.condiciones_especiales, 
        m.horas, 
        m.minutos, 
        m.detalle_tarea,
        ei.nombre_equipo as equipo, 
        s.nombre as sistema, 
        c.nombre as componente, 
        ff.nombre as falla_funcional, 
        dmf.nombre as descripcion_modo_falla, 
        tm.nombre as tipo_mantenimiento, 
        tmr.nombre as tarea_mantenimiento,
        l.nivel,
        l.actividades,
        l.operario        
    FROM mta m
    LEFT JOIN rcm r ON m.id_rcm = r.id
    LEFT JOIN equipo_info ei ON m.id_equipo_info = ei.id
    LEFT JOIN sistema s ON m.id_sistema = s.id
    LEFT JOIN componentes c ON m.id_componente = c.id
    LEFT JOIN falla_funcional ff ON m.id_falla_funcional = ff.id
    LEFT JOIN descripcion_modo_falla dmf ON m.id_descripcion_modo_falla = dmf.id
    LEFT JOIN tipo_mantenimiento tm ON m.id_tipo_mantenimiento = tm.id
    LEFT JOIN tarea_mantenimiento tmr ON m.id_tarea_mantenimiento = tmr.id
    LEFT JOIN lora_mta l ON m.id = l.id_mta
    WHERE m.estado = 'activo'
    """
    cursor.execute(query)
    mtas = cursor.fetchall()
    cursor.close()
    return mtas


@retry_on_disconnect
def obtener_mta_por_id_rcm(id_rcm):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM mta AS m WHERE m.estado = 'activo' AND m.id_rcm = %s"
    cursor.execute(query, (id_rcm,))
    mta = cursor.fetchone()
    cursor.close()
    return mta



"""
1RO para la funcion de mostrar herramientas necesito que haga una peticion a la base de datos de herramientas
relaciones y que me devuelva todas las herramientas que tienen el id_equipo_info y me va a devolver los datos en la columna id_herramienta y en la id_clase_herramienta
luego un print para ver que me devolivo, despues de eso, voy a hacer otra peticion para mostrar donde en la variable analisis se va a hacer una funcion
que busque en la base de datos de herramientas_generales las que tengan el id_clase_herramienta 1 donde por cada dato que obtuve en el filtrado de herramientas relaciones
voy a hacer una peticion para que se me devulva toda la fila que contiene ese id_herramienta, y la misma logica con herramientas especiales que se guarda en la variable herramientas
"""
#######################
@retry_on_disconnect
def obtener_herramientas_relacionadas_por_equipo(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = """
        SELECT id_herramienta, id_clase_herramienta
        FROM herramientas_relacion
        WHERE id_equipo_info = %s
    """
    cursor.execute(query, (id_equipo_info,))
    herramientas_relacionadas = cursor.fetchall()
    cursor.close()
    return herramientas_relacionadas

@retry_on_disconnect
def obtener_detalle_herramienta_general(id_herramienta):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = """
        SELECT * FROM herramientas_generales
        WHERE id = %s
    """
    cursor.execute(query, (id_herramienta,))
    herramienta_general = cursor.fetchone()
    cursor.close()
    return herramienta_general

@retry_on_disconnect
def obtener_detalle_herramienta_especial(id_herramienta):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = """
        SELECT * FROM herramientas_especiales
        WHERE id = %s
    """
    cursor.execute(query, (id_herramienta,))
    herramienta_especial = cursor.fetchone()
    cursor.close()
    return herramienta_especial

#######################
@retry_on_disconnect
def obtener_datos_herramienta(nombre_herramienta):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)  # Usar un cursor de diccionario para acceder por nombre de columna

    # Buscar el id_clase_herramienta en la tabla herramientas_requeridas usando el nombre de la herramienta
    query = "SELECT id_clase_herramienta FROM herramientas_requeridas WHERE nombre = %s"
    cursor.execute(query, (nombre_herramienta,))
    resultado = cursor.fetchone()
    
    # Si no se encuentra la herramienta, devolver None para ambos valores
    if not resultado:
        cursor.close()
        return None, None

    # Extraer id_clase_herramienta del resultado
    id_clase_herramienta = resultado.get('id_clase_herramienta')

    # Determinar en cuál tabla buscar según el valor de id_clase_herramienta
    if id_clase_herramienta == 1:
        tabla_busqueda = 'herramientas_generales'
        columna_nombre = 'nombre'
    elif id_clase_herramienta == 2:
        tabla_busqueda = 'herramientas_especiales'
        columna_nombre = 'nombre_herramienta'
    else:
        cursor.close()
        return None, id_clase_herramienta

    # Ejecutar la consulta para obtener el ID de la herramienta en la tabla correspondiente
    query = f"SELECT id FROM {tabla_busqueda} WHERE {columna_nombre} = %s"
    cursor.execute(query, (nombre_herramienta,))
    resultado = cursor.fetchone()
    cursor.close()

    # Si se encuentra un ID en la tabla específica, devolver el ID y el id_clase_herramienta
    if resultado:
        return resultado.get('id'), id_clase_herramienta
    else:
        return None, id_clase_herramienta

@retry_on_disconnect
def insertar_herramienta_relacion(id_herramienta, id_clase_herramienta, id_equipo_info):
    cursor = db.connection.cursor()

    # Inserta la relación en la tabla herramientas_relacion
    query = """
        INSERT INTO herramientas_relacion (id_herramienta, id_clase_herramienta, id_equipo_info)
        VALUES (%s, %s, %s)
    """
    try:
        cursor.execute(query, (id_herramienta, id_clase_herramienta, id_equipo_info))
        db.connection.commit()  # Confirma los cambios en la base de datos
        print(f"Relación insertada: Herramienta ID {id_herramienta}, Clase {id_clase_herramienta}, Equipo {id_equipo_info}")
    except Exception as e:
        db.connection.rollback()  # Revertir cambios si ocurre un error
        print("Error al insertar la relación:", e)
    finally:
        cursor.close()
    
    
@retry_on_disconnect
def obtener_herramientas_generales_por_equipo(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM `herramientas_relacion` WHERE id_equipo_info = %s;"
    cursor.execute(query, (id_equipo_info,))
    herramientas_relacion = cursor.fetchall()
    query = "SELECT * FROM `herramientas_generales` WHERE id_tipo_herramienta = 1;"
    cursor.execute(query)
    herramientas_generales = cursor.fetchall()
    cursor.close()
    print("herramientas_relacion:", herramientas_relacion)
    print("herramientas_generales:", herramientas_generales)
    return herramientas_generales

@retry_on_disconnect
def obtener_herramientas_especiales_por_equipo(id_equipo_info):
    # Defensive: if no id provided, return empty list
    if not id_equipo_info:
        return []

    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    # Simpler and direct: return all rows from herramientas_especiales for the given equipo
    # If relationships are required instead, the previous join can be restored.
    query = "SELECT * FROM herramientas_especiales WHERE id_equipo_info = %s ORDER BY id"
    cursor.execute(query, (id_equipo_info,))
    herramientas_especiales = cursor.fetchall()
    cursor.close()
    return herramientas_especiales



@retry_on_disconnect
def obtener_nombre_componente_por_id(componente_id):
    cursor = db.connection.cursor()
    query = "SELECT nombre FROM componentes WHERE id = %s"
    cursor.execute(query, (componente_id,))
    result = cursor.fetchone()  # Obtener el primer resultado

    cursor.close()

    if result:
        return result['nombre']  # Devolver el nombre del componente si se encuentra
    else:
        return None  # Si no se encuentra el componente, devuelve None


@retry_on_disconnect
def obtener_tipos_mantenimiento():
    cursor = db.connection.cursor()
    query = "SELECT id, nombre FROM tipo_mantenimiento"
    cursor.execute(query)
    tipos_mantenimiento = cursor.fetchall()
    cursor.close()

    # Devuelve una lista de diccionarios con los id y nombres de los tipos de mantenimiento
    return [{'id': fila['id'], 'nombre': fila['nombre']} for fila in tipos_mantenimiento]


@retry_on_disconnect
def obtener_tareas_mantenimiento():
    cursor = db.connection.cursor()
    query = "SELECT id, nombre FROM tarea_mantenimiento"
    cursor.execute(query)
    tareas_mantenimiento = cursor.fetchall()
    cursor.close()

    return [{'id': fila['id'], 'nombre': fila['nombre']} for fila in tareas_mantenimiento]


#########################################################################################


#crud repuesto

@retry_on_disconnect
def insertar_repuesto(
        id_equipo_info, nombre_herramienta, valor,
        dibujo_seccion, notas, mtbf, codigo_otan
):
    cursor = db.connection.cursor()
    query = """
        INSERT INTO repuesto (
            id_equipo_info, nombre_repuesto, valor,
            dibujo_transversal, notas, mtbf, codigo_otan
        )
        VALUES (%s, %s, %s, %s, %s, %s, %s)
    """
    cursor.execute(query, (
        id_equipo_info, nombre_herramienta, valor,
        dibujo_seccion, notas, mtbf, codigo_otan
    ))
    db.connection.commit()
    repuesto_id = cursor.lastrowid
    cursor.close()
    return repuesto_id


@retry_on_disconnect
def obtener_repuestos_por_equipo_info(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM repuesto WHERE id_equipo_info = %s"
    cursor.execute(query, (id_equipo_info,))
    repuestos = cursor.fetchall()
    cursor.close()
    return repuestos


@retry_on_disconnect
def actualizar_repuesto(id_repuesto, nombre_repuesto, valor, dibujo_transversal, notas, mtbf, codigo_otan):
    cursor = db.connection.cursor()

    # Construimos la consulta SQL dinámicamente
    query = """
        UPDATE repuesto
        SET nombre_repuesto = %s, valor = %s, notas = %s, mtbf = %s, codigo_otan = %s
    """
    params = [nombre_repuesto, valor, notas, mtbf, codigo_otan]

    if dibujo_transversal is not None:
        query += ", dibujo_transversal = %s"
        params.append(dibujo_transversal)

    query += " WHERE id = %s"
    params.append(id_repuesto)

    cursor.execute(query, params)
    db.connection.commit()
    cursor.close()


# database.py
@retry_on_disconnect
def eliminar_repuesto(id_repuesto):
    cursor = db.connection.cursor()
    query = "DELETE FROM repuesto WHERE id = %s"
    cursor.execute(query, (id_repuesto,))
    db.connection.commit()
    cursor.close()


@retry_on_disconnect
def obtener_repuesto_por_id(id_repuesto):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM repuesto WHERE id = %s"
    cursor.execute(query, (id_repuesto,))
    repuesto = cursor.fetchone()
    cursor.close()
    return repuesto


# database.py

@retry_on_disconnect
def insertar_analisis_herramienta(nombre, valor, id_equipo_info, parte_numero, id_herramienta_requerida,
                                  id_tipo_herramienta, id_clase_herramienta,dibujo_seccion_transversal,cantidad):
    cursor = db.connection.cursor()
    query = """
        INSERT INTO herramientas_generales (
            nombre, valor, id_equipo_info, parte_numero, id_herramienta_requerida, id_tipo_herramienta,id_clase_herramienta,dibujo_seccion_transversal,cantidad

        )
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s,%s)
    """

    cursor.execute(query, (
    nombre, valor, id_equipo_info, parte_numero, id_herramienta_requerida, id_tipo_herramienta, id_clase_herramienta,dibujo_seccion_transversal,cantidad))


    db.connection.commit()
    analisis_id = cursor.lastrowid
    cursor.close()
    return analisis_id


@retry_on_disconnect
def obtener_analisis_herramienta_por_id(id_analisis):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM herramientas_generales WHERE id = %s"
    cursor.execute(query, (id_analisis,))
    analisis = cursor.fetchone()
    cursor.close()
    return analisis


@retry_on_disconnect
def obtener_analisis_herramientas_por_equipo(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM herramientas_generales WHERE id_equipo_info = %s"
    cursor.execute(query, (id_equipo_info,))
    analisis = cursor.fetchall()
    cursor.close()
    return analisis



@retry_on_disconnect
def actualizar_analisis_herramienta(id_analisis, nombre, valor, parte_numero,dibujo_seccion_transversal,cantidad):
    cursor = db.connection.cursor()
    query = """
        UPDATE herramientas_generales
        SET nombre = %s, valor = %s, parte_numero = %s, dibujo_seccion_transversal = %s,cantidad = %s
        WHERE id = %s
    """
    cursor.execute(query, (nombre, valor, parte_numero,dibujo_seccion_transversal,cantidad, id_analisis))



    db.connection.commit()
    cursor.close()


@retry_on_disconnect
def eliminar_analisis_herramienta(id_analisis):
    cursor = db.connection.cursor()
    query = "DELETE FROM herramientas_generales WHERE id = %s"
    cursor.execute(query, (id_analisis,))
    db.connection.commit()
    cursor.close()


@retry_on_disconnect
def obtener_herramientas_por_equipo(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    
    # Obtener herramientas relacionadas con el equipo
    query = """
        SELECT hr.id_clase_herramienta, hr.id_herramienta 
        FROM herramientas_relacion hr 
        WHERE hr.id_equipo_info = %s
    """
    cursor.execute(query, (id_equipo_info,))
    relaciones = cursor.fetchall()
    
    herramientas = []
    
    for relacion in relaciones:
        id_clase_herramienta = relacion['id_clase_herramienta']
        id_herramienta = relacion['id_herramienta']
        
        if id_clase_herramienta == 1:
            # Buscar en herramientas_generales
            query_general = "SELECT * FROM herramientas_generales WHERE id = %s"
            cursor.execute(query_general, (id_herramienta,))
            herramienta = cursor.fetchone()
            if herramienta:
                herramienta['tipo'] = 'general'
                herramientas.append(herramienta)
        
        elif id_clase_herramienta == 2:
            # Buscar en herramientas_especiales
            query_especial = "SELECT * FROM herramientas_especiales WHERE id = %s"
            cursor.execute(query_especial, (id_herramienta,))
            herramienta = cursor.fetchone()
            if herramienta:
                herramienta['tipo'] = 'especial'
                herramientas.append(herramienta)
    
    cursor.close()
    return herramientas




#Herramientas especiales:


@retry_on_disconnect
def insertar_herramienta_especial(
        parte_numero, nombre_herramienta, valor,
        dibujo_seccion_transversal, nota, id_equipo_info,
        manual_referencia, id_tipo_herramienta, cantidad,
        id_herramienta_requerida, id_clase_herramienta  # Aseguramos que se recibe este parámetro

):
    cursor = db.connection.cursor()
    query = """
        INSERT INTO herramientas_especiales (
            parte_numero, nombre_herramienta, valor,
            dibujo_seccion_transversal, nota, id_equipo_info,
            manual_referencia, id_tipo_herramienta, cantidad, id_herramienta_requerida,id_clase_herramienta
        )
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s)
    """
    cursor.execute(query, (
        parte_numero, nombre_herramienta, valor,
        dibujo_seccion_transversal, nota, id_equipo_info,
        manual_referencia, id_tipo_herramienta, cantidad, id_herramienta_requerida, id_clase_herramienta
    ))
    db.connection.commit()
    herramienta_id = cursor.lastrowid
    cursor.close()
    return herramienta_id


@retry_on_disconnect
def obtener_herramienta_especial_por_id(id_herramienta):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM herramientas_especiales WHERE id = %s"
    cursor.execute(query, (id_herramienta,))
    herramienta = cursor.fetchone()
    cursor.close()
    return herramienta


@retry_on_disconnect
def actualizar_herramienta_especial(
        id_herramienta, parte_numero, nombre_herramienta, valor,
        dibujo_seccion_transversal, nota, manual_referencia, id_tipo_herramienta, cantidad
):
    cursor = db.connection.cursor()
    query = """
        UPDATE herramientas_especiales
        SET parte_numero = %s, nombre_herramienta = %s, valor = %s,
            dibujo_seccion_transversal = %s, nota = %s,
            manual_referencia = %s, id_tipo_herramienta = %s, cantidad = %s
        WHERE id = %s
    """
    cursor.execute(query, (
        parte_numero, nombre_herramienta, valor,
        dibujo_seccion_transversal, nota, manual_referencia,
        id_tipo_herramienta, cantidad, id_herramienta
    ))
    db.connection.commit()
    cursor.close()


@retry_on_disconnect
def eliminar_herramienta_especial(id_herramienta):
    cursor = db.connection.cursor()
    query = "DELETE FROM herramientas_especiales WHERE id = %s"
    cursor.execute(query, (id_herramienta,))
    db.connection.commit()
    cursor.close()


@retry_on_disconnect
def insertar_herramienta_requerida(nombre, id_tipo_herramienta, id_clase_herramienta):
    cursor = db.connection.cursor()
    query = """
        INSERT INTO herramientas_requeridas (nombre, id_tipo_herramienta,id_clase_herramienta)
        VALUES (%s, %s, %s)
    """
    cursor.execute(query, (nombre, id_tipo_herramienta, id_clase_herramienta))
    db.connection.commit()
    herramienta_requerida_id = cursor.lastrowid
    cursor.close()
    return herramienta_requerida_id


@retry_on_disconnect
def obtener_tipos_herramientas():
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT id_tipo_herramienta, nombre_tipo FROM tipo_herramientas ORDER BY nombre_tipo"
    cursor.execute(query)
    tipos = cursor.fetchall()
    cursor.close()
    return tipos


############################RCMMMMM
@retry_on_disconnect
def obtener_rcm_por_fmea(id_fmea):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = """
        SELECT
            r.id,
            r.id_fmea,
            s.nombre as sistema, 
            ff.nombre as falla_funcional, 
            c.nombre as componente, 
            cmf.nombre as codigo_modo_falla, 
            cf.nombre as consecutivo_modo_falla, 
            dmf.nombre as descripcion_modo_falla, 
            causa.nombre as causa, 
            r.hidden_failures,
            r.safety,
            r.environment,
            r.operation,
            r.h1_s1_n1_o1,
            r.h2_s2_n2_o2,
            r.h3_s3_n3_o3,
            r.h4_s4,
            r.h5,
            r.tarea,
            r.id_accion_recomendada,
            r.intervalo_inicial_horas,
            r.patron_de_falla,
            r.tarea_contemplada,
            r.fuente
        FROM rcm r
        LEFT JOIN fmea f ON r.id_fmea = f.id
        LEFT JOIN sistema s ON f.id_sistema = s.id
        LEFT JOIN falla_funcional ff ON f.id_falla_funcional = ff.id
        LEFT JOIN componentes c ON f.id_componente = c.id
        LEFT JOIN codigo_modo_falla cmf ON f.id_codigo_modo_falla = cmf.id
        LEFT JOIN consecutivo_modo_falla cf ON f.id_consecutivo_modo_falla = cf.id
        LEFT JOIN descripcion_modo_falla dmf ON f.id_descripcion_modo_falla = dmf.id
        LEFT JOIN causa ON f.id_causa = causa.id
        WHERE r.id_fmea = %s AND r.estado = 'activo'
    """
    cursor.execute(query, (id_fmea,))
    rcm = cursor.fetchone()
    
    # Convertir JSON a objeto Python
    if rcm and rcm['patron_de_falla']:
        rcm['patron_de_falla'] = json.loads(rcm['patron_de_falla'])

    cursor.close()
    return rcm

@retry_on_disconnect
def obtener_rcm_por_id(id_rcm):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = """
        SELECT
            r.id,
            r.id_fmea,
            s.nombre as sistema, 
            ff.nombre as falla_funcional, 
            c.nombre as componente, 
            cmf.nombre as codigo_modo_falla, 
            cf.nombre as consecutivo_modo_falla, 
            dmf.nombre as descripcion_modo_falla, 
            causa.nombre as causa, 
            r.hidden_failures,
            r.safety,
            r.environment,
            r.operation,
            r.h1_s1_n1_o1,
            r.h2_s2_n2_o2,
            r.h3_s3_n3_o3,
            r.h4_s4,
            r.h5,
            r.tarea,
            r.id_accion_recomendada,
            r.intervalo_inicial_horas
        FROM rcm r
        LEFT JOIN fmea f ON r.id_fmea = f.id
        LEFT JOIN sistema s ON f.id_sistema = s.id
        LEFT JOIN falla_funcional ff ON f.id_falla_funcional = ff.id
        LEFT JOIN componentes c ON f.id_componente = c.id
        LEFT JOIN codigo_modo_falla cmf ON f.id_codigo_modo_falla = cmf.id
        LEFT JOIN consecutivo_modo_falla cf ON f.id_consecutivo_modo_falla = cf.id
        LEFT JOIN descripcion_modo_falla dmf ON f.id_descripcion_modo_falla = dmf.id
        LEFT JOIN causa ON f.id_causa = causa.id
        WHERE r.id = %s AND r.estado = 'activo'
    """
    cursor.execute(query, (id_rcm,))
    rcm = cursor.fetchone()
    cursor.close()
    return rcm


@retry_on_disconnect
def obtener_rcms_completos():
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = """
        SELECT
            r.id,
            r.id_fmea,
            f.id_equipo_info,
            s.nombre as sistema, 
            ff.nombre as falla_funcional, 
            c.nombre as componente, 
            cmf.nombre as codigo_modo_falla, 
            cf.nombre as consecutivo_modo_falla, 
            dmf.nombre as descripcion_modo_falla, 
            causa.nombre as causa, 
            r.hidden_failures,
            r.safety,
            r.environment,
            r.operation,
            r.h1_s1_n1_o1,
            r.h2_s2_n2_o2,
            r.h3_s3_n3_o3,
            r.h4_s4,
            r.h5,
            r.tarea,
            r.id_accion_recomendada,
            r.intervalo_inicial_horas
        FROM rcm r
        LEFT JOIN fmea f ON r.id_fmea = f.id
        LEFT JOIN sistema s ON f.id_sistema = s.id
        LEFT JOIN falla_funcional ff ON f.id_falla_funcional = ff.id
        LEFT JOIN componentes c ON f.id_componente = c.id
        LEFT JOIN codigo_modo_falla cmf ON f.id_codigo_modo_falla = cmf.id
        LEFT JOIN consecutivo_modo_falla cf ON f.id_consecutivo_modo_falla = cf.id
        LEFT JOIN descripcion_modo_falla dmf ON f.id_descripcion_modo_falla = dmf.id
        LEFT JOIN causa ON f.id_causa = causa.id
        WHERE r.estado = 'activo'
    """
    cursor.execute(query)
    rcms_completos = cursor.fetchall()
    cursor.close()
    return rcms_completos


@retry_on_disconnect
def obtener_fmeas_con_rcm():
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT id_fmea FROM rcm WHERE estado = 'activo'"
    cursor.execute(query)
    fmeas_con_rcm = cursor.fetchall()
    cursor.close()

    # Extraer solo los id_fmea de los resultados
    id_fmeas = [fmea['id_fmea'] for fmea in fmeas_con_rcm]
    return id_fmeas


@retry_on_disconnect
def eliminar_rcm(id_fmea,id_rcm):
    cursor = db.connection.cursor()
    # Cambiar el estado a 'inactivo' en lugar de eliminar
    query = "UPDATE rcm SET estado = 'inactivo' WHERE id_fmea = %s AND id = %s"
    cursor.execute(query, (id_fmea,id_rcm))
    db.connection.commit()
    cursor.close()
"""
cursor = db.connection.cursor()
    # Cambiar el estado a 'inactivo' en lugar de eliminar
    update_query = "UPDATE rcm SET estado = 'inactivo' WHERE id = %s"
    cursor.execute(update_query, (id_rcm,))
    db.connection.commit()
    cursor.close()

"""

@retry_on_disconnect
def actualizar_rcm(rcm):
    cursor = db.connection.cursor()
    
    # Convertir a JSON válido (si viene una imagen en Base64)
    rcm['patron_de_falla'] = json.dumps(rcm.get('patron_de_falla', {})) if rcm.get('patron_de_falla') else None

    query = """
        UPDATE rcm
        SET hidden_failures = %s, safety = %s, environment = %s, operation = %s, 
            h1_s1_n1_o1 = %s, h2_s2_n2_o2 = %s, h3_s3_n3_o3 = %s, h4_s4 = %s, h5 = %s, 
            tarea = %s, intervalo_inicial_horas = %s, id_accion_recomendada = %s, 
            patron_de_falla = %s, tarea_contemplada = %s, fuente = %s
        WHERE id_fmea = %s
    """
    
    cursor.execute(query, (
        rcm['hidden_failures'], rcm['safety'], rcm['environment'], rcm['operation'], 
        rcm['h1_s1_n1_o1'], rcm['h2_s2_n2_o2'], rcm['h3_s3_n3_o3'], rcm['h4_s4'], 
        rcm['h5'], rcm['tarea'], rcm['intervalo_inicial_horas'], rcm['id_accion_recomendada'],
        rcm['patron_de_falla'], rcm['tarea_contemplada'], rcm['fuente'], rcm['id_fmea']
    ))
    
    db.connection.commit()
    cursor.close()



@retry_on_disconnect
def obtener_lista_acciones_recomendadas():
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM accion_recomendada"
    cursor.execute(query)
    accion_recomendada = cursor.fetchall()
    cursor.close()
    print("acciones")
    print(accion_recomendada)
    return accion_recomendada


@retry_on_disconnect
def insertar_rcm(rcm):
    cursor = db.connection.cursor()
    query = """
        INSERT INTO rcm (
            id_fmea, hidden_failures, safety, environment, operation, h1_s1_n1_o1, h2_s2_n2_o2, h3_s3_n3_o3, 
            h4_s4, h5, tarea, intervalo_inicial_horas, id_accion_recomendada, patron_de_falla, tarea_contemplada, fuente
        ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
    """
    cursor.execute(query, (
        rcm['id_fmea'], rcm['hidden_failures'], rcm['safety'], rcm['environment'], rcm['operation'], 
        rcm['h1_s1_n1_o1'], rcm['h2_s2_n2_o2'], rcm['h3_s3_n3_o3'], rcm['h4_s4'], rcm['h5'], rcm['tarea'], 
        rcm['intervalo_inicial_horas'], rcm['id_accion_recomendada'], rcm['patron_de_falla'], 
        rcm['tarea_contemplada'], rcm['fuente']
    ))
    db.connection.commit()
    cursor.close()


#generalidades


# database.py

@retry_on_disconnect
def obtener_equipo_info_por_id(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM equipo_info WHERE id = %s"
    cursor.execute(query, (id_equipo_info,))
    equipo = cursor.fetchone()
    cursor.close()
    return equipo


@retry_on_disconnect
def actualizar_equipo_info(id_equipo_info, data):
    try:
        cursor = db.connection.cursor()

        fields = []
        params = []

        # Campos permitidos para actualización (incluye caracteristicas)
        campos_permitidos = {
            'nombre_equipo': '',
            'fecha': None,
            'fiabilidad_equipo': None,
            'gres_sistema': None,
            'criticidad_equipo': None,
            'marca': '',
            'peso_seco': None,
            'modelo': '',
            'dimensiones': '',
            'descripcion_equipo': '',
            'responsable': '',
            'id_diagrama': None,
            'id_procedimiento': None,
            'sistema': '',
            'equipo': '',
            'id_subsistema': None,
            'cj': '',
            'eqart': '',
            'typbz': '',
            'datsl': None,
            'inbdt': None,
            'baujj': '',
            'baumm': '',
            'gewei': '',
            'ansdt': None,
            'answt': None,
            'waers': '',
            'herst': '',
            'herld': '',
            'mapar': '',
            'serge': '',
            'abckz': '',
            'gewrk': '',
            'tplnr': '',
            'class': '',
            'caracteristicas': None  # Nuevo campo agregado
        }

        for key, default in campos_permitidos.items():
            if key in data:
                valor = data[key]
                if valor in [None, '']:
                    logger.warning(f"Campo {key} es None o vacío. Asignando valor por defecto.")
                    valor = default
                fields.append(f"{mapear_nombre_columna(key)} = %s")
                params.append(valor)

        # Imagen (solo si está presente)
        logger.info(f"📦 imagen_equipo en data: {'imagen_equipo' in data}, tipo: {type(data.get('imagen_equipo'))}")
        if 'imagen_equipo' in data:
            fields.append("imagen = %s")
            params.append(data['imagen_equipo'])

        if not fields:
            logger.info("No se especificaron campos para actualizar.")
            return

        params.append(id_equipo_info)

        query = f"""
            UPDATE equipo_info
            SET {', '.join(fields)}
            WHERE id = %s
        """

        logger.info(f"Consulta SQL generada: {query}")
        logger.info(f"Parámetros de la consulta: {params}")

        cursor.execute(query, params)
        db.connection.commit()
        cursor.close()

    except Exception as e:
        logger.error(f"Error al actualizar equipo_info (ID: {id_equipo_info}): {e}", exc_info=True)
        raise


def mapear_nombre_columna(key):
    """
    Mapea claves del formulario a nombres reales de columnas en la base de datos.
    """
    mapping = {
        'nombre_equipo': 'nombre_equipo',
        'fecha': 'fecha',
        'fiabilidad_equipo': 'fiabilidad_equipo',
        'gres_sistema': 'GRES',
        'criticidad_equipo': 'criticidad_equipo',
        'marca': 'marca',
        'peso_seco': 'peso_seco',
        'modelo': 'modelo',
        'dimensiones': 'dimensiones',
        'descripcion_equipo': 'descripcion',
        'responsable': 'id_personal',
        'id_diagrama': 'id_diagrama',
        'id_procedimiento': 'id_procedimiento',
        'sistema': 'id_sistema',
        'equipo': 'id_equipo',
        'id_subsistema': 'id_subsistema',
    }
    return mapping.get(key, key)


@retry_on_disconnect
def eliminar_equipo_info(id_equipo_info):
    cursor = db.connection.cursor()
    query = "DELETE FROM equipo_info WHERE id = %s"
    cursor.execute(query, (id_equipo_info,))
    db.connection.commit()
    cursor.close()


@retry_on_disconnect
def obtener_diagramas_por_id(id_diagrama):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM diagramas WHERE id = %s"
    cursor.execute(query, (id_diagrama,))
    diagrama = cursor.fetchone()
    cursor.close()
    return diagrama


@retry_on_disconnect
def obtener_responsables():
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT id, nombre_completo FROM personal"
    cursor.execute(query)
    responsables = cursor.fetchall()
    cursor.close()
    return responsables




@retry_on_disconnect
def obtener_personal_por_id(id_personal):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM personal WHERE id = %s"
    cursor.execute(query, (id_personal,))
    responsable = cursor.fetchone()
    cursor.close()
    return responsable


@retry_on_disconnect
def obtener_grupo_constructivo_por_id(id_grupo_constructivo):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM grupo_constructivo WHERE id = %s"
    cursor.execute(query, (id_grupo_constructivo,))
    grupo_constructivo = cursor.fetchone()
    cursor.close()
    return grupo_constructivo




@retry_on_disconnect
def obtener_equipo_por_id(id_equipo):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM equipo_info WHERE id = %s"
    cursor.execute(query, (id_equipo,))
    equipo = cursor.fetchone()
    cursor.close()
    return equipo


@retry_on_disconnect
def obtener_subgrupo_constructivo_por_sistema_id(id_sistema):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    # Obtener id_subgrupo de la tabla sistema
    query_sistema = "SELECT id_subgrupo FROM sistema WHERE id = %s"
    cursor.execute(query_sistema, (id_sistema,))
    sistema = cursor.fetchone()

    if not sistema:
        cursor.close()
        return None  # Si no se encuentra el sistema, retornamos None

    id_subgrupo = sistema['id_subgrupo']

    # Obtener el subgrupo_constructivo de la tabla subgrupo
    query_subgrupo = "SELECT * FROM subgrupo WHERE id = %s"
    cursor.execute(query_subgrupo, (id_subgrupo,))
    subgrupo_constructivo = cursor.fetchone()

    cursor.close()
    return subgrupo_constructivo  # Retornamos el subgrupo constructivo obtenido


@retry_on_disconnect
def obtener_datos_equipo_por_id(id_equipo):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM equipos WHERE id = %s"
    cursor.execute(query, (id_equipo,))
    equipo = cursor.fetchone()
    cursor.close()
    return equipo




# Función para actualizar un análisis funcional existente
@retry_on_disconnect
def actualizar_analisis_funcional(id_analisis_funcional, verbo, accion, estandar_desempeño, id_subsistema):
    cursor = db.connection.cursor()
    query = """
        UPDATE analisis_funcional
        SET verbo = %s, accion = %s, estandar_desempeño = %s, id_subsistema = %s
        WHERE id = %s
    """
    cursor.execute(query, (verbo, accion, estandar_desempeño, id_subsistema, id_analisis_funcional))
    db.connection.commit()
    cursor.close()


# Función para eliminar un análisis funcional
@retry_on_disconnect
def eliminar_analisis_funcional(id_analisis_funcional):
    cursor = db.connection.cursor()
    # Cambiar el estado a 'inactivo' en lugar de eliminar
    query = "UPDATE analisis_funcional SET estado = 'inactivo' WHERE id = %s"
    cursor.execute(query, (id_analisis_funcional,))
    db.connection.commit()
    cursor.close()



@retry_on_disconnect
def obtener_subsistemas_por_equipo_mostrar(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    # Obtener el id_equipo desde equipo_info
    query_equipo = "SELECT id_equipo FROM equipo_info WHERE id = %s"
    cursor.execute(query_equipo, (id_equipo_info,))
    equipo_info = cursor.fetchone()
    if not equipo_info:
        cursor.close()
        return []

    id_equipo = equipo_info['id_equipo']

    # Obtener los subsistemas que pertenecen al id_equipo
    query_subsistemas = "SELECT id, nombre FROM subsistemas WHERE id_equipo = %s"
    cursor.execute(query_subsistemas, (id_equipo,))
    subsistemas = cursor.fetchall()
    cursor.close()
    return subsistemas


@retry_on_disconnect
def obtener_nombre_sistema_por_id(subsistema_id):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    # Si subsistema_id se refiere directamente al sistema
    query = """
    SELECT s.descripcion 
    FROM subsistemas s
    WHERE s.id = %s
    """

    cursor.execute(query, (subsistema_id,))
    resultado = cursor.fetchone()
    cursor.close()

    if resultado:
        return resultado['descripcion']
    else:
        return None


@retry_on_disconnect
def obtener_herramientas_requeridas_por_tipo():
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    dict_herramientas = {}
    tipos = obtener_tipos_herramientas()
    for tipo in tipos:
        query = '''SELECT * FROM herramientas_requeridas hr 
                join tipo_herramientas th on hr.id_tipo_herramienta = th.id_tipo_herramienta 
                WHERE nombre_tipo = %s'''
        cursor.execute(query, (tipo['nombre_tipo'],))
        herramientas = cursor.fetchall()
        dict_herramientas[tipo['nombre_tipo']] = herramientas
    cursor.close()

    return dict_herramientas


@retry_on_disconnect
def insertar_herramientas_requeridas_mta(herramientas_requeridas, id_mta):
    cursor = db.connection.cursor()
    #recorrer la tupla de herramientas requeridas e insertarlas junto al id_mta en la tabla herramientas_mta
    if herramientas_requeridas:
        for herramienta in herramientas_requeridas:
            query = '''INSERT INTO herramientas_mta (id_mta, id_herramienta_requerida) VALUES (%s, %s)'''
            cursor.execute(query, (id_mta, herramienta))
        db.connection.commit()
    cursor.close()


@retry_on_disconnect
def eliminar_herramientas_requeridas_mta(id_mta):
    cursor = db.connection.cursor()
    query = "DELETE FROM herramientas_mta WHERE id_mta = %s"
    cursor.execute(query, (id_mta,))
    db.connection.commit()
    cursor.close()


# obtener_herramientas_mta,
@retry_on_disconnect
def obtener_herramientas_mta():
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = '''SELECT * FROM herramientas_mta hm
            JOIN herramientas_requeridas hr on hm.id_herramienta_requerida = hr.id_herramienta_requerida'''
    cursor.execute(query)
    herramientas_mta = cursor.fetchall()
    cursor.close()
    return herramientas_mta


@retry_on_disconnect
def insertar_repuestos_requeridos_mta(repuestos_requeridos, id_mta):
    cursor = db.connection.cursor()
    #recorrer la tupla de herramientas requeridas e insertarlas junto al id_mta en la tabla herramientas_mta
    if repuestos_requeridos:
        for repuesto in repuestos_requeridos:
            query = '''INSERT INTO repuestos_mta (id_mta, id_repuesto) VALUES (%s, %s)'''
            cursor.execute(query, (id_mta, repuesto))
        db.connection.commit()
    cursor.close()


@retry_on_disconnect
def eliminar_repuestos_requeridos_mta(id_mta):
    cursor = db.connection.cursor()
    query = "DELETE FROM repuestos_mta WHERE id_mta = %s"
    cursor.execute(query, (id_mta,))
    db.connection.commit()
    cursor.close()


#     obtener_repuestos_mta
@retry_on_disconnect
def obtener_repuestos_mta():
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = '''SELECT * FROM repuestos_mta rm
            JOIN repuesto r on rm.id_repuesto = r.id'''
    cursor.execute(query)
    repuestos_mta = cursor.fetchall()
    cursor.close()
    return repuestos_mta


@retry_on_disconnect
def insertar_mta_lora(nivel, actividades, operario, id_mta):
    cursor = db.connection.cursor()
    query = '''INSERT INTO lora_mta (nivel, actividades, operario, id_mta) VALUES (%s, %s, %s, %s)'''
    cursor.execute(query, (nivel, actividades, operario, id_mta))
    db.connection.commit()
    cursor.close()


@retry_on_disconnect
def actualizar_mta_lora(nivel, actividades, operario, id_mta):
    cursor = db.connection.cursor()
    query = '''UPDATE lora_mta SET nivel = %s, actividades = %s, operario = %s WHERE id_mta = %s'''
    cursor.execute(query, (nivel, actividades, operario, id_mta))
    db.connection.commit()
    cursor.close()


@retry_on_disconnect
def eliminar_mta_lora(id_mta):
    cursor = db.connection.cursor()
    query = "DELETE FROM lora_mta WHERE id_mta = %s"
    cursor.execute(query, (id_mta,))
    db.connection.commit()
    cursor.close()


@retry_on_disconnect
def obtener_mta_lora():
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM lora_mta"
    cursor.execute(query)
    lora_mta = cursor.fetchall()
    cursor.close()
    return lora_mta


@retry_on_disconnect
def obtener_max_id_mta():
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT MAX(id) as max_id FROM mta WHERE estado = 'activo'"
    cursor.execute(query)
    max_id = cursor.fetchone()
    cursor.close()
    print(max_id['max_id'])
    return max_id['max_id']


@retry_on_disconnect
def obtener_rcms_con_mta():
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT id_rcm FROM mta WHERE estado = 'activo'"
    cursor.execute(query)
    rcms_con_mta = cursor.fetchall()
    cursor.close()

    # Extraer solo los id_fmea de los resultados
    id_rcms = [mta['id_rcm'] for mta in rcms_con_mta]
    return id_rcms


@retry_on_disconnect
def obtener_lora_mta_por_id_mta(id_mta):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM lora_mta WHERE id_mta = %s"
    cursor.execute(query, (id_mta,))
    lora_mta = cursor.fetchone()
    cursor.close()
    return lora_mta


@retry_on_disconnect
def obtener_herramientas_mta_por_id_mta(id_mta):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = '''SELECT * FROM herramientas_mta hm
            JOIN herramientas_requeridas hr on hm.id_herramienta_requerida = hr.id_herramienta_requerida
            WHERE id_mta = %s'''
    cursor.execute(query, (id_mta,))
    herramientas_mta = cursor.fetchall()
    cursor.close()
    return herramientas_mta


@retry_on_disconnect
def obtener_repuestos_mta_por_id_mta(id_mta):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = '''SELECT * FROM repuestos_mta rm
            JOIN repuesto r on rm.id_repuesto = r.id
            WHERE id_mta = %s'''
    cursor.execute(query, (id_mta,))
    repuestos_mta = cursor.fetchall()
    cursor.close()
    return repuestos_mta


# Función para obtener el id_equipo_info basado en nombre_equipo en MySQL
@retry_on_disconnect
def obtener_id_equipo_info_por_nombre(nombre_equipo):
    # Conectar a la base de datos MySQL
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    # Consulta SQL para obtener id_equipo_info basado en nombre_equipo
    query = "SELECT id FROM equipo_info WHERE nombre_equipo = %s"
    cursor.execute(query, (nombre_equipo,))

    # Obtener el primer resultado
    result = cursor.fetchone()

    # Cerrar la conexión
    cursor.close()
    if result:
        return result['id']  # Devuelve el id del equipo
    else:
        return None


# obtener_informacion_equipo_info,
@retry_on_disconnect
def obtener_informacion_equipo_info(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM equipo_info WHERE id = %s"
    cursor.execute(query, (id_equipo_info,))
    equipo_info = cursor.fetchone()
    cursor.close()
    return equipo_info


# database.py


########################################
@retry_on_disconnect
def obtener_ids_herramientas_relacionadas(id_equipo_info, clase_herramienta):
    cursor = db.connection.cursor()
    query = """
        SELECT id_herramienta
        FROM herramientas_equipo_info
        WHERE id_equipo_info = %s AND id_clase_herramienta = %s
    """
    cursor.execute(query, (id_equipo_info, clase_herramienta))
    resultados = cursor.fetchall()
    cursor.close()
    # Extraemos solo los IDs en una lista
    ids_herramientas = [row[0] for row in resultados]
    return ids_herramientas

########################################


@retry_on_disconnect
def actualizar_herramienta_especial(
        id_herramienta, parte_numero, nombre_herramienta, valor,
        dibujo_seccion_transversal, nota, manual_referencia, id_tipo_herramienta, cantidad
):
    cursor = db.connection.cursor()
    query = """
        UPDATE herramientas_especiales
        SET parte_numero = %s, nombre_herramienta = %s, valor = %s,
            dibujo_seccion_transversal = %s, nota = %s,
            manual_referencia = %s, id_tipo_herramienta = %s, cantidad = %s
        WHERE id = %s
    """
    cursor.execute(query, (
        parte_numero, nombre_herramienta, valor,
        dibujo_seccion_transversal, nota, manual_referencia,
        id_tipo_herramienta, cantidad, id_herramienta
    ))
    db.connection.commit()
    cursor.close()


@retry_on_disconnect
def obtener_procedimiento_por_id(id_procedimiento):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM procedimientos WHERE id = %s"
    cursor.execute(query, (id_procedimiento,))
    procedimiento = cursor.fetchone()
    cursor.close()
    return procedimiento


@retry_on_disconnect
def obtener_grupo_constructivo_por_sistema_id(id_sistema):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    # Obtener id_subgrupo de la tabla sistema
    query_sistema = "SELECT id_subgrupo FROM sistema WHERE id = %s"
    cursor.execute(query_sistema, (id_sistema,))
    sistema = cursor.fetchone()

    if not sistema:
        cursor.close()
        return None  # Si no se encuentra el sistema, retornamos None

    id_subgrupo = sistema['id_subgrupo']

    # Obtener id_grupo_constructivo de la tabla subgrupo
    query_subgrupo = "SELECT id_grupo_constructivo FROM subgrupo WHERE id = %s"
    cursor.execute(query_subgrupo, (id_subgrupo,))
    subgrupo = cursor.fetchone()

    if not subgrupo:
        cursor.close()
        return None  # Si no se encuentra el subgrupo, retornamos None

    id_grupo_constructivo = subgrupo['id_grupo_constructivo']

    # Obtener el grupo_constructivo de la tabla grupo_constructivo
    query_grupo = "SELECT * FROM grupo_constructivo WHERE id = %s"
    cursor.execute(query_grupo, (id_grupo_constructivo,))
    grupo_constructivo = cursor.fetchone()

    cursor.close()
    return grupo_constructivo  # Retornamos el grupo constructivo obtenido


@retry_on_disconnect
def obtener_tipo_equipo_por_id(id_tipos_equipos):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT * FROM tipo_equipos WHERE id = %s"
    cursor.execute(query, (id_tipos_equipos,))
    tipo_equipo = cursor.fetchone()
    cursor.close()
    return tipo_equipo



# Función para obtener todos los análisis funcionales de un equipo específico
@retry_on_disconnect
def obtener_analisis_funcionales_por_equipo_info(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    query = """
    SELECT af.id, af.verbo, af.accion, af.estandar_desempeño, ss.descripcion AS subsistema_nombre
    FROM analisis_funcional af
    JOIN subsistemas ss ON af.id_subsistema = ss.id
    WHERE af.id_equipo_info = %s AND af.estado = 'activo'
    """

    query2 = """
        SELECT cf.id, cf.id_componente, c.nombre, cf.verbo, cf.accion, cf.id_analisis_funcional 
        FROM componente_analisis_funcional cf
        JOIN analisis_funcional af ON af.id = cf.id_analisis_funcional
        JOIN componentes c ON c.id = cf.id_componente
        WHERE af.id_equipo_info = %s AND af.estado = 'activo';
    """


    cursor.execute(query, (id_equipo_info,))
    analisis_funcionales = cursor.fetchall()
    
    cursor.execute(query2, (id_equipo_info,))
    componentes_analisis_funcionales = cursor.fetchall()

    cursor.close()

    return analisis_funcionales, componentes_analisis_funcionales


# Función para obtener un análisis funcional por su ID
@retry_on_disconnect
def obtener_analisis_funcional_por_id(id_analisis_funcional):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = """
        SELECT af.*
        FROM analisis_funcional af
        WHERE af.id = %s AND af.estado = 'activo'
    """

    query2="""SELECT cf.id, cf.id_componente, c.nombre, cf.verbo, cf.accion, cf.id_analisis_funcional
        FROM componente_analisis_funcional cf
        JOIN analisis_funcional af ON cf.id_analisis_funcional = af.id
        JOIN componentes c ON c.id = cf.id_componente
        WHERE af.id = %s AND af.estado = 'activo';
    """

    cursor.execute(query, (id_analisis_funcional,))
    analisis_funcional = cursor.fetchone()

    cursor.execute(query2, (id_analisis_funcional,))
    componentes_analisis_funcionales = cursor.fetchall()

    cursor.close()
    return analisis_funcional, componentes_analisis_funcionales


# Función para actualizar un análisis funcional existente
@retry_on_disconnect
def actualizar_analisis_funcional(id_analisis_funcional, verbo, accion, estandar_desempeño, id_subsistema, componentes):
    cursor = db.connection.cursor()
    
    # Actualizar el análisis funcional principal
    query = """
        UPDATE analisis_funcional
        SET verbo = %s, accion = %s, estandar_desempeño = %s, id_subsistema = %s
        WHERE id = %s
    """
    cursor.execute(query, (verbo, accion, estandar_desempeño, id_subsistema, id_analisis_funcional))

    # Eliminar los componentes existentes
    query_delete = "DELETE FROM componente_analisis_funcional WHERE id_analisis_funcional = %s"
    cursor.execute(query_delete, (id_analisis_funcional,))

    # Insertar componentes actualizados
    for componente in componentes:
        id_componente = componente['id_']
        verbo_componente = componente['verbo'] if componente['verbo'] else None
        accion_componente = componente['accion'] if componente['accion'] else None

        # Insertar solo si el ID del componente es válido
        if id_componente:
            query_componente = """
                INSERT INTO componente_analisis_funcional (id_componente, verbo, accion, id_analisis_funcional)
                VALUES (%s, %s, %s, %s)
            """
            cursor.execute(query_componente, (id_componente, verbo_componente, accion_componente, id_analisis_funcional))

    # Confirmar cambios en la base de datos
    db.connection.commit()
    cursor.close()

# obtener_fmeas_por_equipo_info,
@retry_on_disconnect
def obtener_fmeas_por_equipo_info(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = """
    SELECT 
        f.id, 
        f.id_equipo_info, 
        f.id_sistema, 
        s.nombre AS sistema, 
        f.id_falla_funcional, 
        ff.nombre AS falla_funcional, 
        f.id_componente, 
        c.nombre AS componente, 
        f.id_codigo_modo_falla, 
        cmf.nombre AS codigo_modo_falla, 
        f.id_consecutivo_modo_falla, 
        cf.nombre AS consecutivo_modo_falla, 
        f.id_descripcion_modo_falla, 
        dmf.nombre AS descripcion_modo_falla, 
        f.id_causa, 
        causa.nombre AS causa, 
        f.id_mecanismo_falla, 
        mf.nombre AS mecanismo_falla, 
        f.id_detalle_falla, 
        df.nombre AS detalle_falla, 
        f.MTBF, 
        f.MTTR, 
        f.id_metodo_deteccion_falla,
        f.id_fallo_oculto,
        fo.valor AS fallo_oculto_valor, 
        fo.nombre AS fallo_oculto_descripcion, 
        f.id_seguridad_fisica, 
        sf.valor AS seguridad_fisica_valor, 
        sf.nombre AS seguridad_fisica_descripcion, 
        f.id_medio_ambiente, 
        ma.valor AS medio_ambiente_valor, 
        ma.nombre AS medio_ambiente_descripcion, 
        f.id_impacto_operacional, 
        io.valor AS impacto_operacional_valor, 
        io.nombre AS impacto_operacional_descripcion, 
        f.id_costos_reparacion, 
        cr.valor AS costos_reparacion_valor, 
        cr.nombre AS costos_reparacion_descripcion, 
        f.id_flexibilidad_operacional, 
        flex.valor AS flexibilidad_operacional_valor, 
        flex.nombre AS flexibilidad_operacional_descripcion, 
        f.calculo_severidad,
        f.id_ocurrencia, 
        o.valor AS ocurrencia_valor, 
        o.nombre AS ocurrencia_descripcion, 
        f.ocurrencia_mate, 
        f.id_probabilidad_deteccion, 
        pd.valor AS probabilidad_deteccion_valor, 
        pd.descripcion AS probabilidad_deteccion_descripcion,
        f.RPN,
        f.id_riesgo,
        r.nombre AS nombre_riesgo,
        f.no_funcion,
        f.funcion_activo,
        f.descripcion_falla_funcional,
        f.ref_elemento_tag,
        f.funcion_item_componente,
        f.no_modo_falla,
        f.no_efecto_falla,
        f.efecto_falla,
        f.observaciones,
        p.nombre_completo AS nombre_completo,
        p.id AS id_personal
    FROM fmea f
    LEFT JOIN equipo_info ei ON f.id_equipo_info = ei.id
    LEFT JOIN personal p ON ei.id_personal = p.id
    LEFT JOIN subsistemas_LSA s ON f.id_sistema = s.id
    LEFT JOIN falla_funcional ff ON f.id_falla_funcional = ff.id
    LEFT JOIN componentes c ON f.id_componente = c.id
    LEFT JOIN codigo_modo_falla cmf ON f.id_codigo_modo_falla = cmf.id
    LEFT JOIN consecutivo_modo_falla cf ON f.id_consecutivo_modo_falla = cf.id
    LEFT JOIN descripcion_modo_falla dmf ON f.id_descripcion_modo_falla = dmf.id
    LEFT JOIN causa ON f.id_causa = causa.id
    LEFT JOIN mecanismo_falla mf ON f.id_mecanismo_falla = mf.id
    LEFT JOIN detalle_falla df ON f.id_detalle_falla = df.id
    LEFT JOIN fallo_oculto fo ON f.id_fallo_oculto = fo.id
    LEFT JOIN seguridad_fisica sf ON f.id_seguridad_fisica = sf.id
    LEFT JOIN medio_ambiente ma ON f.id_medio_ambiente = ma.id
    LEFT JOIN impacto_operacional io ON f.id_impacto_operacional = io.id
    LEFT JOIN costos_reparacion cr ON f.id_costos_reparacion = cr.id
    LEFT JOIN flexibilidad_operacional flex ON f.id_flexibilidad_operacional = flex.id
    LEFT JOIN ocurrencia o ON f.id_ocurrencia = o.id
    LEFT JOIN probabilidad_deteccion pd ON f.id_probabilidad_deteccion = pd.id
    LEFT JOIN riesgo r ON f.id_riesgo = r.id
    WHERE f.id_equipo_info = %s
    """
    cursor.execute(query, (id_equipo_info,))
    fmeas = cursor.fetchall()
    cursor.close()
    logger.info(fmeas)
    return fmeas


import json

@retry_on_disconnect
def obtener_rcm_por_equipo_info(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    query = """
        SELECT
            r.id,
            r.id_fmea,
            f.id_equipo_info,
            f.no_funcion,          
            f.no_modo_falla,       
            f.no_efecto_falla,     
            f.calculo_severidad,
            o.valor AS ocurrencia_valor,
            pd.valor AS probabilidad_deteccion,
            f.rpn,
            rsk.nombre AS riesgo,
            sis.nombre AS sistema, 
            ff.nombre AS falla_funcional, 
            c.nombre AS componente, 
            cmf.nombre AS codigo_modo_falla, 
            cf.nombre AS consecutivo_modo_falla, 
            dmf.nombre AS descripcion_modo_falla, 
            causa.nombre AS causa, 
            r.hidden_failures,
            r.safety,
            r.environment,
            r.operation,
            r.h1_s1_n1_o1,
            r.h2_s2_n2_o2,
            r.h3_s3_n3_o3,
            r.h4_s4,
            r.h5,
            r.tarea,
            l.actividades,  
            ar.nombre AS accion_recomendada,
            r.intervalo_inicial_horas,
            r.patron_de_falla,
            r.tarea_contemplada,
            r.fuente
        FROM rcm r
        LEFT JOIN fmea f ON r.id_fmea = f.id
        LEFT JOIN subsistemas s ON f.id_sistema = s.id
        LEFT JOIN sistema sis ON s.sistema_id = sis.id  -- ✅ NUEVO JOIN CORRECTO
        LEFT JOIN falla_funcional ff ON f.id_falla_funcional = ff.id
        LEFT JOIN componentes c ON f.id_componente = c.id
        LEFT JOIN codigo_modo_falla cmf ON f.id_codigo_modo_falla = cmf.id
        LEFT JOIN consecutivo_modo_falla cf ON f.id_consecutivo_modo_falla = cf.id
        LEFT JOIN descripcion_modo_falla dmf ON f.id_descripcion_modo_falla = dmf.id
        LEFT JOIN causa ON f.id_causa = causa.id
        LEFT JOIN accion_recomendada ar ON r.id_accion_recomendada = ar.id 
        LEFT JOIN probabilidad_deteccion pd ON f.id_probabilidad_deteccion = pd.id 
        LEFT JOIN riesgo rsk ON f.id_riesgo = rsk.id 
        LEFT JOIN mta m ON r.id = m.id_rcm  
        LEFT JOIN lora_mta l ON m.id = l.id_mta
        LEFT JOIN ocurrencia o ON f.id_ocurrencia = o.id
        WHERE f.id_equipo_info = %s 
        AND r.estado = 'activo';
    """

    cursor.execute(query, (id_equipo_info,))
    rcms = cursor.fetchall()

    for rcm in rcms:
        if rcm['patron_de_falla']:
            try:
                rcm['patron_de_falla'] = json.loads(rcm['patron_de_falla'])
            except json.JSONDecodeError:
                rcm['patron_de_falla'] = None

    cursor.close()
    return rcms


# obtener_mta_por_equipo_info
@retry_on_disconnect
def obtener_mta_por_equipo_info(id_equipo_info):

    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = """
        SELECT 
            m.id, 
            m.id_rcm, 
            m.id_equipo_info, 
            m.id_sistema, 
            m.id_componente, 
            m.id_falla_funcional, 
            m.id_descripcion_modo_falla, 
            m.id_tipo_mantenimiento, 
            m.id_tarea_mantenimiento, 
            m.cantidad_personal, 
            m.consumibles_requeridos, 
            m.requeridos_tarea, 
            m.condiciones_ambientales, 
            m.condiciones_estado_equipo, 
            m.condiciones_especiales, 
            m.horas, 
            m.minutos, 
            m.detalle_tarea,
            ei.nombre_equipo as equipo, 
            s.nombre as sistema, 
            c.nombre as componente, 
            ff.nombre as falla_funcional, 
            dmf.nombre as descripcion_modo_falla, 
            tm.nombre as tipo_mantenimiento, 
            tmr.nombre as tarea_mantenimiento,
            l.nivel,
            l.actividades,
            l.operario        
        FROM mta m
        LEFT JOIN rcm r ON m.id_rcm = r.id
        LEFT JOIN equipo_info ei ON m.id_equipo_info = ei.id
        LEFT JOIN sistema s ON m.id_sistema = s.id
        LEFT JOIN componentes c ON m.id_componente = c.id
        LEFT JOIN falla_funcional ff ON m.id_falla_funcional = ff.id
        LEFT JOIN descripcion_modo_falla dmf ON m.id_descripcion_modo_falla = dmf.id
        LEFT JOIN tipo_mantenimiento tm ON m.id_tipo_mantenimiento = tm.id
        LEFT JOIN tarea_mantenimiento tmr ON m.id_tarea_mantenimiento = tmr.id
        LEFT JOIN lora_mta l ON m.id = l.id_mta
        WHERE m.id_equipo_info = %s AND m.estado = 'activo'
        """
    cursor.execute(query, (id_equipo_info,))
    mta = cursor.fetchall()
    cursor.close()

    return mta



@retry_on_disconnect
def crear_personal(nombre_completo):
    correo = 'correo1@example.com'
    password = 'password1'
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    sql = "INSERT INTO personal (correo, password, nombre_completo) VALUES (%s, %s, %s)"
    cursor.execute(sql, (correo, password, nombre_completo))
    db.connection.commit()
    new_id = cursor.lastrowid
    cursor.close()
    return new_id

@retry_on_disconnect
def obtener_fmeas_con_rcm_por_equipo_info(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = """
        SELECT f.id
        FROM rcm r
        LEFT JOIN fmea f ON r.id_fmea = f.id
        WHERE f.id_equipo_info = %s AND r.estado = 'activo'
    """
    cursor.execute(query, (id_equipo_info,))

    fmeas_con_rcm = cursor.fetchall()
    cursor.close()

    # Extraer solo los id_fmea de los resultados
    id_fmeas = [fmea['id_fmea'] for fmea in fmeas_con_rcm]
    return id_fmeas

@retry_on_disconnect
def obtener_rcms_con_mta_por_equipo_info(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    query = """
        SELECT m.id_rcm
        FROM mta m
        WHERE m.id_equipo_info = %s AND m.estado = 'activo'
    """

    cursor.execute(query, (id_equipo_info,))
    rcms_con_mta = cursor.fetchall()
    cursor.close()

    # Extraer solo los id_rcm de los resultados
    id_rcms = [rcm['id_rcm'] for rcm in rcms_con_mta]
    return id_rcms



###funciones desactivar
@retry_on_disconnect
def desactivar_mta(id_mta):

    cursor = db.connection.cursor()
    # Cambiar el estado a 'inactivo' en lugar de eliminar
    update_query = "UPDATE mta SET estado = 'inactivo' WHERE id = %s"
    cursor.execute(update_query, (id_mta,))
    db.connection.commit()
    cursor.close()

@retry_on_disconnect
def desactivar_rcm(id_fmea,id_rcm):
    cursor = db.connection.cursor()
    # Cambiar el estado a 'inactivo' en lugar de eliminar
    update_query = "UPDATE rcm SET estado = 'inactivo' WHERE id_fmea = %s AND id = %s"
    cursor.execute(update_query, (id_fmea,id_rcm))
    db.connection.commit()
    cursor.close()

"""
@retry_on_disconnect
def eliminar_FMEA(fmea_id):
    cursor = db.connection.cursor()
    # Cambiar el estado a 'inactivo' en lugar de eliminar
    update_query = "UPDATE fmea SET estado = 'inactivo' WHERE id = %s"
    cursor.execute(update_query, (fmea_id,))
    db.connection.commit()
    cursor.close()
"""
@retry_on_disconnect
def desactivar_equipo_info(id_equipo_in):
    cursor = db.connection.cursor()
    # Cambiar el estado a 'inactivo' en lugar de eliminar
    update_query = "UPDATE equipo_info SET estado = 'inactivo' WHERE id = %s"
    cursor.execute(update_query, (id_equipo_in,))

    db.connection.commit()
    cursor.close()


########################################


@retry_on_disconnect
def obtener_subgrupos_por_sistema(id_sistema):

    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    # Obtener el id_subgrupo relacionado con el sistema

    query_sistema = "SELECT id_subgrupo FROM sistema WHERE id = %s"
    cursor.execute(query_sistema, (id_sistema,))
    sistema = cursor.fetchone()

    if not sistema:
        cursor.close()
        return None  # Si el sistema no existe, retornamos None

    id_subgrupo = sistema['id_subgrupo']

    # Obtener información del subgrupo asociado
    query_subgrupo = "SELECT * FROM subgrupo WHERE id = %s"
    cursor.execute(query_subgrupo, (id_subgrupo,))
    subgrupo_constructivo = cursor.fetchall()  # Retornará una lista de subgrupos

    cursor.close()
    return subgrupo_constructivo

@retry_on_disconnect
def obtener_sistemas_por_grupo(grupo_id):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    # Obtener todos los subgrupos que pertenecen al grupo constructivo
    query_subgrupos = "SELECT id FROM subgrupo WHERE id_grupo_constructivo = %s"
    cursor.execute(query_subgrupos, (grupo_id,))
    subgrupos = cursor.fetchall()

    # Extraer los IDs de subgrupo para buscar sistemas asociados
    subgrupo_ids = [subgrupo['id'] for subgrupo in subgrupos]

    if not subgrupo_ids:
        cursor.close()
        return []  # Si no hay subgrupos, retornar lista vacía

    # Obtener sistemas que pertenecen a estos subgrupos
    query_sistemas = "SELECT * FROM sistema WHERE id_subgrupo IN %s"
    cursor.execute(query_sistemas, (tuple(subgrupo_ids),))
    sistemas = cursor.fetchall()

    cursor.close()
    return sistemas

@retry_on_disconnect
def obtener_equipos_por_sistema(sistema_id):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    
    # Consultar equipos relacionados al sistema específico en la tabla equipo_info
    query = """
        SELECT *
        FROM equipo_info
        WHERE id_sistema = %s
    """
    cursor.execute(query, (sistema_id,))
    equipos = cursor.fetchall()
    

    cursor.close()
    return equipos

@retry_on_disconnect
def actualizar_procedimiento(id_procedimiento, arranque, parada):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = '''
        UPDATE procedimientos
        SET arranque = %s,
            parada = %s
        WHERE id = %s
    '''
    cursor.execute(query, (arranque, parada, id_procedimiento))
    db.connection.commit()
    cursor.close()

@retry_on_disconnect
def actualizar_diagrama(id_diagrama, diagrama_flujo_file, diagrama_caja_negra_file, diagrama_caja_transparente_file):

    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    # Leer los archivos si existen
    diagrama_flujo = diagrama_flujo_file.read() if diagrama_flujo_file else None
    diagrama_caja_negra = diagrama_caja_negra_file.read() if diagrama_caja_negra_file else None
    diagrama_caja_transparente = diagrama_caja_transparente_file.read() if diagrama_caja_transparente_file else None

    # Preparar los campos y valores para la consulta de actualización
    campos = []
    valores = []

    if diagrama_flujo is not None:
        campos.append('diagrama_flujo = %s')
        valores.append(diagrama_flujo)
    if diagrama_caja_negra is not None:
        campos.append('diagrama_caja_negra = %s')
        valores.append(diagrama_caja_negra)
    if diagrama_caja_transparente is not None:
        campos.append('diagrama_caja_transparente = %s')
        valores.append(diagrama_caja_transparente)

    # Solo ejecutamos la consulta si hay campos para actualizar
    if campos:
        valores.append(id_diagrama)
        query = 'UPDATE diagramas SET ' + ', '.join(campos) + ' WHERE id = %s'
        cursor.execute(query, valores)
        db.connection.commit()

    cursor.close()

@retry_on_disconnect
def obtener_id_sistema_por_equipo_info(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = """
        SELECT id_sistema 
        FROM equipo_info 
        WHERE id = %s
    """
    cursor.execute(query, (id_equipo_info,))
    fila = cursor.fetchone()
    cursor.close()
    return fila['id_sistema'] if fila else None

@retry_on_disconnect
def obtener_id_equipo_por_equipo_info(id_equipo_info):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    query = """
        SELECT id_equipo 
        FROM equipo_info 
        WHERE id = %s
    """
    cursor.execute(query, (id_equipo_info,))
    fila = cursor.fetchone()

    cursor.close()
    return fila['id_equipo'] if fila else None

@retry_on_disconnect
def check_nombre_equipo_exists(nombre_equipo):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = "SELECT COUNT(*) AS count FROM equipo_info WHERE nombre_equipo = %s AND estado = 'activo'"
    cursor.execute(query, (nombre_equipo,))
    result = cursor.fetchone()
    cursor.close()
    return result['count'] > 0

@retry_on_disconnect
def eliminar_personal(id_personal):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    try:
        # Primero, eliminar registros en equipo_info que referencian al personal
        sql_equipo_info = "UPDATE equipo_info SET id_personal = NULL WHERE id_personal = %s"
        cursor.execute(sql_equipo_info, (id_personal,))

        # Ahora, eliminar el registro en personal
        sql = "DELETE FROM personal WHERE id = %s"
        cursor.execute(sql, (id_personal,))

        db.connection.commit()
    except MySQLdb.IntegrityError as e:
        print(f"Error al eliminar personal: {e}")
        # Opcionalmente, puedes manejar la excepción según tus necesidades
        # Por ejemplo, devolver un mensaje de error o lanzar una excepción personalizada
        raise
    finally:
        cursor.close()

@retry_on_disconnect
def obtener_equipos_por_buque_y_sistema(id_buque, id_sistema_ils):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = """
        SELECT * FROM equipo_info 
        WHERE id_buque = %s AND id_sistema_ils = %s
    """
    cursor.execute(query, (id_buque, id_sistema_ils))
    equipos = cursor.fetchall()
    cursor.close()
    return equipos

@retry_on_disconnect
def obtener_equipos_por_buque(id_buque, contexto):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    if contexto == "edicion":
        query = """
            SELECT 
                nombre_equipo,
                marca,
                modelo,
                descripcion,
                id_subsistema,
                imagen,
                dimensiones,
                peso_seco
            FROM equipo_info
            WHERE id_buque = %s
        """
    else:  # caso por defecto: fua u otros
        query = """
            SELECT id, nombre_equipo, id_sistema_ils, AOR
            FROM equipo_info
            WHERE id_buque = %s
        """

    cursor.execute(query, (id_buque,))
    equipos = cursor.fetchall()
    cursor.close()

    # Procesar campo 'imagen' si es bytes
    for equipo in equipos:
        if "imagen" in equipo and isinstance(equipo["imagen"], bytes):
            # puedes comentar la línea que no necesites:
            equipo["imagen"] = base64.b64encode(equipo["imagen"]).decode("utf-8")  # (A) para mostrar inline en frontend
            # equipo["imagen"] = None  # (B) si no vas a usar la imagen en esta vista

    return equipos

@retry_on_disconnect
def obtener_sistema_por_codigo(codigo):
    """Obtiene información de un sistema dado su código."""
    with db.connection.cursor(MySQLdb.cursors.DictCursor) as cursor:
        cursor.execute("SELECT * FROM sistema WHERE numeracion = %s", (codigo,))
        return cursor.fetchone()

@retry_on_disconnect
def obtener_subgrupo_por_codigo(codigo):
    """Obtiene información del subgrupo relacionado con el código."""
    subgrupo_numeracion = int(str(codigo)[:-1] + '0')  # Cambiar último dígito por 0
    with db.connection.cursor(MySQLdb.cursors.DictCursor) as cursor:
        cursor.execute("SELECT * FROM subgrupo WHERE numeracion = %s", (subgrupo_numeracion,))
        return cursor.fetchone()

@retry_on_disconnect
def obtener_grupo_por_codigo(codigo):
    """Obtiene información del grupo relacionado con el código."""
    grupo_numeracion = int(str(codigo)[0] + '00')  # Cambiar segundo y tercer dígito por 0
    with db.connection.cursor(MySQLdb.cursors.DictCursor) as cursor:
        cursor.execute("SELECT * FROM grupo_constructivo WHERE numeracion = %s", (grupo_numeracion,))
        return cursor.fetchone()

@retry_on_disconnect
def obtener_id_equipo_por_nombre(nombre_equipo, buque_id=None, sistema_id_ils=None):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    # Si tenemos tanto buque_id como sistema_id_ils, filtramos por esos campos
    if buque_id and sistema_id_ils:
        query = """
            SELECT id 
            FROM equipo_info 
            WHERE nombre_equipo = %s AND id_buque = %s AND id_sistema_ils = %s
        """
        cursor.execute(query, (nombre_equipo, buque_id, sistema_id_ils))
    else:
        # Si no tenemos buque_id ni sistema_id_ils, buscamos solo por el nombre
        query = """
            SELECT id 
            FROM equipo_info 
            WHERE nombre_equipo = %s
        """
        cursor.execute(query, (nombre_equipo,))

    fila = cursor.fetchone()
    cursor.close()

    return fila['id'] if fila else None


def guardar_o_actualizar_buque(
    buque_id,
    nombre_buque=None,
    numero_casco=None,
    misiones=None,
    datos_puerto_base=None,
    datos_sap=None,
    # 👇 nuevos
    peso_buque=None,
    unidad_peso=None,
    tamano_dimension_buque=None
):
    cursor = db.connection.cursor()

    # ¿Existe?
    query_select = "SELECT id FROM buques_info WHERE buque_id = %s"
    cursor.execute(query_select, (buque_id,))
    resultado = cursor.fetchone()

    if resultado:
        # UPDATE dinámico
        campos = []
        valores = []

        if nombre_buque is not None:
            campos.append("nombre_buque = %s")
            valores.append(nombre_buque)
        if numero_casco is not None:
            campos.append("numero_casco = %s")
            valores.append(numero_casco)
        if misiones is not None:
            campos.append("misiones = %s")
            valores.append(json.dumps(misiones))
        if datos_puerto_base is not None:
            campos.append("datos_puerto_base = %s")
            valores.append(json.dumps(datos_puerto_base))
        if datos_sap is not None:
            campos.append("datos_sap = %s")
            valores.append(json.dumps(datos_sap))
        # 👇 nuevos campos generales
        if peso_buque is not None:
            campos.append("peso_buque = %s")
            valores.append(peso_buque)
        if unidad_peso is not None:
            campos.append("unidad_peso = %s")
            valores.append(unidad_peso)
        if tamano_dimension_buque is not None:
            campos.append("tamano_dimension_buque = %s")
            valores.append(tamano_dimension_buque)

        if campos:
            query_update = f"""
                UPDATE buques_info
                SET {', '.join(campos)}
                WHERE buque_id = %s
            """
            valores.append(buque_id)
            cursor.execute(query_update, tuple(valores))
    else:
        # INSERT
        query_insert = """
            INSERT INTO buques_info
              (buque_id, nombre_buque, numero_casco, misiones, datos_puerto_base, datos_sap,
               peso_buque, unidad_peso, tamano_dimension_buque)
            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
        """
        cursor.execute(query_insert, (
            buque_id,
            nombre_buque or '',
            numero_casco or '',
            json.dumps(misiones or []),
            json.dumps(datos_puerto_base or {}),
            json.dumps(datos_sap or {}),
            peso_buque,                # puede ser None -> NULL
            unidad_peso,
            tamano_dimension_buque
        ))

    db.connection.commit()
    cursor.close()



@retry_on_disconnect
def obtener_datos_buque(buque_id):
    """
    Obtiene las misiones y datos de puerto base de un buque desde la base de datos.
    """
    cursor = db.connection.cursor()

    try:
        query = "SELECT misiones, datos_puerto_base, numero_casco FROM buques_info WHERE buque_id = %s"
        cursor.execute(query, (buque_id,))
        resultado = cursor.fetchone()
        cursor.close()

        if resultado:
            misiones = resultado.get('misiones')
            datos_puerto_base = resultado.get('datos_puerto_base')
            numero_casco = resultado.get('numero_casco')
            
            try:
                return {
                    "misiones": json.loads(misiones) if misiones else [],
                    "datosPuertoBase": json.loads(datos_puerto_base) if datos_puerto_base else {},
                    "numero_casco": numero_casco
                }
            except json.JSONDecodeError as e:
                logger.error(f"Error al decodificar JSON: {str(e)}")
                return {"misiones": [], "datosPuertoBase": {}}
        return None
    except Exception as e:
        logger.error(f"Error al obtener datos del buque {buque_id}: {str(e)}")
        raise


@retry_on_disconnect
def actualizar_fua_fr_db(equipo_id, AOR, fua_fr_data):
    
    logger.info(f"se esta ejecutando actualizar FUA --> equipo_id: {equipo_id}, fua_fr_data: {fua_fr_data}")

    """
    Actualiza la columna FUA_FR de un equipo específico en la base de datos.

    :param equipo_id: ID del equipo a actualizar.
    :param fua_fr_data: JSON con la información de FUA y FR.
    """
    cursor = db.connection.cursor()

    try:
        query = """
            UPDATE equipo_info
            SET FUA_FR = %s, AOR = %s
            WHERE id = %s
        """
        cursor.execute(query, (fua_fr_data, AOR, equipo_id))
        db.connection.commit()
    except Exception as e:
        logger.error(f"Error al actualizar FUA_FR para equipo {equipo_id}: {str(e)}")
        raise
    finally:
        cursor.close()

@retry_on_disconnect
def obtener_fua_fr_db(equipo_id):
    """
    Obtiene los datos de la columna FUA_FR de un equipo específico.

    :param equipo_id: ID del equipo.
    :return: JSON con la información de FUA y FR.
    """
    cursor = db.connection.cursor()

    try:
        query = """
            SELECT FUA_FR
            FROM equipo_info
            WHERE id = %s
        """
        cursor.execute(query, (equipo_id,))
        resultado = cursor.fetchone()
        cursor.close()

        if resultado:
            fua_fr = resultado.get('FUA_FR')  # Acceder por clave si el resultado es un diccionario
            return fua_fr if fua_fr else None

        return None
    except Exception as e:
        logger.error(f"Error al obtener FUA_FR para equipo {equipo_id}: {str(e)}")
        raise

@retry_on_disconnect
def obtener_nombre_equipo_por_id(id_equipo):
    """
    Obtiene el nombre del equipo a partir de su ID.

    Args:
        id_equipo (int): ID del equipo.

    Returns:
        str: Nombre del equipo si se encuentra, de lo contrario None.
    """
    cursor = db.connection.cursor()
    query = """
    SELECT nombre_equipo 
    FROM equipo_info 
    WHERE id = %s
    """

    cursor.execute(query, (id_equipo,))
    resultado = cursor.fetchone()
    cursor.close()

    if resultado:
        return resultado['nombre_equipo']
    else:
        return None

@retry_on_disconnect
def obtener_equipos_por_buque_fua(buque_id):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = """SELECT id, nombre_equipo, id_sistema_ils, AOR, FUA_FR FROM equipo_info WHERE id_buque = %s"""
    cursor.execute(query, (buque_id,))
    resultados = cursor.fetchall()
    cursor.close()

    # Convertir bytes a string si hace falta
    for equipo in resultados:
        for k, v in equipo.items():
            if isinstance(v, bytes):
                equipo[k] = v.decode()

    return resultados



@retry_on_disconnect
def obtener_nombre_buque_por_id(id_buque):
    cursor = db.connection.cursor()
    query = """
    SELECT nombre_buque 
    FROM buques_info 
    WHERE buque_id = %s
    """

    cursor.execute(query, (id_buque,))
    resultado = cursor.fetchone()
    cursor.close()

    if resultado:
        return resultado['nombre_buque']
    else:
        return None
    

@retry_on_disconnect
def obtener_id_buque_por_nombre(nombre_buque):
    cursor = db.connection.cursor()
    query = """
    SELECT buque_id
    FROM buques_info
    WHERE nombre_buque = %s
    """
    cursor.execute(query, (nombre_buque,))
    resultado = cursor.fetchone()
    cursor.close()

    if resultado:
        return resultado['buque_id']
    else:
        return None


@retry_on_disconnect
def obtener_subsistemas_db(sistema_id):
    cursor = db.connection.cursor()
    cursor.execute("SELECT id, descripcion, numero_de_referencia FROM subsistemas WHERE sistema_id = %s", (sistema_id,))
    subsistemas = [{'id': row['id'], 'descripcion': row['descripcion'], 'numero_de_referencia': row['numero_de_referencia']} for row in cursor.fetchall()]
    return jsonify(subsistemas)


def generar_codigo_jerarquico(id_subsistema, id_buque):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    # Obtener el número de referencia del subsistema
    cursor.execute("SELECT numero_de_referencia FROM subsistemas WHERE id = %s", (id_subsistema,))
    subsistema = cursor.fetchone()
    if not subsistema:
        raise ValueError("Subsistema no encontrado")

    base_cj = subsistema['numero_de_referencia']

    # Contar cuántos equipos ya existen con ese subsistema y buque
    cursor.execute("""
        SELECT COUNT(*) AS total 
        FROM equipo_info 
        WHERE id_subsistema = %s AND id_buque = %s
    """, (id_subsistema, id_buque))
    
    total = cursor.fetchone()['total']

    # Generar el sufijo estilo Excel: 1-9, A-Z, AA, AB, ..., etc.
    def generar_sufijo(n):
        if n < 9:
            return str(n + 1)
        n -= 9
        letras = string.ascii_uppercase
        sufijo = ""
        while True:
            sufijo = letras[n % 26] + sufijo
            n = n // 26 - 1
            if n < 0:
                break
        return sufijo

    sufijo = generar_sufijo(total)

    return f"{base_cj}{sufijo}"

@retry_on_disconnect
def obtener_subsistemas_por_codigo(codigo_sistema):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    query = """
        SELECT 
            ss.id AS id_subsistema,
            ss.descripcion AS nombre_subsistema,
            ss.numero_de_referencia,
            ss.sistema_id,
            s.numeracion AS ref_sistema,
            s.nombre AS nombre_sistema
        FROM subsistemas ss
        JOIN sistema s ON ss.sistema_id = s.id
        WHERE s.numeracion = %s
    """

    cursor.execute(query, (codigo_sistema,))
    subsistemas = cursor.fetchall()
    cursor.close()

    return subsistemas


def obtener_equipos_con_niveles(id_buque):
    conn = db.connection
    cursor = conn.cursor(MySQLdb.cursors.DictCursor)

    query = '''
        SELECT 
            e.id AS equipo_id,
            e.nombre_equipo,
            e.marca,
            e.modelo,
            e.descripcion,
            e.imagen,
            e.dimensiones,
            e.peso_seco,
            e.id_sistema,
            s.numeracion AS ref_sistema,  -- 🔥 Referencia del sistema (para ILS)
            s.id AS id_sistema,
            s.nombre AS nombre_sistema,

            e.id_subsistema,
            ss.numero_de_referencia AS ref_subsistema,
            ss.descripcion AS nombre_subsistema,

            sg.id AS id_subgrupo,
            sg.numeracion AS ref_subgrupo,
            sg.nombre AS nombre_subgrupo,

            g.id AS id_grupo,
            g.numeracion AS ref_grupo,
            g.nombre AS nombre_grupo,

            COUNT(e_sub.id) AS cantidad
        FROM equipo_info e
        JOIN subsistemas ss ON e.id_subsistema = ss.id
        JOIN sistema s ON ss.sistema_id = s.id
        JOIN subgrupo sg ON s.id_subgrupo = sg.id
        JOIN grupo_constructivo g ON sg.id_grupo_constructivo = g.id
        LEFT JOIN equipo_info e_sub ON 
            e_sub.nombre_equipo = e.nombre_equipo 
            AND e_sub.modelo = e.modelo 
            AND e_sub.id_buque = e.id_buque 
            AND e_sub.id_subsistema = ss.id
        WHERE e.id_buque = %s
        GROUP BY 
            e.id, e.nombre_equipo, e.marca, e.modelo, e.descripcion,
            e.imagen, e.dimensiones, e.peso_seco,
            ss.id, ss.numero_de_referencia, ss.descripcion,
            s.id, s.numeracion, s.nombre,
            sg.id, sg.numeracion, sg.nombre,
            g.id, g.numeracion, g.nombre
    '''

    cursor.execute(query, (id_buque,))
    equipos = cursor.fetchall()
    cursor.close()

    for equipo in equipos:
        if "imagen" in equipo and isinstance(equipo["imagen"], bytes):
            equipo["imagen"] = base64.b64encode(equipo["imagen"]).decode("utf-8")

    return equipos


def obtener_subsistemas_por_buque(id_buque):
    conn = db.connection
    cursor = conn.cursor(MySQLdb.cursors.DictCursor)

    query = '''
        SELECT DISTINCT 
            ss.id AS id_subsistema,
            ss.descripcion AS nombre_subsistema,
            ss.numero_de_referencia,
            ss.sistema_id,
            s.numeracion AS ref_sistema,
            s.nombre AS nombre_sistema
        FROM subsistemas ss
        JOIN sistema s ON ss.sistema_id = s.id
        JOIN equipo_info e ON e.id_subsistema = ss.id
        WHERE e.id_buque = %s
    '''

    cursor.execute(query, (id_buque,))
    subsistemas = cursor.fetchall()
    cursor.close()

    return subsistemas


@retry_on_disconnect
def insertar_equipo_info_api(nombre_equipo, fecha, fiabilidad_equipo, GRES, criticidad_equipo,
                              marca, modelo, peso_seco, dimensiones, descripcion, imagen_equipo_file,
                              id_personal, id_diagrama, id_procedimiento, id_sistema, id_sistema_ils,
                              id_buque, cj, id_subsistema):
    logger.info(f"Insertando equipo_info desde API para buque {id_buque}, sistema ILS {id_sistema_ils}")
    try:
        cursor = db.connection.cursor()

        query = """
            INSERT INTO equipo_info (
                nombre_equipo, fecha, fiabilidad_equipo, GRES, criticidad_equipo,
                marca, modelo, peso_seco, dimensiones, descripcion, imagen,
                id_personal, id_diagrama, id_procedimiento, id_sistema,
                id_sistema_ils, id_buque, cj, id_subsistema
            ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """

        valores = (
            nombre_equipo, fecha, fiabilidad_equipo, GRES, criticidad_equipo,
            marca, modelo, peso_seco, dimensiones, descripcion, imagen_equipo_file,
            id_personal, id_diagrama, id_procedimiento, id_sistema,
            id_sistema_ils, id_buque, cj, id_subsistema
        )

        logger.info(f"Valores insertados: {valores}")
        cursor.execute(query, valores)
        db.connection.commit()
        equipo_info_id = cursor.lastrowid
        cursor.close()
        return equipo_info_id

    except Exception as e:
        db.connection.rollback()
        raise Exception(f"Error al insertar equipo_info desde API: {e}")

@retry_on_disconnect
def actualizar_equipos_basicos_db(nombre_equipo, modelo, id_buque,
                                   marca=None, descripcion=None, dimensiones=None,
                                   peso_seco=None, imagen=None):
    try:
        cursor = db.connection.cursor()

        # Construcción dinámica del SET
        campos_actualizar = {
            "marca": marca,
            "descripcion": descripcion,
            "dimensiones": dimensiones,
            "peso_seco": peso_seco,
            "imagen": imagen
        }

        sets = ", ".join([f"{campo} = %s" for campo in campos_actualizar if campos_actualizar[campo] is not None])
        valores = [v for v in campos_actualizar.values() if v is not None]

        if sets:
            query = f"""
                UPDATE equipo_info
                SET {sets}
                WHERE nombre_equipo = %s AND modelo = %s AND id_buque = %s
            """
            cursor.execute(query, (*valores, nombre_equipo, modelo, id_buque))
            db.connection.commit()

        cursor.close()

    except Exception as e:
        db.connection.rollback()
        raise Exception(f"Error al actualizar equipos en DB: {e}")

@retry_on_disconnect
def eliminar_equipos_info(nombre_equipo, modelo, id_buque):
    try:
        cursor = db.connection.cursor()
        cursor.execute("""
            DELETE FROM equipo_info 
            WHERE nombre_equipo = %s AND modelo = %s AND id_buque = %s
        """, (nombre_equipo, modelo, id_buque))
        db.connection.commit()
        cursor.close()
    except Exception as e:
        db.connection.rollback()
        raise Exception(f"Error al eliminar equipo: {e}")

@retry_on_disconnect
def obtener_equipos_resumen_por_buque(buque_id):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    query = """
        SELECT 
            e.id AS id_equipo,
            e.cj,
            e.nombre_equipo,
            g.id AS id_grupo,
            sg.id AS id_subgrupo,
            s.id AS id_sistema,
            ss.id AS id_subsistema,
            ss.numero_de_referencia AS referencia_subistema
        FROM equipo_info e
        JOIN subsistemas ss ON e.id_subsistema = ss.id
        JOIN sistema s ON ss.sistema_id = s.id
        JOIN subgrupo sg ON s.id_subgrupo = sg.id
        JOIN grupo_constructivo g ON sg.id_grupo_constructivo = g.id
        WHERE e.id_buque = %s
    """

    cursor.execute(query, (buque_id,))
    equipos = cursor.fetchall()
    cursor.close()
    return equipos


@retry_on_disconnect
def obtener_equipos_ils_por_buque(buque_id):
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)

    query = """
        SELECT 
            e.id ,   
            e.cj,
            e.id_sistema_ils,
            e.nombre_equipo
        FROM equipo_info e
        WHERE e.id_buque = %s AND e.estado = 'activo'
    """
    cursor.execute(query, (buque_id,))
    equipos = cursor.fetchall()
    cursor.close()

    return equipos


@retry_on_disconnect
def actualizar_valor_gres(equipo_id, gres):
    logger.info(f"Actualizando equipo id={equipo_id} con GRES={gres}")
    cursor = db.connection.cursor()
    query = "UPDATE equipo_info SET GRES = %s WHERE id = %s"  # Usamos la PK real
    cursor.execute(query, (gres, equipo_id))
    db.connection.commit()
    cursor.close()



def obtener_campos_por_clase(clase):
    conn = db.connection
    cursor = conn.cursor()  # ❌ NO usar dictionary=True

    query = """
        SELECT id, caracteristica, denominacion, tipo_campo, ctd_posiciones, decimales, tipo_entrada, unidad_unica
        FROM clases
        WHERE clase = %s
    """

    try:
        cursor.execute(query, (clase,))
        resultados = cursor.fetchall()

        if not resultados:
            print(f"No se encontraron campos para la clase: {clase}")
            return []

        return resultados  # 🚀 Devuelve directamente los datos crudos como los entrega MySQL
    except Exception as e:
        print(f"Error en obtener_campos_por_clase: {e}")
        return []
    finally:
        cursor.close()


def obtener_valores_lista_db(clase_id):
    conn = db.connection
    cursor = conn.cursor()  # ❌ NO usar dictionary=True

    query = """
        SELECT valor 
        FROM clase_valores
        WHERE clase_id = %s
    """

    try:
        cursor.execute(query, (clase_id,))
        resultados = cursor.fetchall()

        if not resultados:
            print(f"No se encontraron valores para la característica: {clase_id}")
            return []

        return resultados  # 🚀 Devolver solo los valores en una lista
    except Exception as e:
        print(f"Error en obtener_valores_lista_db: {e}")
        return []
    finally:
        cursor.close()


def guardar_o_actualizar_diagrama_db(id_equipo_info, tipo, xml, imagen_base64):
    try:
        logger.info(f"[INIT] Guardar diagrama para equipo {id_equipo_info} - tipo: {tipo}")
        logger.info(f"[XML] Longitud XML: {len(xml) if xml else 'NULO'}")
        logger.info(f"[Imagen] Base64 comienza con: {imagen_base64[:30] if imagen_base64 else 'NULO'}")

        if imagen_base64 and imagen_base64.startswith('data:image'):
            header, encoded = imagen_base64.split(',', 1)
            imagen = base64.b64decode(encoded)
            logger.info(f"[Imagen] Imagen decodificada correctamente. Bytes: {len(imagen)}")
        else:
            imagen = None
            logger.warning("[Imagen] Imagen no válida o no enviada")

        columna_img = f"diagrama_{tipo}"
        columna_xml = f"xml_diagrama_{tipo}"
        logger.info(f"[Cols] Usando columnas: {columna_img}, {columna_xml}")

        conn = db.connection
        cursor = conn.cursor()
        cursor.execute("SELECT id_diagrama FROM equipo_info WHERE id = %s", (id_equipo_info,))
        row = cursor.fetchone()
        id_diagrama = row['id_diagrama'] if row else None

        if id_diagrama:
            logger.info(f"[UPDATE] Actualizando diagrama ID {id_diagrama}")
            query = f"UPDATE diagramas SET {columna_img} = %s, {columna_xml} = %s WHERE id = %s"
            cursor.execute(query, (imagen, xml, id_diagrama))
        else:
            logger.info("[INSERT] Insertando nuevo diagrama")
            query = f"INSERT INTO diagramas ({columna_img}, {columna_xml}) VALUES (%s, %s)"
            cursor.execute(query, (imagen, xml))
            id_diagrama = cursor.lastrowid
            cursor.execute("UPDATE equipo_info SET id_diagrama = %s WHERE id = %s", (id_diagrama, id_equipo_info))

        db.connection.commit()
        cursor.close()

        logger.info(f"[SUCCESS] Diagrama guardado con ID: {id_diagrama}")
        return {'success': True, 'id_diagrama': id_diagrama}

    except Exception as e:
        logger.error(f"[ERROR] Error en guardar_o_actualizar_diagrama_db: {e}")
        return {'success': False, 'error': str(e)}


# backend/db_queries.py
@retry_on_disconnect
def obtener_equipos_por_buque_para_excel(id_buque):
    """
    Retorna los equipos del buque con la información necesaria para Excel,
    incluyendo la cadena jerárquica (subsistema -> sistema -> subgrupo -> grupo).
    """
    conn = db.connection
    cursor = conn.cursor(MySQLdb.cursors.DictCursor)

    query = """
        SELECT
            ei.id,
            ei.id_equipo,
            ei.id_subsistema,                               -- ⬅️ clave de arranque de jerarquía
            ei.nombre_equipo,
            ei.marca,
            ei.modelo,
            ei.dimensiones          AS groes,
            ei.fecha,
            ei.eqart,
            ei.typbz,
            ei.datsl,
            ei.inbdt,
            ei.baujj,
            ei.baumm,
            ei.gewei,
            ei.ansdt,
            ei.answt,
            ei.waers,
            ei.herst,
            ei.herld,
            ei.mapar,
            ei.serge,
            ei.abckz,
            ei.gewrk,
            ei.tplnr,
            ei.class,
            ei.caracteristicas,
            ei.peso_seco            AS brgew,

            -- Jerarquía
            ss.id                   AS subsistema_id,
            ss.descripcion          AS subsistema_descripcion,
            ss.numero_de_referencia AS subsistema_num_ref,
            s.id                    AS sistema_id,
            s.nombre                AS sistema_nombre,
            s.numeracion            AS sistema_numeracion,
            sg.id                   AS subgrupo_id,
            sg.nombre               AS subgrupo_nombre,
            sg.numeracion           AS subgrupo_numeracion,
            gc.id                   AS grupo_id,
            gc.nombre               AS grupo_nombre,
            gc.numeracion           AS grupo_numeracion,

            -- Para mapear eqtyp
            e.id                    AS id_equipo_ref,
            te.id                   AS id_tipo_equipo
        FROM equipo_info ei
        LEFT JOIN lsa.subsistemas       ss ON ss.id = ei.id_subsistema
        LEFT JOIN lsa.sistema           s  ON s.id = ss.sistema_id
        LEFT JOIN lsa.subgrupo          sg ON sg.id = s.id_subgrupo
        LEFT JOIN lsa.grupo_constructivo gc ON gc.id = sg.id_grupo_constructivo
        LEFT JOIN equipos               e  ON e.id = ei.id_equipo
        LEFT JOIN tipo_equipos          te ON te.id = e.id_tipos_equipos
        WHERE ei.id_buque = %s
    """
    cursor.execute(query, (id_buque,))
    rows = cursor.fetchall()
    cursor.close()
    return rows

@retry_on_disconnect
def obtener_datos_sap_buque(buque_id: int):
    """
    Retorna datos_sap (JSON con tecnico/logistico/historico) + datos generales:
    numero_casco, nombre_buque, peso_buque, unidad_peso, tamano_dimension_buque.
    """
    conn = db.connection
    cursor = conn.cursor(MySQLdb.cursors.DictCursor)

    try:
        query = """
            SELECT
                datos_sap,
                numero_casco,
                nombre_buque,
                peso_buque,
                unidad_peso,
                tamano_dimension_buque
            FROM buques_info
            WHERE buque_id = %s
            LIMIT 1
        """
        cursor.execute(query, (buque_id,))
        resultado = cursor.fetchone()
        cursor.close()

        if not resultado:
            return None

        datos_sap_raw = resultado.get('datos_sap')
        numero_casco  = resultado.get('numero_casco')
        nombre_buque  = resultado.get('nombre_buque')
        peso_buque    = resultado.get('peso_buque')
        unidad_peso   = resultado.get('unidad_peso')
        tam_dim       = resultado.get('tamano_dimension_buque')

        datos_sap = {}
        if datos_sap_raw:
            try:
                datos_sap = json.loads(datos_sap_raw) if isinstance(datos_sap_raw, str) else (datos_sap_raw or {})
            except json.JSONDecodeError as e:
                logger.error(f"Error al decodificar datos_sap: {e}")

        return {
            "numero_casco": numero_casco or "",
            "nombre_buque": nombre_buque or "",
            "datos_sap": datos_sap or {},
            # 👇 nuevos
            "peso_buque": peso_buque,
            "unidad_peso": unidad_peso,
            "tamano_dimension_buque": tam_dim
        }
    except Exception as e:
        logger.error(f"Error al obtener datos_sap del buque {buque_id}: {str(e)}")
        raise



# ================================
# FUNCIONES PARA MANEJO DE ARCHIVOS CAD
# ================================

@retry_on_disconnect
def obtener_archivo_cad(equipo_id):
    """
    Obtiene la información del archivo CAD de un equipo específico
    """
    cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
    query = """
        SELECT 
            archivo_cad,
            nombre_archivo_cad,
            tipo_archivo_cad,
            tamanio_archivo_cad
        FROM equipo_info 
        WHERE id = %s
    """
    cursor.execute(query, (equipo_id,))
    resultado = cursor.fetchone()
    cursor.close()
    return resultado


@retry_on_disconnect
def guardar_archivo_cad(equipo_id, archivo_blob, nombre_archivo, tipo_archivo, tamanio_archivo):
    """
    Guarda un archivo CAD en la base de datos para un equipo específico
    """
    cursor = db.connection.cursor()
    query = """
        UPDATE equipo_info 
        SET 
            archivo_cad = %s,
            nombre_archivo_cad = %s,
            tipo_archivo_cad = %s,
            tamanio_archivo_cad = %s
        WHERE id = %s
    """
    cursor.execute(query, (archivo_blob, nombre_archivo, tipo_archivo, tamanio_archivo, equipo_id))
    db.connection.commit()
    cursor.close()
    return True


@retry_on_disconnect
@retry_on_disconnect
def eliminar_archivo_cad(equipo_id):
    """
    Elimina el archivo CAD de un equipo específico
    """
    current_app.logger.info(f"eliminar_archivo_cad: Iniciando eliminación para equipo_id={equipo_id}")
    try:
        cursor = db.connection.cursor()
        query = """
            UPDATE equipo_info 
            SET 
                archivo_cad = NULL,
                nombre_archivo_cad = NULL,
                tipo_archivo_cad = NULL,
                tamanio_archivo_cad = NULL
            WHERE id = %s
        """
        current_app.logger.info(f"eliminar_archivo_cad: Ejecutando query para equipo_id={equipo_id}")
        cursor.execute(query, (equipo_id,))
        db.connection.commit()
        cursor.close()
        current_app.logger.info(f"eliminar_archivo_cad: Eliminación exitosa para equipo_id={equipo_id}")
        return True
    except Exception as e:
        current_app.logger.error(f"eliminar_archivo_cad: Error en función: {str(e)} (tipo: {type(e)})")
        raise


@retry_on_disconnect
def verificar_archivo_cad_existe(equipo_id):
    """
    Verifica si un equipo tiene un archivo CAD asociado y retorna información del archivo
    """
    current_app.logger.info(f"verificar_archivo_cad_existe: Verificando equipo_id={equipo_id}")
    try:
        cursor = db.connection.cursor()
        query = """
            SELECT nombre_archivo_cad, tipo_archivo_cad, tamanio_archivo_cad 
            FROM equipo_info 
            WHERE id = %s AND archivo_cad IS NOT NULL
        """
        current_app.logger.info(f"verificar_archivo_cad_existe: Ejecutando query para equipo_id={equipo_id}")
        cursor.execute(query, (equipo_id,))
        resultado = cursor.fetchone()
        cursor.close()
        
        current_app.logger.info(f"verificar_archivo_cad_existe: Resultado query: {resultado}")
        
        if resultado:
            archivo_info = {
                'nombre_archivo_cad': resultado['nombre_archivo_cad'],
                'tipo_archivo_cad': resultado['tipo_archivo_cad'],
                'tamanio_archivo_cad': resultado['tamanio_archivo_cad']
            }
            current_app.logger.info(f"verificar_archivo_cad_existe: Archivo encontrado para equipo_id={equipo_id}: {archivo_info}")
            return archivo_info
        
        current_app.logger.info(f"verificar_archivo_cad_existe: No se encontró archivo CAD para equipo_id={equipo_id}")
        return None
    except Exception as e:
        current_app.logger.error(f"verificar_archivo_cad_existe: Error en función: {str(e)} (tipo: {type(e)})")
        raise


# ========================================================================
# NUEVAS FUNCIONES: MALLAS CAD PRE-PROCESADAS (OPTIMIZACIÓN DE CARGA)
# ========================================================================

def obtener_malla_procesada_cad(equipo_id):
    """
    Obtener la malla CAD ya procesada (triangulada) desde la BD.
    Esto evita tener que procesar el archivo STEP/IGES cada vez con OCCT.
    
    Returns:
        dict con malla_cad_procesada, formato_malla_cad, tamanio_malla_cad, fecha_procesamiento_cad
        o None si no existe
    """
    current_app.logger.info(f"obtener_malla_procesada_cad: Consultando equipo_id={equipo_id}")
    
    try:
        cursor = db.connection.cursor(MySQLdb.cursors.DictCursor)
        query = """
            SELECT 
                malla_cad_procesada,
                formato_malla_cad,
                tamanio_malla_cad,
                fecha_procesamiento_cad
            FROM equipo_info
            WHERE id = %s AND malla_cad_procesada IS NOT NULL
        """
        cursor.execute(query, (equipo_id,))
        resultado = cursor.fetchone()
        cursor.close()
        
        if resultado:
            current_app.logger.info(f"obtener_malla_procesada_cad: Malla encontrada para equipo_id={equipo_id}, "
                                   f"formato={resultado['formato_malla_cad']}, "
                                   f"tamaño={resultado['tamanio_malla_cad']} bytes")
        else:
            current_app.logger.info(f"obtener_malla_procesada_cad: No hay malla procesada para equipo_id={equipo_id}")
        
        return resultado
        
    except Exception as e:
        current_app.logger.error(f"obtener_malla_procesada_cad: Error en consulta: {str(e)} (tipo: {type(e)})")
        return None


@retry_on_disconnect
def guardar_malla_procesada_cad(equipo_id, malla_blob, formato='glb', tamanio=None):
    """
    Guardar la malla CAD ya procesada (triangulada) en la BD.
    
    Args:
        equipo_id: ID del equipo
        malla_blob: Datos de la malla procesada (GLB, JSON, etc.)
        formato: Formato de la malla ('glb', 'json', 'threejs')
        tamanio: Tamaño en bytes (se calcula si no se proporciona)
    
    Returns:
        True si se guardó exitosamente, False en caso contrario
    """
    if tamanio is None:
        tamanio = len(malla_blob) if isinstance(malla_blob, (bytes, bytearray)) else 0
    
    current_app.logger.info(f"guardar_malla_procesada_cad: Guardando malla para equipo_id={equipo_id}, "
                           f"formato={formato}, tamaño={tamanio} bytes")
    
    try:
        cursor = db.connection.cursor()
        query = """
            UPDATE equipo_info 
            SET 
                malla_cad_procesada = %s,
                formato_malla_cad = %s,
                tamanio_malla_cad = %s,
                fecha_procesamiento_cad = NOW()
            WHERE id = %s
        """
        cursor.execute(query, (malla_blob, formato, tamanio, equipo_id))
        db.connection.commit()
        cursor.close()
        
        current_app.logger.info(f"guardar_malla_procesada_cad: Malla guardada exitosamente para equipo_id={equipo_id}")
        return True
        
    except Exception as e:
        current_app.logger.error(f"guardar_malla_procesada_cad: Error guardando malla: {str(e)} (tipo: {type(e)})")
        db.connection.rollback()
        return False


@retry_on_disconnect
def eliminar_malla_procesada_cad(equipo_id):
    """
    Eliminar la malla procesada de la BD.
    Útil cuando se actualiza el archivo CAD original y hay que re-procesar.
    
    Returns:
        True si se eliminó exitosamente, False en caso contrario
    """
    current_app.logger.info(f"eliminar_malla_procesada_cad: Eliminando malla para equipo_id={equipo_id}")
    
    try:
        cursor = db.connection.cursor()
        query = """
            UPDATE equipo_info 
            SET 
                malla_cad_procesada = NULL,
                formato_malla_cad = NULL,
                tamanio_malla_cad = NULL,
                fecha_procesamiento_cad = NULL
            WHERE id = %s
        """
        cursor.execute(query, (equipo_id,))
        db.connection.commit()
        cursor.close()
        
        current_app.logger.info(f"eliminar_malla_procesada_cad: Malla eliminada para equipo_id={equipo_id}")
        return True
        
    except Exception as e:
        current_app.logger.error(f"eliminar_malla_procesada_cad: Error: {str(e)} (tipo: {type(e)})")
        db.connection.rollback()
        return False