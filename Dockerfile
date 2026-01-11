FROM php:8.2-fpm

# ===============================
# 1. Set working directory
# ===============================
WORKDIR /var/www

# ===============================
# 2. Install system dependencies
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
    nginx \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

# ===============================
# 3. Install PHP extensions
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
# 4. Install Composer
# ===============================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ===============================
# 5. Install Node.js 22
# ===============================
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# ===============================
# 6. Copy application files
# ===============================
COPY . .

# ===============================
# 7. Install PHP dependencies
# ===============================
RUN composer install --no-dev --optimize-autoloader --no-interaction

# ===============================
# 8. Build frontend assets
# ===============================
RUN npm ci && npm run build && npm prune --omit=dev

# ===============================
# 9. Create required directories & permissions
# ===============================
RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# ===============================
# 10. Nginx configuration (Railway compatible)
# ===============================
RUN printf 'server {\n\
    listen ${PORT};\n\
    server_name _;\n\
    root /var/www/public;\n\
    index index.php index.html;\n\
    charset utf-8;\n\
    location / {\n\
        try_files $uri $uri/ /index.php?$query_string;\n\
    }\n\
    location ~ \\.php$ {\n\
        include fastcgi_params;\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;\n\
    }\n\
    location ~ /\\. {\n\
        deny all;\n\
    }\n\
}\n' > /etc/nginx/conf.d/default.conf

# ===============================
# 11. Supervisor configuration
# ===============================
RUN printf '[supervisord]\n\
nodaemon=true\n\
\n\
[program:php-fpm]\n\
command=/usr/local/sbin/php-fpm -F\n\
autorestart=true\n\
stdout_logfile=/dev/stdout\n\
stderr_logfile=/dev/stderr\n\
\n\
[program:nginx]\n\
command=/usr/sbin/nginx -g "daemon off;"\n\
autorestart=true\n\
stdout_logfile=/dev/stdout\n\
stderr_logfile=/dev/stderr\n' > /etc/supervisor/conf.d/supervisord.conf

# ===============================
# 12. Entrypoint (migrate at runtime)
# ===============================
RUN printf '#!/bin/sh\n\
set -e\n\
\n\
echo "Running migrations..."\n\
php artisan migrate --force || true\n\
\n\
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf\n' > /entrypoint.sh \
    && chmod +x /entrypoint.sh

# ===============================
# 13. Expose Railway port
# ===============================
EXPOSE 8080

# ===============================
# 14. Start container
# ===============================
CMD ["/entrypoint.sh"]
