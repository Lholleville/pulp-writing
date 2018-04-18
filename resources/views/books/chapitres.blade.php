<h2>Chapitres
    @if(!Auth::guest())
        @if($book->user_id == Auth::user()->id)
            <a href="{{ action('ChaptersController@create', $book->slug) }}" class="btn btn-success">Ajouter un chapitre</a>
        @endif
    @endif
</h2>
<table class="table table-responsive">
    <tr>
        <th>Titre</th>
        <th>POV</th>
        <th>Illustration</th>
        <th>Commentaires</th>
        <th>Vues</th>
        <th>Mots</th>
        <th>Like</th>
        <th>Lectures</th>
        <th>Ordre</th>
        <th>En ligne</th>
        <th>Actions</th>
    </tr>
    @if($book->chapters())
        @foreach($book->chapters as $chapter)
            <tr class="tr-hover">
                <td><a href="{{url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug.'/edit')}}">{{$chapter->name}}</a></td>
                <td><a href="{{url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug.'/edit')}}">{{$chapter->POV}}</a></td>
                @if($chapter->avatar != "/img/chapters/defaut.jpg")
                    <td><a href="{{url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug.'/edit')}}"><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="bottom" title="<img src='{{ url($chapter->avatar) }}' alt='illustration de {{ $chapter->name }}' class='img-responsive'/>"></span></a></td>
                @else
                    <td><a href="{{url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug.'/edit')}}"><span class="glyphicon glyphicon-eye-close"></span></a></td>
                @endif
                <td><a href="{{url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug.'/edit')}}">{{$chapter->nbComment}}</a></td>
                <td><a href="{{url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug.'/edit')}}">{{$chapter->views}}</a></td>
                <td><a href="{{url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug.'/edit')}}">{{$chapter->words}}</a></td>
                <td><a href="{{url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug.'/edit')}}">{{$chapter->like}}</a></td>
                <td><a href="{{url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug.'/edit')}}">{{$chapter->read}}</a></td>
                <td><a href="{{url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug.'/edit')}}">{{$chapter->order}}</a></td>
                <td><a href="{{url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug.'/edit')}}">{!! $chapter->online !!}</a></td>
                <td>
                    <a href="{{url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug)}}"><span class="circle-green glyphicon glyphicon-eye-open"></span></a>
                    <a href="{{url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug.'/edit')}}"><span class="circle-blue glyphicon glyphicon-wrench"></span></a>
                    <a href="{{url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug)}}" data-method="delete" data-confirm = "Voulez vous vraiment supprimer le chapitre ?"><span class="circle-red glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @endforeach
    @endif
</table>