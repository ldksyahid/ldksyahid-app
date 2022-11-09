<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateITSupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_t_supports', function (Blueprint $table) {
            $table->id();
            $table->string('photoProfile')->nullable();
            $table->string('name');
            $table->string('forkat');
            $table->string('position');
            $table->string('linkInstagram');
            $table->string('linkLinkedin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('i_t_supports');
    }
}
