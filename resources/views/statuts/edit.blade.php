@extends('layouts.app')

@section('content')
    <p><a href="{{ action('StatutsController@index') }}">Retour</a></p>
    <h1>Modifier le statut : {{ $statut->name }}</h1>
    @include('statuts.form', ['action' => 'update'])
@endsection