<?php

declare(strict_types=1);

namespace App\Repositories\Currency;

use App\External\Data\Currency\CurrencyRateData;
use App\Models\Currency\CurrencyRateLog;
use Illuminate\Support\Collection;

class CurrencyRateLogRepository
{
    /**
     * @throws \Throwable
     */
    public static function save(CurrencyRateData $data): void
    {
        $log = new CurrencyRateLog;

        $log->rate = $data->rate;
        $log->currency = $data->currency;
        $log->base_currency = $data->baseCurrency;
        $log->rate_date = $data->rateDate;

        $log->saveOrFail();
    }

    /**
     * @param Collection<CurrencyRateData> $rates
     * @throws \Throwable
     */
    public static function saveBatch(Collection $rates): void
    {
        $rates->each(static function (CurrencyRateData $currencyRate) {
            self::save($currencyRate);
        });
    }
}
