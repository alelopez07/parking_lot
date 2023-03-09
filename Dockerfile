FROM php:8.0.0rc1-fpm

# composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# working directory
WORKDIR /var/www

# dependencies
RUN apt-get update && apt-get install -y \
    zip \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# extensions
RUN docker-php-ext-install pdo_mysql mbstring zip

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# user for application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY ./api /var/www

# Copy existing permissions from folder to docker
COPY --chown=www:www . /var/www
RUN chown -R www-data:www-data /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9002
CMD ["php-fpm"]
