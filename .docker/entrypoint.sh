#!/usr/bin/env bash

# Config and Install project dependencies
cp .env.example .env
composer install
php artisan key:generate

#start php-fpm server
php-fpm


