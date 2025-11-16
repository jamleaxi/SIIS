<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class  extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('semi_expendable_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('tcode');
            $table->string('icsnum');
            $table->string('fund');
            $table->string('office');
            $table->string('purpose');
            $table->string('custodian_id');
            $table->string('custodian');
            $table->string('position_cus');
            $table->string('date_cus');
            $table->string('sign_cus');
            $table->string('issuer_id');
            $table->string('issuer');
            $table->string('position_iss');
            $table->string('date_iss');
            $table->string('sign_iss');
            $table->string('ics_generation');
            $table->string('overall_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semi_expendable_transactions');
    }
};
