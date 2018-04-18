@extends('layouts.app')

@section('content')
    <h1>Statuts</h1><p><a href="{{action('StatutsController@create')}}">Ajouter</a></p>
    <table>
        @foreach($statuts as $statut)

            <tr>
                <td>
                    <p style="color : {{ $statut->color }}">{{ $statut->name }}</p>
                </td>
                <td>
                    <a href="{{action('StatutsController@show',$statut)}}"><span class="circle-green glyphicon glyphicon-eye-open"></span></a>
                    <a href="{{action('StatutsController@edit',$statut)}}"><span class="circle-blue glyphicon glyphicon-wrench"></span></a>
                    <a href="{{action('StatutsController@destroy',$statut)}}" data-method="delete" data-confirm = "Voulez vous vraiment supprimer le statut ?"><span class="circle-red glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection