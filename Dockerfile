# =========================
# Base Image with PHP-FPM
# =========================
FROM php:8.2-fpm

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
    nginx \
    supervisor \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
    && rm -rf /var/lib/apt/lists/*

# =========================
# Install Composer
# =========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# =========================
# Install Node.js 22
# =========================
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# =========================
# Set Working Directory
# =========================
WORKDIR /app

# =========================
# Copy Composer Files
# =========================
COPY composer.json composer.lock ./
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
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data /app

# =========================
# Create .env
# =========================
RUN touch .env

# =========================
# Nginx Configuration
# =========================
RUN rm -f /etc/nginx/sites-enabled/default && \
    rm -f /etc/nginx/sites-available/default

COPY <<'EOF' /etc/nginx/sites-available/default
server {
    listen ${PORT};
    root /app/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# =========================
# Supervisor Configuration
# =========================
COPY <<'EOF' /etc/supervisor/conf.d/supervisord.conf
[supervisord]
nodaemon=true
user=root
logfile=/dev/stdout
logfile_maxbytes=0

[program:php-fpm]
command=/usr/local/sbin/php-fpm
autostart=true
autorestart=true
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0

[program:nginx]
command=/bin/bash -c "envsubst '$$PORT' < /etc/nginx/sites-available/default | tee /etc/nginx/sites-enabled/default > /dev/null && nginx -g 'daemon off;'"
autostart=true
autorestart=true
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
EOF

# =========================
# Start Application
# =========================
CMD php artisan config:clear && \
    php artisan cache:clear && \
    echo "Waiting for database..." && \
    timeout 60 bash -c 'until php artisan migrate:status 2>/dev/null; do echo "Retrying..."; sleep 3; done' && \
    php artisan migrate --force && \
    php artisan config:cache && \
    echo "Starting services on port ${PORT}..." && \
    /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf