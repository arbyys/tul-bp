FROM dunglas/frankenphp:1.1.2-php8.2.17

WORKDIR /app

ENV SERVER_NAME=0.0.0.0:8010

COPY /src/index.php public/index.php

COPY /src/Caddyfile /etc/caddy/Caddyfile

ENV FRANKENPHP_CONFIG="worker public/index.php"
