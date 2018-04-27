@extends('layouts.forum')

@section('secondary')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ action('ForumsController@show', $forum) }}" class="btn btn-info">Retour à la liste des sujets</a>
            <h2>Editer le sujet {{$topic->name}}</h2>
            @include('topics.form', ['action' => 'update'])
        </div>
    </div>
@endsection