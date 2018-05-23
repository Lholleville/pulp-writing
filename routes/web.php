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

use App\Liste;
use App\Listelecture;
use App\Regle;
use App\Reglelecture;

//Route::get('test/AngularJS', function(){
//    $users = App\User::where('id', 1)->first()->newQuery()->select('name', 'id', 'karma', 'slug', 'avatar', 'country')
//        ->where('id', '!=', 1)
//        ->get();
//    return view('test', compact('users'));
//});

Route::group([],function(){
    Auth::routes();
    Route::get('admin', 'AdminsController@index')->name('admin');
    Route::get('malandrin', ['uses' => 'JailController@redirect'])->middleware(['nonbanni']);
});

Route::group(['middleware' => ['banni']], function (){
    Route::get('/', ['uses' => 'HomeController@index']);
    Route::resource('tags', 'TagsController');
    Route::get('tags/{slug}/restore', 'TagsController@restore');

    Route::put('listes/{id}', 'ListesController@update');
    Route::post('listes/create', 'ListesController@store');
    Route::delete('listes/{id}', 'ListesController@destroy');

    Route::PUT('listes/{id}/rules', 'ListesController@setrules');
    Route::PUT('listeslecture/{id}/rules', 'ListeslectureController@setruleslecture');

    Route::get('users/{id}/friends', 'ListesController@friends');
    Route::get('users/{id}/subscribe', 'ListesController@subscribe');
    Route::get('users/{id}/blacklist', 'ListesController@blacklist');

    Route::put('listeslecture/{id}', 'ListeslectureController@update');
    Route::post('listeslecture/create', 'ListeslectureController@store');
    Route::delete('listeslecture/{id}', 'ListeslectureController@destroy');

    Route::get('books/{id}/subscribe', 'ListeslectureController@subscribe');

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

    Route::get('/conversations', 'ConversationsController@index')->name('messagerie');
    Route::get('/conversations/{user}', 'ConversationsController@show')
        ->middleware('can:talkTo,user')
        ->name('messagerie.show');
    Route::post('/conversations/{user}', 'ConversationsController@store')
        ->middleware('can:talkTo,user');
    Route::post('/conversations', 'ConversationsController@storespecial');
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
    Route::get('forums', ['uses' => 'ForumsController@index'])->name('forum');
    Route::get('forums/{slug}', ['uses' => 'ForumsController@show']);



    Route::resource('magic', 'MagicsController');

    Route::get('/{collection}/{slug}', 'ReadController@show');
    Route::get('/{collection}/{book}/{order}/{slug}', 'ReadController@showChapter');



});


Route::get('test', function(){

    $users = \App\User::all();

    foreach ($users as $user){
        $list = new Liste();
        $listlecture = new Listelecture();
        $rule = new Regle();
        $rulelecture = new Reglelecture();

        /* Liste d'amis */
        $list->create(
            [
                'name' => Liste::AMIS_NAME,
                'description' => Liste::AMIS_DESCRIPTION,
                'type' => Liste::AMIS_ID,
                'user_id' => $user->id,
            ]);
        $list = Liste::orderBy('id', 'DESC')->first();

        $rule->create([
            'liste_id' => $list->id
        ]);

        /* Blacklist */
        $list->create(
            [
                'name' => Liste::BLACKLIST_NAME,
                'description' => Liste::BLACKLIST_DESCRIPTION,
                'type' => Liste::BLACKLIST_ID,
                'user_id' => $user->id,
            ]);

        $list = Liste::orderBy('id', 'DESC')->first();

        $rule->create([
            'liste_id' => $list->id
        ]);

        /* Liste des abonnés */
        $list->create(
            [
                'name' => Liste::SUBSCRIBERS_NAME,
                'description' => Liste::SUBSCRIBERS_DESCRIPTION,
                'type' => Liste::SUBSCRIBERS_ID,
                'user_id' => $user->id,
            ]);

        $list = Liste::orderBy('id', 'DESC')->first();

        $rule->create([
            'liste_id' => $list->id
        ]);

        /* Liste des abonnements */

        $list->create(
            [
                'name' => Liste::ABONNEMENTS_NAME,
                'description' => Liste::ABONNEMENTS_DESCRIPTION,
                'type' => Liste::ABONNEMENTS_ID,
                'user_id' => $user->id,
            ]);
        $list = Liste::orderBy('id', 'DESC')->first();

        $rule->create([
            'liste_id' => $list->id
        ]);

        /* Liste de lecture */
        $listlecture->create(
            [
                'name' => Listelecture::LECTURE_NAME,
                'description' => Listelecture::LECTURE_DESCRIPTION,
                'type' => Listelecture::LECTURE_ID,
                'user_id' => $user->id,
            ]);
        $listlecture = Listelecture::orderBy('id', 'DESC')->first();

        $rulelecture->create([
            'listelecture_id' => $listlecture->id
        ]);


    }
});