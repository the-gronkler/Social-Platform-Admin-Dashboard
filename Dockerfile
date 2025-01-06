FROM php:8.2-cli-alpine

# Set the working directory
WORKDIR /var/www

# Install system dependencies
RUN apk add --no-cache zip unzip git sqlite-dev

# Copy application files
COPY . .

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install app dependencies
RUN composer install --no-interaction --no-scripts --optimize-autoloader

# Generate app key
RUN php artisan key:generate

# Set permissions for storage
RUN chmod -R 777 storage bootstrap/cache

# Define command to run the app
#CMD php artisan serve --host=0.0.0.0 --port=8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
