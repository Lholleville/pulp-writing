<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public $guarded = ['id', 'updated_at', 'created_at'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function motifs(){
        return $this->belongsTo('App\Motif', 'motif_id');
    }

    public function chapters(){
        return $this->belongsTo('App\Chapter', 'chapter_id');
    }
}
