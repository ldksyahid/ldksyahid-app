<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGdriveIdToJumbotronsTable extends Migration
{
    public function up()
    {
        Schema::table('jumbotrons', function (Blueprint $table) {
            $table->string('gdrive_id')->nullable()->after('picture');
        });
    }

    public function down()
    {
        Schema::table('jumbotrons', function (Blueprint $table) {
            $table->dropColumn('gdrive_id');
        });
    }
}
