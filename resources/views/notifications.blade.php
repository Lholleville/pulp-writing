<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle"
       role="button"
       data-toggle="dropdown"
       aria-haspopup="true"
       aria-expanded="false">
        <i data-toggle="tooltip" data-placement="bottom" title="Notifications" class="fas fa-bell"></i>

        @if(Auth::user()->NbUnreadNotifications > 0)
            ( {{ Auth::user()->NbUnreadNotifications }} )
        @endif
        <span class="sr-only">
            (current)
        </span>
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
        <div class="notification-container" id="">
            <a href="" onclick="allnotifread('{{ url("notification/all/read") }}')" class="pull-right">Tout marquer comme lu</a>
                    <script>
                        function allnotifread(url){
                            var errorAjax = "Il semblerait qu'il y ait une erreur serveur...";
                            $.ajax({
                                url : url,
                                type : "GET"
                            })
                        }
                    </script>
                    @foreach(Auth::user()->notifications->reverse() as $notif)
                        <div @if($notif->isRead()) class="notification" @else class="notification-unread" @endif>
                            <a class="dropdown-item" onclick="notifread('{{ url('notification/'.$notif->id.'/read')}}')" href="{{ $notif->link }}">
                                @if($notif->isRead())
                                    <span class="badge badge-pill badge-secondary text-secondary">.</span>
                                @else
                                    <span class="badge badge-pill badge-primary text-primary">.</span>
                                @endif
                                {!! $notif->content !!}
                                <span class="pull-right">{{ $notif->created_at }}</span>
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
</li>
