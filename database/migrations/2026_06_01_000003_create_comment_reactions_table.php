<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentReactionsTable extends Migration
{
    public function up()
    {
        Schema::create('tr_comment_reaction', function (Blueprint $table) {
            $table->bigIncrements('reactionID');

            $table->unsignedBigInteger('commentID');
            $table->foreign('commentID')->references('commentID')->on('tr_comment')->onDelete('cascade');

            $table->unsignedBigInteger('userID');
            $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');

            // Reaction type: like|dislike|love|heart_eyes|laughing|rage|slight_smile
            // VARCHAR allows future extension without schema changes
            $table->string('reactionType', 30);

            $table->dateTime('createdDate')->useCurrent();

            // One reaction type per user per comment (multiple types allowed)
            $table->unique(['commentID', 'userID', 'reactionType'], 'uq_comment_user_reaction_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tr_comment_reaction');
    }
}
