# Usa una imagen base de Python
FROM python:3.9-slim

# Establece el directorio de trabajo
WORKDIR /app

# Instala las dependencias del sistema necesarias para mysqlclient y mysql-client
RUN apt-get update && apt-get install -y \
    default-libmysqlclient-dev \
    build-essential \
    gcc \
    pkg-config \
    default-mysql-client \
    mariadb-client \
    netcat-openbsd \
    && rm -rf /var/lib/apt/lists/*

# Copia los archivos de requerimientos
COPY requirements.txt .

# Instala las dependencias de Python
RUN pip install --no-cache-dir -r requirements.txt

# Copia el resto del código de la aplicación
COPY . .

COPY wait_for_mysql.sh /wait_for_mysql.sh
RUN chmod +x /wait_for_mysql.sh

# Configura la variable de entorno para Flask
ENV FLASK_APP=app.py
ENV FLASK_ENV=development

# Exponer el puerto 5000 para Flask
EXPOSE 5000

ENTRYPOINT ["/wait_for_mysql.sh"]

# Comando para iniciar la aplicación
CMD ["flask", "run", "--host=0.0.0.0", "--port=5000"]

