FROM php:8.1-fpm

RUN apt-get update \
    && apt-get install -y \
        zlib1g-dev \
        g++ \
        git \
        libicu-dev \
        zip \
        file \
        libzip-dev \
        zip \
        wget \
		libgmp-dev \
    && docker-php-ext-install \
        intl \
        opcache \
        pdo pdo_mysql \
    && yes | pecl install apcu xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install gmp \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

WORKDIR /app
