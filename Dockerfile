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

CMD ["/start.sh"]
