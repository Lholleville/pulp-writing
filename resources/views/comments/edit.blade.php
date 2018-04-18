@extends('layouts.app')

@section('content')
        <br>
        <div class="col-sm-offset-2 col-sm-8">
            @include('comments.form', ['action' => 'update'])
        </div>
        <br>
@endsection