<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Currency\CurrencyRateLog;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        CurrencyRateLog::factory(100)->create();
    }
}
