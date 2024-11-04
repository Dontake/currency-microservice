<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Commands

#### Prepare for usage sail

````
docker run --rm --interactive --tty \
  --volume $PWD:/app \
  --user $(id -u):$(id -g) \
  composer install --ignore-platform-reqs
````

````
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
````

````
sail artisan sail:publish
````
#### Copy .env.example to .env

#### App start
````
sail up -d
````

#### Bash into container
````
sail shell
````
#### Migrate db tables
````
php artisan migrate
````
#### Start consuming
````
php artisan rabbitmq:consume
````

#### Seed database
````
php artisan db:seed
````

## Usage


#### Command for fetch currency rates by period (last 180 days)
````
php artisan currency:fetch-rates-by-period
````

### RabbitMQ

#### Queue name
````
get-currency
````

#### Consumer job class
````
app/Jobs/Currency/RequestCurrencyRate.php
````

#### Publisher job class
````
app/Jobs/Currency/ResponseCurrencyRate.php
````
