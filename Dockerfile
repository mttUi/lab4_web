FROM php:8.2-fpm-alpine

# Устанавливаем системные зависимости ДО установки расширений
RUN apk update && apk add --no-cache \
    git \
    unzip \
    curl \
    libzip-dev \
    zip \
    libpng-dev \
    libxml2-dev \
    oniguruma-dev \
    freetype-dev \
    jpeg-dev

# Устанавливаем PHP расширения по одному с проверкой
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install xml
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
