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
        Schema::create('common_supplies', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('item');
            $table->string('description');
            $table->string('category');
            $table->string('fund');
            $table->string('remarks')->nullable();
            $table->string('low_indicator');
            $table->string('unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_supplies');
    }
};
