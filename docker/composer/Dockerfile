FROM composer:2.3

RUN apk --update --no-cache add autoconf g++ make \
    && pecl install -f xdebug-3.1.4 \
    && docker-php-ext-enable xdebug \
    && apk del --purge autoconf g++ make


EXPOSE 9000