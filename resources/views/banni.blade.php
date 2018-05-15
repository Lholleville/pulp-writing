@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Vous êtes banni !</h1>
        <br>
        <img src="{{ url('img/jail.jpg') }}" alt="" class="center-block" />
        <br>
        <p>
            Votre Karma est inférieur ou égal à 0, suite à votre comportement néfaste sur le site.
            <br>Vous pouvez toujours faire une réclamation par mail à l'adresse suivante :
            <a href="">contact@le-coin-des-ecrivains.com</a>
            <br>
            <br>
        </p>
        <br>
    </div>
@endsection