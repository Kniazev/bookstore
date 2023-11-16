ARG PHP_VERSION=7.4

FROM php:${PHP_VERSION}-fpm-alpine

RUN apk add --update \
    zip \
    unzip \
    curl \
    nodejs \
    yarn

RUN apk add --no-cache libpq-dev && docker-php-ext-install pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    ln -s $(composer config --global home) /root/composer
ENV PATH=$PATH:/root/composer/vendor/bin COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]