<?php

declare(strict_types=1);

namespace Services\Currency;

use App\Data\Currency\CurrencyRateRequestData;
use App\External\Services\Currency\Cbr\CbrCurrencyRateService;
use App\Jobs\Currency\ResponseCurrencyRate;
use App\Services\Currency\CurrencyRateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CurrencyRateServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CurrencyRateService $currencyRateService;

    public function setUp(): void
    {
        parent::setUp();
        Queue::fake();

        $this->currencyRateService = new CurrencyRateService(new CbrCurrencyRateService());
    }

    public function testHandleOk(): void
    {
        $requestData = new CurrencyRateRequestData(now(), 'USD');

        $this->currencyRateService->handle($requestData);

        $this->assertDatabaseHas('currency_rate_logs', ['currency' => $requestData->currency]);
        Queue::assertPushed(ResponseCurrencyRate::class);
    }
}
