#!/bin/sh
set -eu

# ---- Validación de variables obligatorias ----
require_env() {
  var_name="$1"
  eval "val=\${$var_name:-}"
  if [ -z "$val" ]; then
    echo "Error: variable de entorno '$var_name' no está configurada."
    exit 1
  fi
}

require_env "MYSQL_HOST"
require_env "MYSQL_PORT"
require_env "MYSQL_USER"
require_env "MYSQL_DB"

# ---- Espera de puerto (infra) ----
echo "Esperando a que MySQL esté disponible en ${MYSQL_HOST}:${MYSQL_PORT}..."
while ! nc -z "$MYSQL_HOST" "$MYSQL_PORT"; do
  sleep 1
done

# ---- Construcción de args mysql (compatibles con MariaDB client) ----
# NOTA: En Debian slim, "default-mysql-client" suele ser MariaDB client.
# MariaDB NO soporta --ssl-mode=DISABLED, por eso usamos --ssl=0.
MYSQL_ARGS="-h $MYSQL_HOST -P $MYSQL_PORT -u $MYSQL_USER --ssl=0 --connect-timeout=3"

# Password opcional (evita romper cuando está vacío/no definido)
if [ -n "${MYSQL_PASSWORD:-}" ]; then
  MYSQL_ARGS="$MYSQL_ARGS --password=$MYSQL_PASSWORD"
fi

# ---- Verificación de autenticación (falla rápido y muestra error real) ----
echo "Verificando conexión/autenticación con MySQL..."
mysql $MYSQL_ARGS -e "SELECT 1;" >/dev/null

# ---- Verificación determinística de existencia de DB ----
echo "MySQL responde. Verificando existencia de la base '${MYSQL_DB}'..."
until mysql $MYSQL_ARGS --batch --skip-column-names \
  -e "SHOW DATABASES LIKE '${MYSQL_DB}';" | grep -qx "${MYSQL_DB}"; do
  echo "Base de datos '${MYSQL_DB}' aún no aparece. Reintentando..."
  sleep 1
done

echo "Base de datos '${MYSQL_DB}' encontrada. Iniciando la aplicación..."
exec "$@"
