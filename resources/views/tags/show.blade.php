@extends('layouts.app')

@section('content')
    <h2>Tag : {{ $tag->name }}</h2>

    <h3>Oeuvres taguées</h3>

    @foreach($tag->books as $book)
        <p>{{ $book->name }}</p>
    @endforeach

@endsection