
FROM php:7.2-fpm

COPY . /var/www

WORKDIR /var/www

RUN apt-get update && apt-get install --assume-yes zlib1g-dev
RUN apt-get install --assume-yes --no-install-recommends libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql zip bcmath

RUN apt-get --assume-yes install git
RUN apt-get install unzip

RUN curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer

CMD composer install --working-dir=/var/www && php artisan key:generate && php-fpm
