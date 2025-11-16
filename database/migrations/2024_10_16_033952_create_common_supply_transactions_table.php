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
        Schema::create('common_supply_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('tcode')->nullable();
            $table->string('risnum')->nullable();
            $table->string('entity')->nullable();
            $table->string('fund')->nullable();
            $table->string('division')->nullable();
            $table->string('office')->nullable();
            $table->string('ccode')->nullable();
            $table->string('purpose')->nullable();
            $table->string('requester_id')->nullable();
            $table->string('requester')->nullable();
            $table->string('position_req')->nullable();
            $table->string('date_req')->nullable();
            $table->string('sign_req')->nullable();
            $table->string('approver_id')->nullable();
            $table->string('approver')->nullable();
            $table->string('position_app')->nullable();
            $table->string('date_app')->nullable();
            $table->string('sign_app')->nullable();
            $table->string('assessor_id')->nullable();
            $table->string('assessor')->nullable();
            $table->string('position_ass')->nullable();
            $table->string('date_ass')->nullable();
            $table->string('sign_ass')->nullable();
            $table->string('issuer_id')->nullable();
            $table->string('issuer')->nullable();
            $table->string('position_iss')->nullable();
            $table->string('date_iss')->nullable();
            $table->string('sign_iss')->nullable();
            $table->string('receiver_id')->nullable();
            $table->string('receiver')->nullable();
            $table->string('position_rec')->nullable();
            $table->string('date_rec')->nullable();
            $table->string('sign_rec')->nullable();
            $table->string('status')->nullable();
            $table->string('ris_generation')->default('no');
            $table->string('overall_total')->default('0.00');
            $table->string('archive')->default('no');
            $table->string('accepted')->nullable();
            $table->string('submitted')->default('no');
            $table->string('type')->nullable();
            $table->string('approved')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_supply_transactions');
    }
};
