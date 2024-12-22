# Use the PHP 8.1 Apache image as the base image
FROM php:8.1-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Install necessary dependencies (PHP extensions for Laravel)
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    zip git curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Laravel project into the container
COPY . .

# Install Node.js and npm (use Node.js v18)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Create build directory and set permissions
RUN mkdir -p /var/www/html/public/build && \
    chown -R www-data:www-data /var/www/html/public/build && \
    chmod -R 775 /var/www/html/public/build

# Copy package.json and package-lock.json
COPY package.json package-lock.json ./

# Install npm dependencies and build Vite assets
RUN npm install && npm run build

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Set the server name to suppress warnings
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy the virtual host configuration
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Set the correct permissions for the Laravel directories
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
