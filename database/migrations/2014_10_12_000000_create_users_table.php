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
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('color');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('alias')->nullable();
            $table->boolean('alias_use')->default(false);
            $table->boolean('alias_conf')->default(false);
            $table->boolean('new_letter')->default(false);
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('avatar')->default(false);
            $table->dateTime('birthday')->default(null);
            $table->string('country')->default(null);
            $table->string('sex')->default(null);
            $table->text('description')->default(null);
            $table->integer('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->boolean('confirmed')->default(false);
            $table->string('confirmation_token', 60);
            $table->rememberToken();
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
        Schema::dropIfExists('roles');

    }
}
