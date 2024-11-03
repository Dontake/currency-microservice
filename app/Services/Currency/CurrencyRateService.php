<?php

declare(strict_types=1);

namespace App\Services\Currency;

use App\Data\Currency\CurrencyRateRequestData;
use App\Enums\CurrencyEnum;
use App\External\Data\Currency\CurrencyRateData;
use App\External\Exceptions\Currency\CurrencyRateException;
use App\External\Services\Currency\CurrencyRateServiceInterface;
use App\Jobs\Currency\ResponseCurrencyRate;
use App\Repositories\Currency\CurrencyRateLogRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Throwable;

class CurrencyRateService
{
    public function __construct(
        protected CurrencyRateServiceInterface $externalService
    ) {}

    public function handle(CurrencyRateRequestData $requestData): void
    {
        try {
            $this->validate($requestData);

            $currencyRate = $this->getDynamicRate($requestData);

            CurrencyRateLogRepository::save($currencyRate);

            ResponseCurrencyRate::dispatch($currencyRate->toArray());
        } catch (Throwable $exception) {
            ResponseCurrencyRate::dispatch(['error' => $exception->getMessage()]);
        }
    }

    /**
     * @throws CurrencyRateException
     */
    public function fetchRatesByPeriod(Carbon $from, Carbon $to): void
    {
        $externalService = $this->externalService;

        Cache::get($from->toDateString().$to->toDateString(), static function () use ($from, $to, $externalService) {
            foreach (CarbonPeriod::dates($from, $to)->toArray() as $date) {
                sleep(1);
                CurrencyRateLogRepository::saveBatch($externalService->onDate($date->toMutable()));
            }
        });
    }

    /**
     * @throws CurrencyRateException
     */
    protected function validate(CurrencyRateRequestData $requestData): void
    {
        if ($requestData->baseCurrency !== CurrencyEnum::DEFAULT->value) {
            throw new CurrencyRateException('This base currency is not supported!');
        }
    }

    /**
     * @throws CurrencyRateException
     */
    protected function getDynamicRate(CurrencyRateRequestData $requestData): CurrencyRateData
    {
        $externalService = $this->externalService;

        return Cache::get($requestData->toString(), static function () use ($requestData, $externalService) {
            $currency = $externalService->availableCurrencies()->firstWhere('currencyCode', $requestData->currency);

            if (!$currency) {
                throw new CurrencyRateException('Currency is not available');
            }

            return self::prepareCurrencyRate(
                $externalService->getDynamic($requestData->date, $requestData->date->subDay(), $currency),
                $requestData
            );
        });
    }

    /**
     * @param Collection<CurrencyRateData> $currencyRates
     * @throws CurrencyRateException
     */
    protected static function prepareCurrencyRate(
        Collection $currencyRates,
        CurrencyRateRequestData $requestData
    ): CurrencyRateData {
        if ($currencyRates->isEmpty()) {
            throw new CurrencyRateException('Rate not found');
        }

        $rates = $currencyRates->pluck('rate');

        /** @var CurrencyRateData $currencyRate */
        $currencyRate = $currencyRates->sortByDesc('rareDate')->first();

        $currencyRate->rateDate = $currencyRate->rateDate ?? $requestData->date;
        $currencyRate->baseCurrency = $requestData->baseCurrency;
        $currencyRate->differenceRate = (string)($rates->first() - $rates->last());

        return $currencyRate;
    }
}
