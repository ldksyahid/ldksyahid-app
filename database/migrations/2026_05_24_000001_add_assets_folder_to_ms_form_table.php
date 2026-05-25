<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssetsFolderToMsFormTable extends Migration
{
    public function up()
    {
        Schema::table('ms_form', function (Blueprint $table) {
            $table->string('gdriveAssetsFolderID')->nullable()->after('gdriveAttachmentsFolderUrl');
            $table->string('gdriveAssetsFolderUrl')->nullable()->after('gdriveAssetsFolderID');
        });

    }

    public function down()
    {
        Schema::table('ms_form', function (Blueprint $table) {
            $table->dropColumn(['gdriveAssetsFolderID', 'gdriveAssetsFolderUrl']);
        });
    }
}
