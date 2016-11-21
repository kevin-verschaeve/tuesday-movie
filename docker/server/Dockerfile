FROM php:7-apache

ENV DOCKERIZE_VERSION v0.2.0

RUN apt-get update && \
    apt-get install -y \
        git \
        wget \
        libicu-dev \
        libmcrypt-dev \
        libpng-dev \
        libcurl3-dev \
        libxml2-dev \
        libjpeg-dev \
        libpng-dev \
        libssl-dev \
        libjpeg62-turbo-dev && \
    docker-php-ext-configure intl gd --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install mbstring pdo_mysql intl mcrypt zip gd exif && \
    curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin && \
    apt-get clean && \
    rm -rf /var/lib/lists/*

RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz && \
    tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

COPY php.ini /usr/local/etc/php/php.ini
COPY app.conf /etc/apache2/sites-available/app.conf
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

RUN a2dissite 000-default.conf && \
    a2ensite app.conf && \
    a2enmod rewrite

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
