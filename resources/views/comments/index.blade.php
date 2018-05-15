<?php $comments->load('users') ?>
@foreach($comments->where('online', true) as $comment)

    <div class="row comment">
        <hr>
        <div class="col-sm-2">
            <a href="{{ url('profil/'.$comment->users->name) }}"><img src="{{ url($comment->users->avatar) }}" alt="avatar de {{ $comment->users->name }}" class="img-responsive" /></a>
            <br>
            <p>{{ $comment->users->age }}</p>
            <p>{{ $comment->users->sex }}</p>
            <p>{{ $comment->users->country }}</p>
            <p>{{ $comment->users->nbComments }} commentaires</p>
        </div>
        <div class="col-sm-10">
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
                        <a href="{{action('CommentsController@edit',$comment)}}"><span class="circle-blue glyphicon glyphicon-wrench"></span></a>
                    @else
                        <a href="{{action('SignalsController@show', $comment)}}"><span class="circle-red glyphicon glyphicon-exclamation-sign"></span></a>
                    @endif
                    @if($comment->canEdit(Auth::user()))
                        <a href="{{action('CommentsController@destroy',$comment)}}" data-method="delete" data-confirm = "Voulez vous vraiment supprimer votre commentaire ?"><span class="circle-red glyphicon glyphicon-trash"></span></a>
                    @endif
                </span>
            @endif

            <hr>
            {!! $comment->content !!}
            @if($comment->updated_at != $comment->created_at)
            <br>
            <p><em>Édité le {{$comment->updated_at}}</em></p>
            @endif
        </div>
    </div>
@endforeach
    <div class="pagination">
        {!! $comments->links() !!}
    </div>


