FROM php:8.1-cli

RUN pecl install swoole \
    && docker-php-ext-enable swoole

COPY src/index.php /var/www/html/index.php

WORKDIR /var/www/html

CMD ["php", "index.php"]