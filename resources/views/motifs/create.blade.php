@extends('layouts.app')

@section('content')
    <p><a href="{{ action('MotifsController@index') }}">Retour</a></p>

    <h1>Ajouter un motif d'annotation</h1>
    @include('motifs.form', ['action' => 'store'])
@endsection