FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    supervisor \
    nginx

# Install Node.js 22
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
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

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . /var/www

# Create nginx config inline
RUN echo 'server {\n\
    listen 80;\n\
    listen [::]:80;\n\
    server_name _;\n\
    root /var/www/public;\n\
    add_header X-Frame-Options "SAMEORIGIN";\n\
    add_header X-Content-Type-Options "nosniff";\n\
    index index.php;\n\
    charset utf-8;\n\
    location / {\n\
        try_files $uri $uri/ /index.php?$query_string;\n\
    }\n\
    location = /favicon.ico { access_log off; log_not_found off; }\n\
    location = /robots.txt  { access_log off; log_not_found off; }\n\
    error_page 404 /index.php;\n\
    location ~ \.php$ {\n\
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;\n\
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;\n\
        include fastcgi_params;\n\
        fastcgi_hide_header X-Powered-By;\n\
    }\n\
    location ~ /\.(?!well-known).* {\n\
        deny all;\n\
    }\n\
}' > /etc/nginx/sites-available/default

# Create supervisord config inline
RUN echo '[supervisord]\n\
nodaemon=true\n\
user=root\n\
logfile=/var/log/supervisor/supervisord.log\n\
pidfile=/var/run/supervisord.pid\n\
\n\
[program:php-fpm]\n\
command=/usr/local/sbin/php-fpm -F\n\
stdout_logfile=/dev/stdout\n\
stdout_logfile_maxbytes=0\n\
stderr_logfile=/dev/stderr\n\
stderr_logfile_maxbytes=0\n\
autorestart=true\n\
startretries=3\n\
\n\
[program:nginx]\n\
command=/usr/sbin/nginx -g "daemon off;"\n\
stdout_logfile=/dev/stdout\n\
stdout_logfile_maxbytes=0\n\
stderr_logfile=/dev/stderr\n\
stderr_logfile_maxbytes=0\n\
autorestart=true\n\
startretries=3' > /etc/supervisor/conf.d/supervisord.conf

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Install Node dependencies and build
RUN npm ci && npm run build

# Clean up node_modules after build
RUN npm prune --omit=dev

# Create required directories
RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/framework/testing \
    storage/logs \
    bootstrap/cache

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Laravel optimization (skip route cache karena ada konflik)
RUN php artisan config:cache \
    && php artisan event:cache \
    && php artisan view:cache

# Expose port
EXPOSE 80

# Create entrypoint script
RUN echo '#!/bin/bash\n\
set -e\n\
\n\
echo "Waiting for database..."\n\
until php artisan migrate --force 2>/dev/null; do\n\
  echo "Database is unavailable - sleeping"\n\
  sleep 2\n\
done\n\
\n\
echo "Running migrations..."\n\
php artisan migrate --force\n\
\n\
echo "Starting supervisord..."\n\
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf\n\
' > /entrypoint.sh && chmod +x /entrypoint.sh

# Start with entrypoint
CMD ["/entrypoint.sh"]