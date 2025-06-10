FROM php:8.3-fpm

USER root
ENV USER=root
ENV PHP_EXTRA_CONFIGURE_ARGS="--enable-fpm --with-fpm-user=root --with-fpm-group=root"
RUN apt-get update && apt-get install -y \
        libzip-dev \
        zlib1g-dev \
        libicu-dev \
        g++ \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv mysqli pdo_mysql zip bcmath \
    #mcrypt
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install opcache \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www
