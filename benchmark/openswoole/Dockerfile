FROM php:8.1-cli

RUN pecl install openswoole \
    && docker-php-ext-enable openswoole

COPY src/index.php /var/www/html/index.php

WORKDIR /var/www/html

CMD ["php", "index.php"]