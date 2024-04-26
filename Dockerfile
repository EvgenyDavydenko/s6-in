# Use the official PHP image as the base image
FROM php:8.2.16-cli-bookworm

RUN apt update
RUN apt install -y git zip curl

RUN docker-php-ext-install pdo_mysql

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# install symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/html

COPY . /var/www/html
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer install
