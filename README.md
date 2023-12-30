# Installing

## Setup

#### After clone project, run command below to `composer install`

    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs

#### Create .env

    cp .env.example .env


#### Start app

    ./vendor/bin/sail up

#### Key generate

    sail php artisan key:generate

#### Migrate

    sail php artisan migrate

#### Create user

    sail php artisan make:filament-user

## Usage

#### Start app

    ./vendor/bin/sail up

#### Website Url

    http://localhost:8080/admin
