@extends('layouts.app')

@section('content')
    <h1>Créer une nouvelle oeuvre</h1>
    @include('books.form', ['action' => 'store'])
@endsection