<?php

declare(strict_types=1);

namespace App\Jobs\Currency;

use App\Data\Currency\CurrencyRateRequestData;
use App\Services\Currency\CurrencyRateService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

final class RequestCurrencyRate implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public array $data
    ) {}

    public function handle(CurrencyRateService $currencyRateService): void
    {
        $data = $this->data;

        if (!$this->validate()) {
            ResponseCurrencyRate::dispatch(['error' => 'Validation error']);
        }

        $currencyRateService->handle(new CurrencyRateRequestData(
            Carbon::make($data['date']),
            $data['currency'],
            $data['baseCurrency'] ?? null
        ));
    }

    private function validate(): bool
    {
        return (isset($this->data['date'], $this->data['currency']) || !empty($this->data));
    }
}
