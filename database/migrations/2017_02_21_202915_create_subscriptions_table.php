<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('follower_username');
            $table->index('follower_username');
            $table->integer('following_id');
            $table->index('following_id');

            $table->index(['follower_username', 'following_id']);

            $table->string('customer_id');
            $table->string('email');
            $table->string('subscription_id');
            $table->string('plan');
            $table->string('application_fee_percent');

            $table->string('status');

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
        Schema::dropIfExists('subscriptions');
    }
}
