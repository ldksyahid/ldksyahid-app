<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsKtaldksyahidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_ktaldksyahid', function (Blueprint $table) {
            $table->id();
            $table->string('fullName')->nullable();
            $table->string('nim')->nullable();
            $table->string('faculty')->nullable();
            $table->string('major')->nullable();
            $table->string('generation')->nullable();
            $table->string('about')->nullable();
            $table->string('memberNumber')->nullable();
            $table->string('linkProfile')->nullable();
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('ms_ktaldksyahid');
    }
}
