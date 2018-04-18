@extends('layouts.app')
@section('content')
    <h1>Bienvenue sur votre atelier</h1>
    <a href="{{ action('BooksController@create') }}" class="btn btn-success">Créer un nouveau texte</a>
    <h2>Mes écrits</h2>
    <hr>
    <table class="table table-responsive">
        <thead>
            <th>Titre</th>
            <th>Collection</th>
            <th>Genres</th>
            <th>Statut</th>
            <th><i class="fa fa-paint-brush" aria-hidden="true"></i></th>
            <th><i class="fa fa-eye" aria-hidden="true"></i></th>
            <th><i class="fa fa-pencil" aria-hidden="true"></i></th>
            <th><i class="fa fa-comment-o" aria-hidden="true"></i></th>
            <th><i class="fa fa-globe" aria-hidden="true"></i></th>
            <th><i class="fa fa-clock-o" aria-hidden="true"></i></th>
            <th>Actions</th>
        </thead>
        <tbody>
        @foreach($user->books as $book)
            <tr class="tr-hover">
                <td><a href="{{ action('BooksController@show',$book) }}">{{ $book->name }}</a></td>
                <td><a href="{{ action('BooksController@show',$book) }}">{{ $book->collections->name}}</a></td>
                <td><a href="{{ action('BooksController@show',$book) }}">{{ $book->genres->name }}</a></td>
                <td><a href="{{ action('BooksController@show',$book) }}">{{ $book->statuts->name }}</a></td>
                @if($book->avatar != "/img/books/defaut.jpg")
                    <td><a href="{{ action('BooksController@show',$book) }}"><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="bottom" title="<img src='{{ url($book->avatar) }}' alt='couverture de {{ $book->name }}' class='img-responsive'/>"></span></a></td>
                @else
                    <td><a href="{{ action('BooksController@show',$book) }}"><span class="glyphicon glyphicon-eye-close"></span></a></td>
                @endif
                <td><a href="{{ action('BooksController@show',$book) }}">{{ $book->views }}</a></td>
                <td><a href="{{ action('BooksController@show',$book) }}">{{ $book->words }}</a></td>
                <td><a href="{{ action('BooksController@show',$book) }}">{{ $book->nbComments }}</a></td>
                <td><a href="{{ action('BooksController@show',$book) }}">{!! $book->online !!}</a></td>
                <td><a href="{{ action('BooksController@show',$book) }}">{{ $book->created_at }}</a></td>
                <td>
                    <a href="{{action('BooksController@edit',$book)}}"><span class="circle-blue glyphicon glyphicon-wrench"></span></a>
                    <a href="{{action('BooksController@destroy',$book)}}" data-method="delete" data-confirm = "Voulez vous vraiment supprimer votre texte ?"><span class="circle-red glyphicon glyphicon-trash"></span></a>
                    <a href="{{action('BooksController@show',$book)}}"><span class="circle-green glyphicon glyphicon-eye-open"></span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h2>Mes articles</h2>
    <hr>

@endsection