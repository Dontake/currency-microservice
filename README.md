<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Commands

#### Prepare for usage
````
alias sail='vendor/bin/sail'
````

#### App start
````
sail up
````
````
sail shell
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
