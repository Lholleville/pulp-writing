@extends('layouts.app')

@section('content')
    <p><a href="{{ action('MotifsController@index') }}">Retour</a></p>
    <h1>Modifier le statut : {{ $motif->name }}</h1>
    @include('motifs.form', ['action' => 'update'])
@endsection