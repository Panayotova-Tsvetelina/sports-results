# Use the PHP 8.1 Apache image as the base image
FROM php:8.1-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Install necessary dependencies (PHP extensions for Laravel)
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    zip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Allow .htaccess overrides for Laravel (this step ensures .htaccess works properly)
RUN echo '<Directory /var/www/html/public>' >> /etc/apache2/apache2.conf
RUN echo '    AllowOverride All' >> /etc/apache2/apache2.conf
RUN echo '</Directory>' >> /etc/apache2/apache2.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Laravel project into the container
COPY . .

# Set the correct permissions for the Laravel directories
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]

