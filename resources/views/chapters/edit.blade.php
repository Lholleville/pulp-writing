@extends('layouts.app')

@section('content')
    <h1>Modifier le chapitre {{ $chapter->name }} de {{ $book->name }}</h1>
    {!! Form::model($chapter, ['class' => 'form-horizontal', 'url' => 'ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug, 'method' => 'PUT', 'files' => true ]) !!}
    @include('chapters.form', ['action' => 'update'])
@endsection
