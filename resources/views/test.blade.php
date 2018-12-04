@extends('layouts.app')

@section('content')
    @foreach($users as $user)
        <p>{{ $user->name }}</p>
    @endforeach
@endsection