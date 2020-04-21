FROM php:7.2-apache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/

RUN chown -R www-data:www-data /var/www

CMD ["apache2-foreground"]




