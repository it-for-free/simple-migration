FROM php:8.3.0-fpm-alpine3.19
 
RUN apk --no-cache update \
    && apk add --no-cache autoconf g++ make \
    postgresql-dev linux-headers
RUN pecl install xdebug-3.3.0 \
    && rm -rf /tmp/pear 
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    \
    && docker-php-ext-install pdo_pgsql
     
#composer
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
 
#codeception alias
RUN echo 'alias cept="./vendor/bin/codecept"' >> ~/.profile
 
WORKDIR /var/www