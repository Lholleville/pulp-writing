<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKeySystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keys', function (Blueprint $table){
           $table->increments('id')->index();
           $table->string('key');
           $table->integer('user_id')->nullable();
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('used')->default(false);
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
        Schema::drop('keys');
    }
}
