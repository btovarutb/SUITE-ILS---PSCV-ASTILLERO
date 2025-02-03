#!/bin/bash

set -e

if [ -z "$MYSQL_HOST" ] || [ -z "$MYSQL_PORT" ]; then
  echo "Error: MYSQL_HOST o MYSQL_PORT no están configurados."
  exit 1
fi

echo "Esperando a que MySQL esté disponible en $MYSQL_HOST:$MYSQL_PORT..."

while ! nc -z "$MYSQL_HOST" "$MYSQL_PORT"; do
  sleep 1
done

echo "Verificando la existencia de la base de datos 'lsa'..."
until echo 'SHOW DATABASES;' | mysql -h "$MYSQL_HOST" -u "$MYSQL_USER" --password="$MYSQL_PASSWORD" | grep -q lsa; do
  echo "Base de datos 'lsa' no encontrada. Reintentando..."
  sleep 1
done

echo "Base de datos 'lsa' encontrada. Iniciando la aplicación Flask..."
exec "$@"
