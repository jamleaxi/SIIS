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
        Schema::create('common_supply_transaction_items', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->string('itemnum')->nullable();
            $table->string('cs_id')->nullable();
            $table->string('cs_code')->nullable();
            $table->string('quantity_req')->nullable();
            $table->string('available')->nullable();
            $table->string('quantity_iss')->nullable();
            $table->string('price')->nullable();
            $table->string('total')->nullable();
            $table->string('remarks')->nullable();
            $table->string('disbursed')->default('no');
            $table->string('fund')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_supply_transaction_items');
    }
};
