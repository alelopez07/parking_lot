FROM php:8.1.0-fpm

# working directory
WORKDIR /var/www

# dependencies
RUN apt-get update && apt-get install -y \
    zip \
    vim \
    unzip \
    git \
    curl

# clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# extensions
RUN docker-php-ext-install pdo_mysql

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# user for application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# copy existing application directory contents
COPY ./api /var/www

# copy existing permissions from folder to docker
COPY --chown=www:www . /var/www
RUN chown -R www-data:www-data /var/www

# change current user to www
USER www

# expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
