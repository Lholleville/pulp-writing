<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['banni']], function (){
    Route::get('/', ['uses' => 'HomeController@index']);
    Route::resource('tags', 'TagsController');
    Route::get('tags/{slug}/restore', 'TagsController@restore');

    Route::resource('forums/{forum}/topic', 'TopicsController');
    Route::get('topic/{slug}/pin', 'TopicsController@pin');
    Route::get('topic/{slug}/lock', 'TopicsController@lock');
    Route::get('topic/{slug}/archive', 'TopicsController@archive');
    Route::get('topic/{slug}/answer', 'TopicsController@answerable');

    Route::resource('profil', 'UsersController');
    Route::get('profil/{slug}/alias/delete', ['uses' => 'UsersController@deletealias']);

    Route::get('profil/{slug}/avatar/delete', ['uses' => 'UsersController@deleteavatar']);
    Route::put('profil/alias/create', ['uses' => 'UsersController@setalias']);
    Route::get('profil/alias/ignore', ['uses' => 'UsersController@aliasignored']);

    Route::resource('ecrire/oeuvres', 'BooksController');
    Route::resource('ecrire/oeuvres/{oeuvre}/chapitre', 'ChaptersController');


    Route::resource('admin/genres', 'GenresController');
    Route::resource('admin/motifs', 'MotifsController');
    Route::resource('admin/statuts', 'StatutsController');
    Route::resource('admin/collections', 'CollecsController');
    Route::resource('admin/signalements', 'SignalsController');
    Route::resource('admin/motifs-signalements', 'MotifsignalsController');
    Route::get('admin/users', ['uses' => 'UsersController@index']);
    Route::put('admin/users/{slug}/update', ['uses' => 'UsersController@updateadmin']);
    Route::get('admin/signalements/approved/{id}', ['uses' => 'SignalsController@approved']);
    Route::get('admin/signalements/ignored/{id}', ['uses' => 'SignalsController@ignored']);
    Route::get('admin/signalements/abused/{id}', ['uses' => 'SignalsController@abused']);


    Route::resource('moderation', 'ModerationsController');
    Route::get('moderation/{slug}/reemigrate', ['uses' => 'ModerationsController@reemigrate']);

    Route::get('collections', ['uses' => 'CollecsController@normalIndex']);
    Route::get('collections/{slug}', ['uses' => 'CollecsController@normalShow']);

    Route::get('{id}/dislike', ['uses' => 'ChaptersController@dislike']);
    Route::get('{id}/like', ['uses' => 'ChaptersController@like']);
    Route::get('{id}/read', ['uses' => 'ChaptersController@read']);
    Route::get('{id}/unread', ['uses' => 'ChaptersController@unread']);
    Route::get('{slug}/superliked', ['uses' => 'ModerationsController@superliked']);

    Route::resource('comments', 'CommentsController');

    Route::post('notes', ['uses' =>'NotesController@store']);

    Route::get('ecrire', ['uses' => 'AteliersController@index'])->name('atelier');

    Route::get('confirm/{id}/{token}', 'Auth\RegisterController@getConfirm');

    Route::resource('admin/forums', 'ForumsController');
    Route::get('admin/forums/', ['uses' => 'ForumsController@indexadmin']);
    Route::get('forums', ['uses' => 'ForumsController@index']);
    Route::get('forums/{slug}', ['uses' => 'ForumsController@show']);



    Route::resource('magic', 'MagicsController');

    Route::get('/{collection}/{slug}', 'ReadController@show');
    Route::get('/{collection}/{book}/{order}/{slug}', 'ReadController@showChapter');

});

Route::group([],function(){
    Auth::routes();
    Route::get('admin', 'AdminsController@index')->name('admin');
    Route::get('malandrin', ['uses' => 'JailController@redirect'])->middleware(['nonbanni']);
});

//dd(Route::getRoutes());