@extends('layouts.app')

@section('content')
    <h1>Collections</h1><a class="btn btn-success" href="{{action('CollecsController@create')}}">Ajouter</a>
    <h2>Liste des collections</h2>
    <table class="table table-responsive">
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
                    <img src="{{ url($collection->avatar) }}?{{ time() }}" alt="image de la collection" width="300" height="131">
                </td>
                <td>
                    <a href="{{action('CollecsController@show',$collection)}}"><span class="circle-green glyphicon glyphicon-eye-open"></span></a>
                    <a href="{{action('CollecsController@edit',$collection)}}"><span class="circle-blue glyphicon glyphicon-wrench"></span></a>
                    <a href="{{action('CollecsController@destroy',$collection)}}" data-method="delete" data-confirm = "Voulez vous vraiment supprimer le genre ?"><span class="circle-red glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @endforeach
    </table>
    <h2>Modérateur par collection</h2>
    <table class="table table-responsive">
        @foreach($collections as $collection)
            <tr>
                <td>
                    <p>{{$collection->name}}</p>
                </td>
                @foreach($collection->users as $user)
                    <td>
                        <img src="{{ url($user->avatar) }}" alt="avatar de {{ $user->name }}" class="img-responsive" height="50" width="50">
                    </td>
                    <td>
                        <p>{{ $user->name }}</p>
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
@endsection