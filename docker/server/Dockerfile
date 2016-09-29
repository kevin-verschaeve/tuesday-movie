FROM php:7-apache

RUN apt-get update && \
    apt-get install -y libicu-dev libmcrypt-dev libpng-dev libcurl3-dev libxml2-dev libjpeg-dev libpng-dev libssl-dev libjpeg62-turbo-dev && \
    docker-php-ext-configure intl && \
    docker-php-ext-configure gd --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install mbstring pdo_mysql intl mcrypt gd exif

COPY php.ini /usr/local/etc/php/php.ini
COPY app.conf /etc/apache2/sites-available/app.conf
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

RUN a2dissite 000-default.conf && \
    a2ensite app.conf && \
    a2enmod rewrite

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
