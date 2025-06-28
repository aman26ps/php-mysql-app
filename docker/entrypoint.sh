#!/bin/bash
set -e

# Set defaults for local dev
: "${DB_HOST:=localhost}"
: "${DB_USER:=root}"
: "${DB_PASS:=root}"
: "${DB_NAME:=optimy_db}"

echo "⏳ Waiting for MySQL at $DB_HOST..."

until mysqladmin ping -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" --silent; do
  sleep 2
done

echo "Checking if '$DB_NAME.test' table exists..."
if ! mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" -e "USE $DB_NAME; DESCRIBE test;" >/dev/null 2>&1; then
  echo "Running init.sql..."
  mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" < /var/www/html/init.sql
else
  echo "✅ test table already exists. Skipping init.sql"
fi

echo "🚀 Starting Apache..."
exec apache2-foreground
