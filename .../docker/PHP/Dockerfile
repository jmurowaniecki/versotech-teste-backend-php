FROM php:8.4-fpm-alpine

ARG UID=1000
ARG GID=1000

WORKDIR /var/www/html

RUN apk add --no-cache sqlite sqlite-libs libzip

RUN apk add --no-cache --virtual .build-deps sqlite-dev libzip-dev \
  && docker-php-ext-install pdo pdo_sqlite \
  && apk del .build-deps \
  && rm -rf /var/cache/apk/* \
  && which sqlite3 \
  && sqlite3 --version

RUN addgroup -g ${GID}  --system laravel \
  && adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel \
  && chown   -R laravel:laravel /var/www/html

COPY --from=composer:2.9 /usr/bin/composer /usr/local/bin/composer

COPY www.conf /usr/local/etc/php-fpm.d/www.conf

RUN sed -i 's|^;*error_log =.*|error_log = /proc/self/fd/2|' /usr/local/etc/php-fpm.conf

USER laravel

CMD ["php-fpm", "-F"]

HEALTHCHECK \
    --interval=30s \
    --timeout=3s \
    CMD php-fpm -t || exit 1
