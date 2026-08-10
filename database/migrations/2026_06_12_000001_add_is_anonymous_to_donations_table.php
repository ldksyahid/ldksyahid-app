<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAnonymousToDonationsTable extends Migration
{
    /**
     * Adds an opt-in flag so donors can hide their name from the public
     * donor list. The real name is still stored for the admin/receipt.
     */
    public function up(): void
    {
        if (Schema::hasColumn('donations', 'is_anonymous')) {
            return;
        }

        Schema::table('donations', function (Blueprint $table) {
            $table->boolean('is_anonymous')->default(false)->after('pesan_donatur');
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('donations', 'is_anonymous')) {
            return;
        }

        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn('is_anonymous');
        });
    }
}
