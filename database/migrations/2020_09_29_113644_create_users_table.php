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
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('name')->nullable();;
            $table->string('password');
            $table->boolean('approved')->default(false);
            $table->string('login_token')->nullable();
            $table->string('reset_token')->nullable();
            $table->dateTime('token_time')->nullable();
            $table->dateTime('last_seen')->nullable();
            $table->string('country')->nullable();;
            $table->boolean('silent')->default(false);
            $table->rememberToken()->nullable();
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
