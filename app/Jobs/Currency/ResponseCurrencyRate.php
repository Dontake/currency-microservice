<?php

declare(strict_types=1);

namespace App\Jobs\Currency;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

final class ResponseCurrencyRate implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public array $data
    ) {}
}
