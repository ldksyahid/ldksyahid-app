<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrVisitorDailyUniqueTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tr_visitor_daily_unique')) {
            Schema::create('tr_visitor_daily_unique', function (Blueprint $table) {
                $table->bigIncrements('ID');
                $table->string('ipHash', 64);
                $table->date('visitDate');
                $table->smallInteger('visitCount')->unsigned()->default(1);
                $table->string('firstPath', 500)->nullable();
                $table->dateTime('createdDate')->nullable();
                $table->dateTime('updatedDate')->nullable();

                $table->unique(['ipHash', 'visitDate'], 'uniq_ipHash_visitDate');
                $table->index('visitDate', 'idx_visitDate');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('tr_visitor_daily_unique');
    }
}
