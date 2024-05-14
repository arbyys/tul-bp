FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
        libevent-dev \
        openssl \
        libssl-dev \
        zip \
    && docker-php-ext-install sockets \
    && pecl install event \
    && docker-php-ext-enable --ini-name zz-event.ini event

WORKDIR /app/src

COPY . /app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --ignore-platform-reqs

CMD ["php", "index.php"]