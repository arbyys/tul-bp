FROM php:8.1-cli

WORKDIR /app/src

RUN apt-get update && apt-get install -y \
        git \
        unzip \
        zip 

COPY . /app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install && \
     docker-php-ext-configure pcntl --enable-pcntl && \
     docker-php-ext-install pcntl

CMD ["php", "index.php", "start"]