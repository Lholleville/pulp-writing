@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1>Panel administration</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <h2>Composant du site</h2>
            <ul>
                <li><a href="{{action('GenresController@index')}}">Genres</a></li>
                <li><a href="{{action('StatutsController@index')}}">Statuts</a></li>
                <li><a href="{{action('MotifsController@index')}}">Motifs (annotation)</a></li>
                <li><a href="{{action('MotifsignalsController@index')}}">Motifs (signalement)</a></li>
                <li><a href="{{action('TagsController@index')}}">Tags</a></li>
            </ul>
        </div>
        <div class="col-sm-6">
            <h2>Espaces</h2>
            <ul>
                <li><a href="{{action('CollecsController@index')}}">Collections</a></li>
                <li><a href="{{url('admin/forums')}}">Forums</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <h2>Utilisateurs</h2>
            <ul>
                <li><a href="{{action('SignalsController@index')}}">Signalement</a></li>
                <li><a href="{{action('UsersController@index')}}">Membres</a></li>
            </ul>
        </div>
        <div class="col-sm-6">
            <h2>Configuration site</h2>
            <ul>
                <li><a href="{{action('ConfigurationsController@index')}}">Paramètres de développement</a></li>
                <li><a href="{{action('ConfigurationsController@indexkeys')}}">Clefs</a></li>
            </ul>
        </div>
    </div>
@endsection