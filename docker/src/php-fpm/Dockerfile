FROM php:7.4-fpm

RUN set -eux; \
    pecl channel-update pecl.php.net && \
    apt-get update; \
    apt-get upgrade -y; \
    apt-get install -y --no-install-recommends \
            apt-utils \
            curl \
            libmemcached-dev \
            libz-dev \
            libpq-dev \
            libjpeg-dev \
            libpng-dev \
            libfreetype6-dev \
            libssl-dev \
            libmcrypt-dev;

RUN set -eux; \
    # mysql
    docker-php-ext-install pdo_mysql; \
    docker-php-ext-install mysqli; \
    # zip
    apt-get install -yqq \
            libzip-dev \
            zip \
            unzip; \
    docker-php-ext-install zip; \
    php -m | grep -q 'zip';

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*; \
    rm /var/log/lastlog /var/log/faillog

RUN groupmod -o -g 82 www-data && \
    usermod -o -u 82 -g www-data www-data

WORKDIR /var/www
