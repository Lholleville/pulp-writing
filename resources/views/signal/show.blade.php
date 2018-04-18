@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Signaler du contenu</div>
            <div class="panel-body">
                {!! Form::open(['class' => 'form-horizontal', 'method' => 'POST', 'url' => action("SignalsController@store") ]) !!}
                <div class="form-group">
                    <div class="col-sm-12">
                        <p>Le contenu ci dessous va être signalé. Ce signalement n'est pas anonyme et sera connu des administrateurs.</p><br>
                        <blockquote class="quote">
                            {!! $comment->content !!}
                        </blockquote>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="content" class="col-sm-12">
                            Veuillez choisir un motif
                        </label>

                        <div class="col-sm-12">
                            <select name="type" id="selectMotif" class="form-control">
                                <option value="/">Veuillez choisir un motif</option>
                                <option id="/" class="hidden">Veuillez choisir un motif</option>
                                @foreach($motif as $cat)
                                    <optgroup label="{{$cat->name}}">
                                        @foreach($cat->children as $child)
                                            <option value="{{$child->id }}">{{ $child->name }}</option>
                                            <option id="{{$child->id }}" class="hidden">{{$child->description}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <script>
                                $('#selectMotif').change(function() {
                                    var str = "";
                                    $( "#selectMotif option:selected + option" ).each(function() {
                                        str += $( this ).text() + " ";
                                    });
                                    $( "#description" ).text( str );
                                }).trigger("change");
                            </script>
                            <br>
                            <div class="col-sm-12" id="description">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" value="{!! $comment->id !!}" name="comment_id">
                        <input type="hidden" value="{{ $comment->users->id }}" name="guilt_id">
                        <div class="col-sm-12">
                            <p id="description"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="col-sm-12">
                            Commentaire
                        </label>
                        <div class="col-sm-12">
                            {!! Form::textarea('comment', null, ['class' => 'form-control', 'id' => 'content']) !!}
                        </div>
                        <script>
                            CKEDITOR.replace('comment');
                        </script>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-danger">Signaler !</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection