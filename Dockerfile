FROM php:8.2-cli

WORKDIR /var/www

# ===============================
# System dependencies
# ===============================
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# ===============================
# PHP extensions
# ===============================
RUN docker-php-ext-configure intl \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl

# ===============================
# Composer
# ===============================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ===============================
# Node.js
# ===============================
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# ===============================
# App files
# ===============================
COPY . .

# ===============================
# Install deps
# ===============================
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm ci && npm run build && npm prune --omit=dev

# ===============================
# Permissions
# ===============================
RUN mkdir -p storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# ===============================
# Runtime command
# ===============================
CMD php artisan migrate --force || true && \
    php artisan serve --host=0.0.0.0 --port=${PORT}
