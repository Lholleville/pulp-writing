
@extends('layouts.app')

@section('content')
    @if(isset($readmode) && $readmode == true)
        <a href="{{ action('CollecsController@normalShow', $book->collections->slug) }}" class="btn btn-warning">Revenir à la collection : {{ $book->collections->name }}</a>
    @endif
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

    @if(isset($readmode) && $readmode == true)
        @include('books.tablematiere')
    @else
        @include('books.chapitres')
    @endif
@endsection
