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
                    <th>#</th>
                    <th>Auteur</th>
                    <th>Sujet</th>
                    <th>Dernier message</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4"><hr></td>
                    </tr>
                    @foreach($forum->listTopicPinned() as $topic)
                        <tr class="tr-hover">
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug)}}"><img src="{{$topic->img }}" alt="topic" height="25" width="30"></a></td>
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug)}}">{{$topic->username}}</a></td>
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug)}}">{{$topic->name}}</a></td>
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug)}}">@if($topic->comments != null) {{ $topic->comments->last()->created_at }} @else {{$topic->created_at}} @endif</a></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4"><hr></td>
                    </tr>
                    @foreach($forum->listTopic() as $topic)
                        <tr class="tr-hover">
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug) }}"><img src="{{$topic->img }}" alt="topic" height="25" width="30"></a></td>
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug) }}">{{$topic->username}}</a></td>
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug) }}">{{$topic->name}}</a></td>
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug) }}">@if(!$topic->comments->isEmpty()) {{ $topic->comments->last()->created_at }} @else {{$topic->created_at}} @endif</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection