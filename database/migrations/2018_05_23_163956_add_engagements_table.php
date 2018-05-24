<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEngagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function(Blueprint $table){
           $table->increments('id');
           $table->integer('user_id');
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           $table->text('content');
           $table->timestamps();
        });

        Schema::create('engagements', function(Blueprint $table){
            $table->increments('id')->index();
            $table->integer('comment_id');
            $table->integer('journal_id');
            $table->integer('user_id');
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('has_like')->default(false);
            $table->boolean('has_dislike')->default(false);
            $table->timestamps();
        });

        Schema::table('comments', function(Blueprint $table){
            $table->integer('journal_id')->default(0);
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('engagements');
        Schema::drop('journals');
        Schema::table('comments', function(Blueprint $table){
            $table->dropColumn('journal_id');
        });
    }
}
