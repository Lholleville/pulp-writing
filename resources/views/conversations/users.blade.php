<div class="col-sm-4">
    <div class="list-group">
        @foreach($users as $user)
            <a class="list-group-item" href="{{ route('messagerie.show', $user->id) }}">
                {{ $user->name }}
                @if(isset($unread[$user->id]))
                    <span class="badge badge-pill badge-danger pull-right">
                        {{ $unread[$user->id] }}
                    </span>
                @endif
            </a>
        @endforeach
    </div>
</div>
