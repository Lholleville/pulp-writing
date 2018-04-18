@extends('layouts.app')

@section('content')
    <h1>Genres</h1><a href="{{action('GenresController@create')}}">Ajouter</a>
    <table>
        @foreach($genres as $genre)

            <tr>
                <td>
                    <p>{{ $genre->name }}</p>
                </td>
                <td>
                    <p>{{ $genre->slug }}</p>
                </td>
                <td>
                    <p>{{ $genre->parent }}</p>
                </td>
                <td>
                    <a href="{{action('GenresController@show',$genre)}}"><span class="circle-green glyphicon glyphicon-eye-open"></span></a>
                    <a href="{{action('GenresController@edit',$genre)}}"><span class="circle-blue glyphicon glyphicon-wrench"></span></a>
                    <a href="{{action('GenresController@destroy',$genre)}}" data-method="delete" data-confirm = "Voulez vous vraiment supprimer le genre ?"><span class="circle-red glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @endforeach
    </table>

@endsection