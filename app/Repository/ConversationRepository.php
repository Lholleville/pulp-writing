<?php
/**
 * Created by PhpStorm.
 * User: Loic
 * Date: 16/05/2018
 * Time: 10:41
 */

namespace App\Repository;


use App\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ConversationRepository
{

    private $user;
    /**
     * @var Message
     */
    private $message;

    public function __construct(User $user, Message $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * liste des utilisateurs à qui on peut parler
     * @param $userID
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getConversation ($userID){
        $conversations = $this->user->newQuery()
            ->select('name', 'id', 'karma', 'slug', 'avatar', 'country')
            ->where('id', '!=', $userID)
            ->get();

       return $conversations;
    }

    public function createMessage($content, $from, $to){
        return $this->message->newQuery()->create([
            'content' => $content,
            'from_id' => $from,
            'to_id' => $to,
            'created_at' => Carbon::now()
        ]);
    }

    public function getMessagesFor($from, $to)
    {
        $from = intval($from);
        $to = intval($to);

        return $this->message->newQuery()
            ->whereRaw("((from_id = $from AND to_id = $to) OR (from_id = $to AND to_id = $from))")
            ->orderBy('created_at', 'DESC')
            ->with([
                'from' => function($query) {
                    return $query->select('name', 'id', 'karma', 'slug', 'avatar');
                }
            ]);
    }

    /***
     *  Récupère le nombre de messages non lus pour chaque conversation.
     */
    public function unreadCount($userID){
        return $this->message->newQuery()
            ->where('to_id', $userID)
            ->groupBy('from_id')
            ->selectRaw('from_id, COUNT(id) as count')
            ->whereRaw('read_at IS NULL')
            ->get()
            ->pluck('count', 'from_id');
    }

    /***
     * Marque tous les messages de cet utilisateurs comme lus.
     */
    public function readAllFrom($from, $to){
        $this->message->where('from_id', $from)->where('to_id', $to)->update(['read_at' => Carbon::now()]);
    }
}