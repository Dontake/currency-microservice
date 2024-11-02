<?php

namespace App\Providers;

use App\External\Services\Currency\Cbr\CbrCurrencyRateService;
use App\External\Services\Currency\CurrencyRateServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        CurrencyRateServiceInterface::class => CbrCurrencyRateService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
