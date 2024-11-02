<?php

declare(strict_types=1);

namespace App\External\Enums\Currency\Cbr;

enum DailyInfoMethodEnum: string
{
    case getCursOnDate = 'GetCursOnDateXML';
    case enumValutes = 'EnumValutesXML';
    case dynamic = 'GetCursDynamicXML';
}
