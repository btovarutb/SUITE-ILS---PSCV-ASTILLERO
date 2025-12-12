import os
from flask import Flask
from flask_mysqldb import MySQL
from sqlalchemy import create_engine
from sqlalchemy.orm import scoped_session, sessionmaker
from flask_session import Session
from src.config import config

# Inicialización de MySQL para Flask-MySQLdb
db = MySQL()

# Inicialización de SQLAlchemy
engine = create_engine(
    f"mysql+pymysql://{config['development'].MYSQL_USER}:{config['development'].MYSQL_PASSWORD}@{config['development'].MYSQL_HOST}:{config['development'].MYSQL_PORT}/{config['development'].MYSQL_DB}",
    pool_recycle=config['development'].MYSQL_POOL_RECYCLE,
    pool_pre_ping=True,
    pool_size=config['development'].MYSQL_POOL_SIZE,
    max_overflow=config['development'].MYSQL_MAX_OVERFLOW,
)
db_session = scoped_session(sessionmaker(bind=engine))

# Crear directorio para sesiones si no existe
SESSION_DIR = os.path.join(os.getcwd(), 'flask_session')
os.makedirs(SESSION_DIR, exist_ok=True)

def create_app():
    app = Flask(__name__)
    app.config.from_object(config['development'])

    # Inicializar MySQL y sesiones
    db.init_app(app)
    app.config['SESSION_TYPE'] = 'filesystem'
    app.config['SESSION_FILE_DIR'] = SESSION_DIR
    app.config['SESSION_PERMANENT'] = False
    app.config['SESSION_USE_SIGNER'] = True
    app.config['SESSION_COOKIE_NAME'] = 'flask_session'
    Session(app)

    @app.teardown_appcontext
    def shutdown_session(exception=None):
        db_session.remove()

    return app
