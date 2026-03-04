#!/bin/sh
set -e

echo "==> Caching config, routes e views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Rodando migrations..."
php artisan migrate --force

echo "==> Iniciando serviços..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
