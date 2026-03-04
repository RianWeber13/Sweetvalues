#!/bin/sh
set -e

echo "==> Caching config, routes e views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Rodando migrations..."
php artisan migrate --force

echo "==> Criando usuário admin (se necessário)..."
php artisan db:seed --class=AdminUserSeeder --force

echo "==> Corrigindo permissões..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "==> Iniciando serviços..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
