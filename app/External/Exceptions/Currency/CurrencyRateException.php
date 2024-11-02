<?php

declare(strict_types=1);

namespace App\External\Exceptions\Currency;

use App\Exceptions\BaseException;

class CurrencyRateException extends BaseException
{
    public function __construct(?string $message = null)
    {
        parent::__construct(
            __($message ?? 'Currency rate sync failed!'),
            400
        );
    }
}
