@extends('layouts.forum')

@section('secondary')
    <div class="row">
        <div class="col-sm-12">
            <p>
                <a href="{{ action('ForumsController@index') }}">Tous les forums</a>
                @if($forum->hasCollec()) / <a href="{{action('CollecsController@show', $forum->collections)}}">{{ $forum->collections->name }}</a>@endif
                / <a href="{{ action('ForumsController@show', $forum) }}">{{ $forum->name }} </a>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <a href="{{ action('TopicsController@create', $forum) }}" class="btn btn-success">Nouveau sujet</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <form action="" method="GET">
            <div class="input-group add-on">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
                <input type="text" name = "search" class="form-control" placeholder="Vous pouvez chercher un sujet, le pseudo d'un forumeur..."/>
            </div>
            </form>
        </div>
    </div>
    <br>

    <?php
    use App\User;
    use App\Topic;
    if(isset($_GET['search']) && $_GET['search'] != null){
        ?>
        <a href="{{ action('ForumsController@show', $forum) }}" class="btn btn-info">Retour à la liste des sujets</a>
        <?php
        $user = User::where('name', $_GET['search'])->OrWhere('alias', 'like', '%'.$_GET['search'].'%')->first();
            if(!$user){
                $listTopic = Topic::where('name', 'like', '%'.$_GET['search'].'%' )->get();
                if($listTopic->isEmpty()){
                    $listTopic = $forum->listTopic();
                    echo '<p class=bg-info>Aucun topic trouvé.</p>';
                }
            }else{
                $listTopic = $forum->listTopic()->where('user_id', $user->id);
            }
        }else{
            $listTopic = $forum->listTopic();
        }
    ?>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-stripped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Auteur</th>
                    <th>Sujet</th>
                    <th>Dernier message</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4"><hr></td>
                    </tr>
                    @foreach($forum->listTopicPinned() as $topic)
                        <tr class="tr-hover">
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug)}}"><img src="{{$topic->img }}" alt="topic" height="25" width="30"></a></td>
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug)}}">@if($topic->users->hasAlias()){{$topic->alias}}@else{{ $topic->username }}@endif</a></td>
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug)}}">{{$topic->name}}</a></td>
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug)}}">{{ $topic->last_message_time }}</a></td>
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug)}}" data-method="delete" data-confirm = "Voulez vous vraiment supprimer le topic {{ $topic->name }}"><span class="circle-red glyphicon glyphicon-trash"></span></a></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4"><hr></td>
                    </tr>
                    @foreach($listTopic as $topic)
                        <tr class="tr-hover">
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug) }}"><img src="{{$topic->img }}" alt="topic" height="25" width="30"></a></td>
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug) }}">@if($topic->users->hasAlias()){{$topic->alias}}@else{{ $topic->username }}@endif</a></td>
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug) }}">{{$topic->name}}</a></td>
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug) }}">{{ $topic->last_message_time }}</a></td>
                            <td><a href="{{ url('/forums/'.$forum->slug.'/topic/'.$topic->slug) }}" data-method="delete" data-confirm = "Voulez vous vraiment supprimer le topic {{ $topic->name }}"><span class="circle-red glyphicon glyphicon-trash"></span></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="paginatation">
                {{ $forum->listTopic()->render() }}
            </div>
        </div>
    </div>
@endsection