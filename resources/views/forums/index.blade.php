@extends('layouts.app')

@section('content')
    <ul class="list-group">
        @foreach($forums as $forum)
            <li><a href="{{ action('ForumsController@show', $forum) }}">{{ $forum->name }}</a></li>
        @endforeach
    </ul>
@endsection