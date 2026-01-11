FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev \
    libxml2-dev libicu-dev curl default-mysql-client \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction

# Copy all files
COPY . .

# Finalize composer
RUN composer dump-autoload --optimize --no-dev

# Build assets
RUN npm ci && npm run build && npm prune --omit=dev

# Set permissions
RUN mkdir -p storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Create .env
RUN touch .env

# Health check (optional tapi bagus)
HEALTHCHECK --interval=30s --timeout=3s --start-period=40s \
  CMD php artisan || exit 1

# Start with PORT from Railway
CMD php artisan config:clear && \
    php artisan cache:clear && \
    echo "Waiting for database..." && \
    timeout 60 bash -c 'until php artisan migrate:status 2>/dev/null; do echo "Retrying..."; sleep 3; done' && \
    php artisan migrate --force && \
    php artisan config:cache && \
    echo "PORT variable is: ${PORT}" && \
    echo "Starting server on port ${PORT}..." && \
    php artisan serve --host=0.0.0.0 --port="${PORT}"