<?php

declare(strict_types=1);

use App\Enums\CurrencyEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currency_rate_logs', static function (Blueprint $table) {
           $table->id();

           $table->string('currency')->index();
           $table->string('base_currency')->default(CurrencyEnum::DEFAULT->value)->index();
           $table->string('rate')->index();
           $table->date('rate_date');

           $table->timestamps();
           $table->softDeletes();

           $table->comment('Logs of currency rate requests');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currency_rate_logs');
    }
};
