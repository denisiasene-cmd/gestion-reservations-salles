FROM php:8.3-fpm

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get update \
    && apt-get install -y \
        unzip \
        libzip-dev \
        libxml2-dev \
        libonig-dev \
        nginx \
        gettext-base \
    && docker-php-ext-install pdo_mysql zip mbstring xml \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

ENV PORT=10000

COPY composer.json ./composer.json
COPY composer.lock ./composer.lock

RUN composer install --no-interaction --prefer-dist

COPY . /var/www/html

COPY docker/nginx/render.conf /etc/nginx/conf.d/default.conf

EXPOSE 10000

CMD ["sh", "-c", "envsubst '${PORT}' < /etc/nginx/conf.d/default.conf > /tmp/default.conf && mv /tmp/default.conf /etc/nginx/conf.d/default.conf && php-fpm -D && nginx -g 'daemon off;'"]