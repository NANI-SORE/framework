FROM composer:1.9
ENV COMPOSER_ALLOW_SUPERUSER 1
WORKDIR /app
COPY composer.json composer.json
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader && rm -rf /root/.composer
COPY . ./
RUN composer dump-autoload --no-scripts --no-dev --optimize