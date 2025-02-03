
#aqui se incertan las hermaientas generales:

def insertar_analisis_herramienta(nombre, valor, id_equipo_info, parte_numero, id_herramienta_requerida,
                                  id_tipo_herramienta, id_clase_herramienta):
    cursor = db.connection.cursor() # type: ignore
    query = """
        INSERT INTO herramientas_generales (
            nombre, valor, id_equipo_info, parte_numero, id_herramienta_requerida, id_tipo_herramienta,id_clase_herramienta

        )
        VALUES (%s, %s, %s, %s, %s, %s, %s)
    """

    cursor.execute(query, (
    nombre, valor, id_equipo_info, parte_numero, id_herramienta_requerida, id_tipo_herramienta, id_clase_herramienta))

    db.connection.commit() # type: ignore
    analisis_id = cursor.lastrowid
    cursor.close()
    return analisis_id