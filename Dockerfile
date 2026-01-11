FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev \
    libxml2-dev libicu-dev curl default-mysql-client \
    nginx supervisor \
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
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Nginx config
RUN echo 'server { \n\
    listen ${PORT}; \n\
    root /app/public; \n\
    index index.php; \n\
    \n\
    location / { \n\
        try_files $uri $uri/ /index.php?$query_string; \n\
    } \n\
    \n\
    location ~ \.php$ { \n\
        fastcgi_pass 127.0.0.1:9000; \n\
        fastcgi_index index.php; \n\
        include fastcgi_params; \n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \n\
    } \n\
    \n\
    location ~ /\.(?!well-known).* { \n\
        deny all; \n\
    } \n\
}' > /etc/nginx/sites-available/default

# Supervisor config
RUN echo '[supervisord] \n\
nodaemon=true \n\
\n\
[program:php-fpm] \n\
command=php-fpm \n\
autostart=true \n\
autorestart=true \n\
\n\
[program:nginx] \n\
command=/bin/bash -c "envsubst '\$\${PORT}' < /etc/nginx/sites-available/default > /tmp/default && mv /tmp/default /etc/nginx/sites-enabled/default && nginx -g \"daemon off;\"" \n\
autostart=true \n\
autorestart=true' > /etc/supervisor/conf.d/supervisord.conf

# Create .env
RUN touch .env

# Start script
CMD php artisan config:clear && \
    php artisan cache:clear && \
    timeout 60 bash -c 'until php artisan migrate:status 2>/dev/null; do sleep 3; done' && \
    php artisan migrate --force && \
    php artisan config:cache && \
    /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf