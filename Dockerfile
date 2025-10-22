FROM php:8.2-fpm-alpine

# Устанавливаем системные зависимости
RUN apk update && apk add --no-cache \
    git \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libxml2-dev

# Устанавливаем PHP расширения
RUN docker-php-ext-install \
    pdo_mysql \
    mysqli \
    gd \
    xml \
    mbstring \
    json \
    zip

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
