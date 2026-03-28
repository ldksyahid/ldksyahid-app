<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTrVisitorPageStatTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tr_visitor_page_stat')) {
            Schema::create('tr_visitor_page_stat', function (Blueprint $table) {
                $table->bigIncrements('ID');
                $table->date('statDate');
                $table->string('path', 500);
                $table->unsignedInteger('totalHits')->default(0);
                $table->unsignedInteger('uniqueVisitors')->default(0);
                $table->unsignedInteger('mobileHits')->default(0);
                $table->unsignedInteger('desktopHits')->default(0);
                $table->unsignedInteger('tabletHits')->default(0);
                $table->unsignedInteger('botHits')->default(0);
                $table->dateTime('createdDate')->nullable();
                $table->dateTime('updatedDate')->nullable();

                $table->index('statDate', 'idx_statDate');
            });

            // Partial unique index for long varchar path column
            DB::statement('ALTER TABLE tr_visitor_page_stat ADD UNIQUE KEY uniq_statDate_path (statDate, path(191))');
        }
    }

    public function down()
    {
        Schema::dropIfExists('tr_visitor_page_stat');
    }
}
