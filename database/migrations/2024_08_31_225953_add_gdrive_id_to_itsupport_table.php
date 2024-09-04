<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGdriveIdToItsupportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('i_t_supports', function (Blueprint $table) {
            $table->string('gdrive_id')->nullable()->after('photoProfile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('i_t_supports', function (Blueprint $table) {
            $table->dropColumn('gdrive_id');
        });
    }
}
