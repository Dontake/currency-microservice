<?php

declare(strict_types=1);

namespace App\Jobs\Currency;

use App\External\Exceptions\Currency\CurrencyRateException;
use App\Services\Currency\CurrencyRateService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

final class FetchCurrencyRate implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Carbon $date,
    ) {}

    /**
     * @throws CurrencyRateException
     */
    public function handle(CurrencyRateService $currencyRateService): void
    {
        $currencyRateService->getRatesOnDate($this->date);
    }
}
