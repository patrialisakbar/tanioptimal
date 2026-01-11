# =========================
# Base image
# =========================
FROM php:8.2-cli

# =========================
# Install system dependencies
# =========================
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd

# =========================
# Install Composer
# =========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# =========================
# Set working directory
# =========================
WORKDIR /app

# =========================
# Copy project files
# =========================
COPY . .

# =========================
# Install PHP dependencies
# =========================
RUN composer install --no-dev --optimize-autoloader --no-interaction

# =========================
# Set permissions
# =========================
RUN chmod -R 775 storage bootstrap/cache

# =========================
# Expose port (Railway akan inject PORT)
# =========================
EXPOSE 8080

# =========================
# Start Laravel (WAJIB pakai $PORT)
# =========================
CMD php artisan key:generate --force || true && \
    php artisan migrate --force || true && \
    php artisan serve --host=0.0.0.0 --port=${PORT}
