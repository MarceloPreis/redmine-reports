# Use an official PHP runtime
FROM php:8.2-apache
# Enable Apache modules
RUN a2enmod rewrite

# Set the working directory to /var/www/html
WORKDIR /var/www/html
# Copy the source code in /www into the container at /var/www/html
COPY ../www .

RUN apt-get update && apt-get install -y \
    zip \
    unzip \ 
    git \ 
    && docker-php-ext-install pdo pdo_mysql
    
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
