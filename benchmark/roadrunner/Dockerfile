FROM ghcr.io/roadrunner-server/roadrunner:2023.3.12 AS roadrunner
FROM php:8.1-cli

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

COPY --from=roadrunner /usr/bin/rr /usr/local/bin/roadrunner

WORKDIR /var/www/html
COPY /src /var/www/html

RUN apt-get update && apt-get install -y \
        zip \
        unzip \
    && composer install --ignore-platform-reqs

CMD ["roadrunner", "serve", "-c", ".rr.yaml"]