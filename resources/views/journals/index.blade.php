@extends('layouts.app')


@section('content')
    <h1>Fil d'actualité de {{env('APP_NAME')}} <a class="btn btn-success" data-toggle="modal" data-target="#form-create-journal"><i class="fas fa-plus"></i></a></h1>
    <div class="row">
        <div class="col-sm-12">
            <!-- Modal create -->
            <div class="modal fade" id="form-create-journal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Poster dans le journal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        {!! Form::model($journal, ['url' => action('JournalsController@store'), 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                        <div class="modal-body">
                            {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Créer</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <!-- End modal -->

            <div class="row">
                <div class="col-sm-8">
                    @foreach($journals as $post)
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-2">
                                    <img src="{{ url($post->users->avatar) }}" alt="" class="img-fluid circled">
                                </div>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p>
                                            <span class="pull-left">
                                                <a href="{{action('UsersController@show', $post->users->slug)}}">
                                                    <b>
                                                        @if(Auth::guest())
                                                            {{$post->users->name}}
                                                        @else
                                                            @if(!$post->users->isBlacklisted())
                                                                {{$post->users->name}}
                                                            @else
                                                                Utilisateur mis en liste noire
                                                            @endif
                                                        @endif
                                                    </b>
                                                </a>
                                                <br>
                                                <b>#{{ $post->id }}</b>
                                                @if($post->created_at == $post->updated_at)
                                                    <i> {{ $post->created_at }}</i>
                                                @else
                                                    <i> Édité le {{ $post->updated_at }}</i>
                                                @endif
                                            </span>
                                                @if(!Auth::guest())
                                                    @if(Auth::user()->id == $post->users->id)
                                                        <a class="btn btn-danger pull-right"
                                                           data-method="delete"
                                                           data-toggle="tooltip"
                                                           title="Supprimer la publication"
                                                           data-placement="top"
                                                           href="{{ action('JournalsController@destroy', $post) }}"
                                                           data-confirm = "Voulez vous vraiment supprimer votre publication ?"> <i class="fas fa-trash"></i></a>
                                                        <a class="btn btn-primary pull-right" href="" data-toggle="modal" data-target="#form-edit-journal-{{ $post->id }}"><i class="fas fa-pencil-alt"></i></a>
                                                    @else
                                                        @if($post->users->isBlacklisted())
                                                            <a data-toggle="tooltip" data-placement="top" title="Retirer {{$post->users->name}} de la liste noire." href="{{ action('ListesController@blacklist', $post->users->id) }}" class="btn btn-dark pull-right"><i class="fas fa-child"></i></a>
                                                        @else
                                                            <a data-toggle="tooltip" data-placement="top" title="Ajouter {{$post->users->name}} à la liste noire." href="{{ action('ListesController@blacklist', $post->users->id) }}" class="btn btn-dark pull-right"><i class="fas fa-blind"></i></a>
                                                        @endif
                                                    @endif
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <hr>
                                            @if(Auth::guest())
                                                <p>
                                                    {{ nl2br($post->content) }}
                                                </p>
                                            @else
                                                @if(!$post->users->isBlacklisted())
                                                    <p>
                                                        {{ nl2br($post->content) }}
                                                    </p>
                                                @else
                                                    <p>
                                                        <em>Utilisateur mis en liste noire.</em>
                                                    </p>
                                                @endif
                                            @endif

                                        </div>
                                    </div>

                                    <p>
                                        @if(!Auth::guest())
                                            @if(Auth::user()->hasLikeComment($post))
                                                <a href="{{action("JournalsController@like", $post)}}">
                                                    <i class="fas fa-thumbs-up" data-placement="top" data-toggle="tooltip"
                                                       title="<ul class='list-unstyled'>@foreach($post->like[1] as $name)<li>{{$name}}</li>@endforeach">{{ $post->like[0] }}</i></a>
                                            @else
                                                <a href="{{action("JournalsController@like", $post)}}"><i class="far fa-thumbs-up" data-placement="top" data-toggle="tooltip" title="<ul class='list-unstyled'>@foreach($post->like[1] as $name)<li>{{$name}}</li>@endforeach">{{ $post->like[0] }}</i></a>
                                            @endif
                                            @if(Auth::user()->hasDislikeComment($post))
                                                <a href="{{action("JournalsController@dislike", $post)}}"><i class="fas fa-thumbs-down" data-placement="top" data-toggle="tooltip" title="<ul class='list-unstyled'>@foreach($post->dislike[1] as $name)<li>{{$name}}</li> @endforeach">{{ $post->dislike[0] }}</i></a>
                                            @else
                                                <a href="{{action("JournalsController@dislike", $post)}}"><i class="far fa-thumbs-down" data-placement="top" data-toggle="tooltip" title="<ul class='list-unstyled'>@foreach($post->dislike[1] as $name)<li>{{$name}}</li> @endforeach">{{ $post->dislike[0] }}</i></a>
                                            @endif
                                        @endif
                                        @if($post->has_message())
                                            <button id="post_{{ $post->id }}" class="btn btn-light">Voir {{ $post->nbMessages }} @if($post->nbMessages > 1) réponses @else réponse @endif</button>
                                        @endif
                                        @if(!Auth::guest())
                                                <button id="form_{{$post->id}}" class="btn btn-info">Répondre</button>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="offset-sm-2 comment_zone" id="comment_post_{{ $post->id }}">
                            @foreach($post->comments as $comment)
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <img src="{{ url($comment->users->avatar) }}" alt="" class="img-fluid circled">
                                            </div>
                                            <div class="col-sm-10">
                                                <p>
                                                    <a href="{{ action('UsersController@show', $comment->users->slug) }}">
                                                        @if(Auth::guest())
                                                            <b>{{$comment->users->name}}</b>
                                                        @else
                                                            @if($comment->users->isInList(Auth::user()->blackliste))
                                                                <b>Utilisateur mis en liste noire.</b>
                                                            @else
                                                                <b>{{$comment->users->name}}</b>
                                                            @endif
                                                        @endif
                                                    </a>
                                                    @if(!Auth::guest())
                                                        @if(Auth::user()->id == $comment->users->id)
                                                            <a class="btn btn-danger pull-right"
                                                               data-method="delete"
                                                               data-toggle="tooltip"
                                                               title="Supprimer la publication"
                                                               data-placement="top"
                                                               href="{{ action('JournalsController@destroy', $post) }}"
                                                               data-confirm = "Voulez vous vraiment supprimer votre publication ?"> <i class="fas fa-trash"></i></a>
                                                            <a class="btn btn-primary pull-right" href="{{action('CommentsController@edit',$comment)}}"><span class="fas fa-wrench"></span></a>
                                                        @else
                                                            <a class="btn btn-danger pull-right" href="{{action('SignalsController@show', $comment)}}"><i class="fas fa-exclamation-circle"></i></a>
                                                            @if($comment->users->isBlacklisted())
                                                                <a data-toggle="tooltip" data-placement="top" title="Retirer {{$comment->users->name}} de la liste noire." href="{{ action('ListesController@blacklist', $comment->users->id) }}" class="btn btn-dark pull-right"><i class="fas fa-child"></i></a>
                                                            @else
                                                                <a data-toggle="tooltip" data-placement="top" title="Ajouter {{$comment->users->name}} à la liste noire." href="{{ action('ListesController@blacklist', $comment->users->id) }}" class="btn btn-dark pull-right"><i class="fas fa-blind"></i></a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </p>
                                                @if(Auth::guest())
                                                    <p>{!! $comment->content !!}</p>
                                                @else
                                                    @if($comment->users->isInList(Auth::user()->blackliste))
                                                        <p><em>Cet utilisateur a été mis en liste noire.</em></p>
                                                    @else
                                                        <p>{!! $comment->content !!}</p>
                                                    @endif
                                                @endif
                                                <p>
                                                    @if(!Auth::guest())

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
                                                    @endif
                                                    @if($comment->created_at == $comment->updated_at)
                                                        <i class="pull-right"> {{ $comment->created_at }}</i>
                                                    @else
                                                        <i class="pull-right"> Édité le {{ $comment->updated_at }}</i>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>

                        <div class="col-sm-12 comment_zone" id="form_form_{{$post->id}}">
                            {{--@include('comments.form', ['action' => 'store','id' => $post->id, 'mode' => 'journal'])--}}
                            @if(!Auth::guest())
                                @if(!Auth::user()->isInList($post->users->blackliste))
                                    <form action="{{ action('CommentsController@store')}}" method="POST" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="" class="control-label">
                                                Votre réponse...
                                            </label>
                                            <textarea name="content" id="content" class="form-control"></textarea>
                                        </div>
                                        <input type="hidden" name="journal_id" value="{{ $post->id }}">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Envoyer</button>
                                        </div>
                                    </form>
                                @else
                                    <p><em>Vous avez été bloqué par {{ $post->users->name }}</em></p>
                                @endif
                            @endif
                        </div>
                        <!-- Modal edit -->
                        <div class="modal fade" id="form-edit-journal-{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editer la publication #{{ $post->id }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    {!! Form::model($post, ['url' => action('JournalsController@update', $post), 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                                    <div class="modal-body">
                                        {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Éditer</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <!-- End modal -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="offset-sm-3 col-sm-6">
            <div class="pagination">
                {{ $journals->links() }}
            </div>
        </div>
    </div>

@endsection