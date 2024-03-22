FROM php:8.2-fpm-alpine3.17

WORKDIR /var/www/html

COPY . /var/www/html



RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000
