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

            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->string('name');
            $table->string('email', 250)->unique();
            $table->string('password');
            $table->rememberToken();

            //Instagram
            $table->string('nickname')->nullable();
            $table->string('pass')->nullable();
            $table->boolean('private_checked')->default(false);

            //Pricing
            $table->string('plan')->nullable();

            //Account
            $table->string('account_id')->nullable();

            //Future purchases
            $table->string('customer_id')->nullable();

            
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
