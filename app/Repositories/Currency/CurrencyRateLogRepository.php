<?php

declare(strict_types=1);

namespace App\Repositories\Currency;

use App\External\Data\Currency\CurrencyRateData;
use App\Models\Currency\CurrencyRateLog;

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
}
