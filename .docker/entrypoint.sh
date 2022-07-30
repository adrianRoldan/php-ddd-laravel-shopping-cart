#!/usr/bin/env bash

# Create config file
cp .env.example .env

# Install all project dependencies
composer install

# Generate the laravel application key
php artisan key:generate

# Create databse migrations and populate with some data
php artisan migrate --seed

#start php-fpm server
php-fpm


