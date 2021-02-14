FROM php:8.0-cli
RUN apt update \
    && pecl install xdebug-3.0.2 \
    && docker-php-ext-enable xdebug
