<?php
/**
 * Created by PhpStorm.
 * User: Loic
 * Date: 07/03/2018
 * Time: 15:38
 */

namespace App\Validator;


use App\Book;
use App\Chapter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Validator extends \Illuminate\Validation\Validator
{
    public function validateNamechapter($attribute, $value, $parameters)
    {
        //on récupère tous les chapitres avec le nom donné à celui que l'on crée.
        $chapters = Chapter::where('name', $value)->get();

        //si il y a un chapitre portant ce nom
        if ($chapters) {
            $books = [];
            foreach ($chapters as $chapter) {//pour chaque chapitre on récupère le livre
                $book = Book::where('id', $chapter->book_id)->first();
                $books[] = $book;
            }
            //on regarde si un des livres appartient à l'utilisateur.
            $ok = true;
            foreach ($books as $book) {
                if ($book->user_id == Auth::user()->id) {
                    foreach ($book->chapters as $c) {
                        if ($c->name == $value) {
                            return false;
                        }
                    }
                }
            }
            //sinon on return true
            return true;
        }
    }

}