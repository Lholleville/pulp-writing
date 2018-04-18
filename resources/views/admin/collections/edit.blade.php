@extends('layouts.app')

@section('content')
    <a href="{{ action('CollecsController@index') }}">Retour</a>
    <h1>Editer la collection : {{ $collection->name }}</h1>
    @include('admin.collections.form', ['action' => 'update'])
@endsection