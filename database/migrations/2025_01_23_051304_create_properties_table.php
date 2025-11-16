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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('item');
            $table->string('description');
            $table->string('category');
            $table->string('fund');
            $table->string('unit');
            $table->string('date_acquired');
            $table->string('price');
            $table->string('est_life')->nullable();
            $table->string('status');
            $table->string('custodian')->nullable();
            $table->string('prev_cus')->nullable();
            $table->string('date_transferred')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
