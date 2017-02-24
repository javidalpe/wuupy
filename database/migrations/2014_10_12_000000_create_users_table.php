<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->primary('id');
            $table->string('token');
            $table->rememberToken();
            $table->string('refreshToken')->nullable();
            $table->string('expiresIn')->nullable();
            $table->string('nickname');
            $table->index('nickname');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('avatar');
            $table->string('user');
            $table->string('plan')->nullable();
            $table->string('account_id')->nullable();
            $table->string('customer_id')->nullable();
            $table->boolean('private_checked')->default(false);
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
        Schema::dropIfExists('users');
    }
}
