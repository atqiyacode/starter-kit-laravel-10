# Base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Set alias
RUN echo "alias pamfs='php artisan migrate:fresh --seed'" >> ~/.bashrc
RUN echo "alias paq='php artisan queue:work --tries=10 --timeout=3000 --memory=8000'" >> ~/.bashrc
RUN echo "alias paw='php artisan websockets:serve'" >> ~/.bashrc
RUN echo "alias pa='php artisan'" >> ~/.bashrc

# Install dependencies
RUN apt-get update && apt-get install -y \
    procps \
    cron\
    vim \
    nano \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    zlib1g-dev \
    g++ \
    gnupg \
    supervisor \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install zip pdo_mysql pdo_pgsql mbstring exif pcntl bcmath opcache intl gd -j$(nproc) gd

# Install Swoole extensio
RUN pecl install redis swoole \
    && docker-php-ext-enable redis swoole

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy source code
COPY . .

# Install dependencies
RUN composer install

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage

# Set the memory limit
RUN echo "memory_limit=4096M" > /usr/local/etc/php/conf.d/docker-php-memory-limit.ini

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["php-fpm"]
