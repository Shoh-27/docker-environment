FROM php:8.2-cli

# Install system dependencies for PHP and databases
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libssl-dev \
    pkg-config \
    unzip \
    git \
    libcurl4-openssl-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js and NPM
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# Set working directory
WORKDIR /var/www/html

# Install Laravel 11
RUN composer create-project --prefer-dist laravel/laravel tmp "11.*" \
    && cp -r tmp/. . \
    && rm -rf tmp

# Install jenssegers/mongodb package
RUN composer require jenssegers/mongodb

# Update app name to DataSyncHub
RUN sed -i "s|'name' => 'Laravel'|'name' => 'DataSyncHub'|g" config/app.php

# Expose port
EXPOSE 8000
