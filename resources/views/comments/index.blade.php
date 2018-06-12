<?php $comments->load('users') ?>
@foreach($comments->where('online', true) as $comment)
    @if(!$comment->users->isBlackListed())
    <div class="row">
        <hr>
        <div class="col-sm-2">
            <a href="{{ url('profil/'.$comment->users->name) }}"><img src="{{ url($comment->users->avatar) }}" alt="avatar de {{ $comment->users->name }}" class="img-fluid" /></a>
            <br>
            <p>{{ $comment->users->age }}</p>
            <p>{{ $comment->users->sex }}</p>
            <p>{{ $comment->users->country }}</p>
            <p>{{ $comment->users->nbComments }} commentaires</p>
        </div>
        <div class="col-sm-10" id="{{$comment->id}}">
            @if(Auth::guest())
                <a href="{{ url('profil/'.$comment->users->name) }}" class="title-astuce">{{ $comment->users->name }}</a>
                <span class="pull-right">
                    <em>{{ $comment->created_at }}</em>
                </span>
            @else
                <a href="{{ url('profil/'.$comment->users->name) }}" class="title-astuce">
                    @if($comment->users->id == Auth::user()->id)
                        <span class="blue">@if(isset($mode) && $mode == "forum")@if($comment->users->hasAlias()){{ $comment->users->alias }}@else {{ $comment->users->name }} @endif @else {{ $comment->users->name }} @endif</span>
                    @else
                        {{ $comment->users->name }}
                    @endif
                </a>

                <span class="pull-right"><em>{{ $comment->created_at }}</em>
                    @if($comment->users->id == Auth::user()->id)
                        <a class="btn btn-primary" href="{{action('CommentsController@edit',$comment)}}"><span class="fas fa-wrench"></span></a>
                    @else
                        @if($comment->users->isBlacklisted())
                            <a data-toggle="tooltip" data-placement="top" title="Retirer {{$comment->users->name}} de la liste noire." href="{{ action('ListesController@blacklist', $comment->users->id) }}" class="btn btn-dark"><i class="fas fa-child"></i></a>
                        @else
                            <a data-toggle="tooltip" data-placement="top" title="Ajouter {{$comment->users->name}} à la liste noire." href="{{ action('ListesController@blacklist', $comment->users->id) }}" class="btn btn-dark"><i class="fas fa-blind"></i></a>
                        @endif
                        <a class="btn btn-danger" href="{{action('SignalsController@show', $comment)}}"><i class="fas fa-exclamation-circle"></i></a>
                    @endif
                    @if($comment->canEdit(Auth::user()))
                        <a class="btn btn-danger" href="{{action('CommentsController@destroy',$comment)}}" data-method="delete" data-confirm = "Voulez vous vraiment supprimer votre commentaire ?"><i class="fas fa-trash"></i></a>
                    @endif

                </span>
            @endif

            <hr>
            {!! $comment->content !!}
                <p>
                    @if(Auth::user()->hasLikeComment($comment))
                        <a href="{{action("CommentsController@like", $comment)}}"><i class="fas fa-thumbs-up" data-placement="top" data-toggle="tooltip" title="<ul class='list-unstyled'>@foreach($comment->like[1] as $name)<li>{{$name}}</li>@endforeach">{{ $comment->like[0] }}</i></a>
                    @else
                        <a href="{{action("CommentsController@like", $comment)}}"><i class="far fa-thumbs-up" data-placement="top" data-toggle="tooltip" title="<ul class='list-unstyled'>@foreach($comment->like[1] as $name)<li>{{$name}}</li>@endforeach">{{ $comment->like[0] }}</i></a>
                    @endif
                    @if(Auth::user()->hasDislikeComment($comment))
                        <a href="{{action("CommentsController@dislike", $comment)}}"><i class="fas fa-thumbs-down" data-placement="top" data-toggle="tooltip" title="<ul class='list-unstyled'>@foreach($comment->dislike[1] as $name)<li>{{$name}}</li> @endforeach">{{ $comment->dislike[0] }}</i></a>
                    @else
                        <a href="{{action("CommentsController@dislike", $comment)}}"><i class="far fa-thumbs-down" data-placement="top" data-toggle="tooltip" title="<ul class='list-unstyled'>@foreach($comment->dislike[1] as $name)<li>{{$name}}</li> @endforeach">{{ $comment->dislike[0] }}</i></a>
                    @endif
                </p>
            @if($comment->updated_at != $comment->created_at)
            <br>
            <p><em>Édité le {{$comment->updated_at}}</em></p>
            @endif
        </div>
    </div>
    @else
    <div class="row">
        <hr>
        <div class="col-sm-2">
            <a href="{{ url('profil/'.$comment->users->name) }}"><img src="{{ url("/img/avatars/banni.jpg") }}" alt="avatar de {{ $comment->users->name }}" class="img-fluid" /></a>
            <br>
            <p>Auteur mis en liste noire</p>
        </div>
        <div class="col-sm-10">

                <a href="{{ url('profil/'.$comment->users->name) }}" class="title-astuce">
                    <i>Auteur mis en liste noire</i>
                </a>

                <span class="pull-right"><em>{{ $comment->created_at }}</em>
                    @if($comment->users->id == Auth::user()->id)
                        <a class="btn btn-primary" href="{{action('CommentsController@edit',$comment)}}"><span class="fas fa-wrench"></span></a>
                    @else
                        <a class="btn btn-danger" href="{{action('SignalsController@show', $comment)}}"><i class="fas fa-exclamation-circle"></i></a>
                    @endif
                    @if($comment->canEdit(Auth::user()))
                        <a class="btn btn-danger" href="{{action('CommentsController@destroy',$comment)}}" data-method="delete" data-confirm = "Voulez vous vraiment supprimer votre commentaire ?"><i class="fas fa-trash"></i></a>
                    @endif
                    @if($comment->users->isBlacklisted())
                        <a data-toggle="tooltip" data-placement="top" title="Retirer {{$comment->users->name}} de la liste noire." href="{{ action('ListesController@blacklist', $comment->users->id) }}" class="btn btn-dark"><i class="fas fa-child"></i></a>
                    @else
                        <a data-toggle="tooltip" data-placement="top" title="Ajouter {{$comment->users->name}} à la liste noire." href="{{ action('ListesController@blacklist', $comment->users->id) }}" class="btn btn-dark"><i class="fas fa-blind"></i></a>
                    @endif
                </span>

            <hr>
            <p>Auteur mis en liste noire.</p>
            @if($comment->updated_at != $comment->created_at)
                <br>
                <p><em>Édité le {{$comment->updated_at}}</em></p>
            @endif
        </div>
    </div>
    @endif
@endforeach
    <div class="pagination">
        {!! $comments->links() !!}
    </div>


