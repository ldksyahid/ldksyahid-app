<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGatewayColumnsToDonationsTable extends Migration
{
    /**
     * Columns for the BisaTopup (Bisabiller) QRIS payment gateway.
     * All nullable/additive — existing Xendit rows are unaffected.
     */
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            if (!Schema::hasColumn('donations', 'gateway')) {
                $table->string('gateway', 30)->nullable()->after('total_tagihan')
                      ->comment('Payment gateway used: xendit | bisatopup');
            }
            if (!Schema::hasColumn('donations', 'qr_code')) {
                $table->text('qr_code')->nullable()->after('gateway')
                      ->comment('QRIS payload/image returned by the gateway');
            }
            if (!Schema::hasColumn('donations', 'payment_code')) {
                $table->string('payment_code', 100)->nullable()->after('qr_code');
            }
            if (!Schema::hasColumn('donations', 'status_id')) {
                $table->integer('status_id')->nullable()->after('payment_code')
                      ->comment('Raw gateway status id');
            }
            if (!Schema::hasColumn('donations', 'expired_at')) {
                $table->dateTime('expired_at')->nullable()->after('status_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            foreach (['gateway', 'qr_code', 'payment_code', 'status_id', 'expired_at'] as $col) {
                if (Schema::hasColumn('donations', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
}
