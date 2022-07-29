FROM php:8.1-fpm

# Copy composer.lock and composer.json and .env
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    wget \
    zip \
    libzip-dev \
    libicu-dev \
    zlib1g-dev \
    libmagickwand-dev \
    libsqlite3-dev \
    sqlite3 \
    npm \
    g++
RUN apt-get install libcurl4-openssl-dev
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install soap
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install curl
RUN docker-php-ext-install xml

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

RUN pecl install imagick
RUN docker-php-ext-enable imagick

RUN docker-php-ext-install pdo_sqlite
RUN docker-php-ext-enable pdo_sqlite

RUN docker-php-ext-install gettext

RUN rm -rf /tmp/pear

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY ./.docker/entrypoint.sh /entrypoint.sh
RUN chmod 755 /entrypoint.sh

# Copy existing application directory content with permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Expose port 9000 and execute starting bins
EXPOSE 9000
CMD ["/entrypoint.sh"]
