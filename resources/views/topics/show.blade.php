@extends('layouts.forum')

@section('secondary')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ action('ForumsController@show', $forum) }}" class="btn btn-info">Retour à la liste des sujets</a>
            @if(!Auth::guest())
            <a href="{{ action('TopicsController@create', $forum)}}" class="btn btn-success"> Créer un nouveau sujet</a>
                @if(Auth::user()->isOP($topic))
                    <a href="{{ url('forums/'.$forum->slug.'/topic/'.$topic->slug.'/edit') }}" class="btn btn-primary">Editer le sujet</a>
                @endif
                @if(Auth::user()->isModo() || Auth::user()->roles->name == "admin")
                <a href="{{ action('TopicsController@pin', $topic) }}" class="btn btn-primary">@if($topic->isPinned()) Retirer l'épingle @else Épingler le sujet @endif</a>
                @if($topic->isPinned())
                    <a href="{{ action('TopicsController@answerable', $topic) }}" class="btn btn-primary">@if($topic->isAnswerable()) Désactiver les réponses @else Réactiver les réponses @endif</a>
                @endif
                <a href="{{ action('TopicsController@lock', $topic) }}" class="btn btn-warning">@if($topic->isLocked()) Dévérouiller @else Vérouiller le sujet @endif</a>
                <a href="{{ action('TopicsController@archive', $topic) }}" class="btn btn-warning">@if($topic->isArchived()) Restaurer @else Archiver le sujet @endif</a>
                <a href="{{url('/forums/'.$forum->slug.'/topic/'.$topic->slug)}}" class="btn btn-danger" data-method="delete" data-confirm = "Voulez vous vraiment supprimer le topic {{ $topic->name }}"><span class=" glyphicon glyphicon-trash"></span></a>
                @endif
            @endif
            <h2>{{ $topic->name }}</h2>

        </div>
    </div>
    @include('comments.index', ['comments' => $comments, 'mode' => 'forum'])
    @if(!$topic->isLocked())
        @if($topic->isAnswerable())
            @include('comments.form', ['action' => 'store','id' => $topic->id, 'mode' => 'topic'])
        @else
            <div class="col-sm-12">
                <p class="bg-default text-danger">Ce topic ne peut être commenté.</p>
            </div>
        @endif
    @else
        <div class="col-sm-12">
            <p class="bg-default text-danger">Ce topic a été vérouillé par un modérateur, il n'est plus possible de commenter.</p>
        </div>
    @endif



@endsection
