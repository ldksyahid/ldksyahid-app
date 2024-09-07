<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGdriveIdToGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('gdrive_id')->nullable()->after('groupPhoto');
            $table->string('gdrive_id_1')->nullable()->after('photo1');
            $table->string('gdrive_id_2')->nullable()->after('photo2');
            $table->string('gdrive_id_3')->nullable()->after('photo3');
            $table->string('gdrive_id_4')->nullable()->after('photo4');
            $table->string('gdrive_id_5')->nullable()->after('photo5');
            $table->string('gdrive_id_6')->nullable()->after('photo6');
            $table->string('gdrive_id_7')->nullable()->after('photo7');
            $table->string('gdrive_id_8')->nullable()->after('photo8');
            $table->string('gdrive_id_9')->nullable()->after('photo9');
            $table->string('gdrive_id_10')->nullable()->after('photo10');
            $table->string('gdrive_id_11')->nullable()->after('photo11');
            $table->string('gdrive_id_12')->nullable()->after('photo12');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('gdrive_id');
            $table->dropColumn('gdrive_id_1');
            $table->dropColumn('gdrive_id_2');
            $table->dropColumn('gdrive_id_3');
            $table->dropColumn('gdrive_id_4');
            $table->dropColumn('gdrive_id_5');
            $table->dropColumn('gdrive_id_6');
            $table->dropColumn('gdrive_id_7');
            $table->dropColumn('gdrive_id_8');
            $table->dropColumn('gdrive_id_9');
            $table->dropColumn('gdrive_id_10');
            $table->dropColumn('gdrive_id_11');
            $table->dropColumn('gdrive_id_12');
        });
    }
}
