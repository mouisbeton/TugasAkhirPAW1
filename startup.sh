#!/bin/bash
set -e

# Log output
exec 2>&1

echo "Starting Laravel application setup..."

# Change to the app directory
cd /home/site/wwwroot

# Create database file if it doesn't exist (for SQLite)
if [ "$DB_CONNECTION" = "sqlite" ]; then
    mkdir -p /home/data
    touch /home/data/database.sqlite
    chmod 666 /home/data/database.sqlite
fi

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Clear caches
echo "Clearing caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
echo "Setting file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "Application setup complete!"

# Start PHP-FPM
echo "Starting PHP-FPM..."
exec /usr/sbin/php-fpm8.2 -F
