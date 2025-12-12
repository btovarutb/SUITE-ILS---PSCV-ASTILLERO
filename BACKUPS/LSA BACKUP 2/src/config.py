# config.py
import os

class Config:
    SECRET_KEY = os.environ.get('SECRET_KEY', '773e2996b970504daadaf2625cfc07187e23035e4686aa8dade5bcb2ca190d13')

class DevelopmentConfig(Config):
    DEBUG = True
    # Configuración de conexión MySQL
    MYSQL_HOST = os.environ.get('MYSQL_HOST', 'lsa_db_container')  # Apunta al nombre del servicio Docker
    MYSQL_USER = os.environ.get('MYSQL_USER', 'root')
    MYSQL_PASSWORD = os.environ.get('MYSQL_PASSWORD', '')
    MYSQL_DB = os.environ.get('MYSQL_DB', 'lsa')
    MYSQL_PORT = int(os.environ.get('MYSQL_PORT', 3306))
    MYSQL_UNIX_SOCKET = None  # Solo para conexiones locales si fuera necesario
    MYSQL_CONNECT_TIMEOUT = int(os.environ.get('MYSQL_CONNECT_TIMEOUT', 30))  # Aumenta a 30 segundos
    MYSQL_READ_DEFAULT_FILE = None
    MYSQL_USE_UNICODE = True
    MYSQL_CHARSET = 'utf8mb4'  # Usar utf8mb4 para soportar emojis y caracteres extendidos
    MYSQL_SQL_MODE = None
    MYSQL_CURSORCLASS = 'DictCursor'
    MYSQL_AUTOCOMMIT = True
    MYSQL_CUSTOM_OPTIONS = {
        'init_command': "SET SESSION wait_timeout=300",
    }

    # Configuración de reconexión automática
    MYSQL_POOL_RECYCLE = 300  # Recycle connections cada 280 segundos
    MYSQL_POOL_PRE_PING = True  # Verifica conexiones antes de usarlas
    MYSQL_POOL_SIZE = int(os.environ.get('MYSQL_POOL_SIZE', 5))  # Máximo tamaño del pool de conexiones
    MYSQL_MAX_OVERFLOW = int(os.environ.get('MYSQL_MAX_OVERFLOW', 10))  # Conexiones adicionales permitidas en caso de alta demanda

    # Configuración general de Flask
    SESSION_COOKIE_SECURE = False  # Cambiar a True en producción
    SESSION_COOKIE_HTTPONLY = True
    SESSION_COOKIE_SAMESITE = 'Lax'

config = {
    'development': DevelopmentConfig
}
