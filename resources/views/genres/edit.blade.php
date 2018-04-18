@extends('layouts.app')

@section('content')
    <p><a href="{{ action('GenresController@index') }}">Retour</a></p>
    <h1>Modifier le genre : {{ $genre->name }}</h1>
    @include('genres.form', ['action' => 'update'])
@endsection