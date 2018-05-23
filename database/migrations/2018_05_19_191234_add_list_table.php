<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listes', function(Blueprint $table){
           $table->increments('id')->index();
           $table->string('name')->nullable();
           $table->text('description')->nullable();
           $table->integer('type');
           $table->integer('user_id');
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           $table->timestamps();
        });

        Schema::create('listelectures', function(Blueprint $table){
            $table->increments('id')->index();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('type');
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('liste_user', function(Blueprint $table){
            $table->increments('liste_user_id')->index();
            $table->integer('liste_id')->index();
            $table->foreign('liste_id')->references('id')->on('listes')->onDelete('cascade');
            $table->integer('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('book_listelecture', function(Blueprint $table){
            $table->increments('book_liste_id')->index();
            $table->integer('listelecture_id')->index();
            $table->foreign('listelecture_id')->references('id')->on('listes')->onDelete('cascade');
            $table->integer('book_id')->index();
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('regles', function(Blueprint $table){
            $table->increments('id')->index();
            $table->integer('liste_id')->index();
            $table->foreign('liste_id')->references('id')->on('listes')->onDelete('cascade');
            $table->boolean('user_text_created')->default(true);
            $table->boolean('user_article_created')->default(true);
            $table->boolean('user_diary_created')->default(true);
            $table->boolean('user_topic_created')->default(true);
            $table->boolean('collection_text_created')->default(true);
            $table->boolean('topic_text_created')->default(true);
            $table->boolean('text_chapter_created')->default(true);
            $table->boolean('text_statut_changed')->default(true);
            $table->timestamps();
        });

        Schema::create('reglelectures', function(Blueprint $table){
            $table->increments('id')->index();
            $table->integer('listelecture_id')->index();
            $table->foreign('listelecture_id')->references('id')->on('listes')->onDelete('cascade');

            $table->boolean('collection_text_created')->default(true);
            $table->boolean('topic_text_created')->default(true);
            $table->boolean('text_chapter_created')->default(true);
            $table->boolean('text_statut_changed')->default(true);
            $table->timestamps();
        });



        Schema::create('notifications', function(Blueprint $table){
           $table->increments('id')->index();
           $table->string('content');
           $table->integer('user_id')->index();
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           $table->string('link')->nullable();
           $table->boolean('read')->default(false);
           $table->timestamp('received_at');
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
        Schema::drop('listes');
        Schema::drop('listelectures');
        Schema::drop('liste_user');
        Schema::drop('reglelectures');
        Schema::drop('book_listelecture');
        Schema::drop('notifications');
        Schema::drop('regles');
    }
}
