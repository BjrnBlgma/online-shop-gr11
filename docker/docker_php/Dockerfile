FROM php:8.1-fpm

RUN apt update -q &&  \
    apt install -q -y libpq-dev &&  \
    docker-php-ext-install pdo_pgsql pgsql;