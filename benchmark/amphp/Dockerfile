FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
    curl unzip 

WORKDIR /app/src

COPY /src .

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --ignore-platform-reqs

CMD ["php", "index.php"]