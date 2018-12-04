@extends('layouts.app')

@section('content')
    <h1>Configuration : {{ $config->name }}</h1>

        <form class="form-horizontal">
            <div class="form-group">
                <div class="col-sm-6">
                    <label for="" class="control-label">La valeur de la case est la bonne.</label>
                    <input type="number" id="inputNumber" value="10" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <button class="btn btn-success" id="key_button">
                        Génerer <span id="number_keys">10</span> clefs
                    </button>
                </div>
            </div>
        </form>


    <div class="col-sm-12" id="box">
        <ul class="list-group">
            @foreach($keys as $key)
                <li class="list-group-item @if($key->used) bg-success @else bg-info @endif">
                    <div class="row">
                        <div class="col-sm-4">
                            {{ $key->key }}
                        </div>
                        <div class="col-sm-6">
                            @if($key->used == true)
                                {{ $key->users->name }}
                                <a href="{{action("ConfigurationsController@deletekey", $key->id)}}" class="btn btn-danger pull-right"><i class="fas fa-trash"></i></a>
                            @else
                                <div class="col-sm-8">
                                    {!! Form::model($key, ['class' => 'form-horizontal', 'method' => 'PUT', 'url' => action('ConfigurationsController@attributeKeys')]) !!}
                                    {!! Form::hidden('key_id', $key->id)  !!}
                                    {!! Form::select('user_id', $users->pluck('name','id'), null, ['class' => 'form-control']) !!}

                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::close() !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <script>

        var box = $('#box');
        $('#inputNumber').keydown(function(){
            $('#number_keys').text($('#inputNumber').val());
        });
        $('#inputNumber').change(function(){
            $('#number_keys').text($('#inputNumber').val());
        });

        $('#key_button').click(function (){
            $.ajax({
                url : "keys/generate/"+$('#inputNumber').val(),
                type : "GET",
                success : function(data) {

                },
                error: function() {
                    box.html("Erreur lors de la génération des clefs.");
                }
            })
        });



    </script>

@endsection