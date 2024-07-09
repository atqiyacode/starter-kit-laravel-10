# Base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Set alias
RUN echo "alias pamfs='php artisan migrate:fresh --seed'" >> ~/.bashrc
RUN echo "alias paq='php artisan queue:work'" >> ~/.bashrc
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
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath opcache -j$(nproc) gd

# Install Redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy source code
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage

# Set the memory limit
RUN echo "memory_limit=2048M" > /usr/local/etc/php/conf.d/docker-php-memory-limit.ini

# Run entrypoint
COPY entrypoint.sh /usr/local/bin/
RUN chmod u+x /usr/local/bin/entrypoint.sh

# Expose port
EXPOSE 9000
EXPOSE 8000
EXPOSE 8080

# Set entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Start PHP-FPM server
CMD ["php-fpm"]
