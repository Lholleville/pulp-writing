@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2><a href="{{route('admin')}}">Retour au panel d'administration principal</a></h2>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Ajouter un motif de signalement</div>
                <div class="panel-body">
                    @include('admin.motifsignals.form', ['action' => 'store'])
                </div>
            </div>
        </div>
    </div>
@endsection