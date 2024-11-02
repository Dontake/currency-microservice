<?php

declare(strict_types=1);

namespace App\External\Clients\Currency\Cbr;

use App\Enums\CurrencyEnum;
use App\External\Data\Currency\CurrencyData;
use App\External\Data\Currency\CurrencyRateData;
use App\External\Enums\Currency\Cbr\DailyInfoMethodEnum;
use App\External\Exceptions\Currency\CurrencyRateException;
use App\External\Services\Storage\Xml\XmlService;
use Carbon\Carbon;
use DOMException;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

final class CbrClient
{
    private string $dwsUri;
    private string $url;
    private array $headers = [
        'Content-Type' => 'text/xml; charset=utf-8',
        'Accept' => 'application/soap+xml',
    ];

    public function __construct()
    {
        $this->url = config('currency.cbr.url');
        $this->dwsUri = config('currency.cbr.dws_uri');
    }

    /**
     * @throws CurrencyRateException
     * @throws \JsonException
     */
    public function getDynamic(Carbon $from, Carbon $to, CurrencyData $currencyData): Collection
    {
        $response = $this->parseXmlToArray(
            $this->sendRequestXml(DailyInfoMethodEnum::dynamic, [
                'FromDate' => $from->format('Y-m-d'),
                'ToDate' => $to->format('Y-m-d'),
                'ValutaCode' => $currencyData->externalCurrencyCode,
            ]),
            '//ValuteCursDynamic'
        );

        return Collection::make($response)->map(static function (object $item) use ($currencyData) {
            return new CurrencyRateData(
                $currencyData->currencyCode,
                $item->VunitRate,
                rateDate: new Carbon($item->CursDate),
            );
        });
    }

    /**
     * @throws CurrencyRateException
     * @throws \JsonException
     */
    public function getValutes(bool $isSeld): Collection
    {
        $response = $this->parseXmlToArray(
            $this->sendRequestXml(DailyInfoMethodEnum::enumValutes, ['Seld' => $isSeld ? 'true' : 'false']),
            '//EnumValutes'
        );

        return Collection::make($response)->map(static function (object $value) {
            return new CurrencyData($value->VcharCode ?? '', $value->Vcode) ?? null;
        });
    }

    /**
     * @throws CurrencyRateException
     * @throws \JsonException
     */
    public function getCurse(Carbon $onDate): Collection
    {
        $response = $this->parseXmlToArray(
            $this->sendRequestXml(DailyInfoMethodEnum::getCursOnDate, [
                'On_date' => $onDate->format('Y-m-d'),
            ]),
            '//ValuteCursOnDate'
        );

        return Collection::make($response)->map(static function (object $item) use ($onDate) {
            return new CurrencyRateData(
                $item->VcharCode,
                $item->VunitRate,
                baseCurrency: CurrencyEnum::DEFAULT->value,
                rateDate: $onDate
            );
        });
    }

    /**
     * @throws CurrencyRateException
     */
    private function sendRequestXml(DailyInfoMethodEnum $method, array $data): SimpleXMLElement
    {
        $this->headers = array_merge($this->headers, ['SOAPAction' => 'http://web.cbr.ru/'.$method->value]);

        try {
            return $this->getXmlResponse(
                $this->sendRequest(
                    'POST',
                    $this->url.$this->dwsUri,
                    $this->makeXml($method, $data)
                )
            );
        } catch (\Throwable $e) {
            throw new CurrencyRateException($e->getMessage());
        }
    }

    /**
     * @throws CurrencyRateException
     */
    private function sendRequest(string $method, string $url, mixed $data): PromiseInterface|Response
    {
        try {
            return Http::withHeaders($this->headers)
                ->send($method, $url, ['body' => $data])
                ->throw();
        } catch (\Throwable $e) {
            throw new CurrencyRateException($e->getMessage());
        }
    }

    private function getXmlResponse(Response $response): SimpleXMLElement|false
    {
        return simplexml_load_string($response->getBody()->getContents());
    }

    /**
     * @throws \JsonException
     */
    private function parseXmlToArray(SimpleXMLElement $xml, string $elementsName): array
    {
        return json_decode(
            json_encode(
                $xml->xpath($elementsName),
                JSON_THROW_ON_ERROR
            ),
            false,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    /**
     * @throws DOMException
     */
    private function makeXml(DailyInfoMethodEnum $method, array $data): false|string
    {
        return (new XmlService('soap:Envelope', [
                'attributes' => [
                    'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                    'xmlns:xsd' => 'http://www.w3.org/2001/XMLSchema',
                    'xmlns:soap' => 'http://schemas.xmlsoap.org/soap/envelope/',
                ],
                'soap:Body' => [
                    $method->value => array_merge(['attributes' => ['xmlns' => 'http://web.cbr.ru/']], $data),
                ],
            ]
        ))->getXmlDoc();
    }
}
