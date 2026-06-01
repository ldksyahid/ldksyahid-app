<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('tr_comment', function (Blueprint $table) {
            $table->bigIncrements('commentID');

            $table->unsignedBigInteger('userID');
            $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');

            // Polymorphic-style: supports any content type without new migrations
            // contentType: 'article' | 'news' | 'event' | 'catalogBook' | ...
            $table->string('contentType', 50);
            $table->unsignedBigInteger('contentID');
            $table->index(['contentType', 'contentID'], 'idx_tr_comment_content');

            // Self-referential for nested replies (null = top-level comment)
            $table->unsignedBigInteger('parentID')->nullable();
            $table->foreign('parentID')->references('commentID')->on('tr_comment')->onDelete('cascade');

            $table->text('commentText');

            $table->dateTime('createdDate')->useCurrent();
            $table->dateTime('updatedDate')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tr_comment');
    }
}
