@extends('layouts.app')

@section('content')
    <a href="{{ action('CollecsController@index') }}">Retour</a>
    <h1>Collection {{$collection->name}}</h1>

    <p>{{ $collection->description }}</p>
    <img src="{{ url($collection->avatar) }}" alt="">
    <ul>
        @foreach($collection->users as $modo)
            <li>{{$modo->name}}</li>
        @endforeach
    </ul>
@endsection