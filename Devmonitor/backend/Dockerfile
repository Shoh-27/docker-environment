FROM php:8.3-fpm-alpine

LABEL maintainer="DevMonitor Team"
LABEL version="1.0"

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apk add --no-cache \
    postgresql-dev \
    postgresql-client \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    libzip-dev \
    linux-headers \
    autoconf \
    g++ \
    make \
    nodejs \
    npm \
    bash \
    vim \
    shadow

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    opcache \
    sockets

# Install Redis extension
RUN pecl install redis-6.0.2 \
    && docker-php-ext-enable redis

# Install and enable OPcache for better performance
RUN docker-php-ext-enable opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set PHP configuration for production
RUN { \
    echo 'opcache.memory_consumption=256'; \
    echo 'opcache.interned_strings_buffer=16'; \
    echo 'opcache.max_accelerated_files=10000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.enable_cli=1'; \
    echo 'opcache.validate_timestamps=1'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

# Custom PHP configuration
RUN { \
    echo 'memory_limit=512M'; \
    echo 'upload_max_filesize=20M'; \
    echo 'post_max_size=20M'; \
    echo 'max_execution_time=300'; \
    echo 'max_input_time=300'; \
    echo 'date.timezone=Asia/Tashkent'; \
    echo 'expose_php=Off'; \
    } > /usr/local/etc/php/conf.d/custom.ini

# Copy application files
COPY --chown=www-data:www-data . /var/www

# Install PHP dependencies
RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader

# Install Node dependencies for Laravel Mix/Vite
RUN npm install --omit=dev

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Set proper permissions
RUN chown -R www-data:www-data /var/www \
    && find /var/www -type f -exec chmod 644 {} \; \
    && find /var/www -type d -exec chmod 755 {} \; \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Create necessary directories
RUN mkdir -p /var/www/storage/framework/{sessions,views,cache} \
    && mkdir -p /var/www/storage/logs \
    && mkdir -p /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=60s --retries=3 \
    CMD php artisan schedule:run --verbose --no-interaction || exit 1

# Switch to www-data user
USER www-data

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
