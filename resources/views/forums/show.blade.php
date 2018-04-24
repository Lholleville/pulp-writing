@extends('layouts.forum')

@section('secondary')
    <div class="row">
        <div class="col-sm-12">
            <p>
                <a href="">Accueil</a>
                @if($forum->hasCollec()) / <a href="">{{ $forum->collections->name }}</a>@endif
                / <a href="">{{ $forum->name }} </a>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <a href="{{ action('TopicsController@create', $forum) }}" class="btn btn-success">Nouveau sujet</a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-stripped">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($forum->listTopic() as $topic)
                        <tr>
                            <td>{{$topic->name}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection