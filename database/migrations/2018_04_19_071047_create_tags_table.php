<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function(Blueprint $table){
            $table->increments('id')->index();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('book_tag', function(Blueprint $table){
            $table->increments('id')->index();
            $table->string('name');
            $table->string('slug');
            $table->integer('book_id')->unsigned()->index();
            $table->foreign('book_id')->references('id')->on('books');
            $table->integer('tag_id')->unsigned()->index();
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
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
        //
    }
}
