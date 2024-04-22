# Use the official PHP image with Apache
FROM php:8.3.0-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Enable Apache modules
RUN a2enmod rewrite

# Get Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Copy application code, respecting .dockerignore
COPY . /var/www/html

# Fix permissions
RUN chmod -R 777 /var/www/html
# Install Composer dependencies
RUN composer install --optimize-autoloader --no-dev
