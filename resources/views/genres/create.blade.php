@extends('layouts.app')

@section('content')
    <p><a href="{{ action('GenresController@index') }}">Retour</a></p>

    <h1>Ajouter un genre</h1>
@include('genres.form', ['action' => 'store'])
@endsection