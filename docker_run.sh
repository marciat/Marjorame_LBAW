#!/bin/bash
set -e

cd /var/www; php artisan config:cache
php artisan storage:link
env >> /var/www/.env
php-fpm7.2 -D
nginx -g "daemon off;"
