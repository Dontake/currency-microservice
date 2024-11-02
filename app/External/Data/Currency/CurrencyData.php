<?php

declare(strict_types=1);

namespace App\External\Data\Currency;

use App\External\Data\DataInterface;

class CurrencyData implements DataInterface
{
    public function __construct(
        public string $currencyCode,
        public string $externalCurrencyCode,
    ) {}

    public function toArray(): array
    {
        return [
            $this->externalCurrencyCode => $this->currencyCode
        ];
    }
}
