@extends('layouts.app')

@section('content')
    <h1>Collections</h1><a class="btn btn-success" href="{{action('CollecsController@create')}}">Ajouter</a>
    <table>
        @foreach($collections as $collection)
            <tr>
                <td>
                    <p>{{ $collection->name }}</p>
                </td>
                <td>
                    <p>{{ $collection->slug }}</p>
                </td>
                <td>
                    <p>{{ $collection->description }}</p>
                </td>
                <td>
                    <img src="{{ url($collection->avatar) }}" alt="image de la collection" width="300" height="131">
                </td>
                <td>
                    <a href="{{action('CollecsController@show', $collection)}}"><span class="circle-green glyphicon glyphicon-eye-open"></span></a>
                    <a href="{{action('CollecsController@edit', $collection)}}"><span class="circle-blue glyphicon glyphicon-wrench"></span></a>
                    <a href="{{action('CollecsController@destroy', $collection)}}" data-method="delete" data-confirm = "Voulez vous vraiment supprimer la collection {{ $collection->name }} ?"><span class="circle-red glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection