@extends('layouts.forum')

@section('secondary')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ action('ForumsController@show', $forum) }}" class="btn btn-info">Retour à la liste des sujets</a>
            <h2>Créer un nouveau sujet</h2>
            @include('topics.form', ['action' => 'store'])
        </div>
    </div>
@endsection