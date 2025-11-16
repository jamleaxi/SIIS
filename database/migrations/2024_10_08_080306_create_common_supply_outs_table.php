<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('common_supply_outs', function (Blueprint $table) {
            $table->id();
            $table->string('cs_id');
            $table->string('qty_out');
            $table->string('price_out');
            $table->string('transaction_id');
            $table->string('date_released');
            $table->string('reference_out');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_supply_outs');
    }
};
