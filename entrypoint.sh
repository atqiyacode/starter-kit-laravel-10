#!/usr/bin/env sh

composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs
# Install Node.js dependencies and build assets
npm install && npm run build

chown -R $USER:www-data storage
chown -R $USER:www-data bootstrap/cache
chmod -R 775 .
chmod -R 775 storage
chmod -R 775 bootstrap/cache
# php artisan key:generate
# sleep 5s
# php artisan migrate:fresh --seed --force
# sleep 15s

# Add the following lines to set up cron for Laravel scheduler
echo "* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1" > /etc/cron.d/laravel-scheduler
chmod 0644 /etc/cron.d/laravel-scheduler
crontab /etc/cron.d/laravel-scheduler

# Run Laravel commands
php artisan storage:link
# php artisan icon:cache
# php artisan view:cache
# php artisan config:cache
# php artisan route:cache
# php artisan event:cache

# Start the queue worker and websocket
php artisan queue:work --tries=10 --timeout=3000 --memory=4096 --sleep=1 &
php artisan reverb:start --host=0.0.0.0 --port=8080 &
php artisan pulse:restart &
php artisan horizon &

# Start Octane and WebSocket servers in the background
php artisan serve --host=0.0.0.0 &
# php artisan octane:start --host=0.0.0.0 &

# Execute any additional command passed to the script
exec "$@"
