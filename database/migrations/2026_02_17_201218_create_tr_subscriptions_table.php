<?php

use App\Models\TrSubscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable(TrSubscription::getTableName())) {
            Schema::create(TrSubscription::getTableName(), function (Blueprint $table) {
                $table->bigIncrements('subscriberID');
                $table->string('email')->unique();
                $table->boolean('flagActive')->default(true)->index();
                $table->timestamp('subscribedDate')->useCurrent();
                $table->timestamp('unsubscribedDate')->nullable();
                $table->dateTime('createdDate')->nullable();
                $table->dateTime('editedDate')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable(TrSubscription::getTableName())) {
            Schema::dropIfExists(TrSubscription::getTableName());
        }
    }
}
