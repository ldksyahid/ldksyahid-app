<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogle2faToUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'google2fa_secret')) {
                $table->text('google2fa_secret')->nullable()->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'google2fa_enabled')) {
                $table->boolean('google2fa_enabled')->default(false)->after('google2fa_secret');
            }
            if (!Schema::hasColumn('users', 'two_fa_last_ts')) {
                $table->integer('two_fa_last_ts')->nullable()->after('google2fa_enabled');
            }
            if (!Schema::hasColumn('users', 'two_fa_enabled_at')) {
                $table->timestamp('two_fa_enabled_at')->nullable()->after('two_fa_last_ts');
            }
            if (!Schema::hasColumn('users', 'two_fa_last_used_at')) {
                $table->timestamp('two_fa_last_used_at')->nullable()->after('two_fa_enabled_at');
            }
            if (!Schema::hasColumn('users', 'two_fa_last_used_ip')) {
                $table->string('two_fa_last_used_ip', 45)->nullable()->after('two_fa_last_used_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['google2fa_secret','google2fa_enabled','two_fa_last_ts','two_fa_enabled_at','two_fa_last_used_at','two_fa_last_used_ip'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
}
