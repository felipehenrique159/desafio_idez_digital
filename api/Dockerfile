FROM php:8.3-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    autoconf \
    build-essential \
    apt-utils \
    zlib1g-dev \
    libzip-dev \
    unzip \
    zip \
    libmagick++-dev \
    libmagickwand-dev \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    supervisor \
    curl \
 && mkdir -p /var/log/supervisor \
 && pecl install redis \
 && docker-php-ext-enable redis \
 && docker-php-ext-configure gd --with-freetype --with-jpeg=/usr/include/ --enable-gd \
 && docker-php-ext-install gd intl pdo_mysql mysqli zip \
 && pecl install imagick \
 && docker-php-ext-enable imagick \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN mkdir -p /var/www/storage \
 && chown -R root:www-data /var/www/storage \
 && chmod -R 775 /var/www/storage

WORKDIR /var/www