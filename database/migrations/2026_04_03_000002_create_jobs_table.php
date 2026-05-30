<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tr_job_queue')) {
            Schema::create('tr_job_queue', function (Blueprint $table) {
                $table->bigIncrements('ID');
                $table->string('queue')->index();
                $table->longText('payload');
                $table->unsignedTinyInteger('attempts');
                $table->unsignedInteger('reservedDate')->nullable();
                $table->unsignedInteger('availableDate');
                $table->unsignedInteger('createdDate');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_job_queue');
    }
}
