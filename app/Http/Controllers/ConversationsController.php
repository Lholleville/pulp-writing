<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessagesRequest;
use App\Notifications\MessageReceived;
use App\Repository\ConversationRepository;
use App\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationsController extends Controller
{

    /**
     * @var $r conversationRepository
     */
    private $r;
    private $auth;

    public function __construct(ConversationRepository $conversationRepository, AuthManager $auth)
    {
        $this->r = $conversationRepository;
        $this->auth = $auth;
        $this->middleware('auth');
    }

    public function index() {
        return view('conversations.index', [
            'users' => $this->r->getConversation($this->auth->user()->id),
            'unread' => $this->r->unreadCount($this->auth->user()->id)
        ]);
    }

    public function show(User $user){

        $me = $this->auth->user();

        $messages = $this->r->getMessagesFor($me->id, $user->id)->paginate(25);
        $unread = $this->r->unreadCount($me->id);

        if(isset($unread[$user->id])){
            $this->r->readAllFrom($user->id, $me->id);
            unset($unread[$user->id]);
        }

        return view('conversations.show', [

            'users' => $this->r->getConversation($me->id),
            'user' => $user,
            'messages' => $messages,
            'unread' => $unread
        ]);
    }

    public function store(User $user, MessagesRequest $request){
        $message = $this->r->createMessage(
            $request->get('content'),
            $this->auth->user()->id,
            $user->id
        );

        $user->notify(new MessageReceived($message));

        return redirect(route('messagerie.show', ['id' => $user->id]));
    }
}
