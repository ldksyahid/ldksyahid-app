<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCol1ToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('tag')->nullable();
            $table->dateTime('closeRegist')->nullable();
            $table->string('linkRegist')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('finished')->nullable();
            $table->string('location')->nullable();
            $table->string('linkLocation')->nullable();
            $table->string('place')->nullable();
            $table->string('linkDoc')->nullable();
            $table->string('linkPresent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('tag');
            $table->dropColumn('closeRegist');
            $table->dropColumn('linkRegist');
            $table->dropColumn('start');
            $table->dropColumn('finished');
            $table->dropColumn('location');
            $table->dropColumn('linkLocation');
            $table->dropColumn('place');
            $table->dropColumn('linkDoc');
            $table->dropColumn('linkPresent');
            //
        });
    }
}
