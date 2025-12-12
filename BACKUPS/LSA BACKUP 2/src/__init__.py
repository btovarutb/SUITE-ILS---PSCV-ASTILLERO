from flask import Flask
from flask_mysqldb import MySQL
from sqlalchemy import create_engine
from sqlalchemy.orm import scoped_session, sessionmaker
from src.config import config

# Inicialización de MySQL para Flask-MySQLdb
db = MySQL()

# Inicialización de SQLAlchemy para el pool de conexiones
engine = create_engine(
    f"mysql+pymysql://{config['development'].MYSQL_USER}:{config['development'].MYSQL_PASSWORD}@{config['development'].MYSQL_HOST}:{config['development'].MYSQL_PORT}/{config['development'].MYSQL_DB}",
    pool_recycle=config['development'].MYSQL_POOL_RECYCLE,
    pool_pre_ping=True,  # Verifica conexiones antes de usarlas
    pool_size=config['development'].MYSQL_POOL_SIZE,
    max_overflow=config['development'].MYSQL_MAX_OVERFLOW,
)


db_session = scoped_session(sessionmaker(bind=engine))

def create_app():
    app = Flask(__name__)

    # Configuraciones de la aplicación
    app.config.from_object(config['development'])

    # Inicializar Flask-MySQLdb
    db.init_app(app)

    # Cierre automático de sesiones SQLAlchemy al finalizar cada solicitud
    @app.teardown_appcontext
    def shutdown_session(exception=None):
        db_session.remove()

    return app
