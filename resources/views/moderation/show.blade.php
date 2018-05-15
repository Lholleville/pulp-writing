@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>{{$collection->name}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <img src="{{url($collection->avatar)}}" alt="image de la collection" class="img-collec">
                <hr>
                <p class="text-justify">{{ $collection->description }}</p>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h2>Les textes</h2>
                <table class="table table-striped">
                    <thead class="text-center">
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Genre</th>
                    <th>Apperçu</th>
                    <th>Réémigrer</th>
                    <th>Coup de <3</th>
                    </thead>
                    <tbody>
                    @foreach($collection->books as $book)
                        <tr>
                            <td>{{ $book->name }}</td>
                            <td>{{ $book->users->name }}</td>
                            <td>{{ $book->genres->name }}</td>
                            <td><a href="{{ url($collection->slug.'/'.$book->slug) }}" class="btn btn-default"><i class="fa fa-eye"></i></a></td>
                            @if($collection->isPrimary())
                                <td>
                                    <form method="POST" action="{{ action('ModerationsController@update', $book->slug)}}" accept-charset="UTF-8" class="form-horizontal">
                                        <input name="_method" type="hidden" value="PUT">
                                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                        <div class="col-xs-10">
                                            <select class="form-control" name="collec_id">
                                                @foreach($collections as $collec)
                                                    @if($collec->id != $collection->id)
                                                        <option value="{{$collec->id}}">{{ $collec->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xs-2">
                                            <p><button type="submit" class="btn btn-success">save</button></p>
                                        </div>
                                    </form>
                                </td>
                            @else
                                <td>
                                    <a data-toggle="tooltip" data-placement="bottom" title="Retirer le texte de la collection" href="{{ action('ModerationsController@reemigrate', $book->slug)}}" class="btn btn-danger"><i class="fa fa-check"></i></a></td>
                                </td>
                            @endif
                                <td>
                                    <a data-toggle="tooltip" data-placement="bottom" title="Ce texte est coup de coeur de la collection" href="{{ action('ModerationsController@superliked', $book->slug)}}" class="btn btn-info">@if($book->isSuperliked())<i class="fa fa-star"></i>@else <i class="fa fa-star-o"></i>@endif</a></td>
                                </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h2>Signalements</h2>
                @if(!$signals->isEmpty())
                    @foreach($signals as $signal)
                        @if($signal->belongsToCollectionChapter($collection))
                            <div class="panel panel-default">
                                <div class="panel-heading">#{!! $signal->id !!} <span class="pull-right">{{ $signal->created_at }}</span></div>
                                <div class="panel-body">
                                    <p>Plaite émise par <a href="../profil/{{$signal->user_id}}">{{ $signal->moaner }}</a> envers  <a href="../profil/{{$signal->guilt_id}}">{{ $signal->guilty }}</a></p>
                                    <hr>
                                    <p><span class="glyphicon glyphicon-exclamation-sign"></span> {{$signal->typename }}</p>
                                    <p>{{ $signal->motifsignals->description }}</p>
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
                        @endif
                    @endforeach
                @else
                    <h1 class="text-center" id="fill_page">Il n'y a pas de plainte à s'occuper</h1>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h2>Les forums</h2>
                @if($collection->forums == null)
                    <p>Il n'y a pas de forum</p>
                @else
                <h3>{{ $collection->forums->name }}</h3>
                <hr>
                <p>{{ $collection->forums->description }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <h3>Vérouillés</h3>
                <ul>
                    @foreach($collection->forums->topics as $topic)
                        @if($topic->isLocked())
                            <li><a href="{{ url('/forums/'.$collection->forums->slug.'/topic/'.$topic->slug) }}">{{ $topic->name }}</a></li>
                        @endif
                    @endforeach
                </ul>

            </div>
            <div class="col-sm-4">
                <h3>Épinglés</h3>
                <ul>
                    @foreach($collection->forums->topics as $topic)
                        @if($topic->isPinned())
                            <li><a href="{{ url('/forums/'.$collection->forums->slug.'/topic/'.$topic->slug) }}">{{ $topic->name }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-4">
                <h3>Archivés</h3>
                <ul>
                    @foreach($collection->forums->topics as $topic)
                        @if($topic->isArchived())
                            <li><a href="{{ url('/forums/'.$collection->forums->slug.'/topic/'.$topic->slug) }}">{{ $topic->name }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h2>Signalements</h2>
                @if(!$signals->isEmpty())
                    @foreach($signals as $signal)
                        @if($signal->belongsToCollectionForum($collection->forums))
                            <div class="panel panel-default">
                                <div class="panel-heading">#{!! $signal->id !!} <span class="pull-right">{{ $signal->created_at }}</span></div>
                                <div class="panel-body">
                                    <p>Plaite émise par <a href="../profil/{{$signal->user_id}}">{{ $signal->moaner }}</a> envers  <a href="../profil/{{$signal->guilt_id}}">{{ $signal->guilty }}</a></p>
                                    <hr>
                                    <p><span class="glyphicon glyphicon-exclamation-sign"></span> {{$signal->typename }}</p>
                                    <p>{{ $signal->motifsignals->description }}</p>
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
                        @endif
                    @endforeach
                @else
                    <h1 class="text-center" id="fill_page">Il n'y a pas de plainte à s'occuper</h1>
                @endif
            </div>
        </div>
        @endif

    </div>
@endsection