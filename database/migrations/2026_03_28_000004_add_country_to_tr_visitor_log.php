<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryToTrVisitorLog extends Migration
{
    public function up()
    {
        Schema::table('tr_visitor_log', function (Blueprint $table) {
            $table->string('country', 100)->nullable()->after('os');
            $table->string('countryCode', 2)->nullable()->after('country')->index();
        });
    }

    public function down()
    {
        Schema::table('tr_visitor_log', function (Blueprint $table) {
            $table->dropIndex(['countryCode']);
            $table->dropColumn(['country', 'countryCode']);
        });
    }
}
