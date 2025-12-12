// Definición de nodos (preguntas y respuestas)
const nodos = {
    "inicio": {
        pregunta: "Ejecutar cuestionario LORA",
        respuestas: {
            "Sí": "P1",
            "No": "fin"
        }
    },
    "P1": {
        pregunta: "¿Es posible realizar la reparación del modo de falla en el lugar de operación?",
        respuestas: {
            "Sí": "P16",
            "No": "P2"
        }
    },
    "P2": {
        pregunta:"¿Existe alguna limitación en la disponibilidad de información para la reparación del modo de falla debido a restricciones en la transferencia de tecnología?",
        respuestas: {
            "Sí": "P4",
            "No": "P3"
        }
    },
    "P3": {
        pregunta: "¿La reparación del modo de falla puede producir un riesgo inaceptable para la seguridad del personal de mantenimiento que no puede ser mitigado mediante recursos de apoyo o procedimientos?",
        respuestas: {
            "Sí": "P4",
            "No": "P6"
        }
    },
    "P4": {
        pregunta: "¿El modo de falla puede producir una degradación inaceptable en las misiones del buque?",
        respuestas: {
            "Sí": "P5",
            "No": "R3E_ini"
        }
    },
    "P5": {
        pregunta: "¿Es la probabilidad de ocurrencia del modo de falla mayor o igual a una vez cada cuatro años?",
        respuestas: {
            "Sí": "R3E_iniBA",
            "No": "R3E_ini"
        }
    },
    "P6": {
        pregunta: "¿La duración de la reparación del modo de falla es menor o igual al tiempo máximo de reparación asignado al primer escalón por la política de mantenimiento?",
        respuestas: {
            "Sí": "P9",
            "No": "P7"
        }
    },
    "P7": {
        pregunta: "¿El modo de falla puede producir una degradación inaceptable en las misiones del buque?",
        respuestas: {
            "Sí": "P10",
            "No": "P8"
        }
    },
    "P8": {
        pregunta: "¿Dispone de segundo escalón todos los conocimientos, documentación y medios para realizar la reparación del modo de falla?",
        respuestas: {
            "Sí": "R2E_B",
            "No": "P15"
        }
    },
    "P9": {
        pregunta: "¿Dispone el primer escalón de los conocimientos, documentación y recursos humanos y materiales para realizar la reparación del modo de falla?",
        respuestas: {
            "Sí": "R1E_B",
            "No": "P11"
        }
    },
    "P10": {
        pregunta: "¿Es la probabilidad de ocurrencia del modo de falla menor o igual a una vez cada cuatro años?",
        respuestas: {
            "Sí": "ABB_B",
            "No": "P8"
        }
    },
    "P11": {
        pregunta: "¿El modo de falla puede producir una degradación inaceptable en las misiones del buque?",
        respuestas: {
            "Sí": "P12",
            "No": "P13"
        }
    },
    "P12": {
        pregunta: "¿Es la probabilidad de ocurrencia del modo de falla mayor o igual a una vez cada cuatro años?",
        respuestas: {
            "Sí": "R1E_C",
            "No": "P13"
        }
    },
    "P13": {
        pregunta: "¿Existe algún recurso de apoyo el cual es inviable disponer de él en el primer escalón para realizar la reparación del modo de falla?",
        respuestas: {
            "Sí": "P14",
            "No": "R3E_C"
        }
    },
    "P14": {
        pregunta: "¿Dispone el segundo escalón de los conocimientos, documentación y medios para realizar la reparación del modo de falla?",
        respuestas: {
            "Sí": "R3E_C",
            "No": "P15"
        }
    },
    "P15": {
        pregunta: "¿Existe algún recurso de apoyo el cual es inviable disponer de él en el segundo escalón?",
        respuestas: {
            "Sí": "R4E_D",
            "No": "R3E_C"
        }
    },
    "P16": {
        pregunta:"¿El modo de falla se puede reparar en el lugar de operación por desmontaje y reemplazo?",
        respuestas: {
            "Sí": "P19",
            "No": "P17"
        }
    },
    "P17": {
        pregunta:"¿El desmontaje y reemplazo del componente puede producir un riesgo inaceptable para la seguridad del personal de mantenimiento que no puede ser mitigado mediante recursos de apoyo o procedimientos?",
        respuestas: {
            "Sí": "P20",
            "No": "P18"
        }
    },
    "P18": {
        pregunta:"¿La duración del desmontaje y reemplazo del componente es menor a la del tiempo máximo de reparación asignado al primer escalón por la política de mantenimiento?",
        respuestas: {
            "Sí": "P28",
            "No": "P24"
        }
    }, 
    "P19": {
        pregunta:"¿Es el tiempo de reparación en el lugar de operación dos o mas veces mayor que el tiempo de desmontaje y reemplazo?",
        respuestas: {
            "Sí": "P17",
            "No": "P2"
        }
    }, 
    "P20": {
        pregunta: "¿El modo de falla puede producir una degradación inaceptable en las misiones del buque?",
        respuestas: {
            "Sí": "P21",
            "No": "P23"
        }
    },
    "P21": {
        pregunta:"¿Es la probabilidad de ocurrencia del modo de falla mayor o igual a una vez cada cuatro años?",
        respuestas: {
            "Sí": "P22",
            "No": "P23"
        }
    },
    "P22": {
        pregunta: "¿Está considerado el componente que se desmonta y reemplaza como reparable por el fabricante?",
        respuestas: {
            "Sí": "DYR3E_D3E_E_BD2",
            "No": "DYR3E_D3E_E_BD"
        }
    },
    "P23": {
        pregunta: "¿Está considerado el componente que se desmonta y reemplaza como reparable por el fabricante?",
        respuestas: {
            "Sí": "DYR3E_R3E_E",
            "No": "DYR3E_D3E_E"
        }
    },
    "P24": {
        pregunta: "¿El modo de falla puede producir una degradación inaceptable en las misiones del buque?",
        respuestas: {
            "Sí": "P25",
            "No": "P26"
        }
    },
    "P25": {
        pregunta: "¿Es la probabilidad de ocurrencia del modo de falla menor o igual a una vez cada cuatro años?",
        respuestas: {
            "Sí": "P36",
            "No": "P26"
        }
    },
    "P26": {
        pregunta: "¿Dispone el segundo escalón de los conocimientos, documentación y medios para realizar el desmontaje y reemplazo del componente?",
        respuestas: {
            "Sí": "P27",
            "No": "P31"
        }
    },
    "P27": {
        pregunta: "¿Está considerado el componente que se desmonta y reemplaza como reparable por el fabricante?",
        respuestas: {
            "Sí": "DYR2E_D2E_F",
            "No": "P34"
        }
    },
    "P28": {
        pregunta: "¿El componente afectado por el modo de falla tiene un peso máximo de 15 Kg y ninguna de sus dimensiones (altura, anchura, profundidad) es mayor de 500 mm?",
        respuestas: {
            "Sí": "P29",
            "No": "P39"
        }
    },
    "P29": {
        pregunta: "¿Dispone el primer escalón de los conocimientos, documentación y recursos para realizar el desmontaje y reemplazo del componente?",
        respuestas: {
            "Sí": "P30",
            "No": "P45"
        }
    },
    "P30": {
        pregunta: "¿Está considerado el componente que se desmonta y reemplaza como reparable por el fabricante?",
        respuestas: {
            "Sí": "P49",
            "No": "DYR1E_D1E_G"
        }
    },
    "P31": {
        pregunta: "¿Existe algún recurso de apoyo el cual es inviable disponer de él en el segundo escalón para realizar el desmontaje y reemplazo del componente?",
        respuestas: {
            "Sí": "P33",
            "No": "P32"
        }
    },
    "P32": {
        pregunta: "¿Está considerado el componente que se desmonta y reemplaza como reparable por el fabricante?",
        respuestas: {
            "Sí": "P34",
            "No": "DYR2E_D2E_H"
        }
    },
    "P33": {
        pregunta: "¿Está considerado el componente que se desmonta y reemplaza como reparable por el fabricante?",
        respuestas: {
            "Sí": "DYR3E_R3E_H",
            "No": "DYR3E_D3E_H"
        }
    },
    "P34": {
        pregunta:"¿Existe alguna limitación en la disponibilidad de información para la reparación del componente reparable debido a la existencia de restricciones a la transferencia de tecnología?",
        respuestas: {
            "Sí": "DYR2E_R3E_I",
            "No": "P35"
        }
    },
    "P35": {
        pregunta:"¿Existe algún recurso de apoyo el cual es inviable disponer de él en el segundo escalón para realizar la reparación del componente reparable?",
        respuestas: {
            "Sí": "DYR2E_R3E_I2",
            "No": "DYR2E_D2E_H"
        }
    },
    "P36": {
        pregunta:"¿El componente afectado por el modo de falla tiene un peso máximo de 15 Kg y ninguna de sus dimensiones (altura, anchura, profundidad) es mayor de 500 mm?",
        respuestas: {
            "Sí": "P37",
            "No": "P52"
        }
    },
    "P37": {
        pregunta:"¿Dispone el primer escalón de los conocimientos, documentación y recursos para realizar el desmontaje y reemplazo del componente?",
        respuestas: {
            "Sí": "P38",
            "No": "P56"
        }
    }, 
    "P38": {
        pregunta:"¿Está considerado el componente que se desmonta y reemplaza como reparable por el fabricante?",
        respuestas: {
            "Sí": "C_R34E_Q",
            "No": "DYR1E_D1E_J"
        }
    }, 
    "P39": {
        pregunta: "¿El modo de falla puede producir una degradación inaceptable en las misiones del buque?",
        respuestas: {
            "Sí": "P40",
            "No": "P43"
        }
    },
    "P40": {
        pregunta:"¿Es la probabilidad de ocurrencia del modo de falla menor o igual a una vez cada cuatro años?",
        respuestas: {
            "Sí": "P41",
            "No": "P43"
        }
    },
    "P41": {
        pregunta: "¿Sería viable realizar el desmontaje y reemplazo por más de una persona y se dispone de rutas de desmontaje para realizarlo?",
        respuestas: {
            "Sí": "P42",
            "No": "ABE_K"
        }
    },
    "P42": {
        pregunta:"¿Está considerado el componente que se desmonta y reemplaza como reparable por el fabricante?",
        respuestas: {
            "Sí": "C_R34E_Q",
            "No": "DYR1E_D1E_K"
        }
    },
    "P43": {
        pregunta: "¿Dispone el segundo escalón de los conocimientos, documentación y medios para realizar el desmontaje y reemplazo del componente?",
        respuestas: {
            "Sí": "P44",
            "No": "P45"
        }
    },
    "P44": {
        pregunta:"¿Está considerado el componente que se desmonta y reemplaza como reparable por el fabricante?",
        respuestas: {
            "Sí": "P49",
            "No": "DYR2E_D2E_K"
        }
    },
    "P45": {
        pregunta: "¿Existe algún recurso de apoyo el cual es inviable disponer de él en el primer escalón para realizar el desmontaje y reemplazo del componente?",
        respuestas: {
            "Sí": "P47",
            "No": "P46"
        }
    },
    "P46": {
        pregunta: "¿Está considerado el componente que se desmonta y reemplaza como reparable por el fabricante?",
        respuestas: {
            "Sí": "P49",
            "No": "DYR1E_D1E_L"
        }
    },
    "47": {
        pregunta:"¿El modo de falla puede producir una degradación inaceptable en las misiones del buque?",
        respuestas: {
            "Sí": "P48",
            "No": "P31"
        }
    },
    "P48": {
        pregunta:"¿Es la probabilidad de ocurrencia del modo de falla menor o igual a una vez cada cuatro años?",
        respuestas: {
            "Sí": "ABF_L",
            "No": "P31"
        }
    },
    "P49": {
        pregunta:"¿Existe alguna limitación en la disponibilidad de información para la reparación del componente reparable debido a la existencia de restricciones a la transferencia de tecnología?",
        respuestas: {
            "Sí": "DYR1E_R3E_M",
            "No": "P50"
        }
    },
    "P50": {
        pregunta:"¿Existe algún recurso de apoyo el cual es inviable disponer de él en el segundo escalón para realizar la reparación del componente reparable?",
        respuestas: {
            "Sí": "DYR1E_R3E_M",
            "No": "DYR1E_R2E"
        }
    },
    "P52": {
        pregunta:"¿Sería viable realizar el desmontaje y reemplazo por más de una persona y se disponen de rutas de desmontaje para realizarlo?",
        respuestas: {
            "Sí": "P53",
            "No": "ABG_N"
        }
    },
    "P53": {
        pregunta:"¿Está considerado el componente que se desmonta y reemplaza como reparable por el fabricante?",
        respuestas: {
            "Sí": "P49",
            "No": "DYR1E_D1E_N"
        }
    },
    "P54": {
        pregunta:"¿Dispone el segundo escalón de los conocimientos, documentación y medios para realizar el desmontaje y reemplazo del componente?",
        respuestas: {
            "Sí": "P55",
            "No": "P45"
        }
    },
    "P55": {
        pregunta:"¿Está considerado el componente que se desmonta y reemplaza como reparable por el fabricante?",
        respuestas: {
            "Sí": "DYR2E_R2E",
            "No": "DYR2E_D2E_N"
        }
    },
    "P56": {
        pregunta:"¿Existe algún recurso de apoyo el cual es inviable disponer de él en el primer escalón para realizar el desmontaje y reemplazo del componente?",
        respuestas: {
            "Sí": "ABG_O",
            "No": "P57"
        }
    },
    "P57": {
        pregunta:"¿Está considerado el componente que se desmonta y reemplaza como reparable por el fabricante?",
        respuestas: {
            "Sí": "P49",
            "No": "DYR1E_D1E_O"
        }
    }, 
    
    "DYR1E_D1E_J": {
        pregunta: "Desmontar y reemplazar por el primer escalón y desechar en el primer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "R3E_ini": {
        pregunta: "Reparar por el 3er escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "R3E_iniBA": {
        pregunta: "Reparar por el 3er escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "R2E_B":{
        pregunta:"Reparar por el 2do escalon",
        respuestas:{
            "Fin:":"fin"
        }
    },
    "ABA_ini": {
        pregunta: "Activar bandera A.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "R1E_B": {
        pregunta: "Reparar por el primer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "ABB": {
        pregunta: "Reparar por el primer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR1E_D1E_L": {
        pregunta: "Desmontar y reemplazar en el primer escalón y desechar en el primer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "ABB_B": {
        pregunta: "Reparar por el 2do escalon",
        respuestas: {
            "Fin": "fin"
        }
    },
    "R3E_C": {
        pregunta: "Reparar por el 3er escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "R1E_C": {
        pregunta: "Reparar por el primer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "C_R1E": {
        pregunta: "Calcular el coste anual total de R1E.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "C_R1E_C": {
        pregunta: "Calcular el coste anual total de R1E_C, R3E_C y R4E_C.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "C_R3E": {
        pregunta: " Calcular el coste anual total de R3E.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "C_R3E_C": {
        pregunta: "Calcular el coste anual total de R3E_C.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "R4E": {
        pregunta:"Reparar por el 4to escalón." ,
        respuestas: {
            "Fin": "fin"
        }
    },
    "C_R4E": {
        pregunta: "Calcular el coste anual total de R4E.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "C_R4E_C": {
        pregunta: "Calcular el coste anual total de R4E-NODO-C.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "Min_R134E": {
        pregunta: "Seleccionar el mínimo valor de reparación de escalones 1, 3, 4.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "Min_R134E_C": {
        pregunta: "Seleccionar el mínimo valor de reparación de escalones 1, 3, 4_C.",
        respuestas: {
            "Fin": "fin"
        }
    },

    "DYR2E_R2E": {
        pregunta: "Desmontar y reemplazar por el segundo escalón y reparar en el segundo escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "R4E_D": {
        pregunta: "Reparar por el 4to escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "C_R3E_D": {
        pregunta: "Calcular el coste anual total de R3E_D.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "C_R4E_D": {
        pregunta:"Calcular el coste anual total de R4E_D." ,
        respuestas: {
            "Fin": "fin"
        }
    },
    "Min_R34E_D": {
        pregunta: "Seleccionar el mínimo valor de reparación de escalones 3, 4_D.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR3E_R3E": {
        pregunta: "Desmontar y reemplazar por el tercer escalón y reparar por el tercer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR3E_R3E_E": {
        pregunta: "Desmontar y reemplazar por el tercer escalón y reparar por el tercer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR3E_D3E": {
        pregunta: "Desmontar y reemplazar por el tercer escalón y desechar por el tercer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },

    "DYR3E_D3E_E": {
        pregunta: "Desmontar y reemplazar por el tercer escalón y desechar por el tercer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR3E_D3E_E_BD": {
        pregunta: "Desmontar y reemplazar por el tercer escalón y desechar por el tercer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR3E_D3E_E_BD2": {
        pregunta: "Desmontar y reemplazar por el tercer escalón y reparar por el tercer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR2E_D2E_F": {
        pregunta: "Desmontar y reemplazar por el segundo escalón y desechar por el segundo escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR1E_D1E_G": {
        pregunta: "Desmontar y reemplazar por el primer escalón y desechar en el primer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "ABDYR1E_D1E_J": {
        pregunta: "Desmontar y reemplazar por el primer escalón y desechar en el primer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR3E_D3E_H": {
        pregunta: " Desmontar y reemplazar por el tercer escalón y desechar por el tercer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },

    "DYR3E_R3E_H": {
        pregunta: "Desmontar y reemplazar por el tercer escalón y reparar por el tercer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR2E_D2E_H": {
        pregunta: "Desmontar y reemplazar por el segundo escalón y desechar por el segundo escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "C_R2E": {
        pregunta: "Calcular el coste anual total de R2E.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "C_R34E_I": {
        pregunta:"Calcular el coste anual total de R3E y R4E." ,
        respuestas: {
            "Fin": "fin"
        }
    },


    "Min_R23E": {
        pregunta: "Seleccionar el mínimo valor de reparación de escalones 1 y 2.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "Min_R34E_I": {
        pregunta: "Seleccionar el mínimo valor de reparación de escalones 3 y 4.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR2E_R3E_I": {
        pregunta: "Desmontar y reemplazar en el segundo escalón y reparar en el tercer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },

    "DYR2E_R3E_I2": {
        pregunta: "Desmontar y reemplazar en el segundo escalón y reparar en el tercer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR2E_D2E_K": {
        pregunta: "Desmontar y reemplazar por el segundo escalón y desechar en el segundo escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR1E_D1E_K": {
        pregunta: "Desmontar y reemplazar por el primer escalón y desechar en el primer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "ABE_K": {
        pregunta:"Desmontar y reemplazar por el primer escalón y desechar en el primer escalón." ,
        respuestas: {
            "Fin": "fin"
        }
    },
    "ABF_L": {
        pregunta: "Desmontar y reemplazar en el primer escalón y desechar en el primer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR1E_R3E_M": {
        pregunta: "Desmontar y reemplazar en el primer escalón y reparar en el tercer escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "DYR1E_R2E": {
        pregunta: " Desmontar y reemplazar en el primer escalón y reparar en el segundo escalón.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "ABG_N": {
        pregunta: "Desmontar y reemplazar por el primer escalón y desechar en el primer escalón",
        respuestas: {
            "Fin": "fin"
        }
    },

    "ABG_O": {
        pregunta: "Desmontar y reemplazar por el primer escalón y desechar en el primer escalón",
        respuestas: {
            "Fin": "fin"
        }
    },
    "C_R34E_Q": {
        pregunta: "Calcular el coste anual total de R3E y R4E.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "Min_R34E_Q": {
        pregunta: "Seleccionar el mínimo valor de reparación de escalones 3 y 4.",
        respuestas: {
            "Fin": "fin"
        }
    },
    "C_R34E_R": {
        pregunta:"Calcular el coste anual total de R3E y R4E." ,
        respuestas: {
            "Fin": "fin"
        }
    },
    "Min_R34E_R": {
        pregunta:"Seleccionar el mínimo valor de reparación de escalones 3 y 4." ,
        respuestas: {
            "Fin": "fin"
        }
    },


    "fin": {
        pregunta: "Fin del cuestionario.",
        respuestas: {}
    }
};

// Variables para controlar el flujo del cuestionario
let currentNode = "inicio";
let questionHistory = []; // Historial de las preguntas anteriores
let contadorRespuestas = 1; // Iniciamos un contador para ir llenando los inputs secuencialmente
let respuestas = {}; // Almacena las respuestas asociadas a cada pregunta

// Función para mostrar el nodo actual
function mostrarPregunta(nodeId) {
    const nodo = nodos[nodeId]; // Obtenemos el nodo actual basado en la respuesta
    const questionText = document.getElementById("questionText");

    // Actualizamos el texto de la pregunta
    questionText.textContent = nodo.pregunta;

    if (nodo.respuestas["Fin"] === "fin") {
        const labelElement = document.getElementById("actividades");
        if (labelElement) {
            labelElement.value = nodo.pregunta; // Set the text content of the label
        }
    }

    // Si es el nodo de fin, ocultamos todos los botones
    if (nodeId === "fin") {
        ocultarBotones(); // Aseguramos que todos los botones estén ocultos
        return;
    }




    // Mostrar los botones "Sí" y "No" solo si el nodo tiene respuestas disponibles
    if (nodo.respuestas["Sí"] && nodo.respuestas["No"]) {
        document.getElementById("yesBtn").style.display = "inline-block";
        document.getElementById("noBtn").style.display = "inline-block";
    } else {
        ocultarBotones();
    }

    // Si ya hay preguntas en el historial, mostrar el botón "Volver"
    if (questionHistory.length > 0) {
        document.getElementById("backBtn").style.display = "inline-block";
    } else {
        document.getElementById("backBtn").style.display = "none";
    }

    // Actualizamos los eventos de los botones según la lógica del nodo
    document.getElementById("yesBtn").onclick = function() {
        if (currentNode !== "inicio") { // No guardar si es el nodo de inicio
            guardarRespuesta(currentNode, "Sí");
        }
        questionHistory.push(currentNode); // Guardamos la pregunta actual antes de avanzar
        currentNode = nodo.respuestas["Sí"]; // Actualizamos al nodo siguiente según "Sí"
        ocultarBotones(); // Ocultamos los botones inmediatamente
        mostrarPregunta(currentNode); // Mostramos la siguiente pregunta
    };

    document.getElementById("noBtn").onclick = function() {
        if (currentNode !== "inicio") { // No guardar si es el nodo de inicio
            guardarRespuesta(currentNode, "No");
        }
        questionHistory.push(currentNode); // Guardamos la pregunta actual antes de avanzar
        currentNode = nodo.respuestas["No"]; // Actualizamos al nodo siguiente según "No"
        ocultarBotones(); // Ocultamos los botones inmediatamente
        mostrarPregunta(currentNode); // Mostramos la siguiente pregunta
    };

    // Evento para volver a la pregunta anterior
    document.getElementById("backBtn").onclick = function() {
        if (questionHistory.length > 0) {
            const preguntaAnterior = questionHistory.pop(); // Volver al último nodo del historial
            volverAtras(preguntaAnterior); // Actualizamos la respuesta cuando se vuelve atrás
            currentNode = preguntaAnterior;
            mostrarPregunta(currentNode); // Mostramos la pregunta anterior
        }
    };
}

// Función para ocultar todos los botones
function ocultarBotones() {
    document.getElementById("yesBtn").style.display = "none";
    document.getElementById("noBtn").style.display = "none";
    document.getElementById("backBtn").style.display = "none";
}

// Función para guardar la respuesta
function guardarRespuesta(preguntaId, respuesta) {
    // Si ya respondimos esta pregunta antes, actualizamos su input
    if (respuestas[preguntaId]) {
        const inputId = respuestas[preguntaId]; // Obtenemos el id del input correspondiente
        const inputElement = document.getElementById(inputId);
        if (inputElement) {
            inputElement.value = respuesta; // Actualizamos la respuesta
        }
    } else {
        // Si es una nueva respuesta, llenamos el siguiente input secuencial
        const inputId = `cuestionario_rcm${contadorRespuestas}`; // Generamos el id del input correspondiente
        const inputElement = document.getElementById(inputId); // Obtenemos el input correspondiente
        
        if (inputElement) {
            inputElement.value = respuesta; // Guardamos la respuesta en el input
            respuestas[preguntaId] = inputId; // Almacenamos la relación de la pregunta con el input
            contadorRespuestas++; // Incrementamos el contador
        }
    }
}

// Función para retroceder en el cuestionario
function volverAtras(preguntaId) {
    const inputId = respuestas[preguntaId]; // Obtenemos el id del input asociado con la pregunta
    if (inputId) {
        const inputElement = document.getElementById(inputId);
        if (inputElement) {
            inputElement.value = ""; // Borramos la respuesta del input al retroceder
            contadorRespuestas--; // Reducimos el contador ya que volvemos atrás
        }
    }
}

// Iniciar el cuestionario cuando se abra el modal
document.getElementById("startQuizBtn").addEventListener("click", function () {
    currentNode = "inicio"; // Reiniciar el cuestionario al inicio
    questionHistory = []; // Limpiar el historial cuando se reinicia
    respuestas = {}; // Limpiar las respuestas anteriores
    contadorRespuestas = 1; // Reiniciar el contador
    mostrarPregunta(currentNode);
});
