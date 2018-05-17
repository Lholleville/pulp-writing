@extends('layouts.app')

@section('content')
    @if($user->id != Auth::user()->id)
        <p><a href="{{ route('messagerie.show', $user->id) }}" class="btn btn-default"><i class="fa fa-envelope"></i> Contacter</a></p>
    @endif
    <p><a href="{{ url('profil/my-profil/edit') }}">Modifier</a></p>
    <p>{{ $user->name }}</p>
    <p>{{ $user->sex }}</p>
    <p>{{ $user->email }}</p>
    <p>
        <img src="{{ url($user->avatar) }}" alt="avatar de {{$user->name}}" />
    </p>
    <p>{{ $user->age }}</p>
    <p>{{ $user->description }}</p>
@endsection