<div class="row">
    <div class="col-sm-4">
        @if(!Auth::guest())
            @if($user->id != Auth::user()->id)
                <p><a href="{{ route('messagerie.show', $user->id) }}" class="btn btn-default"><i class="fa fa-envelope"></i> Contacter</a></p>
                @if($user->isInList(Auth::user()->friendsliste))
                    <p><a href="{{ action('ListesController@friends', $user->id) }}" class="btn btn-primary"><i class="fas fa-address-card"></i> Retirer des amis</a></p>
                @else
                    <p><a href="{{ action('ListesController@friends', $user->id) }}" class="btn btn-primary"><i class="fas fa-address-card"></i> Ajouter en ami</a></p>
                @endif
                @if($user->isInList(Auth::user()->abonnementsliste))
                    <p><a href="{{ action('ListesController@subscribe', $user->id) }}" class="btn btn-primary"><i class="far fa-bell-slash"></i> Se désabonner</a></p>
                @else
                    <p><a href="{{ action('ListesController@subscribe', $user->id) }}" class="btn btn-primary"><i class="far fa-bell"></i> S'abonner</a></p>
                @endif
                @if($user->isBlacklisted())
                    <p><a data-toggle="tooltip" data-placement="top" title="Retirer {{$user->name}} de la liste noire." href="{{ action('ListesController@blacklist', $user->id) }}" class="btn btn-dark"><i class="fas fa-child"></i></a></p>
                @else
                    <p><a data-toggle="tooltip" data-placement="top" title="Ajouter {{$user->name}} à la liste noire." href="{{ action('ListesController@blacklist', $user->id) }}" class="btn btn-dark"><i class="fas fa-blind"></i></a></p>
                @endif
            @else
                <p><a href="{{ url('profil/my-profil/edit') }}" class="btn btn-primary">Modifier</a></p>
            @endif
        @endif
        <p>{{ $user->name }}</p>
        <p>{{ $user->sex }}</p>
        <p>{{ $user->email }}</p>
        <p>
            <img src="{{ url($user->avatar) }}" alt="avatar de {{$user->name}}" />
        </p>
        <p>{{ $user->age }}</p>

    </div>
    <div class="col-sm-8">
        {!! $user->description  !!}
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h2>Mes Badges</h2>
        @foreach($user->badges as $badge)
            {{ $badge->name }}
        @endforeach
    </div>
</div>
