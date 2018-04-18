<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collecs', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->boolean('avatar')->default(false);
            $table->boolean('online')->default(true);
            $table->timestamps();
        });

        //modérateurs des collections
        Schema::create('collec_user', function(Blueprint $table){
            $table->integer('user_id')->unsigned()->index();
            $table->integer('collec_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('collec_id')->references('id')->on('collecs')->onDelete('cascade');
        });

        Schema::create('statuts', function(Blueprint $table){
           $table->increments('id');
           $table->string('name');
            $table->string('slug');
            $table->string('color')->default('#000000');
            $table->timestamps();
        });

        Schema::create('genres', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('parent_id');
            $table->foreign('parent_id')->references('id');
            $table->string('color')->default('#000000');
            $table->timestamps();
        });

        Schema::create('books', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->default(null);
            $table->boolean('avatar')->default(false);
            $table->text('summary')->default(null);
            $table->boolean('online')->default(false);
            $table->integer('parent_id')->unsigned()->index();
            $table->foreign('parent_id')->references('id')->on('books');
            $table->integer('collec_id');
            $table->foreign('collec_id')->references('id')->on('collecs');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('statut_id')->unsigned()->index();
            $table->foreign('statut_id')->references('id')->on('statuts');
            $table->integer('genre_id')->unsigned()->index();
            $table->foreign('genre_id')->references('id')->on('genres');
            $table->timestamps();
        });

        //gère les abonnements
        Schema::create('book_user', function(Blueprint $table){
            $table->integer('user_id')->unsigned()->index();
            $table->integer('book_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });

        Schema::create('chapters', function(Blueprint $table){
           $table->increments('id');
           $table->string('name');
           $table->string('slug');
           $table->string('POV');
           $table->longText('content');
           $table->integer('order')->default(1);
           $table->integer('words');
           $table->integer('views');
           $table->boolean('avatar')->default(false);
           $table->boolean('online')->default(true);
           $table->integer('book_id')->unsigned()->index();
           $table->integer('user_id')->unsigned()->index();
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
           $table->integer('signal')->default(0);
           $table->timestamps();


        });

        //données sur le chapitre et les actions utilisateur
        Schema::create('chapter_user', function(Blueprint $table){
            $table->integer('user_id')->unsigned()->index();
            $table->integer('chapter_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
            $table->boolean('has_read')->default(false);
            $table->boolean('liked')->default(true);
        });

        Schema::create('comments', function(Blueprint $table){
           $table->increments('id');
           $table->longText('content');
           $table->integer('user_id')->unsigned()->index();
           $table->foreign('user_id')->references('id')->on('users');
           $table->integer('chapter_id')->unsigned()->index();
           $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
           $table->integer('signal')->default(0);
           $table->timestamps();
        });

        Schema::create('motifs', function(Blueprint $table){
            $table->string('name');
            $table->string('slug');
            $table->string('color')->default('#000000');
            $table->timestamps();
        });

        Schema::create('annotations', function(Blueprint $table){
           $table->increments('id');
           $table->text('content');
           $table->integer('start')->default(0);
           $table->integer('end')->default(0);
           $table->integer('user_id')->unsigned()->index();
           $table->integer('chapter_id')->unsigned()->index();
           $table->integer('motif_id')->unsigned()->index();
           $table->foreign('user_id')->references('id')->on('users');
           $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
           $table->foreign('motif_id')->references('id')->on('motifs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('annotations');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('statuts');
        Schema::dropIfExists('motifs');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('chapter_user');
        Schema::dropIfExists('chapters');
        Schema::dropIfExists('book_user');
        Schema::dropIfExists('books');
        Schema::dropIfExists('collec_user');
        Schema::dropIfExists('collecs');
    }
}
