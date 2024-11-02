<?php

declare(strict_types=1);

namespace App\Data\Currency;

use App\Enums\CurrencyEnum;
use Carbon\Carbon;

class CurrencyRateRequestData
{
    public function __construct(
        public Carbon $date,
        public string $currency,
        public ?string $baseCurrency = CurrencyEnum::DEFAULT->value
    ) {}

    public function toString(): string
    {
        return $this->date->toDateString() . $this->currency . $this->baseCurrency;
    }
}
