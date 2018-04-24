@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2>Modifier le forum : {{ $forum->name }}</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            @include('forums.form', ['action' => 'update'])
        </div>
    </div>
@endsection