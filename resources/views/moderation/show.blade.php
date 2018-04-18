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
            <h2>Les textes</h2>
            <table class="table table-striped">
                <thead class="text-center">
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Genre</th>
                    <th>Apperçu</th>
                    <th>Réémigrer</th>
                </thead>
                <tbody>
                @foreach($collection->books as $book)
                    <tr>
                        <td>{{ $book->name }}</td>
                        <td>{{ $book->users->name }}</td>
                        <td>{{ $book->genres->name }}</td>
                        <td><a href="" class="btn btn-default"><i class="fa fa-eye"></i></a></td>
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
                            <td><a href="{{ action('ModerationsController@reemigrate', $book->slug)}}" class="btn btn-warning"><i class="fa fa-check"></i></a></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <h2>Les forums</h2>
        </div>
    </div>
@endsection