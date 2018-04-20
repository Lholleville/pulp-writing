<?php

namespace Badge;

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

    public function unlockActionFor(User $user, $action, $count){

        $badge = $this->newQuery()->where('action', $action)->where('action_count', $count)->first();

        if ($badge && !$badge->isUnlockedFor($user)) {

            DB::table('badge_user')->insert([
                'user_id' => $user->id,
                'badge_id' => $badge->id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }



}
