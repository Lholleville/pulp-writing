@extends('layouts.app')

@section('content')
    <p><a href="{{ action('StatutsController@index') }}">Retour</a></p>

    <h1>Ajouter un statut</h1>
    @include('statuts.form', ['action' => 'store'])
@endsection