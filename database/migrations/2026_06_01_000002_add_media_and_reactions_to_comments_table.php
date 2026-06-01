<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMediaAndReactionsToCommentsTable extends Migration
{
    public function up()
    {
        Schema::table('tr_comment', function (Blueprint $table) {
            // URL of attached media (Google Drive URL for uploads, external URL for GIFs)
            $table->text('mediaUrl')->nullable()->after('commentText');
            // 'image' | 'gif' | 'sticker'
            $table->string('mediaType', 20)->nullable()->after('mediaUrl');
            // Google Drive file ID (for uploaded images/GIFs stored in GDrive)
            $table->string('mediaGdriveId', 100)->nullable()->after('mediaType');
        });
    }

    public function down()
    {
        Schema::table('tr_comment', function (Blueprint $table) {
            $table->dropColumn(['mediaUrl', 'mediaType', 'mediaGdriveId']);
        });
    }
}
