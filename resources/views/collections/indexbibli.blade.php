@extends('layouts.app')

@section('content')
    @foreach($collections as $collection)
        <a href="{{ action('CollecsController@normalShow', $collection->slug) }}" class="link-collection">
            <div class="row">
                <div class="col-sm-12">
                    <h2>{{ $collection->name }}</h2>
                    <p><img src="{{ url($collection->avatar) }}" alt="" class="img-collec"></p>
                    <p>{{ $collection->description }}</p>
                </div>
            </div>
        </a>
        <hr>
    @endforeach
@endsection