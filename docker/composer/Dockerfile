FROM composer:2.6.5

RUN apk --update --no-cache add autoconf g++ make linux-headers \
    && pecl install -f xdebug-3.2.2 \
    && docker-php-ext-enable xdebug \
    && apk del --purge autoconf g++ make linux-headers


EXPOSE 9000