FROM gitpod/workspace-full

ENV EXT_APCU_VERSION=5.1.19

RUN docker-php-source extract \
    && mkdir -p /usr/src/php/ext/apcu \
    && curl -fsSL https://github.com/krakjoe/apcu/archive/v$EXT_APCU_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/apcu --strip 1 \
    && docker-php-ext-install apcu curl json intl gd xml opcache dom \
    && docker-php-source delete
