<div class="row">
    <div class="col-sm-4">
        <h2>
            Listes de contacts
            @if(!Auth::guest())
                @if($user->id == \Illuminate\Support\Facades\Auth::user()->id)
                    <span class="pull-right" data-toggle="tooltip" data-placement="top" title="Créer une nouvelle liste de contact">
                    <button type="button" href="" class="btn btn-success" data-toggle="modal" data-target="#form-liste-contact">
                        <i class="fas fa-plus"></i>
                    </button>
                </span>
                @endif
            @endif
        </h2>
        <div class="list-group">
            @foreach($user->listes as $listuser)
                <span class="list-group-item" id="{{$listuser->id}}" style="cursor : pointer">
                    {{ $listuser->name }}
                    @if(!Auth::guest())
                        @if($listuser->isDeletable())
                            <span class="pull-right">
                                <a href="{{ action('ListesController@destroy', $listuser) }}"
                                   class="btn btn-danger"
                                   data-toggle="tooltip"
                                   title = "Supprimer la liste: {{ $listuser->name }}"
                                   data-placement="top"
                                   data-method="delete"
                                   data-confirm = "Voulez vous vraiment supprimer la liste : {{ $listuser->name }} ?">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </span>
                        @endif
                    @endif
                </span>
            @endforeach
        </div>
    </div>
    <div class="col-sm-8">
        {{--{{ var_dump($user->listelectures) }}--}}

        @foreach($user->listes as $listuser)
            <div class="list_content_hide" id="{{"list_".$listuser->id }}">
                <h2>
                    {{ $listuser->name }}
                    @if(!Auth::guest())
                        @if($listuser->isNotifiable())
                            <span class="" data-toggle="tooltip" data-placement="top" title="Gérer les options de notification">
                                <button type="button" href="" class="btn btn-primary" data-toggle="modal" data-target="#notif-liste-contact-{{ $listuser->id }}">
                                    <i class="fas fa-cog"></i>
                                </button>
                            </span>
                        @endif
                    @endif
                </h2>
                <!-- Modal contact-->
                <div class="modal fade" id="notif-liste-contact-{{ $listuser->id }}" tabindex="-1" role="dialog" aria-labelledby="Créer une liste de contact" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Recevoir des notifications quand :</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            {!! Form::model($listuser->regles, ['class' => 'form-horizontal', 'method' => 'PUT', 'url' => action('ListesController@setrules', $listuser->id)]) !!}
                            <div class="modal-body">
                                <h2>{{ $listuser->name }}</h2>
                                <div class="form-check">
                                    {!! Form::checkbox('user_text_created') !!}
                                    <label class="form-check-label" for="defaultCheck1">
                                        Un utilisateur crée un texte
                                    </label>
                                </div>
                                <div class="form-check">
                                    {!! Form::checkbox('user_article_created') !!}
                                    <label class="form-check-label" for="defaultCheck2">
                                        Un utilisateur crée un article
                                    </label>
                                </div>
                                <div class="form-check">
                                    {!! Form::checkbox('user_diary_created') !!}
                                    <label class="form-check-label" for="defaultCheck3">
                                        Un utilisateur publie dans son journal
                                    </label>
                                </div>
                                <div class="form-check">
                                    {!! Form::checkbox('user_topic_created') !!}
                                    <label class="form-check-label" for="defaultCheck3">
                                        Un utilisateur crée un topic
                                    </label>
                                </div>
                                <div class="form-check">
                                    {!! Form::checkbox('user_can_see_diary') !!}
                                    <label for="defaultCheck4" class="form-check-label">
                                        Les utilisateurs peuvent voir mon journal
                                    </label>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->
                <p>
                    {{ $listuser->description }}
                </p>
                @if(!Auth::guest())
                    @if(\Illuminate\Support\Facades\Auth::user()->id == $user->id && $listuser->isEditable())
                        {!! Form::model($listuser, ['class' => 'form-horizontal', 'url' => action('ListesController@update', $listuser), 'method' => 'PUT']) !!}
                        <div class="form-group">
                            {!! Form::select('user_id[]', $users->pluck('name', 'id') , $listuser->users()->pluck('id', 'name'), ['multiple' => true, 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </div>
                        {!! Form::close() !!}
                    @endif
                @endif
                <div class="row">
                    @foreach($listuser->users as $membre)
                    <div class="col-3">
                        <p>
                            <a href="{{ action('UsersController@show', $membre->slug) }}">
                                <img class="img-avatar-list"
                                     src="{{ url($membre->avatar) }}"
                                     alt="Avatar de {{ $membre->name }}"
                                >
                                {{ $membre->name }}
                            </a>
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-4">
        <h2>
            Listes de lecture
            @if(!Auth::guest())
                @if($user->id == \Illuminate\Support\Facades\Auth::user()->id)
                    <span class="pull-right" data-toggle="tooltip" data-placement="top" title="Créer une nouvelle liste de lecture">
                        <button type="button" href="" class="btn btn-success" data-toggle="modal" data-target="#form-liste-lecture">
                            <i class="fas fa-plus"></i>
                        </button>
                    </span>
                @endif
            @endif
        </h2>

        <div class="list-group">
            @foreach($user->listelectures as $list)
                <span class="list-group-item-lecture" id="{{$list->id}}" style="cursor : pointer">{{ $list->name }}
                    @if(!Auth::guest())
                        @if($list->isDeletable())
                            <span class="pull-right">
                                <a href="{{ action('ListeslectureController@destroy', $list) }}"
                                   class="btn btn-danger"
                                   data-toggle="tooltip"
                                   title = "Supprimer la liste: {{ $list->name }}"
                                   data-placement="top"
                                   data-method="delete"
                                   data-confirm = "Voulez vous vraiment supprimer la liste : {{ $list->name }} ?">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </span>
                        @endif
                    @endif
                    </span>
            @endforeach
        </div>
    </div>
    <div class="col-sm-8">
        @foreach($user->listelectures as $listlecture)
            <div class="list_content_hide_lecture" id="list_lecture_<?php echo $listlecture->id?>">
                <h2>
                    {{ $listlecture->name }}
                    @if(!Auth::guest())
                        @if($listlecture->isNotifiable())
                            <span class="" data-toggle="tooltip" data-placement="top" title="Gérer les options de notification">
                                <button type="button" href="" class="btn btn-primary" data-toggle="modal" data-target="#notif-liste-lecture-{{ $listlecture->id }}">
                                    <i class="fas fa-cog"></i>
                                </button>
                            </span>
                        @endif
                    @endif
                </h2>
                <!-- Modal lecture-->
                <div class="modal fade" id="notif-liste-lecture-{{ $listlecture->id }}" tabindex="-1" role="dialog" aria-labelledby="Créer une liste de contact" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Recevoir des notifications quand :</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            {!! Form::model($listlecture->reglelectures, ['class' => 'form-horizontal', 'method' => 'PUT', 'url' => action('ListeslectureController@setruleslecture', $listlecture->id)]) !!}
                            <div class="modal-body">
                                <h2>{{ $listlecture->name }}</h2>
                                <div class="form-check">
                                    {!! Form::checkbox('text_chapter_created') !!}
                                    <label class="form-check-label" for="defaultCheck1">
                                        Un chapitre est publié dans le texte
                                    </label>
                                </div>
                                <div class="form-check">
                                    {!! Form::checkbox('text_statut_changed') !!}
                                    <label class="form-check-label" for="defaultCheck2">
                                        Un texte change de statut
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->
                <p>
                    {{ $listlecture->description }}
                </p>
                @if(!Auth::guest())
                    @if(\Illuminate\Support\Facades\Auth::user()->id == $user->id && $listlecture->isEditable())
                        {!! Form::model($listlecture, ['class' => 'form-horizontal', 'url' => action('ListeslectureController@update', $listlecture), 'method' => 'PUT']) !!}
                        <div class="form-group">
                            {!! Form::select('book_id[]', $books->pluck('name', 'id') , $listlecture->books()->pluck('id', 'name'), ['multiple' => true, 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </div>
                        {!! Form::close() !!}
                    @endif
                @endif
                <div class="row">
                    @foreach($listlecture->books as $book)
                        <div class="col-3">
                            <p>
                                <a href="{{ action('ReadController@show', [$book->collections->slug,$book->slug]) }}">
                                    <div class="row col">
                                        <img class="img-avatar-list" src="{{ url($book->avatar) }}" alt="Couverture de {{ $book->name }}">
                                    </div>
                                    <div class="row col-sm-10">
                                        {{ $book->name }}
                                    </div>
                                </a>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
<script>
    $('.list_content_hide_lecture').toggle();
    $(".list-group-item-lecture").click(function(){
        $('.list_content_hide_lecture').hide();
        $('.list-group-item-lecture').removeClass('active');
        $(this).addClass('active');

        $('#list_lecture_' + $(this).attr('id')).show();
    });
    $('.list_content_hide').toggle();
    $(".list-group-item").click(function(){
        $('.list_content_hide').hide();
        $('.list-group-item').removeClass('active');
        $(this).addClass('active');

        $('#list_' + $(this).attr('id')).show();
    });
</script>

<!-- Modal contact-->
<div class="modal fade" id="form-liste-contact" tabindex="-1" role="dialog" aria-labelledby="Créer une liste de contact" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Créer une nouvelle liste de contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::model($listcontact, ['class' => 'form-horizontal', 'method' => 'POST', 'url' => action('ListesController@store')]) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label for="" class="control-label">Nom de la liste</label>
                    {!! Form::text('name', null,['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Description de la liste</label>
                    {!! Form::textarea('description', null,['class' => 'form-control']) !!}
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Sauvegarder</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- Modal lecture-->
<div class="modal fade" id="form-liste-lecture" tabindex="-1" role="dialog" aria-labelledby="Créer une liste de lecture" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Créer une nouvelle liste de lecture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::model($newlistlecture, ['class' => 'form-horizontal', 'method' => 'POST', 'url' => action('ListeslectureController@store')]) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label for="" class="control-label">Nom de la liste</label>
                    {!! Form::text('name', null,['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Description de la liste</label>
                    {!! Form::textarea('description', null,['class' => 'form-control']) !!}
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Sauvegarder</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>