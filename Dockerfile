FROM php:8.2-cli-alpine
WORKDIR /var/www
RUN apk add --no-cache zip unzip git sqlite-dev
RUN mkdir -p storage/app storage/framework/cache storage/framework/sessions storage/framework/views storage/logs
RUN chown -R www-data:www-data storage
COPY . .
RUN docker-php-ext-install pdo pdo_sqlite
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-interaction --no-scripts --optimize-autoloader
RUN php artisan key:generate
RUN chmod -R 777 storage bootstrap/cache
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
