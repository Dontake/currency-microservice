<?php

declare(strict_types=1);

namespace App\External\Data\Currency;

use App\External\Data\DataInterface;
use Carbon\Carbon;

final class CurrencyRateData implements DataInterface
{
    public function __construct(
        public string $currency,
        public string $rate,
        public ?string $baseCurrency = null,
        public ?Carbon $rateDate = null,
        public ?string $differenceRate = null
    ) {}

    public function toArray(): array
    {
        return [
            'currency' => $this->currency,
            'baseCurrency' => $this->baseCurrency,
            'rate' => $this->rate,
            'differenceRate' => $this->differenceRate,
            'rateDate' => $this->rateDate,
        ];
    }
}
