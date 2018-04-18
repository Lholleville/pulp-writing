@extends('layouts.app')

@section('content')
    <h1>Motifs d'annotation</h1><a href="{{action('MotifsController@create')}}">Ajouter</a>
    <table>
        @foreach($motifs as $motif)

            <tr>
                <td>
                    <p>{{ $motif->name }}</p>
                </td>
                <td>
                    <p>{{ $motif->slug }}</p>
                </td>
                <td>
                    <p>{{ $motif->parent }}</p>
                </td>
                <td>
                    <a href="{{action('MotifsController@show',$motif)}}"><span class="circle-green glyphicon glyphicon-eye-open"></span></a>
                    <a href="{{action('MotifsController@edit',$motif)}}"><span class="circle-blue glyphicon glyphicon-wrench"></span></a>
                    <a href="{{action('MotifsController@destroy',$motif)}}" data-method="delete" data-confirm = "Voulez vous vraiment supprimer le motifs ?"><span class="circle-red glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @endforeach
    </table>

@endsection