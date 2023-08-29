#!/bin/bash
# Copy .env.example to .env if .env does not exist
if [ ! -f "/var/www/.env" ]; then
    cp /var/www/.env.example /var/www/.env
fi


# Wait for the database to be ready
echo "Waiting for the Database to Start (it might take a minute)..."
while ! mysqladmin ping -h"mysql" -P"3306" --silent; do
    sleep 1
done

echo "MySQL DB is up - executing commands (migrations)"

# Comment this if you want migrations to run manually.
php artisan migrate --force

# Start Laravel built-in server
php artisan serve --host=0.0.0.0 --port=8000 &

# Start Vue.js frontend
#npm --prefix /var/www/ start &

# Start PHP-FPM
php-fpm
