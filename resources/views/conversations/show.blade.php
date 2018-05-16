@extends('layouts.app')

@section('content')
    <div class="row">
        @include('conversations.users', ['users' => $users, 'unread' => $unread])
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    {{$user->name}}
                </div>
                <div class="card-body conversations">
                    @if($messages->hasMorePages())
                        <div class="text-center">
                            <a href="{{ $messages->nextPageUrl() }}" class="btn btn-light">
                                Voir les messages précédents ...
                            </a>
                        </div>
                    @endif
                    @foreach(array_reverse($messages->items()) as $message)
                        <div class="row">
                            <div class="col-md-10 {{ $message->from->id != $user->id ? "offset-md-2 text-right" : ""}}">
                                <p>
                                    <strong>{{ $message->from->id != $user->id ? 'Moi' : $message->from->name}}</strong><br>
                                    {!! nl2br(e($message->content)) !!}
                                </p>
                            </div>
                        </div>
                    @endforeach
                    @if($messages->hasMorePages())
                        <div class="text-center">
                            <a href="{{ $messages->previousPageUrl() }}" class="btn btn-light">
                                Voir les messages suivants ...
                            </a>
                        </div>
                    @endif
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