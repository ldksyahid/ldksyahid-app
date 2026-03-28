<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTrVisitorLogTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tr_visitor_log')) {
            Schema::create('tr_visitor_log', function (Blueprint $table) {
                $table->bigIncrements('ID');
                $table->string('ipAddress', 45);
                $table->string('ipHash', 64)->index('idx_ipHash');
                $table->string('path', 500);
                $table->string('queryString', 1000)->nullable();
                $table->string('referer', 1000)->nullable();
                $table->text('userAgent')->nullable();
                $table->enum('deviceType', ['desktop', 'mobile', 'tablet', 'bot', 'unknown'])->default('unknown')->index('idx_deviceType');
                $table->string('browser', 100)->nullable();
                $table->string('os', 100)->nullable();
                $table->tinyInteger('isUniqueDaily')->default(0);
                $table->tinyInteger('isBot')->default(0);
                $table->timestamp('visitedAt')->useCurrent();

                $table->index(['ipAddress', 'visitedAt'], 'idx_ip_date');
                $table->index('visitedAt', 'idx_visitedAt');
                $table->index(['isUniqueDaily', 'visitedAt'], 'idx_uniqueDaily');
            });

            // Partial index for long varchar path column
            DB::statement('CREATE INDEX idx_path ON tr_visitor_log (path(191))');
        }
    }

    public function down()
    {
        Schema::dropIfExists('tr_visitor_log');
    }
}
