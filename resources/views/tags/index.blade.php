@extends('layouts.app')

@section('content')
    <a class="btn btn-success" href="#autorisés">Accéder tag autorisés</a> <a href="#interdits" class="btn btn-danger">Accéder tags interdits</a>
    <h2 id="autorisés">Tags autorisés</h2>
    <table class="table table-stripped">
        @foreach($tags as $tag)
            <tr>
                <td><a href="{{action('TagsController@show', $tag)}}">{{$tag->name}}</a></td>
                <td>{{$tag->users->name}}</td>
                <td><a href="{{ url('tags/'.$tag->slug.'/restore') }}" class="btn btn-danger"><i class="fa fa-trash"></i> Désactiver</a></td>
            </tr>
        @endforeach
    </table>
    <a class="btn btn-success" href="#autorisés">Accéder tag autorisés</a> <a href="#interdits" class="btn btn-danger">Accéder tags interdits</a>
    <h2 id="interdits">Tags non autorisés</h2>
    <table class="table table-stripped">
        @foreach($tags_not_online as $tag_no)
            <tr>
                <td><a href="{{action('TagsController@show', $tag_no)}}">{{$tag_no->name}}</a></td>
                <td>{{$tag_no->users->name}}</td>
                <td><a href="{{ url('tags/'.$tag_no->slug.'/restore') }}" class="btn btn-success"><i class="fa fa-check"></i> Réhabiliter</a></td>
            </tr>
        @endforeach
    </table>
@endsection