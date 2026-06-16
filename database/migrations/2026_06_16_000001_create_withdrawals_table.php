<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalsTable extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('withdrawals')) {
            return;
        }
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            $table->string('reff_id')->unique();
            $table->unsignedBigInteger('amount');
            $table->unsignedInteger('fee')->default(0);

            $table->string('bank_code', 20);
            $table->string('account_number', 30);
            $table->string('account_holder')->nullable();
            $table->string('recipient_city_code', 10)->nullable();
            $table->string('remark', 100)->nullable();

            $table->string('status', 20)->default('DRAFT');
            $table->integer('bisabiller_status_id')->nullable();
            $table->string('receipt_url')->nullable();

            $table->json('inquiry_response')->nullable();
            $table->json('disbursement_response')->nullable();

            $table->timestamp('executed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
}
