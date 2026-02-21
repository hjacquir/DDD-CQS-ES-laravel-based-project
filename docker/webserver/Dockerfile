FROM node:22.19.0 AS node
FROM php:8.4-apache

ARG DEBIAN_FRONTEND=noninteractive

# Update
RUN apt-get -y update --fix-missing && \
    apt-get upgrade -y && \
    apt-get --no-install-recommends install -y apt-utils && \
    apt-get clean

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install useful tools and install important libaries
RUN apt-get -y --no-install-recommends install nano wget libsqlite3-dev libsqlite3-0 && \
    apt-get -y --no-install-recommends install zlib1g-dev libzip-dev libicu-dev && \
    apt-get -y --no-install-recommends install --fix-missing build-essential git curl acl openssh-client rsync tzdata libonig-dev && \
    apt-get install -y iputils-ping && \
    apt-get -y --no-install-recommends install --fix-missing libcurl4 libcurl4-openssl-dev zip openssl && \
    apt-get clean

# Install Freetype
RUN apt-get -y update && \
    apt-get --no-install-recommends install -y libfreetype6-dev libwebp-dev libjpeg62-turbo-dev libpng-dev && \
    apt-get clean && \
    docker-php-ext-configure gd --enable-gd --with-freetype --with-webp --with-jpeg && \
    docker-php-ext-install gd

# Install xdebug
RUN pecl install xdebug-3.4.2 && \
    docker-php-ext-enable xdebug && \
    mkdir /var/log/xdebug && \
    mkdir -p /usr/local/etc/php/disabled && \
    mv /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/disabled

# PHP8 Extensions
RUN docker-php-ext-install zip

# Install OPCACHE
RUN docker-php-ext-install opcache
COPY conf.d/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Install node, npm
COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# Ajout des fichiers de configs
COPY conf.d/apache2/sites-available/ /etc/apache2/sites-available/

# Insure an SSL directory exists
RUN mkdir -p /etc/apache2/ssl

# Enable SSL support
RUN a2enmod ssl && a2enmod rewrite

# Activation des sites
RUN a2ensite localhost.conf

# Enable apache modules
RUN a2enmod rewrite headers
