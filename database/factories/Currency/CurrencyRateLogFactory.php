<?php

namespace Database\Factories\Currency;

use App\Models\Currency\CurrencyRateLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CurrencyRateLog>
 */
class CurrencyRateLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'currency' => fake()->currencyCode(),
            'rate_date' => fake()->date(),
            'rate' => fake()->randomDigitNotNull()
        ];
    }
}
