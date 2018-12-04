{{--<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">--}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('forum') }}"><i data-toggle="tooltip" data-placement="bottom" title="Échanger" class="fas fa-crow"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url("bibliotheque") }}" class="nav-link"><i data-toggle="tooltip" data-placement="bottom" title="Lire" class="fas fa-book-open"></i></a>
                    </li>
                    @if (Auth::user())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('atelier') }}"><i data-toggle="tooltip" data-placement="bottom" title="Écrire" class="fas fa-feather-alt"></i></a>
                        </li>
                    @endif

                    @if(Auth::user())
                    <div class="parent2">
                        <div class="counter badge badge-light" id="counter1">{{ Auth::user()->name }}</div>
                        <br>
                        <div class="counter badge badge-light" id="counter2"><i class="far fa-eye"></i> {{ Auth::user()->nbView }}</div>
                        <br>
                        <div class="counter badge badge-light" id="counter3"><i class="fas fa-heart"></i> {{ Auth::user()->NbLike }}</div>
                        <div class="test1">
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt" data-toggle="tooltip" data-placement="bottom" title="Se déconnecter"></i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                        <div class="test2">
                            <a href="{{ url('/profil/'.Auth::user()->slug) }}" data-toggle="tooltip" data-placement="bottom" title="Profil">
                                <i class="fa fa-user fa-2x"></i>
                            </a>
                        </div>
                        <div class="test3">
                            <a data-toggle="tooltip" data-placement="bottom" title="Messagerie" href="{{ route('messagerie') }}">
                                <i class="far fa-envelope">
                                    @if(Auth::user()->UnreadMessage > 0)
                                        <span class="badge badge-danger notif">
                                             {{ Auth::user()->UnreadMessage }}
                                        </span>
                                    @endif
                                </i>
                            </a>
                        </div>
                        <div class="test4">
                            <a href=""  data-toggle="modal" data-target="#ModalNotif" >
                                <i class="fas fa-bell">
                                    @if(Auth::user()->NbUnreadNotifications > 0)
                                        <span class="badge badge-warning notif">
                                             {{ Auth::user()->NbUnreadNotifications }}
                                        </span>
                                    @endif
                                </i>
                            </a>
                        </div>
                        <div class="mask2" style="
                                background-image: url({{ url(Auth::user()->avatar) }}?{{time()}});
                                background-size: cover;
                                "></div>
                    </div>
                    @endif
                </ul>
            </div>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2 navbar-grimancie" type="search" placeholder="Rechercher" aria-label="Rechercher">
            </form>
            @if(Auth::guest())
                <ul class="list-unstyled" id="grand-navbar">
                    <li class="nav-item">
                        <a class="nav-link active" style="color:white" href="{{ route('login') }}">CONNEXION</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" style="color:white" href="{{ route('register') }}">INSCRIPTION</a>
                    </li>
                </ul>
                <div id="petit-navbar">
                    <p>
                        <a data-toggle="tooltip" data-placement="bottom" title="Se connecter" class="pull-left active" style="color:white; " href="{{ route('login') }}"><i class="fas fa-wifi" style="font-size: 1em;"></i></a>
                        <a data-toggle="tooltip" data-placement="bottom" title="S'inscrire" class="pull-right active" style="color:white;" href="{{ route('register') }}"><i class="far fa-address-book" style="font-size: 1em;"></i></a>
                    </p>
                </div>
            @else

            @endif

    </nav>

    <!-- Modal -->
    @if(Auth::user())
    <div class="modal fade" id="ModalNotif" tabindex="-1" role="dialog" aria-labelledby="Notifications" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Notifications">
                        @if(Auth::user()->NbUnreadNotifications > 0)
                            {{ Auth::user()->NbUnreadNotifications }} notifications non lue(s)
                        @else
                            Mes notifications
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12" id="">

                        @foreach(Auth::user()->notifications->reverse() as $notif)
                            <div @if($notif->isRead()) class="notification" @else class="notification-unread" @endif>
                                <a class="row" onclick="notifread('{{ url('notification/'.$notif->id.'/read')}}')" href="{{ $notif->link }}">
                                    <div class="col-sm-1">
                                        @if($notif->isRead())
                                            <span class="badge badge-pill badge-light text-secondary text-light" style="border-color : black;">.</span>
                                        @else
                                            <span class="badge badge-pill badge-dark text-primary text-dark">.</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-8">
                                        {!! $notif->content !!}
                                    </div>
                                    <div class="col-sm-3">
                                        <span class="">{{ $notif->created_at }}</span>
                                    </div>
                                </a>
                                <script>
                                    function notifread(url){
                                        var origin = "{{ url()->current() }}";
                                        console.log(url);
                                        var errorAjax = "Il semblerait qu'il y ait une erreur serveur...";
                                        read(url, origin, errorAjax);
                                    }
                                </script>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Fermer</button>
                    <a href="" onclick="allnotifread('{{ url("notifications/all/read") }}')" class="btn btn-outline-dark">Tout marquer comme lu</a>
                    <script>
                        function allnotifread(url){
                            var errorAjax = "Il semblerait qu'il y ait une erreur serveur...";
                            $.ajax({
                                url : url,
                                type : "GET"
                            })
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    @endif
