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
        Schema::create('property_transaction_items', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('itemnum');
            $table->string('ppe_id');
            $table->string('ppe_code');
            $table->string('quantity');
            $table->string('price');
            $table->string('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_transaction_items');
    }
};
