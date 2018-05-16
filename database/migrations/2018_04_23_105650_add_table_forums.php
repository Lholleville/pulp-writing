<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableForums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forums', function(Blueprint $table){
            $table->increments('id')->index();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->boolean('online')->default(true);
            $table->integer('collec_id')->unsigned()->default('0')->index();
            $table->foreign('collec_id')->references('id')->on('collecs');
            $table->timestamps();
        });

        Schema::create('forum_user', function(Blueprint $table){
            $table->increments('id_forum_user')->index();
            $table->integer('forum_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('forum_id')->references('id')->on('forums');
            $table->foreign('user_id')->references('id')->on('users');
        });


        Schema::create('topics', function(Blueprint $table){
           $table->increments('id')->index();
           $table->string('name');
           $table->string('slug');
           $table->text('message')->nullable();
           $table->boolean('online')->default(true);
           $table->boolean('pinned')->default(false);
           $table->boolean('locked')->default(false);
           $table->boolean('archived')->default(false);
           $table->boolean('answerable')->default(true);
           $table->integer('forum_id')->unsigned()->index();
           $table->foreign('forum_id')->references('id')->on('forums');
           $table->integer('user_id')->unsigned()->index();
           $table->foreign('user_id')->references('id')->on('users');
           $table->timestamps();
           $table->timestamp('last_message_time')->useCurrent();

        });

        Schema::table('comments', function(Blueprint $table){
            $table->integer('topic_id')->unsigned()->default('0')->index();
            $table->foreign('topic_id')->references('id')->on('topics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forums');
        Schema::drop('topics');
        Schema::drop('forum_user');
        Schema::table('comments', function(Blueprint $table){
            $table->dropColumn(['topic_id']);
        });
    }
}
