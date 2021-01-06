FROM php:apache

ARG PROJECT_DIR=/var/www/html/

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get -y install --no-install-recommends \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo_mysql

COPY . ${PROJECT_DIR}
WORKDIR ${PROJECT_DIR}

RUN composer install --no-dev

EXPOSE 80
