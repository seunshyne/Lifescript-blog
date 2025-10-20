# Use official PHP image with Composer and necessary extensions
FROM php:8.2-fpm

# Set unlimited Composer memory
ENV COMPOSER_MEMORY_LIMIT=-1

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip fileinfo

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# ✅ Ensure git and unzip are in PATH before composer install
RUN which git && which unzip

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --verbose

# Build frontend assets (optional, if using Vite)
RUN npm ci && npm run build || true

# Set permissions
RUN chmod -R 775 /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 8000

# Start PHP server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
