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


# Set Apache DocumentRoot to Laravel public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -i -e 's|/var/www/html|${APACHE_DOCUMENT_ROOT}|g' /etc/apache2/sites-available/*.conf
RUN sed -i -e 's|/var/www/|${APACHE_DOCUMENT_ROOT}|g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf


# Install Node packages and build assets
RUN npm install
RUN npm run build

# Cleanup Node.js installation cache
RUN npm cache clean --force

