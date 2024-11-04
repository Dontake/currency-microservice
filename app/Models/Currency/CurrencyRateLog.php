<?php

declare(strict_types=1);

namespace App\Models\Currency;

use Carbon\Carbon;
use Database\Factories\Currency\CurrencyRateLogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property string $currency
 * @property string $base_currency
 * @property string $rate
 * @property Carbon $rate_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class CurrencyRateLog extends Model
{
    /** @use HasFactory<CurrencyRateLogFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'rate_date' => 'date',
        ];
    }
}
