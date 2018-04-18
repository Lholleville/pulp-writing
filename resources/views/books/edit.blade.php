@extends('layouts.app')

@section('content')
    <h1>Editer l'oeuvre : {{ $book->name }}</h1>
    @include('books.form', ['action' => 'update'])
@endsection
