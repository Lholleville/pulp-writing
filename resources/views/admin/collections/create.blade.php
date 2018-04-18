@extends('layouts.app')

@section('content')
    <p><a href="{{ action('CollecsController@index') }}">Retour</a></p>
    <h1>Ajouter une collection</h1>
    @include('admin.collections.form', ['action' => 'store'])
@endsection