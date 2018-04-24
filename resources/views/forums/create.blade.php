@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2>Créer un forum</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            @include('forums.form', ['action' => 'store'])
        </div>
    </div>
@endsection