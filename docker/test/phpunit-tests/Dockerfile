## build context is at docker/
FROM php:8.2-cli
WORKDIR /var/www/html

# install dependencies
RUN set -ex; \
    apt-get update && \
    apt-get -y --no-install-recommends install \
    $PHPIZE_DEPS \
    git \
    unzip

# use the mlocati/docker-php-extension-installer to install necessary packages and php extensions
# the installer cleans up all dev packages which were only used for compiling
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions \
    apcu \
    xdebug \
    zip

# install composer
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"
COPY --from=composer/composer:2-bin /composer /usr/bin/composer

RUN addgroup --gid 1000 php
RUN adduser --ingroup php --shell /bin/sh php
USER php

VOLUME /var/www/html
