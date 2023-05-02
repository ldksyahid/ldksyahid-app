<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCol2ToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('cntctPrsn1')->nullable();
            $table->string('cntctPrsn2')->nullable();
            $table->string('nameCntctPrsn1')->nullable();
            $table->string('nameCntctPrsn2')->nullable();
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
            $table->dropColumn('cntctPrsn1');
            $table->dropColumn('cntctPrsn2');
            $table->dropColumn('nameCntctPrsn1');
            $table->dropColumn('nameCntctPrsn2');
        });
    }
}
