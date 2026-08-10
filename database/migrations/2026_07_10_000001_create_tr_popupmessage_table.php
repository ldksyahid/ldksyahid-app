<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrPopupmessageTable extends Migration
{
    public function up()
    {
        Schema::create('tr_popupmessage', function (Blueprint $table) {
            $table->bigIncrements('messageID');

            $table->string('senderName', 80);
            $table->text('messageText');

            $table->dateTime('createdDate')->useCurrent();
            $table->dateTime('updatedDate')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tr_popupmessage');
    }
}
