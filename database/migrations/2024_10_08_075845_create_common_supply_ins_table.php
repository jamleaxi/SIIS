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
        Schema::create('common_supply_ins', function (Blueprint $table) {
            $table->id();
            $table->string('cs_id');
            $table->string('qty_in');
            $table->string('price_in');
            $table->string('date_acquired');
            $table->string('reference');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_supply_ins');
    }
};
