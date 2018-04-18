<?php namespace App;

use App\Behaviour\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Motifsignal extends Model {

    public $guarded = ['id'];

    use Sluggable;

    public function getGenreAttribute(){
        if(self::find($this->attributes['parent_group'])){
            $group = self::find($this->attributes['parent_group']);
            return $group->name;
        }else{
            return "/";
        }
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getChildrenAttribute(){
        if($this->attributes['parent_group'] == 0){
            $children = self::where('parent_group', $this->attributes['id'])->get();
            return $children;
        }
    }

    public function getParentAttribute(){
        if($this->attributes['parent_group'] != 0){
            $parent = self::where('id', $this->attributes['parent_group'])->limit(1)->get();
            $parent = $parent->last();
            return $parent->name;
        }
    }

    public function getImportanceAttribute(){
        if($this->attributes['importance'] == 0){
            $parent = self::where('id', $this->attributes['parent_group'])->limit(1)->get();
            $parent = $parent->last();
            return $parent->importance;
        }else{
            return $this->attributes['importance'];
        }
    }

}
