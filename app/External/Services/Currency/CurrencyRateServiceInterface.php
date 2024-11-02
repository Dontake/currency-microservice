<?php

declare(strict_types=1);

namespace App\External\Services\Currency;

use App\External\Data\Currency\CurrencyData;
use App\External\Data\Currency\CurrencyRateData;
use App\External\Exceptions\Currency\CurrencyRateException;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface CurrencyRateServiceInterface
{
    /**
     * @throws CurrencyRateException
     * @return Collection<CurrencyData>
     */
    public function availableCurrencies(): Collection;

    /**
     * @throws CurrencyRateException
     * @return Collection<CurrencyRateData>
     */
    public function getDynamic(Carbon $from, Carbon $to, CurrencyData $currencyData): Collection;

    /**
     * @throws CurrencyRateException
     * @return Collection<CurrencyRateData>
     */
    public function onDate(Carbon $date): Collection;
}
