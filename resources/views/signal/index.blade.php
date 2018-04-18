@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-12">
                <h2><a href="{{route('admin')}}">Retour au panel d'administration principal</a></h2>
            </div>
        </div>
        @if(!$signals->isEmpty())
            @foreach($signals as $signal)
                <div class="panel panel-default">
                    <div class="panel-heading">#{!! $signal->id !!} <span class="pull-right">{{ $signal->created_at }}</span></div>
                    <div class="panel-body">
                        <p>Plaite émise par <a href="../profil/{{$signal->user_id}}">{{ $signal->moaner }}</a> envers  <a href="../profil/{{$signal->guilt_id}}">{{ $signal->guilty }}</a></p>
                        <hr>
                        <p><span class="glyphicon glyphicon-exclamation-sign"></span> {{$signal->typename }}</p>
                        <hr>
                        <p>Commentaire incriminé :</p>
                        <br>
                        <blockquote>
                            {!! $signal->commentdenounced !!}
                        </blockquote>
                        <p>Commentaire du plaignant :</p>
                        <br>
                        {!! $signal->comment !!}
                        <br>
                        <p>
                            <a class="btn btn-success" href="{{ url('admin/signalements/approved/'.$signal->id) }}">Approuver</a> <a class="btn btn-warning" href="{{ url('admin/signalements/ignored/'.$signal->id) }}">Ignorer</a> <a class="btn btn-danger" href="{{ url('admin/signalements/abused/'.$signal->id) }}">Abus</a>
                        </p>
                    </div>
                </div>
            @endforeach
        @else
            <h1 class="text-center" id="fill_page">Il n'y a pas de plainte à s'occuper</h1>
        @endif
    </div>
@endsection