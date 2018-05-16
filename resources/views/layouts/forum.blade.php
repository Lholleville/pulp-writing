@include('navbar')
    <div class="container">
        @include('flash')
        <div class="row">
            <div class="col-sm-4">
                <h1>{{ $forum->name }}</h1>
            </div>
            <div class="col-sm-8 forum-description">
                <p>{{ $forum->description }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h2>Modérateurs du forum</h2>
                <ul class="list-group">
                    @foreach($forum->users as $modo)
                        <li class="list-group-item">
                            <p>
                                {{$modo->name}} <img src="{{ url($modo->avatar) }}" alt="Avatar du modérateur {{ $modo->name }}" class="img-responsive" width="50" height="50">
                                <br><a href="" class="btn btn-default"><i class="fa fa-envelope"></i> Contacter</a>
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @yield('secondary')
    </div>
</div>
@if(!\Illuminate\Support\Facades\Auth::guest())
    @if(!\Illuminate\Support\Facades\Auth::user()->hasConfAlias())
        <div class="modal fade" tabindex="-1" role="dialog" id="disclaimerForum">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Allez vous utiliser un alias ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            L'alias vous permet de consulter les forums sans utiliser le nom avec lequel vous postez et commentez vos textes.
                            <br><br>
                            Cette option est facultative et vous n'êtes pas obligé(e) de l'utiliser.
                            <br><br>
                            Vous pouvez à tout moment modifier votre alias dans la section du profil. <br><br>
                            Un alias ne vous rendra pas anonyme.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <form method="POST" action="{{ url("profil/alias/create")}}" accept-charset="UTF-8" class="form-horizontal">
                            <input name="_method" type="hidden" value="PUT">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <div class="col-xs-10">
                                <input type="text" name="alias" class="form-control"/>
                            </div>
                            <div class="col-xs-2">
                                <p><button type="submit" class="btn btn-primary">Valider</button></p>
                            </div>
                        </form>
                        <div class="col-xs-offset-10 col-xs-2">
                            <a class="btn btn-default" href="{{ url("profil/alias/ignore") }}">Ignorer</a>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @endif
@endif
<script src="{{ asset('js/js-custom.js') }}"></script>

<script src="{{ url('/js/laravel.js') }}"></script>

</body>
</html>

