FROM php:7.3-apache as php-runtime

RUN apt-get update && apt-get upgrade -y
RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev
RUN docker-php-ext-install bcmath pdo_mysql zip

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# Apache Configuration
RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
COPY ./docker/api/apache2/sites-enabled/000-default.conf /etc/apache2/sites-enabled/000-default.conf

FROM php-runtime as dev
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
RUN apt-get install -y \
    unzip \
    vim \
    redis
