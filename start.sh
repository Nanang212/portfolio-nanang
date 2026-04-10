#!/bin/sh
set -e

# Render sets PORT env var dynamically — inject into nginx config
PORT="${PORT:-8080}"
sed -i "s/RENDER_PORT/${PORT}/g" /etc/nginx/http.d/default.conf

echo "Starting app on port $PORT..."

# Run Laravel setup on first start
php /var/www/artisan config:cache --quiet || true
php /var/www/artisan route:cache --quiet || true
php /var/www/artisan view:cache --quiet || true
php /var/www/artisan migrate --force --quiet || true
php /var/www/artisan storage:link --quiet || true

# Start php-fpm + nginx via supervisord
exec /usr/bin/supervisord -c /etc/supervisord.conf
