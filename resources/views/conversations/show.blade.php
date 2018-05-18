@extends('layouts.app')

@section('content')
    <div class="row">
        @include('conversations.users', ['users' => $users, 'unread' => $unread])
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ action('UsersController@show', $user->slug) }}">{{$user->name}}</a>
                </div>
                <div class="scroll" id="scroll">
                    <div class="card-body conversations scrollDiv" id="conversation_scrollable">
                        <div class="scrollContent">
                            @if($messages->hasMorePages())
                                <div class="text-center">
                                    <a href="{{ $messages->nextPageUrl() }}" class="btn btn-light">
                                        Voir les messages précédents ...
                                    </a>
                                </div>
                            @endif
                            <?php
                            $messagess = array_reverse($messages->items());
                            $index = 0;
                            ?>
                            @foreach($messagess as $message)
                                <div class="col-md-10 text-justify {{ $message->from->id != $user->id ? "offset-md-2 text-right" : ""}}" >
                                    @if($index - 1 >= 0)

                                        @if($message->from->id != $messagess[$index - 1]->from_id)
                                            <p class="col-sm-12">
                                                <img src="{{ url($message->from->avatar)}} "
                                                     alt="Avatar de {{ $message->from->name }}"
                                                     class="img-micro circled {{ $message->from->id != $user->id ? 'float-right' : 'float-left'}}"
                                                />
                                                <strong> {{ $message->from->id != $user->id ? 'Moi' : $message->from->name}}</strong>
                                                <br><br>
                                            </p>
                                        @endif
                                    @else
                                        <p class="col-sm-12">
                                            <img src="{{ url($message->from->avatar)}} "
                                                 alt="Avatar de {{ $message->from->name }}"
                                                 class="img-micro circled {{ $message->from->id != $user->id ? 'float-right' : 'float-left'}}"
                                            />
                                            <strong> {{ $message->from->id != $user->id ? 'Moi' : $message->from->name}}</strong>
                                            <br><br>
                                        </p>
                                    @endif
                                    <div class="{{ $message->from->id != $user->id ? 'offset-sm-4 ' : ''}} col-sm-8">
                                        <p class="text-left message {{ $message->from->id != $user->id ? 'message-me ' : 'message-other'}} ">
                                            {!! nl2br(e($message->content)) !!}
                                        </p>
                                    </div>

                                </div>
                                <?php $index++; ?>
                            @endforeach
                            @if($messages->hasMorePages())
                                <div class="text-center">
                                    <a href="{{ $messages->previousPageUrl() }}" class="btn btn-light">
                                        Voir les messages suivants ...
                                    </a>
                                </div>
                            @endif
                            <br>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="" method="post" class="form-horizontal">
                        {{csrf_field()}}
                        <div class="form-group">
                            <textarea name="content" id="" class="form-control" placeholder="Ecrivez votre message"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection