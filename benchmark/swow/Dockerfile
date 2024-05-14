FROM php:8.1-cli

WORKDIR /app/src

RUN apt-get update && apt-get install -y \
        git \
        unzip \
        zip 

COPY . /app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install && \
    ./vendor/bin/swow-builder --install && \
    echo "extension=swow.so" >> /usr/local/etc/php/conf.d/php.ini

CMD ["php", "index.php"]