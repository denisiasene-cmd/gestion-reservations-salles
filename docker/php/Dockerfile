FROM php:8.3-fpm

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get update \
    && apt-get install -y unzip libzip-dev libxml2-dev libonig-dev \
    && docker-php-ext-install pdo_mysql zip mbstring xml

WORKDIR /var/www/html

COPY composer.json ./composer.json
COPY composer.lock ./composer.lock

RUN composer install

COPY . /var/www/html

CMD ["php-fpm"]