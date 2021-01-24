FROM php:apache

ARG PROJECT_DIR=/opt/project

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get -y install --no-install-recommends \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo_mysql

COPY . ${PROJECT_DIR}
WORKDIR ${PROJECT_DIR}

RUN composer install
# FIXME --no-dev causes problems :(
# --no-dev --optimize-autoloader

RUN rm -drf /var/www/html \
    && ln -s ${PROJECT_DIR}/public/ /var/www/html

EXPOSE 80
