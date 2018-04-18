@extends('layouts.app')

@section('content')
    <h1>Ajouter un chapitre à {{ $book->name }}</h1>
    {!! Form::model($chapter, ['class' => 'form-horizontal', 'url' => 'ecrire/oeuvres/'.$book->slug.'/chapitre', 'method' => 'POST', 'files' => true ]) !!}
    @include('chapters.form', ['action' => 'store'])
@endsection