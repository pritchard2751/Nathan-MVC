FROM php:7.2-apache

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/

RUN chown -R www-data:www-data /var/www

CMD ["apache2-foreground"]




