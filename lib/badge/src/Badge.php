<?php

namespace Badge;

use App\Notification;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Badge extends Model
{
    public $guarded = [];
    public $timestamps = false;

    public function unlocks(){
        return $this->hasMany(BadgeUnlock::class);
    }

    public function isUnlockedFor(User $user){
        return $this->unlocks()
                       ->where('user_id', $user->id)
                       ->exists();
    }

    public function lockActionFor(User $user, $action){

        $badge = $this->newQuery()->where('action', $action)->first();

        if($badge && $badge->isUnlockedFor($user)){
            DB::table('badge_user')->where('user_id', $user->id)->where('badge_id',$badge->id)->delete();
        }
    }

    public function unlockActionFor(User $user, $action, $count){

        $badge = $this->newQuery()->where('action', $action)->where('action_count', $count)->first();

        if ($badge && !$badge->isUnlockedFor($user)) {

            DB::table('badge_user')->insert([
                'user_id' => $user->id,
                'badge_id' => $badge->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            /*Comment or delete if notification system is not set up*/
            $content = "<b>Vous avez débloqué un nouveau bagde !</b>
                        <br>
                        <img src='$badge->avatar' alt='' class='img-mini'><i>$badge->name</i>";
            $link = url("profil/".$user->slug);

            Notification::create([
                'content' => $content,
                'user_id' => $user->id,
                'link' => $link,
            ]);
        }
    }



}
