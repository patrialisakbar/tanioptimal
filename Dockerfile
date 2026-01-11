# =========================
# Base Image
# =========================
FROM php:8.2-cli

# =========================
# Install System Dependencies
# =========================
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    curl \
    default-mysql-client \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl

# =========================
# Install Composer
# =========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# =========================
# Install Node.js 22
# =========================
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# =========================
# Set Working Directory
# =========================
WORKDIR /app

# =========================
# Copy Composer Files (untuk caching)
# =========================
COPY composer.json composer.lock ./

# =========================
# Install PHP Dependencies
# =========================
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction

# =========================
# Copy All Files
# =========================
COPY . .

# =========================
# Finalize Composer
# =========================
RUN composer dump-autoload --optimize --no-dev

# =========================
# Install Node Dependencies & Build Assets
# =========================
RUN npm ci && npm run build && npm prune --omit=dev

# =========================
# Set Permissions
# =========================
RUN mkdir -p storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# =========================
# Create .env placeholder
# =========================
RUN touch .env

# =========================
# Start Application
# =========================
CMD php artisan config:clear && \
    php artisan cache:clear && \
    echo "Waiting for database connection..." && \
    timeout 60 bash -c 'until php artisan migrate:status 2>/dev/null; do echo "Retrying database connection..."; sleep 3; done' && \
    echo "Running migrations..." && \
    php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    echo "Starting server on port ${PORT:-8080}..." && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8080}