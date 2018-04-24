@extends('layouts.forum')

@section('secondary')
    <div class="row">
        <div class="col-sm-12">
            <h2>Créer un nouveau sujet</h2>
            @include('topics.form', ['action' => 'store'])
        </div>
    </div>
@endsection