@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ action('ForumsController@create') }}" class="btn btn-success">Ajouter</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-stripped">
                <thead>
                    <th>Nom</th>
                    <th>Online</th>
                    <th>Actions</th>
                    <th>Modérateurs</th>
                </thead>
                <tbody>
                    @foreach($forums as $forum)
                        <tr>
                            <td>{{ $forum->name }}</td>
                            <td>{!! $forum->online !!}</td>
                            <td>
                                <a href="{{action('ForumsController@show',$forum)}}"><span class="circle-green glyphicon glyphicon-eye-open"></span></a>
                                <a href="{{action('ForumsController@edit',$forum)}}"><span class="circle-blue glyphicon glyphicon-wrench"></span></a>
                                <a href="{{action('ForumsController@destroy', $forum)}}" data-method="delete" data-confirm = "Voulez vous vraiment supprimer le forum {{ $forum->name }} ?"><span class="circle-red glyphicon glyphicon-trash"></span></a>
                            </td>
                            @foreach($forum->users as $user)
                            <td>
                               <p> <img src="{{ url($user->avatar) }}" alt="avatar du modérateur {{ $user->name }}" class="img-responsive" height="50" width="50" />{{$user->name}}</p>
                            </td>
                            @endforeach

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection