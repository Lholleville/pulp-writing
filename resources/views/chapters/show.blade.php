@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-offset-1 col-xs-10">
            <h1 class="text-center">
                {{ $chapter->name }}
            </h1>
        </div>
        <div class="col-xs-1">
            <span class="pull-right">
                @if(!Auth::guest())
                    @if(Auth::user()->id == $chapter->user_id)
                        <a href="{{ url('ecrire/oeuvres/'.$slugbook.'/chapitre/'.$chapter->slug.'/edit') }}"><button class="btn btn-primary">Editer</button></a>
                    @endif
                @endif
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            @if($chapter->avatar != '/img/chapters/defaut.jpg')
                <img src="{{ url($chapter->avatar) }}" alt="Illustration de {{ $chapter->name }}" class="img-illu center-block">
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <h1 class="text-center">{{ $chapter->POV }}</h1>
        </div>
    </div>

    <br>

    @if(!\Illuminate\Support\Facades\Auth::guest())
    <div class="row">
        <div class="col-sm-offset-5 col-sm-2 text-center">
            <h2 id="like">
                @if(\Illuminate\Support\Facades\Auth::user()->hasLike($chapter))
                    <a href="{{ url($chapter->id."/dislike") }}" class="pomegranate"><i class="fa fa-heart" data-toggle="tooltip" data-placement="bottom" title="Je n'aime plus ce chapitre !" id="ouilike"></i></a>
                @else
                    <a href="{{ url($chapter->id."/like") }}" class="pomegranate"><i class="fa fa-heart-o" data-toggle="tooltip" data-placement="bottom" title="J'aime ce chapitre !" id="nonlike"></i></a>
                @endif
            </h2>
        </div>
    </div>
    @endif
    <br>

    <div class="row col-sm-offset-3">
        <div class="col-sm-2 text-center "><i class="fa fa-heart pomegranate" aria-hidden="true"></i><br>{{ $chapter->like }}</div>
        <div class="col-sm-2 text-center"><i class="fa fa-eye" aria-hidden="true"></i><br>{{ $chapter->views }}</div>
        <div class="col-sm-2 text-center"><i class="fa fa-commenting-o" aria-hidden="true"></i><br>{{ $chapter->nbComments }}</div>
        <div class="col-sm-2 text-center"><i class="fa fa-pencil" aria-hidden="true"></i><br>{{ $chapter->words }}</div>
    </div>


    <br>

    <div class="row">
        <div class="col-sm-12">
            @if(!$chapter->notes->isEmpty())
                @foreach($chapter->notes as $note)
                    <p>#{{ $note->id }} | {{ $note->start }} | {{ $note->end }}</p>
                @endforeach
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            @if(Auth::user())
                <div id="annotation_icon"><button class="btn btn-default" data-toggle="modal" data-target="#annotation_modal"><i class="fa fa-commenting-o" aria-hidden="true"></i></button></div>
            @endif
            <div class="text-justify" id="chapitre">{!! $chapter->notetext !!}</div>
        </div>
    </div>
<div class="row">
    <div class="col-sm-12">
        <div class="text-justify margin-content">
            <p><b>Modifié le :</b> {{ $chapter->updated_at }}</p>
            <p><b>Créé le :</b>  {{ $chapter->created_at }}</p>
        </div>
    </div>
</div>
<br>
    @if(!\Illuminate\Support\Facades\Auth::guest())
        <div class="row">
            <div class="col-sm-offset-4 col-sm-2 text-center">
                <h2 id="like2">
                    @if(\Illuminate\Support\Facades\Auth::user()->hasLike($chapter))
                        <a href="{{ url($chapter->id."/dislike") }}" class="pomegranate"><i class="fa fa-heart" data-toggle="tooltip" data-placement="bottom" title="Je n'aime plus ce chapitre !" id="ouilike2"></i></a>
                    @else
                        <a href="{{ url($chapter->id."/like") }}" class="pomegranate"><i class="fa fa-heart-o" data-toggle="tooltip" data-placement="bottom" title="J'aime ce chapitre !" id="nonlike2"></i></a>
                    @endif
                </h2>
            </div>
            <div class="col-sm-2">
                <h2 id="read">
                    @if(\Illuminate\Support\Facades\Auth::user()->hasRead($chapter))
                        <a href="{{ url($chapter->id."/unread") }}" class="pomegranate"><i class="fa fa-eye" data-toggle="tooltip" data-placement="bottom" title="Je n'ai pas lu ce chapitre !" id="ouiread"></i></a>
                    @else
                        <a href="{{ url($chapter->id."/read") }}" class="pomegranate"><i class="fa fa-eye-slash" data-toggle="tooltip" data-placement="bottom" title="J'ai lu ce chapitre !" id="nonread"></i></a>
                    @endif
                </h2>
            </div>
        </div>
    @endif
<br>
<div class="row">
    <div class="col-sm-12">
        <div class="text-justify margin-content">
            <h2>
                @if($chapter->previous->id !== $chapter->id)
                    <a href="{{ url($chapter->books->collections->slug."/".$slugbook."/".$chapter->previous->order."/".$chapter->previous->slug) }}" class="text-pomegranate">
                        <span class="pull-left text-uppercase pomegranate">précédent</span>
                    </a>
                @endif
                @if($chapter->next->id !== $chapter->id)
                   <a href="{{ url($chapter->books->collections->slug."/".$slugbook."/".$chapter->next->order."/".$chapter->next->slug) }}" class="text-pomegranate">
                        <span class="pull-right text-uppercase pomegranate">suivant</span>
                   </a>
                @endif
            </h2>
        </div>
    </div>
</div>
<br>
<div class="row">
    @include('chapters.modal')
    @include('comments.form', ['action' => 'store','id' => $chapter->id, 'mode' => 'chapter'])
    @include('comments.index')
</div>
@endsection