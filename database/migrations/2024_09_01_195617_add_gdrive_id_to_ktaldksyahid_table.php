<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGdriveIdToKtaldksyahidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_ktaldksyahid', function (Blueprint $table) {
            $table->string('gdrive_id')->nullable()->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ms_ktaldksyahid', function (Blueprint $table) {
            $table->dropColumn('gdrive_id');
        });
    }
}
