<?php

declare(strict_types=1);

namespace App\Console\Commands\Currency;

use App\Jobs\Currency\FetchCurrencyRate;
use Illuminate\Console\Command;

class FetchCurrencyRatesByPeriod extends Command
{
    protected $signature = 'currency:fetch-rates-by-period {days=180}';
    protected $description = 'Fetch currency rates by period';

    public function handle(): void
    {
        FetchCurrencyRate::dispatch(now(), now()->subDays((int)$this->argument('days')));
    }
}
