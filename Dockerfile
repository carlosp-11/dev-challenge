FROM richarvey/nginx-php-fpm:3.1.6

COPY . .

# Configuración de la imagen
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Configuración de Laravel
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Permitir que composer corra como root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Variables necesarias para Render
ENV APP_KEY=""
ENV DB_CONNECTION pgsql
ENV DATABASE_URL=""

# Configuración adicional para Laravel 6
ENV SESSION_DRIVER file
ENV CACHE_DRIVER file
ENV QUEUE_CONNECTION sync

# Crear script de inicialización específico para Laravel 6
RUN echo '#!/bin/bash' > /var/www/html/init.sh && \
    echo 'cd /var/www/html' >> /var/www/html/init.sh && \
    echo 'composer install --no-dev --optimize-autoloader' >> /var/www/html/init.sh && \
    echo 'php artisan config:cache' >> /var/www/html/init.sh && \
    echo 'php artisan route:cache' >> /var/www/html/init.sh && \
    echo 'php artisan view:cache' >> /var/www/html/init.sh && \
    echo 'chmod -R 755 storage' >> /var/www/html/init.sh && \
    echo 'chmod -R 755 bootstrap/cache' >> /var/www/html/init.sh && \
    chmod +x /var/www/html/init.sh

# Ejecutar inicialización y luego el comando original
CMD ["/bin/bash", "-c", "/var/www/html/init.sh && /start.sh"]
