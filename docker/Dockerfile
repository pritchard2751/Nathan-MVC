FROM php:7.2-apache as base

COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf

COPY . /var/www

RUN chown -R www-data:www-data /var/www

FROM composer:1.9 as vendor

WORKDIR /app

COPY composer.json /app
COPY composer.lock /app

RUN composer install --no-dev --no-scripts --no-suggest --prefer-dist --optimize-autoloader

COPY . /app

RUN composer dump-autoload --no-dev --optimize --classmap-authoritative

FROM base as prod

COPY --from=vendor /app/vendor/ /var/www/vendor

