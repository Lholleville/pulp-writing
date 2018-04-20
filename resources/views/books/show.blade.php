@extends('layouts.app')

@section('content')
    @if($book->collections->isPrimary())
        <form method="POST" action="{{ action('ModerationsController@update', $book->slug)}}" accept-charset="UTF-8" class="form-horizontal">
            <input name="_method" type="hidden" value="PUT">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <div class="col-xs-4">
                <select class="form-control" name="collec_id">
                    @foreach($collections as $collec)
                        @if($collec->id != $book->collections->id)
                            <option value="{{$collec->id}}">{{ $collec->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-xs-2">
                <p><button type="submit" class="btn btn-success">save</button></p>
            </div>
        </form>
    @else
        <a data-toggle="tooltip" data-placement="bottom" title="Retirer le texte de la collection" href="{{ action('ModerationsController@reemigrate', $book->slug)}}" class="btn btn-danger"><i class="fa fa-check"></i></a>
    @endif
    @if(isset($readmode) && $readmode == true)
        <a href="{{ action('CollecsController@normalShow', $book->collections->slug) }}" class="btn btn-warning">Revenir à la collection : {{ $book->collections->name }}</a>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <h1>{{$book->name}} <span>{{ $book->statuts->name }}</span>
                @if(!Auth::guest())
                    @if($book->user_id == Auth::user()->id)
                        <a href="{{ action('BooksController@edit', $book) }}" class="btn btn-primary">Editer</a>
                    @endif
                @endif
            </h1>
            <p>{!! $book->summary !!}</p>
            <p>{{ $book->genres->name }}</p>
            <p>{{ $book->created_at }}</p>
            <p>{{ $book->updated_at }}</p>
            <img src="{{ url($book->avatar)}}?{{time()}}" alt="Couverture de {{ $book->name }}">
            @if($book->parent_id != 0)
                <p>Cette oeuvre est la suite de {{$book->parent}}</p>
            @endif
            <h3>tags</h3>
            <ul class="tags">
                @foreach($book->tags as $tag)
                    <li><a href="{{ action('TagsController@show', $tag) }}" class="tag">{{$tag->name}}</a></li>
                @endforeach
            </ul>
            <p>Ce livre appartient à la collection : {{$book->collections->name}}</p>
            <p>{{ $book->NbComments }}</p>
            <p>{{ $book->views }}</p>
            <p>{{ $book->words }}</p>
            @if(isset($readmode) && $readmode == true)
                @if($book->chapters()->first())
                    @if(isset($_COOKIE['order_'.$book->id]))
                        <a href="{{ url($book->collections->slug."/".$book->slug."/".$_COOKIE['order_'.$book->id]."/".$book->chapters()->where('book_id', $book->id)->where('order', $_COOKIE['order_'.$book->id])->first()->slug) }}" class="btn btn-info">Reprendre {{ $book->name }} !</a>
                    @else
                        <a href="{{ url($book->collections->slug."/".$book->slug."/1/".$book->chapters()->first()->slug) }}" class="btn btn-info">Lire {{ $book->name }} !</a>
                    @endif
                @else
                    <a href="" class="btn btn-warning">Ce livre ne contient pas encore de chapitre</a>
                @endif
            @endif
            <hr>
        </div>
    </div>


    @if(isset($readmode) && $readmode == true)
        @include('books.tablematiere')
    @else
        @include('books.chapitres')
    @endif
@endsection
