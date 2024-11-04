<?php

declare(strict_types=1);

namespace App\Console\Commands\Currency;

use App\External\Exceptions\Currency\CurrencyRateException;
use App\Services\Currency\CurrencyRateService;
use Illuminate\Console\Command;

class FetchCurrencyRatesByPeriod extends Command
{
    protected $signature = 'currency:fetch-rates-by-period {days=180}';
    protected $description = 'Fetch currency rates by period';

    /**
     * @throws CurrencyRateException
     */
    public function handle(CurrencyRateService $rateService): void
    {
        $rateService->fetchRatesByPeriod(now()->subDays((int)$this->argument('days')), now());
    }
}
