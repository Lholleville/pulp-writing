@extends('layouts.app')

@section('content')
    <p><a href="{{ action('MotifsController@index') }}">Retour</a></p>
    <h1 style="color : {{$motif->color}}">{{$motif->name}}</h1>
@endsection