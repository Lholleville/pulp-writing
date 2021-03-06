<?php

namespace App;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Liste extends Model
{
    const AMIS_ID = "1";
    const AMIS_NAME = 'Liste d\'amis';
    const AMIS_DESCRIPTION = 'Voici la liste de vos amis. Ajoutez-y les personnes que vous appréciez pour ne rien rater de leur activité sur le site.';
    const AMIS_MODIFICTATION = true;

    const BLACKLIST_ID = "2";
    const BLACKLIST_NAME = 'Liste noire';
    const BLACKLIST_DESCRIPTION = 'Voici la liste des utilisateurs dont vous ne voulez plus voir le contenu. Vous ne pourrez plus vous contacter ni lire les messages.';
    const BLACKLIST_MODIFICTATION = true;

    const SUBSCRIBERS_ID = "3";
    const SUBSCRIBERS_NAME = "Liste des abonnés";
    const SUBSCRIBERS_DESCRIPTION = "Voici la liste des gens qui se sont abonnés à vous. Vous ne pouvez pas ajouter ou retirer de membre de cette liste.";
    const SUBSCRIBERS_MODIFICTATION = false;

    const ABONNEMENTS_ID = "4";
    const ABONNEMENTS_NAME = "Liste de vos abonnements";
    const ABONNEMENTS_DESCRIPTION = "Voici la liste des personnes à qui vous vous êtes abonnés.";
    const ABONNEMENTS_MODIFICTATION = true;

    const LECTURE_ID = "5";
    const LECTURE_NAME = "Liste de lecture";
    const LECTURE_DESCRIPTION = "Une liste de lecture où vous pouvez ajouter les oeuvres qui vous intéressent.";
    const LECTURE_MODIFICTATION = true;

    const CUSTOM_USER_ID = "6";
    const CUSTOM_USER_NAME = "Liste personnalisée";
    const CUSTOM_USER_DESCRIPTION = "Une liste de contacts personnalisée.";
    const CUSTOM_USERMODIFICTATION = true;

    const CUSTOM_LECTURE_ID = "7";
    const CUSTOM_LECTURE_NAME = "Liste de lecture personnalisée";
    const CUSTOM_LECTURE_DESCRIPTION = "Une liste de lecture personnalisée.";
    const CUSTOM_LECTURE_MODIFICTATION = true;

    public $guarded = ['id'];

    public $dates = ['created_at', 'updated_at'];



    public function users(){
       return $this->belongsToMany('App\User');
    }

    public function regles(){
        return $this->HasOne('App\Regle');
    }

    public function getOwnerAttribute(){
        return User::findOrFail($this->attributes['user_id']);
    }

    public function isEditable(){
        $return = [];
        switch($this->name){
            case Self::SUBSCRIBERS_NAME :
                $return[0] = Self::SUBSCRIBERS_MODIFICTATION;
                break;
            default :
                $return[0] = true;
        }
        $return[1] = ($this->owner->id == Auth::user()->id) ? true : false;

        return ($return[0] && $return[1]) ? true : false;
    }

    public function isDeletable(){
        $return = [];

        switch($this->type){
            case Self::CUSTOM_USER_ID :
                $return[0] = true;
                break;
            case Self::CUSTOM_LECTURE_ID :
                $return[0] = true;
            break;
            default :
                $return[0] = false;
        }

        $return[1] = ($this->owner->id == Auth::user()->id) ? true : false;

        return ($return[0] && $return[1]) ? true : false;
    }

    public function isNotifiable(){
        $return = [];

        switch($this->type){
            case Self::SUBSCRIBERS_ID :
                $return[0] = false;
                break;
            case Self::BLACKLIST_ID :
                $return[0] = false;
            break;
            default :
                $return[0] = true;
        }
        $return[1] = ($this->owner->id == Auth::user()->id) ? true : false;

        return ($return[0] && $return[1]) ? true : false;
    }
}
