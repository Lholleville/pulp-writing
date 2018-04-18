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

//use App\Chapter;
//use Illuminate\Support\Str;

Route::get('/', ['uses' => 'HomeController@index']);

//Route::get('profil/{pseudo}/edit', 'UsersController@edit');
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



//Route::get('/script', function(){
//    $chapters = Chapter::where('slug', null)->get();
//    foreach($chapters as $chapter){
//        $slug = (isset($chapter->name)) ? $chapter->slug = Str::slug($chapter->name) : $chapter->slug = Str::slug($chapter->title);
//        $chapter->slug = $slug;
//        $chapter->update();
//    }
//});

//Route::get('/script', function(){
//
//    $createur = ['Philippe', 'Benoît', 'Loïc', 'Ulysse', 'Christine', 'Laurent'];
//    $tags1 = ['cheval', 'animal','chevre', 'chien', 'canard', 'chat', 'dauphin'];
//    $tags2 = ['maison', 'appartement', 'voiture', 'helicoptère', 'château', 'bateau', 'trottinette', 'char', 'skateboard'];
//    $tags3 = ['angleterre', 'france', 'allemagne', 'danemark', 'espagne', 'italie', 'malte', 'portugal', 'pologne', 'slovakie'];
//    $json = '[';
//    for($i = 0; $i < 27; $i++){
//        $json .= '
//                {
//                    "id" : "'.$i.'",
//                    "fichier" : "cinemagraph-'.$i.'.gif",
//                    "createur" : "'.$createur[rand(0, sizeof($createur) - 1)].'",
//                    "type" : "'.rand(0,1).'",
//                    "tags" : [
//                        "'.$tags1[rand(0, sizeof($tags1) - 1)].'", "'.$tags2[rand(0, sizeof($tags2) - 1)].'", "'.$tags3[rand(0, sizeof($tags3) - 1)].'"
//                    ],
//                    "view" : "'.rand(0,99999).'",
//                    "like" : "'.rand(0,2000).'"
//                }
//               ';
//        if($i != 26){
//            $json .= ',';
//        }
//    }
//
//    $json .= ']';
//    echo $json;
//
//});