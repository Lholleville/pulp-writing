@extends('layouts.app')

@section('content')
    <p><a href="{{ action('StatutsController@index') }}">Retour</a></p>
    <h1 style="color : {{$statut->color}}">{{$statut->name}}</h1>
@endsection