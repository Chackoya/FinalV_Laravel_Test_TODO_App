# Use the official PHP 8.1 image from the dockerhub
FROM php:8.1-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git unzip curl nodejs npm default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql \
    && apt-get clean

# Set working directory
WORKDIR /var/www

# Copy composer and install
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory
COPY . .

# Install project dependencies
RUN composer install
RUN npm install
# Build Vite assets
RUN npm run build

# Make the entrypoint script executable
RUN chmod +x /var/www/entrypoint.sh

# Use the entrypoint script as the container's entrypoint
ENTRYPOINT ["/var/www/entrypoint.sh"]

# Expose port 9000 to interact with the application
EXPOSE 9000