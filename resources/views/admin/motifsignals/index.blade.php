@extends('layouts.app')

@section('content')
<br>
<div class="row">
    <div class="col-sm-12">
        <h2><a href="{{route('admin')}}">Retour au panel d'administration principal</a></h2>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Les motifs de signalement</div>
    <div class="panel-body">
        <div class="col-sm-12">
            <a href="{{ action('MotifsignalsController@create') }}" class="btn btn-primary">Ajouter</a>
        </div>
        <div class="col-sm-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Sous-genre</th>
                    <th>Description</th>
                    <th>Parent</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($motifs as $motif)
                    <tr>
                        <td>{{ $motif->id }}</td>
                        <td>{{ $motif->name }}</td>
                        <td>{{ $motif->genre }}</td>
                        <td>{{ $motif->description }}</td>
                        <td>{{ $motif->importance }}</td>
                        <td>
                            <a href="{{action('MotifsignalsController@edit',$motif)}}"><span class="circle-blue glyphicon glyphicon-wrench"></span></a>
                            <a href="{{action('MotifsignalsController@destroy',$motif)}}" data-method="delete" data-confirm = "Voulez vous vraiment supprimer le motif de signalement ?"><span class="circle-red glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection