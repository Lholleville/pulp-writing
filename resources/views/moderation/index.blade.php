@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1>Panel de Modération</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h2>Collections modérées</h2>
            <table class="table table-responsive">
                <tr>
                    <th>
                       <p>Nom</p>
                    </th>
                    <th>
                        <p>Image</p>
                    </th>
                    <th>
                        <p>Nb txt</p>
                    </th>
                </tr>
                @foreach(Auth::user()->collections as $collection)
                <tr>
                    <td><p><a class="link-collection" href="{{ action('ModerationsController@show', $collection->slug) }}">{{ $collection->name }}</p></a></td>
                    <td><a href="{{ action('ModerationsController@show', $collection->slug) }}"><img src="{{ url($collection->avatar) }}" alt="illustration de la collection {{ $collection->name }}" class="img-mini-collec"/></a></td>
                    <td><p>{{ $collection->nbTxt }}</p></td>
                </tr>
            @endforeach
            </table>
        </div>
    </div>
@endsection