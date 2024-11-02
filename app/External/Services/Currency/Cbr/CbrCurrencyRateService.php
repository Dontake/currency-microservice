<?php

declare(strict_types=1);

namespace App\External\Services\Currency\Cbr;

use App\External\Clients\Currency\Cbr\CbrClient;
use App\External\Data\Currency\CurrencyData;
use App\External\Data\Currency\CurrencyRateData;
use App\External\Exceptions\Currency\CurrencyRateException;
use App\External\Services\Currency\CurrencyRateServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CbrCurrencyRateService implements CurrencyRateServiceInterface
{
    private CbrClient $client;

    public function __construct()
    {
        $this->client = new CbrClient();
    }

    /**
     * @return Collection<CurrencyRateData>
     * @throws \JsonException
     * @throws CurrencyRateException
     */
    public function onDate(Carbon $date): Collection
    {
        return $this->client->getCurse($date);
    }

    /**
     * @return Collection<CurrencyData>
     * @throws \JsonException
     * @throws CurrencyRateException
     */
    public function availableCurrencies(): Collection
    {
        return $this->client->getValutes(false);
    }

    /**
     * @return Collection<CurrencyRateData>
     * @throws \JsonException
     * @throws CurrencyRateException
     */
    public function getDynamic(Carbon $from, Carbon $to, CurrencyData $currencyData): Collection
    {
        return $this->client->getDynamic($from, $to, $currencyData);
    }
}
