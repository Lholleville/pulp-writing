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


Route::get('/', ['uses' => 'HomeController@index']);

Route::resource('tags', 'TagsController');
Route::get('tags/{slug}/restore', 'TagsController@restore');

Route::resource('profil', 'UsersController');
Route::resource('ecrire/oeuvres', 'BooksController');
Route::resource('ecrire/oeuvres/{oeuvre}/chapitre', 'ChaptersController');


Route::get('admin', ['uses' => 'AdminsController@index'])->name('admin');


Route::resource('admin/genres', 'GenresController');
Route::resource('admin/motifs', 'MotifsController');
Route::resource('admin/statuts', 'StatutsController');
Route::resource('admin/collections', 'CollecsController');
Route::resource('admin/signalements', 'SignalsController');
Route::resource('admin/motifs-signalements', 'MotifsignalsController');
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

Route::resource('comments', 'CommentsController');

Route::post('notes', ['uses' =>'NotesController@store']);

Route::get('ecrire', ['uses' => 'AteliersController@index'])->name('atelier');

Auth::routes();

Route::get('/confirm/{id}/{token}', 'Auth\RegisterController@getConfirm');

Route::get('/{collection}/{slug}', ['uses' => 'ReadController@show']);
Route::get('/{collection}/{book}/{order}/{slug}', ['uses' => 'ReadController@showChapter']);

