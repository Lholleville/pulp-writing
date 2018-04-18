@extends('layouts.app')

@section('content')
    <p><a href="{{ action('GenresController@index') }}">Retour</a></p>
    <h1>{{$genre->name}}</h1>
@endsection