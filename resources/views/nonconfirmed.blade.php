@extends('layouts.app')

@section('content')
    <h1>Compte non confirmé.</h1>

    <p>Pour des raisons de sécurité, vous devez confirmer votre compte. <br>
    </p>
    <a href="{{ action('JailController@confirmationmail') }}" class="btn btn-sucess">Renvoyer l'email de confirmation.</a>
@endsection